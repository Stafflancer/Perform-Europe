<?php
namespace UserMeta;

class AjaxProModel
{

    function ajaxSaveEmailTemplate()
    {
        global $userMeta;
        $userMeta->verifyNonce(true);

        if (! isset($_REQUEST))
            $userMeta->showError(__('Error occurred while updating', $userMeta->name));

        $data = $userMeta->arrayRemoveEmptyValue($_REQUEST);
        //@todo use sanitizeDeep
        //$data = $userMeta->arrayRemoveEmptyValue(sanitizeDeep($_REQUEST));
        $data = $userMeta->removeNonArray($data);

        $userMeta->updateData('emails', stripslashes_deep($data));
        echo $userMeta->showMessage(__('Successfully saved.', $userMeta->name));
    }

    /**
     * Export UMP fields,forms,settings etc to txt file.
     */
    function ajaxExportUmp()
    {
        global $userMeta;
        $userMeta->verifyNonce(true);

        $result = array();
        $result['fields'] = $userMeta->getData('fields');

        if (! empty($_REQUEST['includes']) && is_array($_REQUEST['includes'])) {
            foreach (sanitizeDeep($_REQUEST['includes']) as $key) {
                $data = $userMeta->getData($key);
                if ($data)
                    $result[$key] = $data;
            }
        }

        $result = base64_encode(serialize($result));

        $siteName = str_replace(' ', '_', htmlspecialchars_decode(get_bloginfo('name')));
        $fileName = 'User_Meta_Pro_(' . $siteName . ')_' . date('Y-m-d_H-i') . '.txt';
        $userMeta->generateTextFile($fileName, $result);
        exit();
    }

    /**
     * Import UMP fields,forms,settings etc exported by UMP export tools.
     * Give user choice to replace existing data or add new data.
     */
    function ajaxImportUmp()
    {
        global $userMeta;
        $userMeta->verifyNonce(true);

        /**
         * Reading uploaded file and asssign file content to $data
         */
        if (empty($_REQUEST['filepath']))
            return $userMeta->showError(__('Something went wrong. File has not been uploaded', $userMeta->name));

        $uploads = $userMeta->determinFileDir(sanitize_text_field($_REQUEST['filepath']), true);
        if (empty($uploads))
            return $userMeta->showError(__('Something went wrong. File has not been uploaded', $userMeta->name));

        $fullpath = $uploads['path'];

        // $uploads = wp_upload_dir();
        // $fullpath = $uploads[ 'basedir' ] . $_REQUEST[ 'filepath' ];

        $data = file_get_contents($fullpath);
        $data = unserialize(base64_decode($data));

        /**
         * Run Import
         */
        if (isset($_REQUEST['do_import'])) {
            if (empty($_REQUEST['includes']) || ! is_array($_REQUEST['includes']))
                return $userMeta->showError(__('Nothing to import!', $userMeta->name));

            foreach (sanitizeDeep($_REQUEST['includes']) as $key => $action) {
                if (empty($data[$key]))
                    continue;

                if ($action == 'replace') {
                    $userMeta->updateData($key, $data[$key]);
                    $imported = true;
                } elseif ($action == 'add') {
                    if (is_array($data[$key])) {
                        $existingData = $userMeta->getData($key);
                        if (is_array($existingData))
                            $data[$key] = $existingData + $data[$key];
                        $userMeta->updateData($key, $data[$key]);
                        $imported = true;
                    }
                }
            }

            if (! empty($imported)) {
                $config = $userMeta->getData('config');
                $config = is_array($config) ? $config : array();
                $config['max_field_id'] = 0;
                $userMeta->updateData('config', $config);

                echo $userMeta->showMessage(__('Import completed.', $userMeta->name));
            } else
                echo $userMeta->showError(__('Nothing to import!', $userMeta->name));

            die();

        /**
         * Attempt for import
         */
        } elseif ((! empty($_REQUEST['field_id']) ? $_REQUEST['field_id'] : null) == 'txt_upload_ump_import') {
            echo $userMeta->renderPro('importUmStep2', array(
                'data' => $data
            ), 'exportImport');
        }
    }

    /**
     * Perform user exports by ajax call also save user export template.
     */
    function ajaxUserExport()
    {
        global $userMeta;
        $userMeta->verifyNonce(true);

        try {
            $export = new UserExport();
            $export->execute();
        } catch (\Throwable $t) {
            echo $t->getMessage();
        } catch (\Exception $t) {
            echo $t->getMessage();
        }
    }

    /**
     * Build user export forms in admin section and generate new form by ajax call.
     * verifyNonce is calling inside.
     */
    function ajaxUserExportForm($populateAll = false)
    {
        global $userMeta;

        $fieldsDefault = $userMeta->defaultUserFieldsArray();
        $fieldsDefault['user_avatar'] = __('Avatar', $userMeta->name);

        $fieldsMeta = array();
        $extraFields = $userMeta->getData('fields');
        if (is_array($extraFields)) {
            foreach ($extraFields as $data) {
                if (! empty($data['meta_key'])) {
                    $fieldTitle = ! empty($data['field_title']) ? $data['field_title'] : $data['meta_key'];
                    $fieldsMeta[$data['meta_key']] = $fieldTitle;
                }
            }
        }
        $fieldsAll = apply_filters('user_meta_user_exportable_fields', array_merge($fieldsDefault, $fieldsMeta));
        $roles = $userMeta->getRoleList();

        if ($populateAll) {
            $export = $userMeta->getData('export');
            $formsSaved = ! empty($export['user']) ? $export['user'] : '';
            if (is_array($formsSaved) && ! empty($formsSaved)) {
                foreach ($formsSaved as $formID => $formData) {
                    $fieldsSelected = $formData['fields'];
                    $fieldsAvailable = $fieldsAll;
                    if (is_array($fieldsSelected)) {
                        foreach ($fieldsSelected as $key => $val)
                            unset($fieldsAvailable[$key]);
                    }

                    echo $userMeta->renderPro('exportForm', array(
                        'formID' => $formID,
                        'fieldsSelected' => $fieldsSelected,
                        'fieldsAvailable' => $fieldsAvailable,
                        'roles' => $roles,
                        'formData' => $formData
                    ), 'exportImport');
                }

                $break = true;
            }

            $newUserExportFormID = (int) $userMeta->maxKey($formsSaved) + 1;
            echo "<input type=\"hidden\" id=\"new_user_export_form_id\" value=\"$newUserExportFormID\" />";
        }

        // / For default or new form
        if (empty($break)) {
            $formID = ! empty($_REQUEST['form_id']) ? $_REQUEST['form_id'] : 'default';
            if ($formID != 'default')
                $userMeta->verifyNonce(true);

            echo $userMeta->renderPro('exportForm', array(
                'formID' => $formID,
                'fieldsSelected' => array(),
                'fieldsAvailable' => $fieldsAll,
                'roles' => $roles
            ), 'exportImport');
        }
    }

    /**
     * Remove User Export Template by ajax call
     */
    function ajaxRemoveExportForm()
    {
        global $userMeta;
        $userMeta->verifyNonce(true);

        $export = $userMeta->getData('export');

        if (! empty($export['user'][$_REQUEST['form_id']]) && $export['user'][$_REQUEST['form_id']] != 'default') {
            unset($export['user'][$_REQUEST['form_id']]);
            $userMeta->updateData('export', $export);
        }
    }
}