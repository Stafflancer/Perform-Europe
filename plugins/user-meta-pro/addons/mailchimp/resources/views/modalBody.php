<?php

namespace UserMeta\MailChimp;
Base::enqueScript('mailchimp.js');
?>

<div>
    <!-- Nav tabs -->
    <ul class='nav nav-tabs' role='tablist'>
        <li role='presentation' class='nav-item'><a href='#um_addon_mailchimp_api' class='nav-link active'
            aria-controls='um_addon_mailchimp_api' role='tab' data-bs-toggle='tab'><?php _e('API Setup', 'user-meta') ?></a></li>
        <li role='presentation' class="nav-item"><a href='#um_addon_mailchimp_settings' class='nav-link'
            aria-controls='um_addon_mailchimp_settings' role='tab' data-bs-toggle='tab'><?php _e('Settings', 'user-meta') ?></a></li>
        <li role='presentation' class="nav-item"><a href='#um_addon_mailchimp_import_export' class='nav-link'
            aria-controls='um_addon_mailchimp_import_export' role='tab' data-bs-toggle='tab'><?php _e('Import/Export', 'user-meta') ?></a></li>
        <li role='presentation' class="nav-item"><a href='#um_addon_mailchimp_log' class='nav-link'
            aria-controls='um_addon_mailchimp_log' role='tab' data-bs-toggle='tab'><?php _e('Logs', 'user-meta') ?></a></li>
    </ul>

    <!-- Tab panes -->
    <div class='tab-content'>
        <div role='tabpanel' class='tab-pane active' id='um_addon_mailchimp_api'>
            <?php echo Base::view('api', ['data' => $data, 'mc' => $mc]); ?>
        </div>
        <div role='tabpanel' class='tab-pane' id='um_addon_mailchimp_settings'>
            <?php echo Base::view('settings', ['data' => $data, 'fields' => $fields, 'list' => $list, 'tag' => $tag, 'delete' => $delete]); ?>
        </div>
        <div role='tabpanel' class='tab-pane' id='um_addon_mailchimp_import_export'>
            <?php echo Base::view('importExport'); ?>
        </div>
        <div role='tabpanel' class='tab-pane' id='um_addon_mailchimp_log'>
            <?php echo Base::view('logs'); ?>
        </div>
    </div>

</div>