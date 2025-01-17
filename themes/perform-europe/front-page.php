<?php
get_header(); 
$banner_type_1 = get_field('banner_type_1'); 
$banner_type_2 = get_field('banner_type_2'); 
$banner_type_3 = get_field('banner_type_3'); 
$banner_type_4 = get_field('banner_type_4'); 
$banner_type_5 = get_field('banner_type_5'); 
$banner_type_6 = get_field('banner_type_6'); 
?>
<section class="section-wrp s-landing-animation">
    <div class="overlay-wrp bg-blue">
        <div class="overlay-cont">
            <?php if(get_field('hello_title')){?> 
            <h3 class="h3 margin-btm"><?php echo get_field('hello_title');?></h3>
            <?php } ?>
            <?php if(get_field('hello_description')){?> 
            <p class="paragraph margin-btm"><?php echo get_field('hello_description');?></p>
            <?php } ?>     
            <div class="cta-wrp"><?php
                if(get_field('hello_video')){ ?>
                    <div id="open-video" class="play-btn _100">
                        <div class="txt-block--1rem"><?php echo get_field('hello_section_button'); ?></div>
                        <div class="play-btn__icon"></div>
                    </div><?php
                } 
                $hello_section_link = get_field('hello_section_link');
                if(!empty($hello_section_link['url'])){ ?>
                    <a href="<?php echo esc_url($hello_section_link['url']); ?>" target="<?php echo $hello_section_link['target']; ?>" class="link--block w-inline-block">
                        <div class="txt--small"><?php echo $hello_section_link['title']; ?></div>
                    </a><?php
                } ?>
            </div>
        </div>
    </div>
	<?php if (wp_is_mobile() ) : ?>
	<?php
    $mobile_option_type = get_field('mobile_option_type');
    $mobile_option = get_field('mobile_option');
    $mobile_image = get_field('mobile_image');
    if($mobile_option_type == 'video'){
        if($mobile_option){ ?>
            <div class="landing__image--mobile">
                <video autoplay muted loop class="landing__image">
                    <source src="<?php echo $mobile_option['url']; ?>" type="video/mp4">
                </video>
            </div><?php
        } 
    } 
    else{
        if($mobile_image){ ?>
            <div class="landing__image--mobile">
                <img src="<?php echo $mobile_image; ?>">
            </div><?php
        } 
    } ?>
<?php else : ?>
	<div class="landing-img-wrp">
        <div class="l__itm__titles"><?php
            if(get_field('caption_text_1')){ ?>
                <div class="l__title-wrp">
                    <h3 class="l__title" id="title-gen"><?php echo get_field('caption_text_1'); ?></h3>
                </div><?php
            } 
            if(get_field('caption_text_2')){ ?>
                <div class="l__title-wrp">
                    <h3 class="l__title" id="title-div"><?php echo get_field('caption_text_2'); ?></h3>
                </div><?php
            }
            if(get_field('caption_text_3')){ ?>
                <div class="l__title-wrp">
                    <h3 class="l__title" id="title-inn"><?php echo get_field('caption_text_3'); ?></h3>
                </div><?php
            }
            if(get_field('caption_text_4')){ ?>
                <div class="l__title-wrp">
                    <h3 class="l__title" id="title-inc"><?php echo get_field('caption_text_4'); ?></h3>
                </div><?php
            }
            if(get_field('caption_text_5')){ ?>
                <div class="l__title-wrp">
                    <h3 class="l__title" id="title-sus"><?php echo get_field('caption_text_5'); ?></h3>
                </div><?php
            }
            if(get_field('caption_text_6')){ ?>
                <div class="l__title-wrp">
                    <h3 class="l__title" id="title-acc"><?php echo get_field('caption_text_6'); ?></h3>
                </div><?php
            } ?>
        </div><?php
        $option_1 = get_field('option_1');
        if($banner_type_1 == 'video'){
            if($option_1){ ?>
                <video autoplay muted loop class="l__img top-right">
                    <source src="<?php echo $option_1['url']; ?>" type="video/mp4">
                </video><?php
            } 
        }
        else{ 
            $image_1 = get_field('image_1'); 
            if(!empty($image_1)){ ?>
                <div class="banner-image">
                    <img src="<?php echo $image_1; ?>">
                </div><?php
            }
        }
        $option_2 = get_field('option_2');
        if($banner_type_2 == 'video'){
            if($option_2){ ?>
                <video autoplay muted loop class="l__img top-mid-right">
                    <source src="<?php echo $option_2['url']; ?>" type="video/mp4">
                </video><?php
            }
        }
        else{ 
            $image_2 = get_field('image_2'); 
            if(!empty($image_2)){ ?>
                <div class="banner-image">
                    <img src="<?php echo $image_2; ?>">
                </div><?php
            }
        }
        $option_3 = get_field('option_3');
        if($banner_type_3 == 'video'){
            if($option_3){ ?>
                <video autoplay muted loop class="l__img top-mid">
                    <source src="<?php echo $option_3['url']; ?>" type="video/mp4">
                </video><?php
            } 
        }
        else{ 
            $image_3 = get_field('image_3'); 
            if(!empty($image_3)){ ?>
                <div class="banner-image">
                    <img src="<?php echo $image_3; ?>">
                </div><?php
            }
        }
        $option_4 = get_field('option_4');
        if($banner_type_4 == 'video'){
            if($option_4){ ?>
                <video autoplay muted loop class="l__img bottom-mid">
                    <source src="<?php echo $option_4['url']; ?>" type="video/mp4">
                </video><?php
            }
        }
        else{ 
            $image_4 = get_field('image_4'); 
            if(!empty($image_4)){ ?>
                <div class="banner-image">
                    <img src="<?php echo $image_4; ?>">
                </div><?php
            }
        }
        $option_5 = get_field('option_5');
        if($banner_type_5 == 'video'){
            if($option_5){ ?>
                <video autoplay muted loop class="l__img bottom-left">
                    <source src="<?php echo $option_5['url']; ?>" type="video/mp4">
                </video><?php
            }
        }
        else{ 
            $image_5 = get_field('image_5'); 
            if(!empty($image_5)){ ?>
                <div class="banner-image">
                    <img src="<?php echo $image_5; ?>">
                </div><?php
            }
        }
        $option_6 = get_field('option_6');
        if($banner_type_6 == 'video'){
            if($option_6){ ?>
                <video autoplay muted loop class="l__img bottom-right">
                    <source src="<?php echo $option_6['url']; ?>" type="video/mp4">
                </video><?php
            } 
        } 
        else{ 
            $image_6 = get_field('image_6'); 
            if(!empty($image_6)){ ?>
                <div class="banner-image">
                    <img src="<?php echo $image_6; ?>">
                </div><?php
            }
        }?>
    </div>
<?php endif; ?>
    
</section>
<section class="section-wrp s-card">
    <div class="card-wrp bg-mint"><?php
        if(get_field('intro_title')){ ?>
            <h2 class="card__title"><?php echo get_field('intro_title'); ?></h2><?php
        } 
        if(get_field('intro_description') || get_field('intro_page_link')){ ?>
            <div class="card-cont"><?php
                if(get_field('intro_description')){ ?>
                    <p class="paragraph"><?php echo get_field('intro_description'); ?></p><?php
                } 
                $intro_page_link = get_field('intro_page_link');
                if(!empty($intro_page_link)){ ?>
                    <a href="<?php echo esc_url($intro_page_link['url']); ?>" target="<?php echo $intro_page_link['target']; ?>" class="btn--black w-inline-block">
                    <div class="txt-block--1rem"><?php echo esc_html( $intro_page_link['title'] ); ?></div>
                    </a><?php
                } ?>
            </div><?php
        } 
        if(get_field('highlight_1') || get_field('highlight_2') || get_field('highlight_3')){ ?>
            <div class="card-cont mobile--hide"><?php
                if(get_field('highlight_1')){ ?>
                    <div class="card__element">
                        <div class="txt-block--1rem">Total Budget</div>
                        <div class="txt-block--1rem txt-big"><?php echo get_field('highlight_1'); ?></div>
                    </div><?php
                } 
                if(get_field('highlight_2')){ ?>
                    <div class="card__element">
                        <div class="txt-block--1rem">Grants</div>
                        <div class="txt-block--1rem txt-big"><?php echo get_field('highlight_2'); ?></div>
                    </div><?php
                } 
                if(get_field('highlight_3')){ ?>
                    <div class="card__element">
                        <div class="txt-block--1rem">Selected Projects</div>
                        <div class="txt-block--1rem txt-big"><?php echo get_field('highlight_3'); ?></div>
                    </div><?php
                } ?>
            </div><?php
        } ?>
    </div>
</section><?php
$get_pinned_post = get_field('select_pinned_post', 'option');
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3, 
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'post__not_in' => array($get_pinned_post->ID),
);
$recent_posts = new WP_Query($args); 
if ($recent_posts->have_posts()) {  ?>
    <section class="section-wrp s-latest"><?php
        $news_page_link = get_field('news_page_link'); 
        if(get_field('news_title') || $news_page_link['url']){ ?>
            <div class="title-wrp t-w-latest">
                <h3 class="txt-h2"><?php echo get_field('news_title'); ?></h3><?php
                if(!empty($news_page_link['url'])){ ?>
                   <a href="<?php echo esc_url($news_page_link['url']); ?>" class="link--block w-inline-block"><div class="txt--small"><?php echo esc_html( $news_page_link['title'] ); ?></div></a><?php
                } ?>
            </div><?php
        } ?>
        <div class="latest__itm-grid-wrp">
            <div class="latest__itm-grid"><?php $i =0;
                while ( $recent_posts->have_posts() ) {
                    $recent_posts->the_post();
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
                        else if($category->name == 'Events'){
                            $class[] = "shadow-yellow";
                        }
                        else if($category->name == 'Resources'){ 
                             $class[] = "shadow-green";
                        }
                        else if($category->name == 'Stories'){ 
                             $class[] = "shadow-magenta";
                        }
                        else{
                             $class[] = "";
                        } 
                    } 

                    if($i == 0){
                    if(!empty($get_pinned_post))
                    {
                        $categoriess = get_the_category($get_pinned_post->ID); 
                        $classs = array();
                            foreach( $categoriess as $category ) {
                                if($category->name == 'News'){
                                    $classs[] = "shadow-red";
                                }
                                else if($category->name == 'Events'){
                                    $classs[] = "shadow-yellow";
                                }
                                else if($category->name == 'Resources'){ 
                                     $classs[] = "shadow-green";
                                }
                                else if($category->name == 'Stories'){ 
                             $class[] = "shadow-magenta";
                        }
                                else{
                                     $classs[] = "";
                                } 
                            } 
                            $images = wp_get_attachment_url( get_post_thumbnail_id($get_pinned_post->ID, 'full'));  
                        ?>
                            <a href="<?php echo get_the_permalink($get_pinned_post->ID); ?>" class="grid__itm-wrp <?php echo implode(" ",$classs); ?> w-inline-block">
                                <div class="grid__itm-head">
                                    <div class="label-wrp"><?php 
                                        foreach( $categoriess as $category ) {
                                            if($category->name == 'News'){ ?>
                                                <div class="label bg-red">
                                                    <div class="label__txt txt-up"><?php echo $category->name; ?></div>
                                                </div><?php
                                            }
                                            else if($category->name == 'Events'){ ?>
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
                                            else if($category->name == 'Stories'){ ?>
                                                <div class="label bg-magenta">
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
                                            <div class="label--transparent">
                                                <div class="label__txt--white txt-up">pinned</div>
                                            </div><?php
                                        ?>
                                    </div>
                                    <div class="arrow-btn"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="arrow__img"></div>
                                </div>
                                <div class="grid__itm-cont"><?php
                                    if(!empty($images)){ ?>
                                        <div class="itm__img">
                                            <img src="<?php echo $images; ?>" loading="lazy" alt="<?php the_title($get_pinned_post->ID); ?>" class="itm__img__img">
                                        </div><?php
                                    } ?>
                                    <h4 class="itm__txt"><?php echo get_the_title($get_pinned_post->ID); ?></h4>
                                </div><?php
                                if(!empty(get_field( 'deadline', $get_pinned_post->ID))){ ?>
                                    <div class="itm__deadline">Deadline: <?php echo esc_html ( get_field( 'deadline', $get_pinned_post->ID) ); ?></div><?php
                                }
                                else{ ?>
                                    <div class="itm__deadline">Published: <?php echo get_the_date('M j, Y',$get_pinned_post->ID); ?></div>
                                <?php } ?>
                            </a><?php
                        }
                    }
                    ?>
                    <a href="<?php echo get_the_permalink(); ?>" class="grid__itm-wrp <?php echo implode(" ",$class); ?> w-inline-block">
                        <div class="grid__itm-head">
                            <div class="label-wrp"><?php 
                                foreach( $categories as $category ) {
                                    if($category->name == 'News'){ ?>
                                        <div class="label bg-red">
                                            <div class="label__txt txt-up"><?php echo $category->name; ?></div>
                                        </div><?php
                                    }
                                    else if($category->name == 'Events'){ ?>
                                        <div class="label bg-yellow">
                                            <div class="label__txt txt-up"><?php echo $category->name; ?></div>
                                        </div><?php
                                    }
                                     else if($category->name == 'Stories'){ ?>
                                                <div class="label bg-magenta">
                                                    <div class="label__txt txt-up"><?php echo $category->name; ?></div>
                                                </div><?php
                                            }
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
                            <div class="itm__deadline">Published: <?php echo esc_html (get_the_date()); ?></div>
                        <?php } ?>
                    </a><?php $i++;
                } wp_reset_postdata(); 
               
                $subscribe_title = get_field('subscribe', 'option');

                if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                    <div id="w-node-c90942e8-2cab-8a1e-95ed-3a5c1306a881-eaa7b610" class="grid-cta hide-mobile"><?php
                        if(!empty($subscribe_title['description'])){ ?>
                            <?php echo $subscribe_title['description']; ?><?php
                        }
                        if(!empty($subscribe_title['external_link'])){ ?>
                            <a href="<?php echo $subscribe_title['external_link']['url'] ?>" class="btn--transparent w-inline-block" target="_blank">
                                <div class="txt-block--1rem">Join newsletter</div>
                            </a><?php
                        } ?>
                    </div><?php
                } ?>
            </div><?php
            if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                <div class="grid-cta--mobile"><?php
                    if(!empty($subscribe_title['description'])){ ?>
                        <?php echo $subscribe_title['description']; ?><?php
                    } 
                    if(!empty($subscribe_title['external_link'])){ ?>
                        <a href="<?php echo $subscribe_title['external_link']['url'] ?>" target="_blank" class="btn--transparent w-inline-block">
                            <div class="txt-block--1rem">Join newsletter</div>
                        </a><?php
                    } ?>
                </div><?php
            } ?>
        </div>
    </section><?php
} 
$moving_text_block_text = get_field('moving_text_block_text'); 
if(!empty($moving_text_block_text)){ ?>
    
    <section class="section-wrp s-marquee">
        <div class="marquee-wrp">
            <div class="marquee__txt">
                <div class="txt-block"><?php echo $moving_text_block_text; ?></div>
            </div>
        </div>
    </section><?php
} 
global $post;
$randomized_from = get_field('randomized_from');
if ( ! empty( $randomized_from ) ) { ?>
    <section class="section-wrp s-selected">
        <div class="title-wrp t-w-projects">
            <h3 class="txt--h2"><?php echo get_field('selected_project_title');?></h3>
			<?php $selected_project_link = get_field('selected_project_link'); ?>
            <a href="<?php echo $selected_project_link['url'];?>" class="link--block w-inline-block">
                <div class="txt--small"><?php echo $selected_project_link['title'];?></div>
            </a>
        </div>
        <div class="paragraph-wrp">
			<?php echo get_field('selected_project_description');?>            
        </div>

        <div id="app">
            <div class="swiper">
                <div class="swiper-wrapper"><?php                    
                   shuffle($randomized_from);
                   foreach ( $randomized_from as $post ){
                        setup_postdata( $post );
                        $postid = get_the_ID(); ?>
                        <div class="swiper-slide">
                            <div class="swiper-carousel-animate-opacity">
                                <a href="<?php echo get_the_permalink(); ?>" class="project__itm-wrp p-featured w-inline-block">
                                    <div class="project__itm-head">
                                        <div class="arrow-btn">
                                            <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="arrow__img">
                                        </div>
                                    </div><?php
                                    if (has_post_thumbnail( get_the_ID()) ): 
                                        $image = wp_get_attachment_url( get_post_thumbnail_id($postid, 'full'));   ?>
                                        <div class="project-img">
                                            <img src="<?php echo $image; ?>" loading="lazy" alt="<?php the_title(); ?>" class="itm__img__img">
                                        </div><?php
                                    endif; ?>
                                    <div class="txt--4rem-slid txt-up _w-700"><?php echo substr(get_the_title(), 0, 45).'...'; ?></div>
                                </a>
                            </div>
                        </div><?php
                    } wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </section><?php
} ?>
<section class="footer">
    <div class="title-wrp">
        <?php if(!empty(get_field('consortium_partners_title'))){ ?>
        <h3 class="txt--h2"><?php echo get_field('consortium_partners_title');?></h3>
        <?php } ?>
        <?php if(!empty(get_field('consortium_partners_page_link'))){ 
            $consortium_partner_page_link = get_field('consortium_partners_page_link');                    
            ?>
        <a href="<?php echo $consortium_partner_page_link['url'];?>" class="link--block w-inline-block" target="<?php echo $consortium_partner_page_link['target'];?>">
            <div class="txt--small"><?php echo $consortium_partner_page_link['title'];?></div>
        </a>
        <?php } ?>  
    </div>
    <div class="logo-wrp">
        <?php echo get_field('consortium_partners_description');?>
        <?php 
        if( have_rows('add_consortium_partner',43) ): 
        ?>
        <div class="logo__list">
        <?php                   
            while( have_rows('add_consortium_partner',43) ) : the_row();
                $logo = get_sub_field('logo');                                                
            ?>
            <img src="<?php echo $logo;?>" loading="lazy" alt="" class="logo__list__img">
        <?php
            endwhile;
        echo '</div>';
        endif;
    ?>                 
    </div>
</section> 
<?php
get_footer(); ?>
