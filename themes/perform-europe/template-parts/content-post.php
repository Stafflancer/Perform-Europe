<?php
/**
 * Template part for displaying post.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bopper
 */

$postid = get_the_ID();
$pinned = get_field('pinned', get_the_ID());
$deadline = get_field('deadline', get_the_ID());
$image = wp_get_attachment_url( get_post_thumbnail_id($postid, 'full'));  
$categories = get_the_category(); 
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
                else if($category->name == 'Events'){ ?>
                    <div class="label bg-yellow">
                        <div class="label__txt txt-up"><?php echo $category->name; ?></div>
                    </div><?php
                }
                
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
            if($pinned == 11){ ?>
                <div class="label--transparent">
                    <div class="label__txt--white txt-up">pinned</div>
                </div><?php
            } ?>
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
    </div>
    <?php
                    if(!empty($deadline)){ ?>
                            <div class="itm__deadline">Deadline: <?php echo esc_html ( get_field( 'deadline', get_the_ID()) ); ?></div><?php
                        } else{ ?>
                            <div class="itm__deadline">Published: <?php echo get_the_date(); ?></div>
                        <?php } ?>
</a>