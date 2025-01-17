<?php
/**
 * Showing single addon on admin section
 *
 * @uses Addons::addonPanel()
 */
?>

<div class="col-lg-6" style="min-height: 15em;">
	<div class="card card-default">
		<div class="card-body">

			<div class="um_ribbon <?= $active ? 'visible': 'invisible' ?>">
				<span>ACTIVE</span>
			</div>

			<div class="row">
				<div class="col-lg-3" style="text-align: center;">
					<i
						class="um_addon_icon <?= $active ? 'active': 'inactive'?> fa <?= $icon ?> fa-5x"></i>
				</div>

				<div class="col-lg-7">
					<h5><?= $title ?></h5>
					<div><?= $brief ?></div>
				</div>

				<div class="col-lg-2">
					<div>
						<input type="checkbox" class="um_switch_checkbox"
							data-addon='<?= json_encode($ajaxData) ?>'
							<?php if ($active) echo "checked"; ?> />
					</div>
					<div class="um_wait"></div>
				</div>
			</div>
		</div>

		<div class="card-footer">
			<div class="row">
				<div class="col-lg-6">
					<i class="fa fa-book"></i> <a href="<?= $url ?>">Documentation</a>
				</div>
				<div class="col-lg-6 um_options text-end <?= $active ? 'visible': 'invisible' ?>">
        			<?php if ($hasOption): ?>        			
        				<i class="dashicons dashicons-admin-settings"></i> <a
						href="#" data-bs-toggle="modal" data-bs-target="#um_modal_<?= $name ?>">Options</a>       			
        			<?php endif; ?>					
				</div>
			</div>
		</div>

	</div>
</div>