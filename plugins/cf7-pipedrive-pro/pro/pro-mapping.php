<?php 
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;
if(vxcf_pipedrive::$is_pr){ 
if(isset($fields['user_id']) || isset($fields['owner_id'])){
$panel_count++;
$users=$this->post('users',$info_meta);
$meta_user=isset($meta['user']) ? $meta['user'] : '';
               ?>
     <div class="vx_div vx_refresh_panel ">    
      <div class="vx_head ">
<div class="crm_head_div"> <?php echo sprintf(esc_html__('%s. Object Owner',  'cf7-pipedrive' ),$panel_count); ?></div>
<div class="crm_btn_div"><i class="fa crm_toggle_btn fa-minus" title="<?php esc_html_e('Expand / Collapse','cf7-pipedrive') ?>"></i></div>
<div class="crm_clear"></div> 
  </div>                 
    <div class="vx_group ">
   <div class="vx_row"> 
   <div class="vx_col1"> 
  <label for="crm_owner"><?php esc_html_e("Assign Owner", 'cf7-pipedrive'); $this->tooltip('vx_owner_check');?></label>
  </div>
  <div class="vx_col2">
  <input type="checkbox" style="margin-top: 0px;" id="crm_owner" class="crm_toggle_check <?php if(empty($users)){echo 'vx_refresh_btn';} ?>" name="meta[owner]" value="1" <?php echo !empty($meta["owner"]) ? "checked='checked'" : ""?> autocomplete="off"/>
    <label for="owner"><?php esc_html_e("Yes, assign owner", 'cf7-pipedrive'); ?></label>
  </div>
<div class="clear"></div>
</div>
    <div id="crm_owner_div" style="<?php echo empty($meta["owner"]) ? "display:none" : ""?>">
  <div class="vx_row">
  <div class="vx_col1">
  <label><?php esc_html_e('Users List','cf7-pipedrive'); $this->tooltip('vx_owners'); ?></label>
  </div>
  <div class="vx_col2">
  <button class="button vx_refresh_data" data-id="refresh_users" type="button" autocomplete="off" style="vertical-align: baseline;">
  <span class="reg_ok"><i class="fa fa-refresh"></i> <?php esc_html_e('Refresh Data','cf7-pipedrive') ?></span>
  <span class="reg_proc"><i class="fa fa-refresh fa-spin"></i> <?php esc_html_e('Refreshing...','cf7-pipedrive') ?></span>
  </button>
  </div> 
   <div class="clear"></div>
  </div> 

  <div class="vx_row">
   <div class="vx_col1">
  <label for="crm_sel_user"><?php esc_html_e('Select User','cf7-pipedrive'); $this->tooltip('vx_sel_owner'); ?></label>
</div> 
<div class="vx_col2">

  <select id="crm_sel_user" name="meta[user]" style="width: 100%;" class="vx_input_100" autocomplete="off">
  <?php echo $this->gen_select($users,$meta_user,__('Select User','cf7-pipedrive')); ?>
  </select>

   </div>

   <div class="clear"></div>
   </div>
 
  
  </div>
  

  </div>
  </div>
 <?php
 }               

$id=$this->post('id',$feed);
if(isset($fields['person_id']) || in_array($module,array('deal','lead')) ){
      $panel_count++;
      $contact_feeds=$this->get_object_feeds($form_id,$this->account,'person',$id);  
  ?>
    <div class="vx_div vx_refresh_panel ">    
      <div class="vx_head ">
<div class="crm_head_div"> <?php  echo sprintf(esc_html__('%s. Assign Contact',  'cf7-pipedrive' ),$panel_count); ?></div>
<div class="crm_btn_div"><i class="fa crm_toggle_btn fa-minus" title="<?php esc_html_e('Expand / Collapse','cf7-pipedrive') ?>"></i></div>
<div class="crm_clear"></div> 
  </div>                 
    <div class="vx_group ">

        <div class="vx_row"> 
   <div class="vx_col1"> 
  <label for="contact_check"><?php esc_html_e("Assign Contact ", 'cf7-pipedrive'); $this->tooltip('vx_assign_contact');?></label>
  </div>
  <div class="vx_col2">
  <input type="checkbox" style="margin-top: 0px;" id="contact_check" class="crm_toggle_check" name="meta[contact_check]" value="1" <?php echo !empty($meta["contact_check"]) ? "checked='checked'" : ""?> autocomplete="off"/>
    <label for="contact_check"><?php esc_html_e("Enable", 'cf7-pipedrive'); ?></label>
  </div>
<div class="clear"></div>
</div>
    <div id="contact_check_div" style="<?php echo empty($meta["contact_check"]) ? "display:none" : ""?>">
         <div class="vx_row">
   <div class="vx_col1">
  <label for="crm_sel_contact"><?php esc_html_e('Select Contact Feed ','cf7-pipedrive'); $this->tooltip('vx_sel_contact'); ?></label>
</div> 
<div class="vx_col2">

  <select id="crm_sel_contact" class="vx_input_100" name="meta[object_contact]" style="width: 100%;" autocomplete="off">
  <?php echo $this->gen_select($contact_feeds ,$this->post('object_contact',$meta),__('Select Contact Feed','cf7-pipedrive')); ?>
  </select>
  
  <div class="howto"><?php echo sprintf(__('Go to "Pipedrive Feeds" tab and Create a feed , select %s Object in this feed then choose that feed in this dropdown','cf7-pipedrive'),'<code>Contact</code>')?></div>  
   </div>

   <div class="clear"></div>
   </div>
   
    </div>

  </div>
  </div>
    <?php
  }
  
if(isset($fields['org_id']) || in_array($module,array('person','deal','lead')) ){
      $panel_count++;
      $org_feeds=$this->get_object_feeds($form_id,$this->account,'organization',$id);  
  ?>
    <div class="vx_div vx_refresh_panel ">    
      <div class="vx_head ">
<div class="crm_head_div"> <?php  echo sprintf(esc_html__('%s. Assign Organization',  'cf7-pipedrive' ),$panel_count); ?></div>
<div class="crm_btn_div"><i class="fa crm_toggle_btn fa-minus" title="<?php esc_html_e('Expand / Collapse','cf7-pipedrive') ?>"></i></div>
<div class="crm_clear"></div> 
  </div>                 
    <div class="vx_group ">

        <div class="vx_row"> 
   <div class="vx_col1"> 
  <label for="org_check"><?php esc_html_e("Assign Organization", 'cf7-pipedrive'); $this->tooltip('vx_assign_org');?></label>
  </div>
  <div class="vx_col2">
  <input type="checkbox" style="margin-top: 0px;" id="org_check" class="crm_toggle_check" name="meta[org_check]" value="1" <?php echo !empty($meta["org_check"]) ? "checked='checked'" : ""?> autocomplete="off"/>
    <label for="org_check"><?php esc_html_e("Enable", 'cf7-pipedrive'); ?></label>
  </div>
<div class="clear"></div>
</div>
    <div id="org_check_div" style="<?php echo empty($meta["org_check"]) ? "display:none" : ""?>">
         <div class="vx_row">
   <div class="vx_col1">
  <label for="crm_sel_org"><?php esc_html_e('Select Organization Feed','cf7-pipedrive'); $this->tooltip('vx_sel_org'); ?></label>
</div> 
<div class="vx_col2">

  <select id="crm_sel_org" class="vx_input_100" name="meta[object_org]" style="width: 100%;" autocomplete="off">
  <?php echo $this->gen_select($org_feeds ,$this->post('object_org',$meta),__('Select Organization Feed','cf7-pipedrive')); ?>
  </select>
<div class="howto"><?php echo sprintf(__('Go to "Pipedrive Feeds" tab and Create a feed , select %s Object in this feed then choose that feed in this dropdown','cf7-pipedrive'),'<code>Organization</code>')?></div> 
   </div>

   <div class="clear"></div>
   </div>
    </div>

  </div>
  </div>
    <?php
  }

}
?>

