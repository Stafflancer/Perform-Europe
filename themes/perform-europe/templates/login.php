<?php /* Template Name: Login Panel */

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
    <div class="login__form-wrps">
        
        <?php echo do_shortcode('[wpforms id="1319"]');?>		
		
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