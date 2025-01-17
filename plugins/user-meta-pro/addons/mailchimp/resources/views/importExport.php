<?php

namespace UserMeta\MailChimp;

?>

<br>
<h5><?php echo __('From MailChimp Contacts to WordPress User', 'user-meta'); ?></h5><br>
<ol>
    <li>
        <?php echo __('Click "Export Audience" in Mailchimp admin dashboard from ', 'user-meta'); ?>
        <a href="https://admin.mailchimp.com/lists/members/"><?php echo __('"Audience >> All Contacts"', 'user-meta')?></a>
    </li>
    <li><?php echo __('Choose "Export AS CSV" and a CSV file with contacts data would be generated', 'user-meta'); ?></li>
    <li>
        <?php echo __('Import users through "User Meta >> Export & Import" using ', 'user-meta'); ?>
        <a href="<?php echo get_admin_url(null, 'admin.php?page=user-meta-import-export'); ?>"><?php echo __('User Import Option', 'user-meta')?></a>
    </li>
</ol>
<br>
<h5><?php echo __('From WordPress User to MailChimp Contacts', 'user-meta'); ?></h5>
<ol>
    <li>
        <?php echo __('Export WordPress users as CSV through "User Meta >> Export & Import" where email field is required using', 'user-meta'); ?>
        <a href="<?php echo get_admin_url(null, 'admin.php?page=user-meta-import-export'); ?>"><?php echo __('User Export Option', 'user-meta')?></a>
    </li>
    <li><?php echo __('Go to "Audience >> All Contacts" on your Mailchimp dashboard', 'user-meta'); ?></li>
    <li><?php echo __('Under "Add Contacts", choose "Import contacts" and "Upload a file" option', 'user-meta'); ?></li>
    <li><?php echo __('Upload the CSV file and confirm status, tags or other fields matching', 'user-meta'); ?></li>
</ol>
