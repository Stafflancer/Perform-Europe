<?php

namespace UserMeta\MailChimp;

use UserMeta\Html\Html;

?>

<br>
<p>
    <label class='pf_label'> <?php echo __('MailChimp API Key', 'user-meta') ?></label>
<?php echo Html::text(!empty($data['api_key']) ? $data['api_key'] : '', [
    'name' => 'api_key',
    'style' => 'width:80%;'
]); ?>
</p>

<p><?php echo __('Enter your Mailchimp API key to connect with Mailchimp account.', 'user-meta')?>&nbsp;
<a href="https://admin.mailchimp.com/account/api"><?php echo __('Get your API key here!', 'user-meta')?></a></p>

<strong><?php echo __('Status', 'user-meta')?></strong><br>
<?php echo $mc->getStatus()?>
<?php echo $mc->getListHtml()?>
