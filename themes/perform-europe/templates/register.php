<?php /* Template Name: Create an Account */

get_header();

?>


<section class="section-wrp s-login">
    <div class="page-content-wrp">
        <div class="page__title-wrp">
            <h1 class="page__title"><?php echo get_field('create_an_account_form_heading','option');?></h1>
        </div>
    </div>
</section>
<section class="section-wrp s-login-form">
 
    <div class="create-account-wrps">
        <?php echo do_shortcode("[wpforms id='1135']");?>
		<div style="float:right;">
		<div id="w-node-_0246cced-2d63-c13d-409b-a2b5454abf90-a709e52f" class="form__preview-wrp">
                            <div id="w-node-ec3cd385-1cfd-6c73-3ee1-fbaf59f0f91c-a709e52f" class="form__preview">
                                <img src="https://performeurope.eu/wp-content/uploads/2023/11/profile_illustration.svg" loading="lazy" alt="" class="form__preview__img">
                            </div>
                        </div>
		</div>
    </div>
</section>
<style>
	.footer--dark{clear:both;}</style>
<?php
get_footer();
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("body").addClass('pe-body--mint');
        jQuery(".footer").addClass('footer--dark');
    });
</script>