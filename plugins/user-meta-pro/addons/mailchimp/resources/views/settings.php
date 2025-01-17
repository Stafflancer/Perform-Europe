<?php

namespace UserMeta\MailChimp;

use UserMeta\Html\Html;

?>

<br>
<label for='um_addon_mailchimp_subscription_on_registration'>
    <?php echo Html::checkbox(!empty($data['subscription_on_registration']), [
        'name' => 'subscription_on_registration',
        'id' => 'um_addon_mailchimp_subscription_on_registration'
    ]); ?>
    <?php echo __('Subscription Option on Registration', 'user-meta'); ?>
</label>
<br>

<label for='um_addon_mailchimp_subscription_on_profile'>
    <?php echo Html::checkbox(!empty($data['subscription_on_profile']), [
        'name' => 'subscription_on_profile',
        'id' => 'um_addon_mailchimp_subscription_on_profile'
    ]); ?>
    <?php echo __('Mailchimp Member Data Sync on Profile Update', 'user-meta'); ?>
</label>
<hr>

<label for='um_addon_mailchimp_subscription_without_permission'>
    <?php echo Html::checkbox(!empty($data['subscription_without_permission']), [
        'name' => 'subscription_without_permission',
        'id' => 'um_addon_mailchimp_subscription_without_permission'
    ]); ?>
    <?php echo __('Subscribe user without asking permission via email', 'user-meta'); ?>
</label>
<br>
<?php echo __('(User will be in pending state when disabled and can permit the subscription via received email', 'user-meta'); ?>

<p><br>
    <?php echo Html::select(isset($data['permission_field']) ? $data['permission_field'] : '', [
        'name' => 'permission_field',
        'id' => 'um_addon_mailchimp_permission_field',
        'label' => [
            __('Subscription Check Field on Form', 'user-meta'),
            'class' => 'col-sm-6',
        ],
    ], $fields); ?><br>
    <?php echo __('(Should be a consent or single checkbox field. Empty value means no permission field needed)', 'user-meta'); ?>
</p>

<hr>

<p>
    <?php echo Html::select(isset($data['list_selection_method']) ? $data['list_selection_method'] : '', [
        'name' => 'list_selection_method',
        'id' => 'um_addon_mialchimp_list_selection_method',
        'label' => [
            __('Subscription List Selection Method', 'user-meta'),
            'class' => 'col-sm-6',
        ],
    ], $list); ?>
</p>
<br>

<p>
    <?php echo Html::select(isset($data['list_selection_field']) ? $data['list_selection_field'] : '', [
        'name' => 'list_selection_field',
        'id' => 'um_addon_mialchimp_list_selection_field',
        'label' => [
            __('Subscription List Selection Field', 'user-meta'),
            'class' => 'col-sm-6',
        ],
    ], $fields); ?><br>
    <?php echo __('(Should be a select or multiselect field. Field option values need to be the list IDs)', 'user-meta'); ?>
</p>

<p>
    <?php echo Html::text(isset($data['list_selection_text']) ? $data['list_selection_text'] : '', [
        'name' => 'list_selection_text',
        'id' => 'um_addon_mialchimp_list_selection_text',
        'label' => [
            __('Subscription List IDs', 'user-meta'),
            'class' => 'col-sm-6',
        ],
    ]); ?><br>
    <?php echo __('(Use comma separation for multiple IDs)', 'user-meta'); ?>
</p>

<hr>

<p>
    <?php echo Html::select(isset($data['tag_selection_method']) ? $data['tag_selection_method'] : '', [
        'name' => 'tag_selection_method',
        'id' => 'um_addon_mialchimp_tag_selection_method',
        'label' => [
            __('Tag Selection Method', 'user-meta'),
            'class' => 'col-sm-6',
        ],
    ], $tag); ?>
</p>

<br>

<p>
    <?php echo Html::select(isset($data['tag_selection_field']) ? $data['tag_selection_field'] : '', [
        'name' => 'tag_selection_field',
        'id' => 'um_addon_mialchimp_tag_selection_field',
        'label' => [
            __('Tag List Selection Field', 'user-meta'),
            'class' => 'col-sm-6',
        ],
    ], $fields); ?><br>
    <?php echo __('(Should be a select or multiselect field. Field option values need to be the tags)', 'user-meta'); ?>
</p>

<p>
    <?php echo Html::text(isset($data['tag_selection_text']) ? $data['tag_selection_text'] : '', [
        'name' => 'tag_selection_text',
        'id' => 'um_addon_mialchimp_tag_selection_text',
        'label' => [
            __('Tag(s) Value', 'user-meta'),
            'class' => 'col-sm-6',
        ],
    ]); ?><br>
    <?php echo __('(Use comma separation for multiple tags)', 'user-meta'); ?>
</p>

<hr>

<p>
    <label class='pf_label'> <?php echo __('Merge User Data with Mailchimp Audience Fields', 'user-meta') ?></label>
    <?php echo Html::text(!empty($data['merge_fields']) ? $data['merge_fields'] : '', [
        'name' => 'merge_fields',
        'style' => 'width:80%;'
    ]); ?>
</p>
<p><?php echo __('Enter merging field pair values with comma separation. Put : between mailchimp field tag and WordPress user field\'s metakey. E.g.', 'user-meta') ?>
<i> FNAME:first_name,LNAME:last_name</i></p>
<hr>

<p>
    <?php echo Html::select(isset($data['user_delete_action']) ? $data['user_delete_action'] : '', [
        'name' => 'user_delete_action',
        'label' => [
            __('Action on User Delete', 'user-meta'),
            'class' => 'col-sm-6',
        ],
    ], $delete); ?>
</p>

