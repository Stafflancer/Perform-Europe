<?php
namespace UserMeta;

/**
 * Export users to csv.
 *
 * @uses AjaxProModel::ajaxUserExport()
 *       e.g. (new UserExport())->execute();
 * @author Khaled Hossain
 * @since 1.2.0
 */
class UserExport
{

    /**
     * Base array for providing export settings.
     *
     * @var array
     */
    private $provider = [];

    /**
     * List of fields to export.
     *
     * @var array
     */
    private $fields = [];

    /**
     * Setting offset for get_users() function.
     *
     * @var int
     */
    private $countStart = 0;

    /**
     * Number of users for each iteration.
     *
     * @var int
     */
    private $countLimit = 200;

    /**
     * Arrays of array, containing exported users.
     *
     * @var array
     */
    private $usersData = [];

    /**
     * Set provider.
     * By default, set $_REQUEST to $this->provider.
     *
     * @param array $provider
     */
    public function __construct(array $provider = [])
    {
        $this->provider = $provider;
        if (empty($this->provider)) {
            $this->provider = sanitizeDeep($_REQUEST);
        }

        $this->setFields();
    }

    /**
     * Set $this->fields based on $this->provider.
     */
    private function setFields()
    {
        if (isset($this->provider['fields']) && is_array($this->provider['fields'])) {
            if (isset($this->provider['field_count'])) {
                $this->fields = empty($this->provider['field_count']) ? [] : array_slice($this->provider['fields'], 0, $this->provider['field_count'], true);
            } else {
                $this->fields = $this->provider['fields'];
            }
        }
    }

    /**
     * Call save() and export() based on $this->provider['action_type'].
     */
    public function execute()
    {
        if (empty($this->provider['action_type'])) {
            throw new \Exception('action_type is missing in UserExport.');
        }

        if ($this->provider['action_type'] == 'save' || $this->provider['action_type'] == 'save_export') {
            $this->save();
        }

        if ($this->provider['action_type'] == 'export' || $this->provider['action_type'] == 'save_export') {
            $this->generateCsv('php://output');
        }
    }

    /**
     * Save export forms in database.
     */
    private function save()
    {
        global $userMeta;

        if (empty($this->provider['form_id'])) {
            throw new \Exception('form_id is missing in UserExport.');
        }

        $data = array(
            'fields' => $this->fields
        );

        $this->addKeys($data, $this->provider, array(
            'exclude_roles',
            'start_date',
            'end_date',
            'orderby',
            'order'
        ));

        $export = $userMeta->getData('export');
        $export['user'][$this->provider['form_id']] = $data;
        $userMeta->updateData('export', $export);
    }

    /**
     * Download exported csv file that contains users's data.
     *
     * @return string Downloadable csv
     */
    public function download()
    {
        download($this->getCsvFileName(), function () {
            $this->generateCsv('php://output');
        });
    }

    /**
     * Write user exported csv to file.
     *
     * @param string $formID
     *            User export form_id. If form_is is not null, contruct should be use.
     * @param string $path
     *            (optional) Base directory without trailing slash
     * @param string $fileName
     *            (optional)
     * @param string $delimiter
     *            (optional)
     * @param string $enclosure
     *            (optional)
     *            
     * @return string File full path
     */
    public function writeToFile($formID = null, $path = null, $fileName = null, $delimiter = ',', $enclosure = '"')
    {
        $path = $path ?: wp_upload_dir()['path'];

        if (! is_writable($path)) {
            throw new \Exception("'$path' is not writable.");
        }

        $fileName = $fileName ?: $this->getCsvFileName();
        $fullPath = "$path/$fileName";

        $this->generateCsv($fullPath, $formID, $delimiter, $enclosure);

        return $fullPath;
    }

    /**
     * Generate a csv and write to file.
     *
     * @param string $path
     *            (optional) Base directory without trailing slash
     * @param string $formID
     *            User export form id (optional)
     * @param string $delimiter
     *            (optional)
     * @param string $enclosure
     *            (optional)
     */
    private function generateCsv($path, $formID = null, $delimiter = ',', $enclosure = '"')
    {
        $delimiter = apply_filters('user_meta_user_export_csv_delimiter', $delimiter);
        $enclosure = apply_filters('user_meta_user_export_csv_enclosure', $enclosure);

        $file = fopen($path, 'w');
        foreach ($this->export($formID) as $rowArr) {
            fputcsv($file, $rowArr, $delimiter, $enclosure);
        }
        fclose($file);
    }

    /**
     * File name for exported csv.
     *
     * @return string
     */
    private function getCsvFileName()
    {
        $fileName = 'User Export (' . get_bloginfo('name') . ') ' . date('Y-m-d_H-i') . '.csv';

        return apply_filters('user_meta_user_export_filename', $fileName);
    }

    /**
     * Get arrays of users data.
     *
     * @param string $formID
     *            : form id. If id is provided, load setting from db else by constructor
     *            
     * @return array: $usersData arrays contaning arrays
     */
    public function export($formID = null)
    {
        if ($formID) {
            $this->exportByForm($formID);
        }

        $export = $this->getUsersData();

        $labels = apply_filters('user_meta_user_export_label', $this->fields);
        array_unshift($export, $labels);

        return $export;
    }

    /**
     * Export based on form's setting in databsee.
     *
     * @param string $id
     *            Form id
     */
    private function exportByForm($id)
    {
        global $userMeta;

        $export = $userMeta->getData('export');
        if (! isset($export['user'][$id])) {
            throw new \Exception('form_id is not found in UserExport.');
        }

        $this->__construct($export['user'][$id]);
    }

    /**
     * Get arrays of array containing targated users data.
     *
     * @return array: arrays of array
     */
    public function getUsersData()
    {
        $this->setUsersData();

        return $this->usersData;
    }

    /**
     * Set $this->usersData
     * Call $this->getUsers() multiple times to avoid exceeding memory allocation.
     */
    private function setUsersData()
    {
        set_time_limit(600);

        $users = $this->getUsers();
        while (! empty($users)) {
            foreach ($users as $user) {
                $this->usersData[] = $this->getSingleUserData($user);
            }

            $this->countStart += $this->countLimit;
            $users = $this->getUsers();
        }
    }

    /**
     * Get targeted data from a single user.
     * private method _export_$key will call if available
     *
     * @param
     *            WP_User object $user
     *            
     * @return array: Arrays of array
     */
    private function getSingleUserData($user)
    {
        $userData = [];
        foreach ($this->fields as $key => $label) {
            $fieldValue = null;
            $methodName = "_export_$key";
            if (method_exists($this, $methodName)) {
                $fieldValue = $this->$methodName($user);
            } elseif (isset($user->$key)) {
                $fieldValue = $user->$key;
            }

            $fieldValue = apply_filters('user_meta_user_export_pre_field_data', $fieldValue, $key, $user->ID);

            /**
             * Split by comma for multivalues.
             * Field will automatically bounded by double quotation while split by comma
             */
            if (is_array($fieldValue) || is_object($fieldValue)) {
                $userData[$key] = implode(',', (array) $fieldValue);
            } else {
                $userData[$key] = $fieldValue;
            }
        }

        return apply_filters('user_meta_user_export_fields', $userData, $user);
    }

    /**
     * Filter on getting roles as array.
     *
     * This method is getting called in $this->getSingleUserData()
     * array to string conversion happens in $this->getSingleUserData()
     *
     * @param
     *            WP_User object $user
     *            
     * @return array|null
     */
    private function _export_role($user)
    {
        return $user->roles;
    }

    /**
     * Get array of WP_user object.
     *
     * @return array
     */
    private function getUsers()
    {
        add_action('pre_user_query', array(
            $this,
            'filterRegistrationDate'
        ));
        $users = get_users($this->getUserQueryArgs());
        remove_action('pre_user_query', array(
            $this,
            'filterRegistrationDate'
        ));

        return $users;
    }

    /**
     * Get args for get_users() function.
     *
     * @return array
     */
    private function getUserQueryArgs()
    {
        $args = [
            'fields' => 'all_with_meta',
            'role__not_in' => $this->getExcludedRoles(),
            'offset' => $this->countStart,
            'number' => $this->countLimit
        ];

        $this->addKeys($args, $this->provider, [
            'orderby',
            'order'
        ]);

        return $args;
    }

    /**
     * Get array of excluded roles
     *
     * @return array
     */
    private function getExcludedRoles()
    {
        $excludedRoles = [];
        if (isset($this->provider['exclude_roles']) && is_array($this->provider['exclude_roles']))
            $excludedRoles = $this->provider['exclude_roles'];

        return $excludedRoles;
    }

    /**
     * Not in use since 1.4.1
     *
     * Filter $meta_query for excluded roles.
     * (Call by referance).
     *
     * @param array $meta_query
     */
    private function filterExcludeRoles(array &$meta_query)
    {
        global $wpdb, $blog_id;

        if (isset($this->provider['exclude_roles']) && is_array($this->provider['exclude_roles'])) {
            foreach ($this->provider['exclude_roles'] as $role) {
                $meta_query[] = array(
                    'key' => $wpdb->get_blog_prefix($blog_id) . 'capabilities',
                    'value' => "\"$role\"",
                    'compare' => 'NOT LIKE'
                );
            }
        }
    }

    /**
     * Callback hook for "pre_user_query".
     * Filter users by registration date.
     *
     * @param object $query
     *
     * @return object $query
     */
    public function filterRegistrationDate($query)
    {
        global $wpdb;

        if (! empty($this->provider['start_date'])) {
            $query->query_where = $query->query_where . $wpdb->prepare(" AND $wpdb->users.user_registered >= %s", $this->provider['start_date']);
        }

        if (! empty($this->provider['end_date'])) {
            /*
             * Edited from version 2.1
             * '$wpdb->users.user_registered' return date as 'Y-m-d H:i:s' and 'end_data' value stored in 'Y-m-d', default H:i:s = '00:00:00'
             * '$wpdb->users.user_registered' formatted same as 'end_data' to remove logically wrong output
             */
            $query->query_where = $query->query_where . $wpdb->prepare(" AND FORMAT($wpdb->users.user_registered, 'yyyy-MM-dd') <= %s", $this->provider['end_date']);
        }

        return $query;
    }

    /**
     * Add data to base array from provided array based on keys.
     *
     * @param array $data
     *            base as referance
     * @param array $provider
     *            provided array
     * @param array $keys
     *            keys for checking in provded array
     */
    public function addKeys(array &$data, array $provider, array $keys)
    {
        foreach ($keys as $key) {
            if (isset($provider[$key])) {
                $data[$key] = $provider[$key];
            }
        }
    }
}
