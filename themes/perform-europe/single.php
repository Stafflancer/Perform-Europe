 <?php
get_header(); 
$pinned = get_field('pinned', get_the_ID());
$related_article = get_field('related_article', get_the_ID());
$categories = get_the_category(); 
$class = array();
$category_id = array();
$exclude = get_the_ID();
foreach( $categories as $category ) {
    $category_id[] = $category->term_id;
    if($category->name == 'News'){
        $class[] = "bg-red";
    }
    else if($category->name == 'Events'){
        $class[] = "bg-yellow";
    }
    else if($category->name == 'Resources'){ 
         $class[] = "bg-green";
    }
    else if($category->name == 'Stories'){ 
         $class[] = "bg-magenta";
    }   
    else{
         $class[] = "bg-red";
    } 
} 
$button = get_field('button', get_the_ID()); ?>
<section class="section-wrp s-article">
    <div class="article__title-wrp">
        <div class="title__label-wrp"><?php 
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
                        <div class="label__txt"><?php echo $category->name; ?></div>
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
            } ?>
           <a href="/activities/" class="txt-link--small">VIEW ALL</a>
        </div>
        <h1 class="h1"><?php the_title();?></h1>
    </div>
    <div class="article__cont">
        <div class="article__img-cont"><?php 
            if (has_post_thumbnail( get_the_ID()) ): 
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' ); ?>
                <div class="article__img-wrp">
                    <img src="<?php echo $image[0]; ?>" loading="lazy" alt="" class="article__img" data-savee-read="true">
                </div><?php
            endif; 
            if(!empty(get_field( 'deadline'))){ ?>                            
                <div class="article__img__description">Deadline: &nbsp;<?php echo esc_html ( get_field( 'deadline') ); ?></div>
                <?php
            } else{ ?>
                <div class="article__img__description">Published: &nbsp;<?php echo get_the_date();?></div>
            <?php } ?> 
        </div>
        <?php the_content(); ?><?php
        if(!empty($button['url'])){ ?>
           <a href="<?php echo esc_url($button['url']); ?>" target="<?php echo $button['target'];?>" class="btn--big w-inline-block <?php echo implode(" ",$class); ?>">
                <div class="txt-block"><?php echo esc_html( $button['title'] ); ?></div>
            </a><?php
        } ?>
    </div>
</section><?php
//if($related_article == 1){
    if(!empty($categories)){
       related_blog( $exclude, $category_id, $pinned); 
    } 
//} ?>
<?php
get_footer();