<?php /* Template Name: Partners */
get_header(); 
error_reporting(0); 
global $wpdb;
$table_name = 'partners_status';
$total_approve = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND status = 'approve' OR current_user_id = ".get_current_user_id()." AND status = 'approve') ");
$total_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND status = 'request') ");
$total_sent = $wpdb->get_results("SELECT * FROM $table_name WHERE (current_user_id = ".get_current_user_id()." AND status = 'request') "); 
$total_fav = $wpdb->get_results("SELECT count(id) as total_favs FROM favourite_partners WHERE (current_user_id = ".get_current_user_id().")");  
?>

<section class="section-wrp s-project-first">
    <div class="page-content-wrp">
        <h1 class="page__title">Find partners</h1>
    </div>
</section>
<section class="section-wrp s-project-search">
    <div class="find-partners__tab-wrp">
        <div class="tab__itm opacity-new active" onclick="myFunction()">
            <div class="txt-block">View all</div>
        </div>
        <div class="tab__itm opacity-new my-favorites"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/star.svg"
                loading="eager" alt="" class="tab__icon">
            <div class="txt-block hide-mobile">My favorites</div>
			<div class="txt__notification"><?php echo $total_fav[0]->total_favs; ?></div>
        </div>
        <div class="tab__itm opacity-new get-matches"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/icon.svg"
                loading="eager" alt="" class="tab__icon">
            <div class="txt-block hide-mobile">My matches</div>
            <div class="txt__notification"><?php echo count($total_approve); ?></div>
        </div>
        <div class="tab__itm opacity-new get-recive-request"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/vector.svg"
                loading="eager" alt="" class="tab__icon">
            <div class="txt-block hide-mobile">Request</div>
            <div class="txt__notification"><?php echo count($total_request); ?></div>
        </div>
        <div class="tab__itm opacity-new get-sent-request"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/6510a8f49935a84b92661f93_Vector%20(3).svg"
                loading="eager" alt="" class="tab__icon">
            <div class="txt-block hide-mobile">Sent</div>
            <div class="txt__notification"><?php echo count($total_sent); ?></div>
        </div>
    </div>
    <div class="search-wrp">
        <div class="search__bar--blue">
            <input type="text" class="searchbar__txt search__bar__txt search-input-ajax" name="keyword" style="background-color: rgba(0, 0, 255, .0);" placeholder="search an organisation">
    	</div>
        <div class="search__suggestions hide">
           
        </div>
    </div>
    <div class="project__list">
        <div class="project-list__head">
            <div class="project-list__itm--head find-partners list__head">
                <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e8f-a709e52f" class="txt-block hide-mobile">
                    Preview</div>
                <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e91-a709e52f" class="txt-block">Name and
                    Country</div>
                <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e93-a709e52f" class="txt-block hide-mobile">
                    Offer</div>
                <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e95-a709e52f" class="txt-block hide-mobile">
                    Needs</div>
                <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e97-a709e52f" class="txt-block hide-mobile">
                    Performing arts</div>
                <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e99-a709e52f" class="txt-block hide-mobile">
                    Topics covered</div>
            </div>
        </div>
        <div class="product-row"><?php        
            $no = 20;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            if($paged==1){
              $offset=0;  
            }else {
               $offset= ($paged-1)*$no;
            }
            $user_query = new WP_User_Query( 
                array(
                    'role' => 'Subscriber',  
                    'number' => $no, 
                    'offset' => $offset,
				 	'orderby' => 'ID',
                    'order'   => 'DESC',		
                    'exclude' => array( get_current_user_id() ),
                    'meta_query'    => array(
                        'relation' => 'AND', 
                          array( 
                              'key'     => 'make_profile_private',
                              'value'   => 2,
                              'compare' => '=',
                          ),
                         array( 
                            'key'     => 'wpforms-pending',                            
                            'compare' => 'NOT EXISTS',
                        )
                    )
                ) 
            );
            if ( ! empty( $user_query->results ) ) {
                foreach ( $user_query->results as $user ) {
                    $user_meta = get_user_meta($user->ID); 
					$get_email = get_userdata($user->ID);					
                    $full_name = $user_meta['first_name'][0].' '.$user_meta['last_name'][0]; ?>
                    <div class="project-list__itm-wrp individual-partners">
                        <a href="<?php echo esc_url( get_author_posts_url($user->ID) ) ;?>" class="project-list__itm find-partners w-inline-block" target="_blank">
							<div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e9f-a709e52f" class="project-list__img-wrp">
							<?php
                            if(!empty($user_meta['cover_picture']) && !empty($user_meta['cover_picture'][0])){ 
								$get_cover = $user_meta['cover_picture'][0];
								//$cover_pic = wp_get_attachment_url($get_cover[0]);
							?>
                                
                                    <img src="<?php echo $get_cover; ?>" loading="lazy" id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea0-a709e52f" alt="" class="project-list__img">
                               <?php
                            } ?>
							</div>
                            <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea1-a709e52f" class="project__txt-wrp productions">
								<div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea2-a709e52f" class="project-itm__title">
								<?php if($user_meta['account_type'][0] == 'Organisation')
								{
								echo $user_meta['name_of_organisation']['0'];
								}else{
								echo $full_name;	
								}  ?>
								</div>		
								<?php                                
								$select_your_country = '';
								if(!empty($user_meta['country']) && !empty($user_meta['country'][0])){ 
									$select_your_country = $user_meta['country'][0];
								} 
                                if(!empty($select_your_country)){ ?>
                                  <div class="txt-xxs"><?php echo $select_your_country; ?></div><?php
                                } 
					
								
                                if(!empty($user_meta['organisation_type']) && !empty($user_meta['organisation_type'][0])){ ?>
                                   <?php 
										if(is_serialized($user_meta['organisation_type'][0])){
											$location = unserialize($user_meta['organisation_type'][0]);
										}
										else{
											$location = $user_meta['organisation_type'];
										}																												
										if(is_array($location))
										{ ?>		                          
				                            <div class="txt-xxs"><?php echo implode(', ',$location); ?></div>
				                        <?php
										 }
                                } ?>
                                
                            </div>
                            <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea6-a709e52f" class="project__txt-wrp location"><?php
                                if(!empty($user_meta['your_offer']) && !empty($user_meta['your_offer'][0])){ ?>
                                  <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea7-a709e52f" class="project__offer__txt">
                                    <?php echo $user_meta['your_offer'][0]; ?></div><?php
                                } ?>
                            </div>
                            <div id="w-node-_76a30b19-fea6-93d0-ed71-9838dd21b90f-a709e52f"
                                class="project__txt-wrp location"><?php
                                if(!empty($user_meta['your_needs']) && !empty($user_meta['your_needs'][0])){ ?>
                                    <div id="w-node-_76a30b19-fea6-93d0-ed71-9838dd21b910-a709e52f" class="project__needs__txt hide-mobile"><?php echo $user_meta['your_needs'][0]; ?></div><?php
                                } ?>
                            </div>
                            <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0eb0-a709e52f" class="project-itm__label-wrp performing-arts"><?php
								 $get_performaings = array();
                                if(!empty($user_meta['performing_art_forms']) && !empty($user_meta['performing_art_forms'][0])){ 
									if(is_serialized($user_meta['performing_art_forms'][0])){
											$get_performaing = unserialize($user_meta['performing_art_forms'][0]);										 
											foreach($get_performaing as $display_perform)
											{
											 //$display_perform_cat =  get_term_by('id', $display_perform, 'performing_arts');
												$get_performaings[] = $display_perform;
											}
											
										}
										else{
											$get_performaings = $user_meta['performing_art_forms'];
										}	
                                    																
									if(is_array($get_performaings)){ ?>
										<div class="itm__label bg-magenta">
                                            <div class="itm__label__txt"><?php echo implode(', ',$get_performaings);  ?></div>
                                        </div><?php
									}
                                } ?>
                            </div>
                            <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0eb4-a709e52f" class="project-itm__label-wrp topics-covered"><?php
                                if(!empty($user_meta['topics_covered']) && !empty($user_meta['topics_covered'][0])){ 
									$topics_covereds = array();
									$get_covered = unserialize($user_meta['topics_covered'][0]);
									if(is_serialized($user_meta['topics_covered'][0])){
											$topics_covered = unserialize($user_meta['topics_covered'][0]);
												foreach($topics_covered as $display_topics)
													{
													// $display_topic_cat =  get_term_by('id', $display_topics, 'topics_covered');
														$topics_covereds[] = $display_topics;
													}
										}
										else{
											$topics_covereds = $user_meta['topics_covered'];
										}
									if(is_array($topics_covereds))
									{ ?>
                                    <div class="itm__label bg-magenta">
                                        <div class="itm__label__txt"><?php echo implode(', ',$topics_covereds); ?></div>
                                    </div><?php
                                } } ?>
                            </div>
                        </a>
                        <div id="w-node-f573d56b-449d-184f-bf69-7a7c4302a870-a709e52f" class="project__itm__cta">
							<?php 
							global $wpdb;
							$total_favs = $wpdb->get_results("SELECT fav_user_id from favourite_partners WHERE (current_user_id = ".get_current_user_id().")"); 
							$array_fav = array();
							foreach($total_favs as $get_fev_list)
							{									 
								array_push($array_fav,$get_fev_list->fav_user_id);
							}
							if(in_array($user->ID,$array_fav))
							{
								echo '<div class="star__icon remove_fav active" data-id="'.$user->ID.'"></div>';	
							}
							else{
								echo '<div class="star__icon add_fav" data-id="'.$user->ID.'"></div>';	
							}
							
                            $table_name = 'partners_status';

                            $send_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".$user->ID." AND current_user_id = ".get_current_user_id()." AND status = 'request') ");

                            $recived_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (current_user_id = ".$user->ID." AND user_id = ".get_current_user_id()." AND status = 'request') "); 

                            $approve_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$user->ID." AND status = 'approve' OR user_id = ".$user->ID." AND current_user_id = ".get_current_user_id()." AND status = 'approve') ");

                            $declined_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$user->ID." AND status = 'approve' OR user_id = ".$user->ID." AND current_user_id = ".get_current_user_id()." AND status = 'declined') ");
                            
                            if(!empty($send_request)){ ?>
                                <div class="btn--send">
                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow.svg" loading="lazy" alt="" class="send__icon">
                                    <div class="txt-block">sent</div>
                                </div><?php
                            }
                            else if(!empty($recived_request)){ ?>
                                <div class="btn--approve">
                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                                    <div class="txt-block approve-request" data-id="<?php echo $user->ID; ?>">approve</div>
                                </div>
                                <div class="remove__icon declined-request" data-id="<?php echo $user->ID; ?>"></div><?php
                            }
                            else if(!empty($approve_request)){ ?>
                                <div class="btn--match"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/match-icon.svg" loading="lazy" alt="" class="quickmatch__icon">
                                <div class="txt-block">It`s a match!</div>
                                </div>
							<a href="mailto:<?php echo $get_email->user_email;?>"><div class="mail__icon"></div></a><?php
                            }
                            else if(!empty($declined_request)){ ?>
                                <div class="btn--declined">
                                    <div class="txt-block">declined</div>
                                </div><?php
                            }
                            else{ ?>
                                <div class="btn--quickmatch" data-id="<?php echo $user->ID; ?>"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                                    <div class="txt-block">quick match</div>
                                </div><?php
                            } ?>
                        </div>
                    </div><?php
                }
            } 
            else{
                echo "<span>".get_field('message_for_partner_page','option')."</span>";
            } 
            $total_user = $user_query->total_users;  
            $total_pages=ceil($total_user/$no); 
            if($total_pages > 1){ ?>
                <div class="pages__menu-wrp">
                    <div class="pages__menu ajax_pagination">
                        <div class="txt--small">Pages</div><?php
                            echo paginate_links(array(  
                              'base' => get_pagenum_link(1) . '%_%',  
                              'format' => '?paged=%#%',  
                              'current' => $paged,  
                              'total' => $total_pages,  
                              'prev_text' => 'Previous',  
                              'next_text' => 'Next',
                              'type'     => 'list',
                            )); ?>
                    </div>
                </div><?php
            } ?>
        </div>
    </div>
</section>
<?php 
get_footer(); ?>

<script>
jQuery(document).ready(function($)
{ 
    var placeholder = "Any";
    $(".select").select2({
        placeholder: placeholder,
        allowClear: false,
        minimumResultsForSearch: 5
    });
    jQuery(document).on("keyup",".search-input-ajax",function()
    {
        var search = jQuery(this).val();
        var withoutSpace = search.replace(/ /g, '').length; 
        if(withoutSpace > 3){
            jQuery.ajax({
              type: "POST",
              url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
              data: ({ action : 'search_partners', search : search}),
             
              success: function(response)
              {   
                jQuery('.search__suggestions').html( response );
                jQuery('.search__suggestions').removeClass('hide');
              }
          
            });
        }
        else{
            jQuery('.search__suggestions').addClass('hide');
        }
        return false;
    });
    jQuery(document).on("change",".country-select",function()
    {
        var performing_data = [];
        $.each($(".performing-arts option:selected"), function(){            
            performing_data.push($(this).val());
        });

        var topics_data = [];
        $.each($(".topics-covered option:selected"), function(){            
            topics_data.push($(this).val());
        });

        var page = jQuery('.active').attr('p');
        var countries = jQuery(this).val();
        var performing = performing_data.join(", ");
        var topics = topics_data.join(", ");
        call_ajax(page,topics,countries,performing);
        return false;
    });
    jQuery(document).on("change",".performing-arts",function()
    {
        var page = jQuery('.active').attr('p');
        var countries = jQuery('.country-select').val();
        var performing = jQuery(this).val();
        var topics_data = [];
        $.each($(".topics-covered option:selected"), function(){            
            topics_data.push($(this).val());
        });
        var topics = topics_data.join(", ");
        call_ajax(page,topics,countries,performing);
        return false;
    });
    jQuery(document).on("change",".topics-covered",function()
    {
        var page = jQuery('.active').attr('p');
        var topics = jQuery(this).val();
        var performing_data = [];
        $.each($(".performing-arts option:selected"), function(){            
            performing_data.push($(this).val());
        });
        var performing = performing_data.join(", ");
        var countries = jQuery('.country-select').val();

        call_ajax(page,topics,countries,performing);
        return false;
    });

    function call_ajax(page,topics,countries,performing)
    {
			if(topics == 'Any')
			{
				topics = '';	
			}
			if(performing == 'Any')
			{
				performing = '';	
			}
			
        jQuery.ajax({
          type: "POST",
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          data: ({ action : 'partners_filter_list', page : page, topics : topics, countries : countries, performing : performing}),
          success: function(response)
          {   
            jQuery('.product-row').html( response );
          }
          
        });
    }

    jQuery(document).on("click",".btn--quickmatch",function()
    {
        var user_id = $(this).attr('data-id');
        var current_user_id = '<?php echo get_current_user_id(); ?>';
        jQuery.ajax({
          type: "POST",
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          data: ({ action : 'quickmatch', user_id : user_id, current_user_id : current_user_id}),
          success: function(response){ 
            var returnedata = $.parseJSON(response);  
            var status = returnedata.status;
            if(status == 'success'){
                location.reload();
            }
          }
        });
    });
	jQuery(document).on("click",".remove_fav",function()
    {
        var user_id = $(this).attr('data-id');
        var current_user_id = '<?php echo get_current_user_id(); ?>';
        jQuery.ajax({
          type: "POST",
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          data: ({ action : 'remove_favorites_user', user_id : user_id, current_user_id : current_user_id}),
          success: function(response){            
            if(response == 'success'){
                location.reload();
                //jQuery(".my-favorites").trigger('click');
            }
          }
        });
    }); 
	
	jQuery(document).on("click",".add_fav",function()
    {
        var user_id = $(this).attr('data-id');
        var current_user_id = '<?php echo get_current_user_id(); ?>';
        jQuery.ajax({
          type: "POST",
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          data: ({ action : 'favorites_user', user_id : user_id, current_user_id : current_user_id}),
          success: function(response){            
            if(response == 'success'){
                location.reload();
            }
          }
        });
    }); 
	
    jQuery(document).on("click",".declined-request",function()
    {
        var user_id = $(this).attr('data-id');
        var current_user_id = '<?php echo get_current_user_id(); ?>';
        jQuery.ajax({
          type: "POST",
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          data: ({ action : 'declined_request', user_id : user_id, current_user_id : current_user_id}),
          success: function(response){ 
            var returnedata = $.parseJSON(response);  
            var status = returnedata.status;
            if(status == 'success'){
                location.reload();
            }
          }
        });
    });
    jQuery(document).on("click",".approve-request",function()
    {
        var user_id = $(this).attr('data-id');
        var current_user_id = '<?php echo get_current_user_id(); ?>';
        jQuery.ajax({
          type: "POST",
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          data: ({ action : 'approve_request', user_id : user_id, current_user_id : current_user_id}),
          success: function(response){ 
            var returnedata = $.parseJSON(response);  
            var status = returnedata.status;
            if(status == 'success'){
                location.reload();
            }
          }
        });
    });
    jQuery(document).on("click",".get-matches",function()
    {
        $('.opacity-new').removeClass('active');
        $(this).addClass('active');
        var current_user_id = '<?php echo get_current_user_id(); ?>';
        jQuery.ajax({
          type: "POST",
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          data: ({ action : 'get_matches', current_user_id : current_user_id}),
          success: function(response){ 
             jQuery('.product-row').html( response );
          }
        });
    });
	  
    jQuery(document).on("click",".get-recive-request",function()
    {
        $('.opacity-new').removeClass('active');
        $(this).addClass('active');
        var current_user_id = '<?php echo get_current_user_id(); ?>';
        jQuery.ajax({
          type: "POST",
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          data: ({ action : 'get_recive_request', current_user_id : current_user_id}),
          success: function(response){ 
             jQuery('.product-row').html( response );
          }
        });
    });
    jQuery(document).on("click",".get-sent-request",function()
    {
        $('.opacity-new').removeClass('active');
        $(this).addClass('active');
        var current_user_id = '<?php echo get_current_user_id(); ?>';
        jQuery.ajax({
          type: "POST",
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          data: ({ action : 'get_sent_request', current_user_id : current_user_id}),
          success: function(response){ 
             jQuery('.product-row').html( response );
          }
        });
    });
    jQuery(document).on("click",".my-favorites",function()
    {
        $('.opacity-new').removeClass('active');
        $(this).addClass('active');
        var current_user_id = '<?php echo get_current_user_id(); ?>';
        jQuery.ajax({
          type: "POST",
          url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          data: ({ action : 'get_fav_matches', current_user_id : current_user_id}),
          success: function(response){ 
             jQuery('.product-row').html( response );
          }
        });
    });
    
});
function myFunction() {
  location.reload();
}
</script>
