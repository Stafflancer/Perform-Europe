<?php /* Template Name: Create Account Information */

get_header();
?>

<section class="section-wrp s-login">
    <div class="page-content-wrp">
        <div class="page__title-wrp">
            <h1 class="page__title"><?php echo get_field('create_an_account_heading','option');?></h1>
        </div>
    </div>
</section>
<section class="section-wrp s-login-form">
    <div class="create-account-wrp">
        <?php echo get_field('create_an_account_page_description','option');?>
        <div class="login-form">
            <div class="form">
                <div class="form__radio">
                    <div class="check-box"></div>
                    <div class="form__txt--small">I have read the <a href="https://performeurope.eu/wp-content/uploads/2023/11/Perform-Europe-Open-Call-and-Guidelines.pdf" target="_blank" class="paragraph__link--black">Open
                            Call</a>*</div>
                </div>
            </div>
            <div class="btn-wrp--horizontal">
                <div id="btn-w-open" class="btn-large _50">
                    <div class="btn__txt">create an account</div>
                </div><a href="https://performeurope.eu/wp-content/uploads/2023/11/Perform-Europe-Open-Call-and-Guidelines.pdf" target="_blank" class="btn__link-block w-inline-block">
                    <div class="txt--small">Read the open call</div>
                </a>
            </div>
        </div>
    </div>
</section>


<div class="action-warning">
    <div class="warning__cont">
        <?php echo get_field('create_an_account_popup_text','option');?>
        <div class="warning__cta"><a href="/create-account-form" class="btn-large--warning w-inline-block">
                <div class="btn__txt">Yes, I’m sure</div>
            </a>
            <div id="btn-w-close" class="btn__link-block--warning">
                <div class="txt-small">Cancel</div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("body").addClass('pe-body--mint');
        jQuery(".footer").addClass('footer--dark');
    });
</script>