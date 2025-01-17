 <?php
get_header(); 

$edition = get_field_object( 'edition' );
$value = $edition['value'];
$label = $edition['choices'][ $value ]; 
$background_color = get_field('project_background_color', get_the_ID()); 
if($background_color == 'blue'){
    $class = 'project--bg-blue';
} 
else if($background_color == 'green'){
    $class = 'project--bg-green';
} 
else if($background_color == 'magenta'){
    $class = 'project--bg-magenta';
} 
else{
    $class = 'project--bg-red';
}  ?>
<style>
.p__slider__title {
    width: 176px;
    word-wrap: break-word;
}</style>
<section class="section-wrp s-project-land <?php echo $class; ?>">
    <div class="project__title-wrp"><?php
        if(!empty($edition)){ ?>
            <a href="/selected-projects/" style="color: #ffffff;"><h4 class="project__subtitle"><?php echo esc_html($label); ?></h4></a><?php
        } ?>
        <h1 class="project__title"><?php the_title(); ?></h1>
    </div><?php
    if (has_post_thumbnail( get_the_ID()) ): 
         $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' ); ?>
        <div class="project__img" data-savee-read="true" style="background-image: url(<?php echo $image[0]; ?>); "></div><?php
    endif; ?>
</section><?php
if(get_field('project_description', get_the_ID()) || get_field('project_grant', get_the_ID())){ ?>
    <section class="section-wrp s-project-descr"><?php
        if(get_field('project_description', get_the_ID())){ ?>
            <div class="paragraph--2coll"><?php echo get_field('project_description', get_the_ID()); ?></div><?php
        } 
        if(get_field('project_grant', get_the_ID())){ ?>
            <div class="project__grant">
                <div class="grant__txt">Perform Europe Grant</div>
                <div class="grant__number"><?php echo get_field('project_grant', get_the_ID()); ?></div>
            </div><?php
        } ?>
    </section><?php
} 
$select_partners = get_field('select_partners', get_the_ID()); 
if(!empty($select_partners)){ ?>
    <section class="section-wrp s-project-partners">
        <div class="section__title-wrp">
            <h2 class="section__title">Partners</h2>
        </div>
        <div class="partners__slider-wrp">
            <div class="partners__slider"><?php
                foreach($select_partners as $partners){                      
                    $add_partner_name = $partners['add_partner_name'];
                    $add_partner_image = $partners['add_partner_image'];
                    $select_partner_country = $partners['select_partner_country'];  
                    $partners_link = $partners['partners_link'];
                    if(!empty($partners_link))
                    {
                        $partners_link_new = $partners_link;
                        $target = '_blank';
                    }
                    else
                    {
                        $partners_link_new = 'javascript:void(0);';
                        $target = '';
                    }
                    ?>
                    <a href="<?php echo $partners_link_new;?>" class="p__slider__itm single-page-list w-inline-block" target="<?php echo $target;?>">
                        
                        <div class="p__slider__title"><?php echo $add_partner_name; ?></div><?php
                        if(!empty($select_partner_country)){ ?>
                            <div class="p__slider__place"><?php echo $select_partner_country; ?></div><?php
                        } 
                        if($partners_link != '')
                        {
                            ?>
                            <div class="p__slider__icon"></div>
                            <?php
                        }
                        ?>                        
                    </a><?php
                } ?>
            </div>
        </div>
    </section><?php
} 
$timeline_heading = 'Timeline and Itinerary';
$timeline_and_itinerary = get_field('timeline_and_itinerary', get_the_ID()); 
if(!empty($timeline_heading) && !empty($timeline_and_itinerary)){ ?>
    <section class="section-wrp s-project-timeline"><?php
        if(!empty($timeline_heading)){ ?>
            <div class="section__title-wrp">
                <h2 class="section__title"><?php echo $timeline_heading?></h2>
            </div><?php
        } 
        if(!empty($timeline_and_itinerary)){ ?>
            <div class="paragraph--2coll"><?php echo $timeline_and_itinerary; ?></div><?php
        } ?>
    </section><?php
} 
$productions = get_field('productions', get_the_ID());
if(!empty($productions)){ 
    global $post;
if(count($productions) == 1){
                    $slider_class= 'single-slider';
                }
                else{
                    $slider_class= '';
                }
?>
    <section class="section-wrp s-project-productions">
        <div class="section__title-wrp">
            <h2 class="section__title"><?php echo get_field('productions_heading','option');?></h2>
        </div>
        <div class="productions__slider-wrp <?php echo $slider_class;?>">
            <div class="productions__slider"><?php
                
                foreach ( $productions as $production ){ ?>
                
                    <div class="pro__slider__itm <?php echo $slider_class;?>">
                        <div class="dividing-line op-0"></div>
                        <div class="pro__slid__itm__cont">
                            <div class="pro__slid__head single-page-prod">
                                <div class="pro__slid__head-left"><?php
                                if($production['production_name']){ ?>
                                    <div class="pro__slid__title"><?php echo $production['production_name']; ?></div><?php
                                }
                                if($production['producer_name']){ ?>
                                    <div class="pro__slid__subtitle">Producers: <?php echo $production['producer_name']; ?></div><?php
                                } ?>
                                </div><?php
                                if($production['production_link']){ ?>
                                <div class="pro__slider__icon"><a href="<?php echo $production['production_link'];?>" target="_blank" style="opacity: 0;">text</a></div>
                                <?php }
                                ?>
                                
                            </div><?php
                            if($production['producer_image']){  ?>
                                <div class="pro__slid__img-wrp">
                                    <img src="<?php echo $production['producer_image']; ?>" loading="lazy" alt="" class="pro__slid__img">
                                </div><?php
                            } 
                            if($production['production_description']){ ?>
                                <div class="paragraph"><?php echo $production['production_description']; ?></div><?php
                            } ?>
                        </div>
                        <?php if(count($productions) == 1)
                        {
                        echo '<div class="dividing-line op-0"></div>';
                        }
                        else{
                            echo '<div class="dividing-line"></div>';
                        } ?>
                        
                    </div><?php
                } ?>
            </div>
        </div>
    </section><?php
} 
$performance = get_field('performance', get_the_ID()); 

if(!empty($performance)){ 
global $post; ?>
    <section class="section-wrp s-project-dates">
        <div class="section__title-wrp">
            <h2 class="section__title"><?php echo get_field('performance_dates_heading','option');?></h2>
        </div>
        <div class="dates__list">
            <div class="list__itm-menu-wrp">
                <div class="list__menu">
                    <div id="w-node-_50a575d8-0e82-107d-e213-6e3228081045-a709e52f" class="txt-block">List of
                        performances</div>
                    <div id="w-node-cb3e0ce0-7a93-a8b1-9379-6f908ba5fd86-a709e52f"
                        class="txt-block--right show-mobile">DATES</div>
                    <div id="w-node-_6a8b0886-9083-c844-c3fc-3678a87b182f-a709e52f" class="txt-block hide-mobile">
                        Venue and location</div>
                    <div id="w-node-_194dcece-3d65-93e2-c3a2-f2da020ae3d1-a709e52f" class="txt-block hide-mobile">
                        Performing arts</div>
                    <div id="w-node-efd978fd-53e6-7986-d488-e1861e5f3b6e-a709e52f" class="txt-block hide-mobile">
                        Topics covered</div>
                    <div id="w-node-dc966ebc-3148-bbe2-6715-615a109be0d7-a709e52f" class="txt-block hide-mobile">
                        Date</div>
                </div>
            </div><?php
			
			$venue = array();
			$country = array();
			$start_date = array();
			$end_date = array();
			$main_array = array();
			$performing_arts_array = array();
			$topics_covered_array = array();
			$website_link_array = array();
			foreach ( $performance as $post ){
                setup_postdata( $post ); 
                $performing_arts = get_the_terms( get_the_ID(), 'performing_arts' );
                $topics_covered = get_the_terms( get_the_ID(), 'topics_covered' ); 
                $producers = get_field('producers', get_the_ID());
				 
                $website_link = get_field('website_link', get_the_ID());
                
				
                if($producers){
					
                    foreach( $producers as $producer ) {
						$child_array = array(); 
                        $child_array['venue'] = $producer['venue'];
                        $child_array['country'] = $producer['country'];
                        $child_array['start_date'] = $producer['start_date'];
                        $child_array['end_date'] = $producer['end_date'];
						$child_array['performing_arts'] = $performing_arts;
						$child_array['topics_covered'] = $topics_covered;
						$child_array['website_link'] = $website_link;
						array_push($main_array,$child_array);

                    } 
                }  
            }
			if(!empty($main_array))	 
			{
						usort($main_array, 'date_compare');
			
						$past_or_blank = [];
						$future = [];

						// Current date
						$current_dates = date('Y-m-d');

						// Iterate through the array
						foreach ($main_array as $item) {
							$start_new_date = date('Y-m-d',strtotime($item['start_date']));
							if (empty($start_new_date) || $start_new_date < $current_dates) {
								$past_or_blank[] = $item;
							} else {
								$future[] = $item;
							}
						}
				
					if(!empty($future)){
						foreach($future as $display_item)
						{	
							$website_link = $display_item['website_link'];
							 if($website_link != '')
							{
								$get_website_link = $website_link;
								$link_target = '_blank';
							}
							else
							{
								$get_website_link = 'javascript:void(0)';   
								$link_target = '';
							}
							
							$venue = $display_item['venue'];
							$country = $display_item['country'];
							$performing_arts = $display_item['performing_arts'];
							$topics_covered = $display_item['topics_covered'];
							$start_date = $display_item['start_date'];
							$end_date = $display_item['end_date'];
							?>
							 <a href="<?php echo $get_website_link; ?>" class="list__itm-wrp w-inline-block" target="<?php echo $link_target;?>">
                            <div class="list__itm">
                                <div id="w-node-c3077b49-7dac-42e5-5db1-975bf4217c4f-a709e52f" class="itm__title"><?php the_title(); ?></div>
                                <div id="w-node-_02e96550-8ca3-f3a2-4423-17c9b0847b26-a709e52f" class="itm__txt-wrp"><?php
                                    if(!empty($venue)){ 
                                       ?>
                                            <div class="txt-block"><?php echo $venue; ?></div><?php
                                       
                                    }
                                    if(!empty($country)){   
                                        ?>
                                            <div class="txt--small" style="color: #b1a2a2;font-weight: bold;"><?php echo $country; ?></div><?php
                                       
                                    } ?>
                                </div>
                                <div id="w-node-_859fcd17-d2d8-a4cf-709c-80d86193271a-a709e52f"
                                    class="project-itm__label-wrp hide-mobile"><?php
                                    if($performing_arts){
                                        foreach( $performing_arts as $performing_art ) { ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $performing_art->name; ?></div>
                                            </div><?php
                                        }
                                    } ?>
                                </div>
                                <div id="w-node-ea8a67a1-2dea-b5ae-37d2-830252ef099b-a709e52f"
                                    class="project-itm__label-wrp hide-mobile"><?php
                                    if($topics_covered){
                                        foreach( $topics_covered as $topics ) { ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $topics->name; ?></div>
                                            </div><?php
                                        }
                                    } ?>
                                </div>
                                
                                    <?php                            
                                    if($start_date && $end_date){                              
                                       ?>
                                       <div id="w-node-_157b903e-82b7-7f9c-5719-792b20ed5eb7-a709e52f" class="itm__txt-wrp">
                                           <div class="txt-block"><?php echo $start_date .' - '. $end_date ; ?></div>
                                        </div>
                                           <?php 
                                    }
                                else{                              
                                       ?>
                                       <div id="w-node-_157b903e-82b7-7f9c-5719-792b20ed5eb7-a709e52f" class="itm__txt-wrp">
                                           <div class="txt-block"><?php echo $start_date; ?></div>
                                        </div>
                                           <?php 
                                    }?>
                                <?php if($get_website_link)
                                { ?>
                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="partner__list__icon">
                                <?php } ?>
                                
                            </div>
                        </a>
							<?php
						}
					}
					
				if(!empty($past_or_blank)){
						foreach($past_or_blank as $display_item)
						{	
							$website_link = $display_item['website_link'];
							 if($website_link != '')
							{
								$get_website_link = $website_link;
								$link_target = '_blank';
							}
							else
							{
								$get_website_link = 'javascript:void(0)';   
								$link_target = '';
							}
							
							$venue = $display_item['venue'];
							$country = $display_item['country'];
							$performing_arts = $display_item['performing_arts'];
							$topics_covered = $display_item['topics_covered'];
							$start_date = $display_item['start_date'];
							$end_date = $display_item['end_date'];
							
							
							$style_opcity = '';
                        if($start_date){
                           
                            if($end_date != '')
                            {
                                $date_now = time(); //current timestamp
                                $date_convert = strtotime($end_date);

                                if ($date_now > $date_convert) {
                                    $style_opcity = 'style="opacity:50%";';
                                }  
                            }
                            else
                            {
                                $date_now = time(); //current timestamp
                                $date_convert = strtotime($start_date);

                                if ($date_now > $date_convert) {
                                    $style_opcity = 'style="opacity:50%";';
                                }    
                            }
                           
                        } 
							
							?>
							 <a href="<?php echo $get_website_link; ?>" class="list__itm-wrp w-inline-block" <?php echo $style_opcity;?> target="<?php echo $link_target;?>">
                            <div class="list__itm">
                                <div id="w-node-c3077b49-7dac-42e5-5db1-975bf4217c4f-a709e52f" class="itm__title"><?php the_title(); ?></div>
                                <div id="w-node-_02e96550-8ca3-f3a2-4423-17c9b0847b26-a709e52f" class="itm__txt-wrp"><?php
                                    if(!empty($venue)){ 
                                       ?>
                                            <div class="txt-block"><?php echo $venue; ?></div><?php
                                       
                                    }
                                    if(!empty($country)){   
                                        ?>
                                            <div class="txt--small"><?php echo $country; ?></div><?php
                                       
                                    } ?>
                                </div>
                                <div id="w-node-_859fcd17-d2d8-a4cf-709c-80d86193271a-a709e52f"
                                    class="project-itm__label-wrp hide-mobile"><?php
                                    if($performing_arts){
                                        foreach( $performing_arts as $performing_art ) { ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $performing_art->name; ?></div>
                                            </div><?php
                                        }
                                    } ?>
                                </div>
                                <div id="w-node-ea8a67a1-2dea-b5ae-37d2-830252ef099b-a709e52f"
                                    class="project-itm__label-wrp hide-mobile"><?php
                                    if($topics_covered){
                                        foreach( $topics_covered as $topics ) { ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $topics->name; ?></div>
                                            </div><?php
                                        }
                                    } ?>
                                </div>
                                
                                    <?php                            
                                    if($start_date && $end_date){                              
                                       ?>
                                       <div id="w-node-_157b903e-82b7-7f9c-5719-792b20ed5eb7-a709e52f" class="itm__txt-wrp">
                                           <div class="txt-block"><?php echo $start_date .' - '. $end_date ; ?></div>
                                        </div>
                                           <?php 
                                    }
                                else{                              
                                       ?>
                                       <div id="w-node-_157b903e-82b7-7f9c-5719-792b20ed5eb7-a709e52f" class="itm__txt-wrp">
                                           <div class="txt-block"><?php echo $start_date; ?></div>
                                        </div>
                                           <?php 
                                    }?>
                                <?php if($get_website_link)
                                { ?>
                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="partner__list__icon">
                                <?php } ?>
                                
                            </div>
                        </a>
							<?php
						}
					}
				
			} 	
			 wp_reset_postdata(); ?>
        </div>
    </section><?php
} 
$photo_credits = get_field('photo_credits', get_the_ID()); 
if(!empty($photo_credits)){ ?>
    <section class="section-wrp s-project-photo-credits">
        <div class="credits-wrp">
            <div class="credits__head">
                <div class="txt--small">Photo credits</div>
            </div>
            <p class="paragraph"><?php echo $photo_credits; ?></p>
        </div>
    </section><?php
}
$post  = array(
    'numberposts' => 3,
    'post_type'   => 'post',
    'orderby'     => 'date',
    'order'       => 'DESC',
);
$latest_post = get_posts( $post );
if ( !empty( $latest_post ) ) {
    global $post;?>
    <section class="section-wrp s-news">
        <div class="title-wrp t-w-latest">
            <h3 class="txt--h2">Related news</h3>
            <div class="txt-block txt-up"><a href="/activities/" class="link--block w-inline-block">view all </a></div>
        </div>
        <div class="itm-grid"><?php
            foreach ( $latest_post as $post ) {
                setup_postdata( $post ); 
                $postid = get_the_ID();
                $image = wp_get_attachment_url( get_post_thumbnail_id($postid, 'full'));  
                $categories = get_the_category(); 
                $pinned = get_field('pinned', get_the_ID());
                $deadline = get_field('deadline', get_the_ID());
                $class = array();
                foreach( $categories as $category ) {
                    if($category->name == 'News'){
                        $class[] = "shadow-red";
                    }
                    else if($category->name == 'Event'){
                        $class[] = "shadow-yellow";
                    }
                    else if($category->name == 'Resources'){ 
                         $class[] = "shadow-green";
                    }
                    else{
                         $class[] = "";
                    } 
                } ?>
                <a href="<?php echo get_the_permalink(); ?>" class="grid__itm-wrp <?php echo implode(" ",$class); ?> w-inline-block">
                    <div class="grid__itm-head">
                        <div class="label-wrp"><?php 
                            foreach( $categories as $category ) {
                                if($category->name == 'News'){ ?>
                                    <div class="label bg-red">
                                        <div class="label__txt txt-up"><?php echo $category->name; ?></div>
                                    </div><?php
                                }
                                else if($category->name == 'Event'){ ?>
                                    <div class="label bg-yellow">
                                        <div class="label__txt txt-up"><?php echo $category->name; ?></div>
                                    </div><?php
                                }
                                /*else if($category->name == 'Open Call'){ ?>
                                    <div class="label">
                                        <div class="label__txt"><?php echo $category->name; ?></div>
                                    </div><?php
                                }*/
                                else if($category->name == 'Resources'){ ?>
                                    <div class="label bg-green">
                                        <div class="label__txt txt-up"><?php echo $category->name; ?></div>
                                    </div><?php
                                }
                                else{ ?>
                                    <div class="label bg-red">
                                        <div class="label__txt txt-up"><?php echo $category->name; ?></div>
                                    </div><?php
                                }
                            } 
                            ?>
                        </div>
                        <div class="arrow-btn"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="arrow__img"></div>
                    </div>
                    <div class="grid__itm-cont"><?php
                        if(!empty($image)){ ?>
                            <div class="itm__img">
                                <img src="<?php echo $image; ?>" loading="lazy" alt="<?php the_title(); ?>" class="itm__img__img">
                            </div><?php
                        } ?>
                        <h4 class="itm__txt"><?php the_title(); ?></h4>
                    </div><?php
                    if(!empty($deadline)){ ?>
                            <div class="itm__deadline">Deadline: <?php echo esc_html ( get_field( 'deadline', get_the_ID()) ); ?></div><?php
                        } else{ ?>
                            <div class="itm__deadline">Published: <?php echo get_the_date('M j Y',get_the_ID()); ?></div>
                        <?php } ?>
                </a><?php
            } wp_reset_postdata(); ?>
        </div>
    </section><?php
}

function date_compare($a, $b)
{
	$t1 = strtotime($a['start_date']);
	$t2 = strtotime($b['start_date']);
	return $t1 - $t2;
}    
get_footer();