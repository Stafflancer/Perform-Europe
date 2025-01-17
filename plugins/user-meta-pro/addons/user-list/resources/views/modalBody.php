<?php
namespace UserMeta\UserList;
use UserMeta\Html\Html;

global $userMeta;
$UMPFields = new UMPFields();
$fields = $UMPFields->availableUMPFields();
$defaultColumns = $UMPFields->defaultColumns;

?>

<div>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="nav-item"><a href="#um_addon_user_list_configure" class="nav-link active"
			aria-controls="um_addon_user_list_configure" role="tab" data-bs-toggle="tab">Frontend Setup</a></li>
		<li role="presentation" class="nav-item"><a class="nav-link" href="#um_addon_user_list_help" aria-controls="um_addon_user_list_help"
			role="tab" data-bs-toggle="tab">Shortcode Guide</a></li>
        <li role="presentation" class="nav-item"><a class="nav-link" href="#um_addon_user_list_backend" aria-controls="um_addon_user_list_backend"
			role="tab" data-bs-toggle="tab">Backend Setup</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="um_addon_user_list_configure"> 
            <br>
            <h6><?php _e('Select Public Profile Page (for individual users):', $userMeta->name) ?></h6>
            <?php
            echo wp_dropdown_pages([
            'name' => 'public_profile_page',
            'class' => 'um_page_dropdown',
            'selected' => isset($data['public_profile_page']) ? $data['public_profile_page'] : '',
            'echo' => 0,
            'show_option_none' => 'None'
            ]);
            ?>
            <p><?php _e('Public profile page should contain public profile shortcode like:', $userMeta->name) ?> [user-meta type=public form="Form_Name"] or [user-meta-public-profile form="Form_Name"]</p>
            
        </div>
        
		<div role="tabpanel" class="tab-pane" id="um_addon_user_list_help">
            <br>
            <p style="text-align: center;">
                <?php _e('Basic Shortcode:',$userMeta->name) ?>
                <strong> [user-meta-user-list]</strong>
                <br>
                (this shortcode displays a user list with the link to user public profile)
            </p>
            <br>
            <div style="overflow-x:auto;">
                <style>
                    .um_addon_user_list_table_modal{table-layout: auto; width: 100%;}
                    .um_addon_user_list_table_modal td{word-wrap: break-word;}
                    .um_addon_user_list_table_modal th{text-align: center;}
                    .um_addon_user_list_table_modal td, .um_addon_user_list_table_modal th{border: 1px solid #ddd; padding: 8px;}
                </style>
                <table class="um_addon_user_list_table_modal">
                    <tr>
                        <th><?php _e('Option',$userMeta->name) ?></th>
                        <th><?php _e('Default',$userMeta->name) ?></th>
                        <th><?php _e('Description',$userMeta->name) ?></th>
                    </tr>
                    <tr>
                        <td><?php _e('caption',$userMeta->name) ?></td>
                        <td><?php _e('null',$userMeta->name) ?></td>
                        <td><?php _e('Caption of the user table. No caption by default.',$userMeta->name) ?><br>
                        <?php _e('Example:',$userMeta->name) ?> <input value='[user-meta-user-list caption="My Caption"]' size ="40"></td>
                    </tr>
                    <tr>
                        <td><?php _e('role',$userMeta->name) ?></td>
                        <td><?php _e('all',$userMeta->name) ?></td>
                        <td><?php _e('Filter users by role, write multiple roles with comma separation.',$userMeta->name) ?><br>
                        <?php _e('Example:',$userMeta->name) ?> <input value='[user-meta-user-list role="author,subscriber"]' size ="40"></td>
                    </tr>
                    <tr>
                        <td><?php _e('fields',$userMeta->name) ?></td>
                        <td><?php _e('null',$userMeta->name) ?></td>
                        <td><?php _e('Fields to display in the user table. Write multiple shared fields ID with comma separation. Without this option user list contains default fields.',$userMeta->name) ?><br>
                        <?php _e('Example:',$userMeta->name) ?> <input value='[user-meta-user-list fields="1,2,3,4"]' size ="40"></td>
                    </tr>
                    <tr>
                        <td><?php _e('link-field',$userMeta->name) ?></td>
                        <td><?php _e('null',$userMeta->name) ?></td>
                        <td><?php _e('Only applicable if fields option is applied. Pick fields id (with comma separation) that will contain the user public proflie link.',$userMeta->name) ?><br>
                        <?php _e('Example:',$userMeta->name) ?> <input value='[user-meta-user-list fields="1,2,3,4" link-field="1,2"]' size ="40"></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div role="tabpanel" class="tab-pane" id="um_addon_user_list_backend">
            <br>
            <?php
                echo '<p><label class="pf_label">' . __('Add Column (UMP Shared Field) to Backend User List', $userMeta->name) . '</label></p>';
                echo Html::multiselect(!empty($data['backend_add_column']) ? $data['backend_add_column'] : [], [
                    'name' => 'backend_add_column[]',
                    'class' => 'um_addon_user_list_multiple dropdown-item',
                    'enclose' => 'div'
                ], $fields);
                
                echo '<br>';
                
                echo '<p><label class="pf_label">' . __('Exclude Default Column from Backend User List', $userMeta->name) . '</label></p>';
                echo Html::multiselect(!empty($data['backend_exclude_column']) ? $data['backend_exclude_column'] : [], [
                    'name' => 'backend_exclude_column[]',
                    'class' => 'um_addon_user_list_multiple dropdown-item',
                    'enclose' => 'div'
                ], $defaultColumns);    
            ?>     
        </div>
	</div>
</div>

<script>
jQuery(function() {
    jQuery('.um_addon_user_list_multiple').multiselect({
    	includeSelectAllOption: true,
    	enableClickableOptGroups: true
    });
});
</script>