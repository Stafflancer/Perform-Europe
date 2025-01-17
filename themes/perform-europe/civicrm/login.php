<?php
/**
 * Login
 */
if(!is_user_logged_in() ) {
	wp_redirect( home_url('/login') ); exit;
}
get_header();

?>

<section class="section-wrp s-login">
    <div class="page-content-wrp">
        <div class="page__title-wrp">
            <h1 class="page__title">Login</h1>
        </div>
    </div>
</section>
<section class="section-wrp s-login-form">
    <?php
    if (isset($_SESSION['civicrm_theme_notices']) && $_SESSION['civicrm_theme_notices']) {
        if (isset($_SESSION['civicrm_theme_notices']['type']) && $_SESSION['civicrm_theme_notices']['type'] == 'error') { ?>
            <div style="color: red;"><?php echo $_SESSION['civicrm_theme_notices']['message']; ?></div>
    <?php }
    }
    ?>    
    <div class="login__form-wrp">
        
        <form  id="w-node-_1ed4cdcb-eaa9-f426-c31b-197925c873c9-a709e52f" class="login-form" method="POST" action="<?php echo site_url(); ?>/wp-admin/admin-post.php">
            <input type="hidden" name="action" value="muyadev_login_user"/>
            <div class="form">
                <div class="form__itm">
                    <input class="form__input" type="text" type="email" name="email" id="email" placeholder="Email">
                    <div class="form__required">*</div>
                </div>
                <div class="form__itm">
                    <input class="form__input" type="password" id="password" name="password" placeholder="Password">
                    <div class="form__required">*</div>
                </div>
                <div class="form__radio">
                    <div class="check-box is--checked"></div>
                    <div class="form__txt--small">Remember me</div>
                </div>
            </div>
            <div class="btn-large">
                <input class="btn__submit" type="submit">
                <div class="btn__txt">login</div>
            </div>
        </form>
		<div id="w-node-_1ed4cdcb-eaa9-f426-c31b-197925c873dc-a709e52f" class="no-account-wrp">
		<?php if(get_field('account_creation_menu_hide','option') != '1')  { ?>        
            <div class="txt-h4">Don’t have an account yet?</div><a href="/user/create-account" class="link-small">Create an
                account</a>      
		<?php } ?>
		</div>
		<a id="w-node-_1ed4cdcb-eaa9-f426-c31b-197925c873e1-a709e52f" href="/user/forgot-password"
            class="forgot-wrp w-inline-block">
            <div id="w-node-_1ed4cdcb-eaa9-f426-c31b-197925c873e2-a709e52f" class="link-small">forgot your
                password?</div>
        </a>
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