<?php
namespace UserMeta\WooCommerce;

global $userMeta;
?>

<div>
    <!-- Nav tabs -->
    <ul class='nav nav-tabs' role='tablist'>
        <li role='presentation' class="nav-item"><a class="nav-link active" href='#um_addon_woocommerce_account'
                                                  aria-controls='um_addon_woocommerce_account' role='tab'
                                                  data-bs-toggle='tab'><?php _e('WC Profile', $userMeta->name) ?></a></li>
        <li role='presentation' class="nav-item"><a class="nav-link" href='#um_addon_woocommerce_registration'
                                   aria-controls='um_addon_woocommerce_registration'
                                   role='tab' data-bs-toggle='tab'><?php _e('WC Registration', $userMeta->name) ?></a></li>
        <li role='presentation' class="nav-item"><a class="nav-link" href='#um_addon_woocommerce_checkout' aria-controls='um_addon_woocommerce_checkout'
                                   role='tab' data-bs-toggle='tab'><?php _e('WC Checkout', $userMeta->name) ?></a></li>
    </ul>

    <!-- Tab panes -->
    <div class='tab-content'>
        <div role='tabpanel' class='tab-pane active'
             id='um_addon_woocommerce_account'><?php echo Base::view('profile',
				['data' => $data, 'fields' => $fields]); ?></div>
        <div role='tabpanel' class='tab-pane'
             id='um_addon_woocommerce_registration'><?php echo Base::view('registration',
				['data' => $data, 'fields' => $fields]); ?></div>
        <div role='tabpanel' class='tab-pane'
             id='um_addon_woocommerce_checkout'><?php echo Base::view('checkout',
				['data' => $data, 'fields' => $fields]); ?></div>
    </div>

</div>

<script>
    jQuery(function () {
        jQuery('.um_addon_woocommerce_multiple').multiselect({
            includeSelectAllOption: true,
            enableClickableOptGroups: true
        });
    });
</script>