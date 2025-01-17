<?php
/**
 * Showing addon modal on admin section
 *
 * @uses Addons::addonModal()
 */
?>

<div class="modal fade" id="um_modal_<?= $name ?>" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" style="min-width:50%;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">
					<i class="fa <?= $icon ?> um_addon_icon active"></i> <?= $title ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<!-- <span aria-hidden="true">&times;</span> -->
				</button>
			</div>
			<div class="modal-body">
				<form id="um_modal_form_<?= $name ?>">
    				<?= $body ?>
    			</form>
			</div>

			<div class="modal-footer">
				<div class="row">
					<div class="col-6">
						<div class="um_error_msg text-left"></div>
					</div>
					<div class="um_options text-right">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> &nbsp;
						<button type="button" class="um_save_button btn btn-primary"
							data-addon='<?= json_encode($ajaxData) ?>'>Save Changes</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>