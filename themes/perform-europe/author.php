<?php 
if(!is_user_logged_in() ) {
	wp_redirect( home_url('/login') ); exit;
}
get_header();
$logged_in_user_id = get_current_user_id();
$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
$current_user_id = $author->ID;
if(!empty($current_user_id)){
	$user_meta = get_user_meta($current_user_id);
	$full_name = $user_meta['first_name'][0].' '.$user_meta['last_name'][0]; 
	$select_your_country = '';
	if(!empty($user_meta['country']) && !empty($user_meta['country'][0])){ 
		$select_your_country = $user_meta['country'][0];
	} ?>
	<section class="section-wrp s-profile-first">
		<a href="/partners/" class="btn--transparent w-inline-block"><div class="txt-block--1rem">more partners</div></a>
	    <h1 class="page__title"><?php 
	    if($user_meta['account_type'][0] == 'Organisation'){
			echo $user_meta['name_of_organisation']['0'];
		}
		else{
			echo $full_name;	
		}  ?>
		</h1><?php
	    if(!empty($select_your_country)){ ?>
	    	<h3 class="page__subtitle"><?php echo $select_your_country; ?></h3><?php
	    } ?>
	    <div class="profile__gradient"></div>
		<?php if(!empty($user_meta['cover_picture'])){
			$get_cover = $user_meta['cover_picture'][0];
			//$cover_pic = wp_get_attachment_url($get_cover[0]);
		?>
	    <img src="<?php echo $get_cover;?>" loading="eager" sizes="100vw" class="profile__img--large">
		<?php } ?>
	</section>
	<section class="section-wrp s-profile-cont"><?php
		global $wpdb;
		$table_name = 'partners_status';
		$total_approve = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$current_user_id." AND status = 'approve' OR user_id = ".$current_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'approve') ");
		if(!empty($total_approve)){ ?>
	    	<div class="contact__card">
	        	<h2 class="contact__title">Main contact <a href="javascript:void(0);" class="display_user_data"><img class="open-eyes" src="https://performeurope.eu/wp-content/uploads/2023/12/eye.svg"><img src="https://performeurope.eu/wp-content/uploads/2023/12/eye_closed.svg" style="display:none;" class="eye_closed"></a></h2>
	        	<div class="contact__cont">
	            <div id="w-node-f12c6a42-82d1-3833-cdc5-3183de4864a0-eaa7b610" class="txt--50">First name</div>
	            <div id="w-node-_4c584b2d-ceeb-0347-4563-e76a3d1c6d1c-eaa7b610" class="contact__txt"><?php echo $user_meta['first_name'][0]; ?></div>
	            <div id="w-node-_25b55a23-e3a1-3790-2883-4fbabf2bddaa-eaa7b610" class="txt--50">Last name</div>
	            <div id="w-node-_7da1bc62-71b7-9889-b8ba-27bd893782e2-eaa7b610" class="contact__txt"><?php echo $user_meta['last_name'][0]; ?></div>
				<?php if(!empty($user_meta['pronouns']) && !empty($user_meta['pronouns'][0])){ ?>
	            <div id="w-node-cde51876-eeea-72a1-eb71-0cc5e0b3e8e6-eaa7b610" class="txt--50">Pronouns</div>
	            <div id="w-node-_409def6e-6945-7491-1358-b3d561f48cfd-eaa7b610" class="contact__txt"><?php echo $user_meta['pronouns'][0]; ?></div> <?php
				}
				if(!empty($user_meta['job_title']) && !empty($user_meta['job_title'][0])){ 
					$job_title = unserialize($user_meta['job_title'][0]);
				?>
		            <div id="w-node-_75df46e6-519b-8e81-6d8e-95d20c3dcf3c-eaa7b610" class="txt--50">Job Title</div>
		            <div id="w-node-edbb892d-c20a-c6e8-e1d7-0ac9d6f3cde7-eaa7b610" class="contact__txt"><?php echo $user_meta['job_title'][0]; ?></div><?php
		        } 
	
	            if(!empty($user_meta['account_type']) && !empty($user_meta['account_type'][0])){ 
					//$job_titles = unserialize($user_meta['account_type'][0]);
					if(is_serialized($user_meta['account_type'][0])){
						$job_titles = unserialize($user_meta['account_type'][0]);
					}
					else{
						$job_titles = $user_meta['account_type'];
					}
					
				?>
		            <div id="w-node-_75df46e6-519b-8e81-6d8e-95d20c3dcf3c-eaa7b610" class="txt--50">Account type</div>
		            <div id="w-node-edbb892d-c20a-c6e8-e1d7-0ac9d6f3cde7-eaa7b610" class="contact__txt"><?php echo implode(", ",$job_titles); ?></div><?php
		        } 
		        if(!empty($author->user_email)){ ?>
		            <div id="w-node-_9ab6c798-6186-e2b2-f2c1-588b2cc2a21c-eaa7b610" class="txt--50">Email</div>
		            <div id="w-node-_12b1bc94-6974-3f4c-7d81-62ffdd66eced-eaa7b610" class="contact__txt"><a href="mailto:<?php echo $author->user_email; ?>"><?php echo $author->user_email; ?></a></div><?php
		        } 
				if(!empty($user_meta['social']) && !empty($user_meta['social'][0])){ ?>
	             <div id="w-node-_799383c1-b9ff-44fb-4d92-9c1fc41ae660-eaa7b610" class="txt--50">Website/Social media
	            </div>
	            <div id="w-node-_18ab124a-4ffa-1c70-71b1-f4031a129d3b-eaa7b610" class="contact__txt"><a href="<?php echo $user_meta['social'][0]; ?>" target="_blank"><?php echo $user_meta['social'][0]; ?></a></div> 
				<?php } ?>
	        	</div>	
				<div class="contact__cta">
					<span class="btn--send clickcopy"  style="cursor: pointer;" data-href="<?php echo esc_url( get_author_posts_url($current_user_id) ) ;?>">Copy Profile Link</span>
				</div> 
				
	        	<div class="contact__cta"><?php 
					global $wpdb;
					 
                    $table_name = 'partners_status';
						   							
					$total_favs = $wpdb->get_results("SELECT fav_user_id from favourite_partners WHERE (current_user_id = ".get_current_user_id().")"); 
					$array_fav = array();
					foreach($total_favs as $get_fev_list)
					{									 
						array_push($array_fav,$get_fev_list->fav_user_id);
					}
					if(in_array($current_user_id,$array_fav))
					{
						echo '<div class="star__icon remove_fav active" data-id="'.$current_user_id.'"></div>';	
					}
					else{
						echo '<div class="star__icon add_fav" data-id="'.$current_user_id.'"></div>';	
					}	   

                    $send_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".$current_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'request') ");

                    $recived_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (current_user_id = ".$current_user_id." AND user_id = ".get_current_user_id()." AND status = 'request') "); 

                    $approve_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$current_user_id." AND status = 'approve' OR user_id = ".$current_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'approve') ");

                    $declined_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$current_user_id." AND status = 'approve' OR user_id = ".$current_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'declined') ");
                    
                    if(!empty($send_request)){ ?>
                        <div class="btn--send">
                            <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow.svg" loading="lazy" alt="" class="send__icon">
                            <div class="txt-block">sent</div>
                        </div><?php
                    }
                    else if(!empty($recived_request)){ ?>
                        <div class="btn--approve">
                            <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                            <div class="txt-block approve-request" data-id="<?php echo $current_user_id; ?>">approve</div>
                        </div>
                        <div class="remove__icon declined-request" data-id="<?php echo $current_user_id; ?>"></div><?php
                    }
                    else if(!empty($approve_request)){ ?>
                        <div class="btn--match"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/match-icon.svg" loading="lazy" alt="" class="quickmatch__icon">
                        <div class="txt-block">It`s a match!</div>
                        </div>
                        <a href="mailto:<?php echo $author->user_email;?>"><div class="mail__icon"></div></a><?php
                    }
                    else if(!empty($declined_request)){ ?>
                        <div class="btn--declined">
                            <div class="txt-block">declined</div>
                        </div><?php
                    }
                    else{ ?>
                        <div class="btn--quickmatch" data-id="<?php echo $current_user_id; ?>"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                            <div class="txt-block">quick match</div>
                        </div><?php
                    } ?>
	        	</div>
	    	</div><?php
	   	} 
		else if($logged_in_user_id == $current_user_id)
		{ ?>
	    	<div class="contact__card">
	        	<h2 class="contact__title">Main contact <a href="javascript:void(0);" class="display_user_data"><img class="open-eyes" src="https://performeurope.eu/wp-content/uploads/2023/12/eye.svg"><img src="https://performeurope.eu/wp-content/uploads/2023/12/eye_closed.svg" style="display:none;" class="eye_closed"></a></h2>
	        	<div class="contact__cont">
	            <div id="w-node-f12c6a42-82d1-3833-cdc5-3183de4864a0-eaa7b610" class="txt--50">First name</div>
	            <div id="w-node-_4c584b2d-ceeb-0347-4563-e76a3d1c6d1c-eaa7b610" class="contact__txt"><?php echo $user_meta['first_name'][0]; ?></div>
	            <div id="w-node-_25b55a23-e3a1-3790-2883-4fbabf2bddaa-eaa7b610" class="txt--50">Last name</div>
	            <div id="w-node-_7da1bc62-71b7-9889-b8ba-27bd893782e2-eaa7b610" class="contact__txt"><?php echo $user_meta['last_name'][0]; ?></div>
				<?php if(!empty($user_meta['pronouns']) && !empty($user_meta['pronouns'][0])){ ?>
	            <div id="w-node-cde51876-eeea-72a1-eb71-0cc5e0b3e8e6-eaa7b610" class="txt--50">Pronouns</div>
	            <div id="w-node-_409def6e-6945-7491-1358-b3d561f48cfd-eaa7b610" class="contact__txt"><?php echo $user_meta['pronouns'][0]; ?></div> <?php
				}
				if(!empty($user_meta['job_title']) && !empty($user_meta['job_title'][0])){ 
					$job_title = unserialize($user_meta['job_title'][0]);
				?>
		            <div id="w-node-_75df46e6-519b-8e81-6d8e-95d20c3dcf3c-eaa7b610" class="txt--50">Job Title</div>
		            <div id="w-node-edbb892d-c20a-c6e8-e1d7-0ac9d6f3cde7-eaa7b610" class="contact__txt"><?php echo $user_meta['job_title'][0]; ?></div><?php
		        } 
	
	            if(!empty($user_meta['account_type']) && !empty($user_meta['account_type'][0])){ 
					//$job_titles = unserialize($user_meta['account_type'][0]);
					if(is_serialized($user_meta['account_type'][0])){
											$job_titles = unserialize($user_meta['account_type'][0]);
										}
										else{
											$job_titles = $user_meta['account_type'];
										}
					
				?>
		            <div id="w-node-_75df46e6-519b-8e81-6d8e-95d20c3dcf3c-eaa7b610" class="txt--50">Account type</div>
		            <div id="w-node-edbb892d-c20a-c6e8-e1d7-0ac9d6f3cde7-eaa7b610" class="contact__txt"><?php echo implode(", ",$job_titles); ?></div><?php
		        } 
		        if(!empty($author->user_email)){ ?>
		            <div id="w-node-_9ab6c798-6186-e2b2-f2c1-588b2cc2a21c-eaa7b610" class="txt--50">Email</div>
		            <div id="w-node-_12b1bc94-6974-3f4c-7d81-62ffdd66eced-eaa7b610" class="contact__txt"><a href="mailto:<?php echo $author->user_email; ?>"><?php echo $author->user_email; ?></a></div><?php
		        } 
				if(!empty($user_meta['social']) && !empty($user_meta['social'][0])){ ?>
	             <div id="w-node-_799383c1-b9ff-44fb-4d92-9c1fc41ae660-eaa7b610" class="txt--50">Website/Social media
	            </div>
	            <div id="w-node-_18ab124a-4ffa-1c70-71b1-f4031a129d3b-eaa7b610" class="contact__txt"><a href="<?php echo $user_meta['social'][0]; ?>" target="_blank"><?php echo $user_meta['social'][0]; ?></a></div> 
				<?php } ?>
	        	</div>
	        	<div class="contact__cta" style="display:none;">
	            <div class="star__icon"></div>
	            <div class="btn--send"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow.svg" loading="lazy" alt="" class="send__icon">
	            <div class="txt-block" style="display:none;">Send</div></div>
	        	</div>
	    	</div><?php
		}
		else{  ?>
	    	<div class="contact__card">
	        	<h2 class="contact__title">Main contact <a href="javascript:void(0);" class="display_user_data"><img class="open-eyes" src="https://performeurope.eu/wp-content/uploads/2023/12/eye.svg"><img src="https://performeurope.eu/wp-content/uploads/2023/12/eye_closed.svg" style="display:none;" class="eye_closed"></a></h2>
	        	<div class="contact__cont">
	            <div id="w-node-f12c6a42-82d1-3833-cdc5-3183de4864a0-eaa7b610" class="txt--50  ">First name</div>
	            <div id="w-node-_4c584b2d-ceeb-0347-4563-e76a3d1c6d1c-eaa7b610" class="contact__txt blur ">XXXXXXX</div>
	            <div id="w-node-_25b55a23-e3a1-3790-2883-4fbabf2bddaa-eaa7b610" class="txt--50  ">Last name</div>
	            <div id="w-node-_7da1bc62-71b7-9889-b8ba-27bd893782e2-eaa7b610" class="contact__txt blur ">XXXXXXX</div>
				<?php if(!empty($user_meta['pronouns']) && !empty($user_meta['pronouns'][0])){ ?>
	            <div id="w-node-cde51876-eeea-72a1-eb71-0cc5e0b3e8e6-eaa7b610" class="txt--50">Pronouns</div>
	            <div id="w-node-_409def6e-6945-7491-1358-b3d561f48cfd-eaa7b610" class="contact__txt blur">XXXXXXX</div> <?php
				}
				if(!empty($user_meta['job_title']) && !empty($user_meta['job_title'][0])){ 
					$job_title = unserialize($user_meta['job_title'][0]);
				?>
		            <div id="w-node-_75df46e6-519b-8e81-6d8e-95d20c3dcf3c-eaa7b610" class="txt--50">Job Title</div>
		            <div id="w-node-edbb892d-c20a-c6e8-e1d7-0ac9d6f3cde7-eaa7b610" class="contact__txt blur">XXXXXXX</div><?php
		        } 
	
	            if(!empty($user_meta['account_type']) && !empty($user_meta['account_type'][0])){ 
					//$job_titles = unserialize($user_meta['account_type'][0]);
					if(is_serialized($user_meta['account_type'][0])){
											$job_titles = unserialize($user_meta['account_type'][0]);
										}
										else{
											$job_titles = $user_meta['account_type'];
										}
					
				?>
		            <div id="w-node-_75df46e6-519b-8e81-6d8e-95d20c3dcf3c-eaa7b610" class="txt--50">Account type</div>
		            <div id="w-node-edbb892d-c20a-c6e8-e1d7-0ac9d6f3cde7-eaa7b610" class="contact__txt blur">XXXXXXX</div><?php
		        } 
		        if(!empty($author->user_email)){ ?>
		            <div id="w-node-_9ab6c798-6186-e2b2-f2c1-588b2cc2a21c-eaa7b610" class="txt--50">Email</div>
		            <div id="w-node-_12b1bc94-6974-3f4c-7d81-62ffdd66eced-eaa7b610" class="contact__txt blur">XXXXXXX</div><?php
		        } 
				if(!empty($user_meta['social']) && !empty($user_meta['social'][0])){ ?>
	             <div id="w-node-_799383c1-b9ff-44fb-4d92-9c1fc41ae660-eaa7b610" class="txt--50">Website/Social media
	            </div>
	            <div id="w-node-_18ab124a-4ffa-1c70-71b1-f4031a129d3b-eaa7b610" class="contact__txt blur">XXXXXXX</a></div> 
				<?php } ?>
	        	</div>				
	        	<div class="contact__cta">	
					
					<?php 
							global $wpdb;
							 
                            $table_name = 'partners_status';			
					$total_favs = $wpdb->get_results("SELECT fav_user_id from favourite_partners WHERE (current_user_id = ".get_current_user_id().")"); 
					$array_fav = array();
					foreach($total_favs as $get_fev_list)
					{									 
						array_push($array_fav,$get_fev_list->fav_user_id);
					}
					if(in_array($current_user_id,$array_fav))
					{
						echo '<div class="star__icon remove_fav active" data-id="'.$current_user_id.'"></div>';	
					}
					else{
						echo '<div class="star__icon add_fav" data-id="'.$current_user_id.'"></div>';	
					}	   

                    $send_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".$current_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'request') ");

                    $recived_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (current_user_id = ".$current_user_id." AND user_id = ".get_current_user_id()." AND status = 'request') "); 

                    $approve_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$current_user_id." AND status = 'approve' OR user_id = ".$current_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'approve') ");

                    $declined_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$current_user_id." AND status = 'approve' OR user_id = ".$current_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'declined') ");
                    
                    if(!empty($send_request)){ ?>
                        <div class="btn--send">
                            <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow.svg" loading="lazy" alt="" class="send__icon">
                            <div class="txt-block">sent</div>
                        </div><?php
                    }
                    else if(!empty($recived_request)){ ?>
                        <div class="btn--approve">
                            <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                            <div class="txt-block approve-request" data-id="<?php echo $current_user_id; ?>">approve</div>
                        </div>
                        <div class="remove__icon declined-request" data-id="<?php echo $current_user_id; ?>"></div><?php
                    }
                    else if(!empty($approve_request)){ ?>
                        <div class="btn--match"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/match-icon.svg" loading="lazy" alt="" class="quickmatch__icon">
                        <div class="txt-block">It`s a match!</div>
                        </div>
                        <div class="mail__icon"></div><?php
                    }
                    else if(!empty($declined_request)){ ?>
                        <div class="btn--declined">
                            <div class="txt-block">declined</div>
                        </div><?php
                    }
                    else{ ?>
                        <div class="btn--quickmatch" data-id="<?php echo $current_user_id; ?>"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                            <div class="txt-block">quick match</div>
                        </div><?php
                    } ?>
	        	</div>
	    	</div><?php
		} ?>
	    <div class="profile__desrc"><?php
	    	if(!empty($user_meta['description']) && !empty($user_meta['description'][0])){ 
								
			?>
	        	<p id="w-node-dfdc8035-6611-c5e5-af55-be3829234b5a-eaa7b610" class="descr__paragraph"><?php echo $user_meta['description'][0];  ?></p><?php
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
								<div class="type__itm">
				                    <div class="profile__subtitle">Type</div>
				                    <div class="type__selected"> 
										<div class="selected-itm">				                          
						                            <div class="selected-itm__txt"><?php echo implode(', ',$location); ?></div>
						                        </div>							   
									</div>
                        		</div><?php
							}																																							 
                        }
                        if(!empty($user_meta['performing_art_forms']) && !empty($user_meta['performing_art_forms'][0])){ 					
							global $post;
						
							if(is_serialized($user_meta['performing_art_forms'][0])){
								$get_performaing = unserialize($user_meta['performing_art_forms'][0]);										 
								foreach($get_performaing as $display_perform)
								{
							
									$get_performaings[] = $display_perform;
								}
								
							}
							else{
								$get_performaings = $user_meta['performing_art_forms'];
							}
																									
							if(is_array($get_performaings))
							{ ?>
										<div class="type__itm">
		                    <div class="profile__subtitle">Performing arts</div>
		                    <div class="type__selected">
								<div class="selected-itm">
				                            
				                            <div class="selected-itm__txt"><?php echo implode(', ',$get_performaings);?></div>
				                        </div>
							</div>
                                    </div><?php
										  }																																									 
                                }  
	            	 
                                if(!empty($user_meta['topics_covered']) && !empty($user_meta['topics_covered'][0])){ 
									//$get_covered = unserialize($user_meta['topics_covered'][0]);
									
									if(is_serialized($user_meta['topics_covered'][0])){
											$topics_covered = unserialize($user_meta['topics_covered'][0]);
												foreach($topics_covered as $display_topics)
													{
													
														$topics_covereds[] = $display_topics;
													}
										}
										else{
											$topics_covereds = $user_meta['topics_covered'];
										}
									
									if(is_array($topics_covereds))
										{
								?>
					 <div class="type__itm">
		                    <div class="profile__subtitle">Topics covered</div>
		                    <div class="type__selected">
								<div class="selected-itm">
			                           
			                            <div class="selected-itm__txt"><?php echo implode(', ',$topics_covereds); ?></div>
			                        </div>
								   </div>
		                </div>
								<?php
                                }  ?>  
		          
		                 <?php
		            } ?>
	            </div>
				<?php if(!empty($user_meta['i_offer_work'][0]) && $user_meta['i_offer_work'][0] != '') { ?> 
	            <div class="profile__slider">
	                <div class="profile__subtitle">Performing arts work</div>
	                <div class="slider-wrps">
	                  
		                      <?php echo $user_meta['all_work'][0];?>
	                   
	                </div>
	            </div>
				<?php } ?>
				<?php if(!empty($user_meta['all_tour'][0]) && $user_meta['all_tour'][0] != '') { ?> 
	            <div class="profile__slider">
	                <div class="profile__subtitle">Touring opportunities</div>
	                <div class="slider-wrps">
	                   
							<?php echo $user_meta['all_tour'][0];?>
							
	                    
	                </div>
	            </div>
				<?php } ?>
	        </div>
	    </div>
	</section><?php
}
get_footer();
?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        jQuery("body").addClass('pe-body--white');
        jQuery(".footer").addClass('footer--dark');
		
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
</script>

<script>
$(".display_user_data").click(function(){
  $(".contact__cont").toggleClass("display-contact");
  $(".eye_closed").toggleClass("open");
  $(".open-eyes").toggleClass("closed");
  	
});	
var $temp = $("<input>");
var $url = $(".clickcopy").attr('data-href');
$('.clickcopy').on('click', function() {	
  $("body").append($temp);
$temp.val($url).select();
  document.execCommand("copy");
  $temp.remove();
  $(".clickcopy").text("URL copied!");
})
</script>