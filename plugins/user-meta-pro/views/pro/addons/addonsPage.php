<?php
namespace UserMeta;

global $userMeta;
?>

<div class="wrap">
	<div>
		<h2 class="text-center" style="padding: 1em">
			<i class="fa fa-plug"></i>
    			<?php _e( 'User Meta Pro Add-ons', $userMeta->name ); ?>
    	</h2>
    	<?php do_action('um_admin_notice'); ?>
	</div>

	<div id="dashboard-widgets-wrap">
		<div id="um_addons_admin">
			<div class="row" style="padding: 1em">		
				<?php (new Addons())->showAddons(); ?>					
			</div>
		</div>
	</div>
</div>


<style>
.um_addon_icon {
	padding-top: 20px;
}

.um_addon_icon.active {
	color: #79A70A;
}

.um_addon_icon.inactive {
	color: #999;
}
</style>