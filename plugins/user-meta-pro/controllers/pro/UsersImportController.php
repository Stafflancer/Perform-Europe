<?php
namespace UserMeta;

class UsersImportController
{

    function __construct()
    {
        add_action('wp_ajax_um_user_import', array(
            $this,
            'ajaxUserImport'
        ));
    }

    function ajaxUserImport()
    {
        global $userMeta;
        $userMeta->verifyNonce(true);

        if (! current_user_can('add_users'))
            wp_die(__('You do not have sufficient permissions to access this page.', $userMeta->name));

        if (isset($_REQUEST['step']) && $_REQUEST['step'] == 'one') {
            $key = '';
            $this->importForm($key);
        } elseif (isset($_REQUEST['step']) && $_REQUEST['step'] == 'import') {
            echo $this->userImport();
        }

        die();
    }

    function importForm($key)
    {
        global $userMeta, $wp_roles;

        ini_set('auto_detect_line_endings', true);

        $uploads = $userMeta->determinFileDir((! empty($_REQUEST['filepath']) ? sanitize_text_field($_REQUEST['filepath']) : null), true);
        if (empty($uploads))
            return $userMeta->showError(__('Something went wrong!', $userMeta->name));

        $fullpath = $uploads['path'];

        // $uploads = wp_upload_dir();
        // $fullpath = $uploads['basedir'] . $_REQUEST['filepath'];

        $file = fopen($fullpath, "r");
        $csvHeader = fgetcsv($file);
        $csvSample = fgetcsv($file);
        fclose($file);

        $fieldList = $userMeta->defaultUserFieldsArray();
        $fieldAdded = array(
            '' => '',
            'custom_field' => 'Custom Field'
        );
        $fieldList = array_merge($fieldAdded, $fieldList);
        $fieldList['user_avatar'] = __('Avatar', $userMeta->name);

        $roles = $wp_roles->role_names;
        $roles = array_merge(array(
            '' => ''
        ), $roles);

        $cache = $userMeta->getData('cache');
        $lastImport = ! empty($cache['last_users_import']) ? $cache['last_users_import'] : array();

        $userMeta->renderPro("importStep2", array(
            'key' => $key,
            'fullpath' => $fullpath,
            'csvHeader' => $csvHeader,
            'csvSample' => $csvSample,
            'fieldList' => $fieldList,
            'roles' => $roles,
            'lastImport' => $lastImport
        ), 'exportImport');
    }

    function userImport()
    {
        global $userMeta;

        ini_set('auto_detect_line_endings', true);

        $csv_header = ! empty($_POST['csv_header']) ? sanitizeDeep($_POST['csv_header']) : null;
        $selected_field = ! empty($_POST['selected_field']) ? sanitizeDeep($_POST['selected_field']) : null;
        $custom_field = ! empty($_POST['custom_field']) ? sanitizeDeep($_POST['custom_field']) : null;
        $filepath = ! empty($_POST['filepath']) ? sanitize_text_field(urldecode($_POST['filepath'])) : null;
        $filesize = ! empty($_POST['filesize']) ? sanitize_text_field($_POST['filesize']) : null;

        if (! $filepath || ! file_exists($filepath))
            return $userMeta->showError(__('CSV file is not found for import!', $userMeta->name));
        if (! $selected_field || ! is_array($selected_field))
            return $userMeta->showError(__('Error occurred while importing.', $userMeta->name));

        if ((! empty($_POST['import_by']) ? $_POST['import_by'] : null) == 'email') {
            if (! in_array('user_email', $selected_field))
                return $userMeta->showError(__('Email should be selected as one of the fields.', $userMeta->name));
        } elseif ((! empty($_POST['import_by']) ? $_POST['import_by'] : null) == 'username') {
            if (! in_array('user_login', $selected_field))
                return $userMeta->showError(__('Username should be selected as one of the fields.', $userMeta->name));
        } elseif ((! empty($_POST['import_by']) ? $_POST['import_by'] : null) == 'both') {
            if (! in_array('user_email', $selected_field) || ! in_array('user_login', $selected_field))
                return $userMeta->showError(__('Both Email and Username should be selected as any of the fields.', $userMeta->name));
        }

        // Determine $userFields
        foreach ($selected_field as $key => $val) {
            if ($val == 'custom_field') {
                $userFields[$key] = ! empty($custom_field[$key]) ? $custom_field[$key] : null;
                if (! empty($custom_field[$key]))
                    $extraFields[] = $custom_field[$key];
            } else
                $userFields[$key] = $val;
        }

        // Show Blank progressbar for init
        if (isset($_POST['init'])) {
            // Added custom fields to 'Field Editor'
            if (! empty($_POST['add_fields'])) {
                if (! empty($extraFields))
                    $userMeta->addCustomFields($extraFields);
            }

            $import_count = array(
                'rows' => 0,
                'created' => 0,
                'updated' => 0,
                'added' => 0
            );
            set_transient('user_meta_user_import', $import_count, 3600);

            return $userMeta->renderPro('importStep3', array(
                'file_pointer' => 0,
                'percent' => 0,
                'is_loop' => true,
                'import_count' => $import_count
            ), 'exportImport');
        }

        set_time_limit(3600);

        $file = fopen($filepath, "r");
        $import_count = get_transient('user_meta_user_import');

        if (! empty($_POST['file_pointer']))
            fseek($file, (! empty($_POST['file_pointer']) ? $_POST['file_pointer'] : null));
        else
            $first_row = fgetcsv($file);

        $is_multisite = is_multisite();
        if ($is_multisite) {
            $blog_id = get_current_blog_id();
            $default_role = get_option('default_role');
        }

        $limit = 50;
        $n = 0;
        while (! feof($file)) {
            if ($n == $limit)
                break;

            $csvData = fgetcsv($file);
            if (! $csvData)
                continue;

            // Assigned data to $userdata array
            foreach ($userFields as $key => $val) {
                if ($val)
                    $userdata[$val] = ! empty($csvData[$key]) ? $csvData[$key] : null;
            }

            $userdata['user_email'] = ! empty($userdata['user_email']) ? sanitize_email($userdata['user_email']) : null;
            $userdata['user_login'] = ! empty($userdata['user_login']) ? sanitize_user($userdata['user_login'], true) : null;

            $user_id = null;
            if ($_POST['import_by'] == 'email') {
                if (! empty($userdata['user_email'])) {
                    $user_id = email_exists($userdata['user_email']);
                    if (! $user_id) {
                        if (username_exists($userdata['user_login']))
                            unset($userdata['user_login']);
                    }
                }
            } elseif ($_POST['import_by'] == 'username') {
                if (! empty($userdata['user_login'])) {
                    $user_id = username_exists($userdata['user_login']);
                    if (! $user_id) {
                        if (email_exists($userdata['user_email']))
                            unset($userdata['user_email']);
                    }
                }
            } elseif ($_POST['import_by'] == 'both') {
                $user_id = email_exists($userdata['user_email']);
                if (! $user_id)
                    $user_id = username_exists($userdata['user_login']);
            }

            if (! empty($_POST['user_role']))
                $userdata['role'] = sanitizeDeep($_POST['user_role']);

            $trigger = ''; // Need to check

            $userdata = apply_filters('user_meta_pre_user_import', $userdata, $trigger);

            // User registration
            if (! $user_id) {
                $umUserInsert = new UserInsert();
                $response = $umUserInsert->importUsersProcess($userdata, $user_id);
                if (! is_wp_error($response)) {
                    $this->_updateRawPassword($userdata, $response);
                    do_action('user_meta_after_user_import', (object) $response, $trigger, $userdata);
                    if (isset($_POST['send_email']))
                        do_action('user_meta_after_user_register', (object) $response);
                    $import_count['created'] ++;
                }

                // User update
            } elseif ($user_id && ! empty($_POST['overwrite'])) {
                $umUserInsert = new UserInsert();
                $response = $umUserInsert->importUsersProcess($userdata, $user_id);
                if (! is_wp_error($response)) {
                    $this->_updateRawPassword($userdata, $response);
                    do_action('user_meta_after_user_import', (object) $response, $trigger, $userdata);
                    $import_count['updated'] ++;
                }
            }

            // add_user_to_blog
            if ($user_id && $is_multisite && ! empty($_POST['add_user_to_blog'])) {
                if (! is_user_member_of_blog($user_id, $blog_id)) {
                    $role = isset($userdata['role']) ? $userdata['role'] : $default_role;
                    add_user_to_blog($blog_id, $user_id, $role);
                    $import_count['added'] ++;
                }
            }

            $import_count['rows'] ++;
            unset($userdata);
            $n ++;
        } // End While

        set_transient('user_meta_user_import', $import_count, 3600);

        $file_pointer = ftell($file);
        fclose($file);

        if ($file_pointer < $filesize) {
            $percent = floor(($file_pointer * 100) / $filesize);
            $is_loop = true;
        } else {
            $percent = 100;
            $is_loop = false;
        }

        $this->updateLastImport();

        return $userMeta->renderPro('importStep3', array(
            'file_pointer' => $file_pointer,
            'percent' => $percent,
            'is_loop' => $is_loop,
            'import_count' => $import_count
        ), 'exportImport');
    }

    function updateLastImport()
    {
        global $userMeta;

        $csv_header = ! empty($_POST['csv_header']) ? sanitizeDeep($_POST['csv_header']) : array();
        $selected_field = ! empty($_POST['selected_field']) ? sanitizeDeep($_POST['selected_field']) : array();
        $custom_field = ! empty($_POST['custom_field']) ? sanitizeDeep($_POST['custom_field']) : array();

        $lastImport = array();

        if (! empty($csv_header) && ! empty($selected_field))
            $lastImport['selected_field'] = array_combine($csv_header, $selected_field);

        if (! empty($csv_header) && ! empty($custom_field))
            $lastImport['custom_field'] = array_combine($csv_header, $custom_field);

        $lastImport['import_by'] = ! empty($_POST['import_by']) ? sanitizeDeep($_POST['import_by']) : '';
        $lastImport['user_role'] = ! empty($_POST['user_role']) ? sanitizeDeep($_POST['user_role']) : '';

        $lastImport['overwrite'] = ! empty($_POST['overwrite']) ? true : false;
        $lastImport['send_email'] = ! empty($_POST['send_email']) ? true : false;
        $lastImport['add_fields'] = ! empty($_POST['add_fields']) ? true : false;

        $cache = $userMeta->getData('cache');
        $cache['last_users_import'] = $lastImport;
        $userMeta->updateData('cache', $cache);
    }

    function _updateRawPassword($userdata, $response)
    {
        global $wpdb;

        if (empty($userdata['user_pass']) || (34 != strlen($userdata['user_pass'])))
            return;

        $wpdb->update($wpdb->users, array(
            'user_pass' => $userdata['user_pass']
        ), array(
            'ID' => $response['ID']
        ));
    }
}