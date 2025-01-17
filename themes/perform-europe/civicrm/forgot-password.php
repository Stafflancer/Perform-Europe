<?php

/**
 * Forgot Password
 */

get_header();
?>

<section class="section-wrp s-login">
    <div class="page-content-wrp">
        <div class="page__title-wrp">
            <h1 class="page__title">Lost Password</h1>
        </div>
    </div>
</section>
<section class="section-wrp s-login-form">

    <?php if (isset($_SESSION['civicrm_theme_notices']['type']) && $_SESSION['civicrm_theme_notices']['type'] == 'error') { ?>
                <div style="color: red;"><?php echo $_SESSION['civicrm_theme_notices']['message']; ?></div>
    <?php } ?>
    <?php if (isset($_SESSION['civicrm_theme_notices']['type']) && $_SESSION['civicrm_theme_notices']['type'] == 'success') { ?>
                <div style="color: green;"><?php echo $_SESSION['civicrm_theme_notices']['message']; ?></div>
    <?php } ?>

    <div class="login__form-wrp">
        <form method="POST" action="<?php echo site_url(); ?>/wp-admin/admin-post.php" id="w-node-_26e1a73a-8ed6-2161-f2b8-c0513b8937d3-a709e52f" class="login-form">
            <input type="hidden" name="action" value="muyadev_forgotpass_user"/>    
            <div class="form">
                <div class="form__itm">
                    <input class="form__input" required type="email" name="email" placeholder="My email">
                    <div class="form__required">*</div>
                </div>
            </div>
            <div class="btn-large">
                <input class="btn__submit" type="submit">
                <div class="btn__txt">reset my password</div>
            </div>
        </form>
        <div id="w-node-_26e1a73a-8ed6-2161-f2b8-c0513b8937dd-a709e52f" class="no-account-wrp">
            <div class="txt-h4">Don’t have an account yet?</div><a href="/user/create-account" class="link-small">Create an account</a>
        </div>
    </div>
</section>

<?php
get_footer();
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("body").addClass('pe-body--mint');
        jQuery(".footer").addClass('footer--dark');
    });
</script>