<?php /* Template Name: Reset Password*/

get_header();

?>


<section class="section-wrp s-login">
    <div class="page-content-wrp">
        <div class="page__title-wrp">
            <h1 class="page__title"><?php the_title();?></h1>
        </div>
    </div>
</section>
<section class="section-wrp s-login-form">
 
     
        <?php the_content();?>
     
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