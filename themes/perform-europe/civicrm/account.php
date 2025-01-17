<?php
/**
 * Proposal
 */
get_header(); 
$make_profile_private = get_user_meta( get_current_user_id(), 'make_profile_private' , true ); 
$sent_request_notify = get_user_meta( get_current_user_id(), 'sent_request_notify' , true ); 
$request_not_accept = get_user_meta( get_current_user_id(), 'request_not_accept' , true ); 
$accept_request_notify = get_user_meta( get_current_user_id(), 'accept_request_notify' , true ); ?>
<div class="action-warning">
    <div class="warning__cont">
        <p class="txt-2rem">Thank you! We’ll carefully review your proposal and get back to you.</p>
        <div class="warning__cta">
            <a href="/create-account-form" class="btn-large--warning w-inline-block">
                <div class="btn__txt">Return to My Proposals</div>
            </a>
        </div>
    </div>
</div>

<section class="section-wrp s-accoutn-first">
    <div class="page__title-wrp">
        <h1 class="page__title">My account</h1><a href="<?php echo home_url('user/logout') ?>" class="btn-transparent--dark w-inline-block">
            <div class="txt-block--1rem">log out</div>
        </a>
    </div>
    <div class="account__slider">
		<h3 class="account__subtitle">Welcome back! <span class="h-link-small"><a href="<?php echo esc_url( get_author_posts_url( wp_get_current_user()->ID ) ) ;?>" class="first w-inline-block">View your public profile</a></span></h3>
        <div class="slider-wrp">
            <div class="p-slider">
				<a href="/edit-profile/" class="account__slider__itm w-inline-block">
                    <div class="slider__title">Edit my profile</div>
                    <div class="slider__txt txt--50">Edit your information.</div>
                    <div class="slider__icon"><img
                            src="https://performeurope.eu/wp-content/uploads/2023/11/arrow-btn.svg"
                            loading="eager" alt="" class="img"></div>
                </a>
				<a href="/partners" class="account__slider__itm w-inline-block">
                    <div class="slider__title">Find partners</div>
                    <div class="slider__txt txt--50">Network and find your ideal partners for the call.</div>
                    <div class="slider__icon"><img
                            src="https://performeurope.eu/wp-content/uploads/2023/11/arrow-btn.svg"
                            loading="eager" alt="" class="img"></div>
                </a></div>
        </div>
    </div>
    <div class="form">
        <div class="form__title">
            <h3 class="account__subtitle">General settings</h3>
        </div>
        <div class="form__itm-wrp">
            <div class="form__radio-wrp">
                <div class="form__radio">
                    <div class="profile-private-checkbox check-box <?php if($make_profile_private == 1){ echo 'is--checked'; } ?>"></div>
                    <div class="form__txt--small">Make my profile private</div>
                </div>
                <div class="form__radio__explain__txt">You will not appear in search results.</div>
            </div>
            <div class="form__subtitle">
                <div class="txt-block">Quick match &nbsp;settings</div>
                <div class="form__title__descr"><?php echo get_field('dashboard_quick_match_heading','option');?></div>
            </div>
            <div class="form__radio-wrp">
                <div class="form__radio">
                    <div class="check-box sent-request-notify <?php if($sent_request_notify == 1){ echo 'is--checked'; } ?>"></div>
                    <div class="form__txt--small">Receive email notifications for matching requests</div>
                </div>                
            </div>
            <div class="form__radio-wrp">
                <div class="form__radio">
                    <div class="check-box accept-request <?php if($accept_request_notify == 1){ echo 'is--checked'; } ?>"></div>
                    <div class="form__txt--small">Receive email notifications when a match is accepted</div>
                </div>                
            </div>
            <div class="form__radio-wrp">
                <div class="form__radio">
                    <div class="check-box request-not-accept <?php if($request_not_accept == 1){ echo 'is--checked'; } ?>"></div>
                    <div class="form__txt--small">Receive email notifications when a match is refused</div>
                </div>                
            </div>
            <div class="form__subtitle--nomargin">Delete my account</div>            
			<a href="mailto:info@performeurope.eu?subject=Perform Europe Website -Delete my account&body=Dear team, I would like to put request to delete my account {user_email}. Thank you." class="btn__link-block w-inline-block"> <div class="txt--small">Delete my account</div></a>
        </div>
    </div>
</section><?php
get_footer();?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        jQuery("body").addClass('pe-body--white');
        jQuery(".footer").addClass('footer--dark');
        $('.profile-private-checkbox').click(function(){
            if ($(this).hasClass("is--checked")) {
                var checkbox = 1;
            }
            else{
                var checkbox = 2;
            }
            var user_id = '<?php echo get_current_user_id(); ?>';
            jQuery.ajax({
              type: "POST",
              url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
              data: ({ action : 'private_profile_checked', user_id : user_id, 'checkbox' : checkbox}),
              success: function(response)
              {   
              }
            });
        });

        $('.sent-request-notify').click(function(){
            if ($(this).hasClass("is--checked")) {
                var checkbox = 1;
            }
            else{
                var checkbox = 2;
            }
            var user_id = '<?php echo get_current_user_id(); ?>';
            jQuery.ajax({
              type: "POST",
              url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
              data: ({ action : 'sent_match_request', user_id : user_id, 'sent_request_notify' : checkbox}),
              success: function(response)
              {   
              }
            });
        });

        $('.accept-request').click(function(){
            if ($(this).hasClass("is--checked")) {
                var checkbox = 1;
            }
            else{
                var checkbox = 2;
            }
            var user_id = '<?php echo get_current_user_id(); ?>';
            jQuery.ajax({
              type: "POST",
              url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
              data: ({ action : 'accept_user_request', user_id : user_id, 'accept_request_notify' : checkbox}),
              success: function(response)
              {   
              }
            });
        });

        $('.request-not-accept').click(function(){
            if ($(this).hasClass("is--checked")) {
                var checkbox = 1;
            }
            else{
                var checkbox = 2;
            }
            var user_id = '<?php echo get_current_user_id(); ?>';
            jQuery.ajax({
              type: "POST",
              url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
              data: ({ action : 'request_rejected', user_id : user_id, 'request_not_accept' : checkbox}),
              success: function(response)
              {   
              }
            });
        });

        $('.delete-account').click(function(){
            var user_id = '<?php echo get_current_user_id(); ?>';
            jQuery.ajax({
              type: "POST",
              url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
              data: ({ action : 'delete_account', user_id : user_id}),
              success: function(response){ 
                location.reload();  
              }
            });
        });

    });
</script>