<?php /* Template Name: Profile */
get_header(); 
global $current_user;
get_currentuserinfo();
if(!empty($_REQUEST['user'])){
	$current_user_id = $_REQUEST['user'];
}
else{
	$current_user_id = get_current_user_id();
}

if(!empty($current_user_id)){
	$user_meta = get_user_meta($current_user_id);
	$full_name = $user_meta['first_name'][0].' '.$user_meta['last_name'][0]; 
	$select_your_country = '';
	if(!empty($user_meta['select_your_country']) && !empty($user_meta['select_your_country'][0])){ 
		$select_your_country = $user_meta['select_your_country'][0];
	}  ?>
	<section class="section-wrp s-profile-first">
		<a href="/partners/" class="btn--transparent w-inline-block"><div class="txt-block--1rem">more partners</div></a>
	    <h1 class="page__title"><?php echo $full_name; ?></h1><?php
	    if(!empty($select_your_country)){ ?>
	    	<h3 class="page__subtitle"><?php echo $select_your_country; ?></h3><?php
	    } ?>
	    <div class="profile__gradient"></div>
	    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/650857e72272bf8f15ae7a86_fc6c5c82cfde94edf6fda6d0e94ea79f.png" loading="eager" sizes="100vw" srcset="<?php echo get_stylesheet_directory_uri()?>/assets/images/650857e72272bf8f15ae7a86_fc6c5c82cfde94edf6fda6d0e94ea79f-p-500.png 500w, <?php echo get_stylesheet_directory_uri()?>/assets/images/650857e72272bf8f15ae7a86_fc6c5c82cfde94edf6fda6d0e94ea79f-p-800.png 800w, <?php echo get_stylesheet_directory_uri()?>/assets/images/650857e72272bf8f15ae7a86_fc6c5c82cfde94edf6fda6d0e94ea79f-p-1080.png 1080w, <?php echo get_stylesheet_directory_uri()?>/assets/images/650857e72272bf8f15ae7a86_fc6c5c82cfde94edf6fda6d0e94ea79f.png 1500w" alt="" class="profile__img--large">
	</section>
	<section class="section-wrp s-profile-cont"><?php
		global $wpdb;
		$table_name = 'partners_status';
		$total_approve = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND status = 'approve' OR current_user_id = ".get_current_user_id()." AND status = 'approve') "); 
		if(!empty($total_approve)){ ?>
		    <div class="contact__card">
		        <h2 class="contact__title">Main contact</h2>
		        <div class="contact__cont">
		            <div id="w-node-f12c6a42-82d1-3833-cdc5-3183de4864a0-eaa7b610" class="txt--50">First name</div>
		            <div id="w-node-_4c584b2d-ceeb-0347-4563-e76a3d1c6d1c-eaa7b610" class="contact__txt"><?php echo $user_meta['first_name'][0]; ?></div>
		            <div id="w-node-_25b55a23-e3a1-3790-2883-4fbabf2bddaa-eaa7b610" class="txt--50">Last name</div>
		            <div id="w-node-_7da1bc62-71b7-9889-b8ba-27bd893782e2-eaa7b610" class="contact__txt"><?php echo $user_meta['last_name'][0]; ?></div>
		            <!-- <div id="w-node-cde51876-eeea-72a1-eb71-0cc5e0b3e8e6-eaa7b610" class="txt--50">Pronouns</div>
		            <div id="w-node-_409def6e-6945-7491-1358-b3d561f48cfd-eaa7b610" class="contact__txt">He/him</div> --><?php
		            if(!empty($user_meta['my_job_title']) && !empty($user_meta['my_job_title'][0])){ ?>
			            <div id="w-node-_75df46e6-519b-8e81-6d8e-95d20c3dcf3c-eaa7b610" class="txt--50">Job title</div>
			            <div id="w-node-edbb892d-c20a-c6e8-e1d7-0ac9d6f3cde7-eaa7b610" class="contact__txt"><?php echo $user_meta['my_job_title'][0]; ?></div><?php
			        } 
			        if(!empty($current_user->user_email)){ ?>
			            <div id="w-node-_9ab6c798-6186-e2b2-f2c1-588b2cc2a21c-eaa7b610" class="txt--50">Email</div>
			            <div id="w-node-_12b1bc94-6974-3f4c-7d81-62ffdd66eced-eaa7b610" class="contact__txt"><?php echo $current_user->user_email; ?></div><?php
			        } ?>
		            <!-- <div id="w-node-_799383c1-b9ff-44fb-4d92-9c1fc41ae660-eaa7b610" class="txt--50">Website/Social media
		            </div>
		            <div id="w-node-_18ab124a-4ffa-1c70-71b1-f4031a129d3b-eaa7b610" class="contact__txt">doe.com</div> -->
		        </div>
		        <div class="contact__cta" style="display:none;">
		            <div class="star__icon"></div>
		            <div class="btn--send"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow.svg" loading="lazy" alt="" class="send__icon">
		            <div class="txt-block" style="display:none;">Send</div></div>
		        </div>
		    </div><?php
		} ?>
	    <div class="profile__desrc"><?php
	    	if(!empty($user_meta['who_are_you_and_what_are_you_looking_for']) && !empty($user_meta['who_are_you_and_what_are_you_looking_for'][0])){ ?>
	        	<p id="w-node-dfdc8035-6611-c5e5-af55-be3829234b5a-eaa7b610" class="descr__paragraph"><?php echo $user_meta['who_are_you_and_what_are_you_looking_for'][0]; ?></p><?php
	        } 
	        if(!empty($user_meta['your_offer']) && !empty($user_meta['your_offer'][0])){ ?>
		        <div id="w-node-a3aff3d3-9355-d8b4-7516-cf9bec708b5e-eaa7b610" class="desrc__itm">
		            <div class="desrc__head">Offer</div>
		            <p class="paragraph"><?php echo $user_meta['your_offer'][0]; ?></p>
		        </div><?php
		    } 
		    if(!empty($user_meta['your_needs']) && !empty($user_meta['your_needs'][0])){ ?>
		        <div id="w-node-_2313233f-2589-703f-26f8-039797616b55-eaa7b610" class="desrc__itm">
		            <div class="desrc__head">Needs</div>
		            <p class="paragraph"><?php echo $user_meta['your_needs'][0]; ?></p>
		        </div><?php
		    } ?>
	    </div>
	    <div class="profile__activities">
	        <h2 class="activities__title">Activities</h2>
	        <div class="activities-wrp">
	            <div class="type-wrp"><?php
	            	if(!empty($user_meta['location'])){ ?>
		                <div class="type__itm">
		                    <div class="profile__subtitle">Type</div>
		                    <div class="type__selected"><?php
		                    	foreach($user_meta['location'] as $location){ 
		                    		if(is_serialized($location)){
										$get_location = unserialize($location);
									}
									else{
										$get_location = $user_meta['location'];
									}	
		                    		if(!empty($get_location)){ ?>
				                        <div class="selected-itm">
				                            <div class="selected-itm__remove"></div>
				                            <div class="selected-itm__txt"><?php echo implode(', ',$get_location);  ?></div>
				                        </div><?php
				                    }
			                    } ?>
		                    </div>
		                </div><?php
		            } 
		            if(!empty($user_meta['performing_arts'])){ ?>
		                <div class="type__itm">
		                    <div class="profile__subtitle">Performing arts</div>
		                    <div class="type__selected"><?php
		                    	foreach($user_meta['performing_arts'] as $performing_arts){ 
		                    		if(is_serialized($performing_arts)){
										$get_performaing = unserialize($performing_arts);
									}
									else{
										$get_performaing = $user_meta['performing_arts'];
									}																		
		                    		if(!empty($get_performaing)){ ?>
				                        <div class="selected-itm">
				                            <div class="selected-itm__remove"></div>
				                            <div class="selected-itm__txt"><?php echo implode(', ',$get_performaing);  ?></div>
				                        </div><?php
				                    }
			                    } ?>
		                    </div>
		                </div><?php
		            } 
		            if(!empty($user_meta['topics_covered'])){ ?>
		                <div class="type__itm">
		                    <div class="profile__subtitle">Topics covered</div>
		                    <div class="type__selected"><?php
		                    	foreach($user_meta['topics_covered'] as $topics_covered){ 
		                    		if(is_serialized($topics_covered)){
										$get_topics = unserialize($topics_covered);
									}
									else{
										$get_topics = $user_meta['topics_covered'];
									} 
									if(!empty($get_topics)){ ?>
				                        <div class="selected-itm">
				                            <div class="selected-itm__remove"></div>
				                            <div class="selected-itm__txt"><?php echo implode(', ',$get_topics);  ?></div>
				                        </div><?php
				                    }
			                    } ?>
		                    </div>
		                </div><?php
		            } ?>
	            </div>
	            <div class="profile__slider">
	                <div class="profile__subtitle">Productions</div>
	                <div class="slider-wrp">
	                    <div class="p-slider"><?php
	                        if(!empty($user_meta['production_name_1']) && !empty($user_meta['production_name_1'][0]) || !empty($user_meta['production_description_1']) && !empty($user_meta['production_description_1'][0])){ ?>
		                        <div class="slider__itm first"><?php
		                        	if(!empty($user_meta['production_name_1']) && !empty($user_meta['production_name_1'][0])){ ?>
		                            	<div class="slider__title"><?php echo $user_meta['production_name_1'][0]; ?></div><?php
		                            } 
		                            if(!empty($user_meta['production_description_1']) && !empty($user_meta['production_description_1'][0])){ ?>
			                            <div class="slider__txt"><?php echo $user_meta['production_description_1'][0]; ?></div>
			                        	<?php
			                        } ?>
			                    </div><?php
			                } 
			                if(!empty($user_meta['production_name_2']) && !empty($user_meta['production_name_2'][0]) || !empty($user_meta['production_description_2']) && !empty($user_meta['production_description_2'][0])){  ?>
		                        <div class="slider__itm"><?php
		                        	if(!empty($user_meta['production_name_2']) && !empty($user_meta['production_name_2'][0])){ ?>
		                            	<div class="slider__title"><?php echo $user_meta['production_name_2'][0]; ?></div><?php
		                            } 
		                            if(!empty($user_meta['production_description_2']) && !empty($user_meta['production_description_2'][0])){ ?>
		                            	<div class="slider__txt"><?php echo $user_meta['production_description_2'][0]; ?></div><?php
		                            } ?>
		                        </div><?php
		                    } 
		                    if(!empty($user_meta['production_name_3']) && !empty($user_meta['production_name_3'][0]) || !empty($user_meta['production_description_3']) && !empty($user_meta['production_description_3'][0])){ ?>
		                        <div class="slider__itm"><?php
		                        	if(!empty($user_meta['production_name_3']) && !empty($user_meta['production_name_3'][0])){ ?>
		                            	<div class="slider__title"><?php echo $user_meta['production_name_3'][0]; ?></div><?php
		                            } 
		                            if(!empty($user_meta['production_description_3']) && !empty($user_meta['production_description_3'][0])){ ?>
		                            	<div class="slider__txt"><?php echo $user_meta['production_description_3'][0]; ?></div><?php
		                            } ?>
		                        </div><?php
		                    } 
		                    if(!empty($user_meta['production_name_4']) && !empty($user_meta['production_name_4'][0]) || !empty($user_meta['production_description_4']) && !empty($user_meta['production_description_4'][0])){ ?>
		                        <div class="slider__itm"><?php
		                        	if(!empty($user_meta['production_name_4']) && !empty($user_meta['production_name_4'][0])){ ?>
		                            	<div class="slider__title"><?php echo $user_meta['production_name_4'][0]; ?></div><?php
		                            } 
		                            if(!empty($user_meta['production_description_4']) && !empty($user_meta['production_description_4'][0])){ ?>
		                            	<div class="slider__txt"><?php echo $user_meta['production_description_4'][0]; ?></div><?php
		                            } ?>
		                        </div><?php
		                    } ?>
	                    </div>
	                </div>
	            </div>
	            <div class="profile__slider">
	                <div class="profile__subtitle">Touring opportunities</div>
	                <div class="slider-wrp">
	                    <div class="p-slider"><?php
	                        if(!empty($user_meta['tourning_production_name_1']) && !empty($user_meta['tourning_production_name_1'][0]) || !empty($user_meta['tourning_production_description_1']) && !empty($user_meta['tourning_production_description_1'][0])){ ?>
		                        <div class="slider__itm first"><?php
		                        	if(!empty($user_meta['tourning_production_name_1']) && !empty($user_meta['tourning_production_name_1'][0])){ ?>
		                            	<div class="slider__title"><?php echo $user_meta['tourning_production_name_1'][0]; ?></div><?php
		                            } 
		                            if(!empty($user_meta['tourning_production_description_1']) && !empty($user_meta['tourning_production_description_1'][0])){ ?>
		                            	<div class="slider__txt"><?php echo $user_meta['tourning_production_description_1'][0]; ?></div><?php
		                            } ?>
		                        </div><?php
		                    } 
		                    if(!empty($user_meta['tourning_production_name_2']) && !empty($user_meta['tourning_production_name_2'][0]) || !empty($user_meta['tourning_production_description_2']) && !empty($user_meta['tourning_production_description_2'][0])){ ?>
		                        <div class="slider__itm first"><?php
		                        	if(!empty($user_meta['tourning_production_name_2']) && !empty($user_meta['tourning_production_name_2'][0])){ ?>
		                            	<div class="slider__title"><?php echo $user_meta['tourning_production_name_2'][0]; ?></div><?php
		                            } 
		                            if(!empty($user_meta['tourning_production_description_2']) && !empty($user_meta['tourning_production_description_2'][0])){ ?>
		                            	<div class="slider__txt"><?php echo $user_meta['tourning_production_description_2'][0]; ?></div><?php
		                            } ?>
		                        </div><?php
		                    } 
		                    if(!empty($user_meta['tourning_production_name_3']) && !empty($user_meta['tourning_production_name_3'][0]) || !empty($user_meta['tourning_production_description_3']) && !empty($user_meta['tourning_production_description_3'][0])){ ?>
		                        <div class="slider__itm first"><?php
		                        	if(!empty($user_meta['tourning_production_name_3']) && !empty($user_meta['tourning_production_name_3'][0])){ ?>
		                            	<div class="slider__title"><?php echo $user_meta['tourning_production_name_3'][0]; ?></div><?php
		                            } 
		                            if(!empty($user_meta['tourning_production_description_3']) && !empty($user_meta['tourning_production_description_3'][0])){ ?>
		                            	<div class="slider__txt"><?php echo $user_meta['tourning_production_description_3'][0]; ?></div><?php
		                            } ?>
		                        </div><?php
		                    } 
		                    if(!empty($user_meta['touring_production_name_4']) && !empty($user_meta['touring_production_name_4'][0]) || !empty($user_meta['touring_production_description_4']) && !empty($user_meta['touring_production_description_4'][0])){ ?>
		                        <div class="slider__itm first"><?php
		                        	if(!empty($user_meta['touring_production_name_4']) && !empty($user_meta['touring_production_name_4'][0])){ ?>
		                            	<div class="slider__title"><?php echo $user_meta['touring_production_name_4'][0]; ?></div><?php
		                            } 
		                            if(!empty($user_meta['touring_production_description_4']) && !empty($user_meta['touring_production_description_4'][0])){ ?>
		                            	<div class="slider__txt"><?php echo $user_meta['touring_production_description_4'][0]; ?></div><?php
		                            } ?>
		                        </div><?php
		                    }
		                    if(!empty($user_meta['touring_production_name_5']) && !empty($user_meta['touring_production_name_5'][0]) || !empty($user_meta['touring_production_description_5']) && !empty($user_meta['touring_production_description_5'][0])){ ?>
		                        <div class="slider__itm first"><?php
		                        	if(!empty($user_meta['touring_production_name_5']) && !empty($user_meta['touring_production_name_5'][0])){ ?>
		                            	<div class="slider__title"><?php echo $user_meta['touring_production_name_5'][0]; ?></div><?php
		                            } 
		                            if(!empty($user_meta['touring_production_description_5']) && !empty($user_meta['touring_production_description_5'][0])){ ?>
		                            	<div class="slider__txt"><?php echo $user_meta['touring_production_description_5'][0]; ?></div><?php
		                            } ?>
		                        </div><?php
		                    }  ?>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section><?php
}
get_footer(); ?>