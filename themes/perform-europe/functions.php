<?php

if (! file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

if (! locate_template($file = "app/setup.php", true, true)) {
    wp_die(
        /* translators: %s is replaced with the relative file path */
        sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
    );
}

if (! locate_template($file = "app/actions.php", true, true)) {
    wp_die(
        /* translators: %s is replaced with the relative file path */
        sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
    );
}

/**
 * Functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bopper
 * @since   1.0.0
 */
/**
 * Define theme globals: theme version, text domain, etc.
 *
 * @since 1.0.0
 */
$theme_version  = wp_get_theme()->get( 'Version' );
$version_string = is_string( $theme_version ) ? $theme_version : null;

function theme_slug_setup() {
    add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'theme_slug_setup' );

/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
function scripts() {
    /**
     * Enqueue 3rd party required styles.
     */
    wp_enqueue_style( 'style', get_theme_file_uri( 'style.css' ), [], null );
    
    /**
     * Enqueue required scripts.
     */     
    
    wp_enqueue_style( 'swiperjs-style', get_theme_file_uri( '/assets/css/swiper-bundle.min.css' ), [], null );
    wp_enqueue_style( 'custom-style', get_theme_file_uri( '/assets/css/custom-style.css' ), [], null );
    wp_enqueue_script( 'swiperjs-script', get_theme_file_uri( '/assets/js/swiper-bundle.min.js' ), [], null, true );
    
    wp_enqueue_script( 'carousel-script', get_theme_file_uri( '/assets/js/carousel.js' ), [], null, true );   
    //wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css', [], null ); 
    wp_enqueue_style( 'select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css', [], null );  
   // wp_enqueue_script( 'bootstrap-script', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js', [], null, true );
    wp_enqueue_script( 'select2-script', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js', [], null, true );
    wp_enqueue_script( 'gsap-script', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js' ,[], null, true);
    wp_enqueue_script( 'custom-script', get_theme_file_uri( '/assets/js/script.js' ), [], null, true ); 

}

add_action( 'wp_enqueue_scripts', 'scripts' );
 

/**
 * ACF theme options page - Setting up ACF options pages
 * Enables "Options" pages in Advanced Custom Fields
 */

if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( [
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect'   => true,
        'position'   => 3.1,
    ] );

    acf_add_options_sub_page( [
        'page_title'  => 'General Settings',
        'menu_title'  => 'General',
        'parent_slug' => 'theme-settings',
    ] );

    acf_add_options_sub_page( [
        'page_title'  => 'Header Settings',
        'menu_title'  => 'Header',
        'parent_slug' => 'theme-settings',
    ] );

    acf_add_options_sub_page( [
        'page_title'  => 'Footer Settings',
        'menu_title'  => 'Footer',
        'parent_slug' => 'theme-settings',
    ] );

}


add_filter( 'body_class', 'my_neat_body_class');
function my_neat_body_class( $classes ) {
    if ( is_page(57) ){
        $classes[] = 'pe-body--mint';
    }
    else if ( is_page(195) ){
        $classes[] = 'pe-body--pink';
    }
    else if ( is_page(197) ){
        $classes[] = 'pe-body--beige';
    }
    else if ( is_page(1020) || is_page(1086) ){
        $classes[] = 'pe-body--white';
    }
    else{
        $classes[] = 'pe-body';
    }   
    return $classes; 
}

// add post image
add_theme_support( 'post-thumbnails' );

/* Blog Filter */

function latestnewslist_fn_ajax( $atts ) 
{
    global $wpdb;
    $noofposts = 9;

    $page = (int) (!isset($_REQUEST['page']) ? 1 :$_REQUEST['page']);

    $page = ($page == 0 ? 1 : $page);

    $recordsPerPage = $noofposts;

    $start = ($page-1) *$recordsPerPage;

    $adjacents = "1";

    $get_pinned_post = get_field('select_pinned_post', 'option');

    if(!empty($_POST['newsortby']))
    {

        $found_posts = array(

            'post_type' => 'post',

            'post_status'   => 'publish',

            'posts_per_page' => $recordsPerPage,

            'paged' => $page,

            'orderby' => 'date',

            'order'   => 'DESC',
            'post__not_in' => array($get_pinned_post->ID),

            'tax_query' => array(

                array(

                    'taxonomy' => 'category',

                    'field'    => 'term_id',

                    'terms'    => array($_POST['newsortby']),

                ),

            ),

        ); 
    }
    else
    {
            $found_posts = array(

            'post_type' => 'post',

            'post_status'   => 'publish',

            'orderby' => 'date',

            'order'   => 'DESC',

            'posts_per_page' => $recordsPerPage,

            'paged' => $page,
             'post__not_in' => array($get_pinned_post->ID),
               
            );
    }
    $wp_query = new WP_Query($found_posts);
    $count = $wp_query->found_posts;
    if (!empty($get_pinned_post))
    {
        $categories = get_the_category($get_pinned_post->ID); 
        $category_id = $_POST['newsortby'];
        $get_pinned_category_id = $categories[0]->cat_ID;
        if($category_id == $get_pinned_category_id || $_POST['newsortby'] == ''){
          $classs = array();
          foreach( $categories as $category ) {
              if($category->name == 'News'){
                  $classs[] = "shadow-red";
              }
              else if($category->name == 'Events'){
                  $classs[] = "shadow-yellow";
              }
              else if($category->name == 'Resources'){ 
                   $classs[] = "shadow-green";
              }
              else{
                   $classs[] = "";
              } 
          } 
          $images = wp_get_attachment_url( get_post_thumbnail_id($get_pinned_post->ID, 'full'));  ?>
          <a href="<?php echo get_the_permalink($get_pinned_post->ID); ?>" class="grid__itm-wrp <?php echo implode(" ",$classs); ?> w-inline-block">
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
    if ($wp_query->have_posts())
    { 
        while ($wp_query->have_posts())
        { 
            $wp_query->the_post(); 
            get_template_part( 'template-parts/content', get_post_type() );
        } wp_reset_postdata(); ?>
        <div id="w-node-_5375aeed-c089-51f4-511b-318aa04264b7-a709e52f" class="search__results__cta-wrp">
            <div class="search__pages__menu ajax_pagination">
                <div class="txt--small">Pages</div>
                 <?php include("ajax_pagination.php"); ?>
            </div><?php
            $subscribe_title = get_field('subscribe', 'option'); 
            if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                <div id="w-node-_5375aeed-c089-51f4-511b-318aa04264c8-a709e52f" class="grid-cta"><?php
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
    }
    else{
      echo "<span class='error-message'>No result!</span>";
    }
    die;
}

add_action( 'wp_ajax_blogs', 'latestnewslist_fn_ajax' );

add_action( 'wp_ajax_nopriv_blogs', 'latestnewslist_fn_ajax' ); 

function title_filter( $where, &$wp_query ){
    global $wpdb;
    if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $search_term ) ) . '%\'';
    }
    return $where;
}

/* News Search */
function latestsearchlist_fn_ajax( $atts ) 
{
    if(!empty($_POST['search']))
    {
        $found_posts = array(

            'post_type' => 'post',

            'post_status'   => 'publish',

            'posts_per_page' => 5,

            'orderby' => 'date',

            'order'   => 'DESC',

            'search_prod_title' => $_POST['search'],

        ); 
    }
    add_filter( 'posts_where', 'title_filter', 10, 2 );
    $wp_query = new WP_Query($found_posts);
    remove_filter( 'posts_where', 'title_filter', 10, 2 );
    if ($wp_query->have_posts()){ 
        while ($wp_query->have_posts()){ 
            $wp_query->the_post(); 
            $postid = get_the_ID(); 
            $blogimage = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID(), 'thumbnail'));  
            $categories = get_the_category();  ?>
            <a href="<?php echo get_the_permalink(); ?>"><div class="search__suggestion__itm"><?php 
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
                    else{ ?>
                        <div class="label--transparent">
                            <div class="label__txt--white txt-up"><?php echo $category->name; ?></div>
                        </div><?php
                    }
                } ?>
                <div id="w-node-_2d2dcde4-f1f8-1776-5c1d-c7830e409966-a709e52f" class="search__img-wrp ss-m">
                    <img src="<?php echo $blogimage; ?>"
                        loading="lazy" sizes="(max-width: 479px) 100vw, 80px"
                        srcset="<?php echo $blogimage; ?>"
                        alt="<?php the_title(); ?>" class="search__img"></div>
                 <div id="w-node-_2d2dcde4-f1f8-1776-5c1d-c7830e409968-a709e52f" class="search__title"><?php echo get_the_title(); ?></div>
            </div></a><?php
        } wp_reset_postdata(); 
    } 
    else{
        echo ' <p class="error-msg">there are 0 results</p>';
    }
    die;
}

add_action( 'wp_ajax_search_blogs', 'latestsearchlist_fn_ajax' );

add_action( 'wp_ajax_nopriv_search_blogs', 'latestsearchlist_fn_ajax' ); 

// Display the related blog
function related_blog( $exclude, $category_id) {
    $args = array(
        'category__in' => $category_id,
        'posts_per_page' => 3,
        'post_status' => 'publish',
        'ignore_sticky_posts' => true,
        'no_found_rows' => true,
        'post__not_in' => array($exclude),
        'meta_key'      => 'pinned',
        'orderby'       => 'meta_value',
        'order'     => 'DESC',
    );
    $recent_posts = new WP_Query( $args ); 
    if ( $recent_posts->have_posts() ) 
    {  ?>
        <section class="section-wrp s-news">
            <div class="title-wrp t-w-latest">
                <h3 class="txt-h2">Related news</h3>
                <a href="/activities/" class="txt-block txt-up">view all </a>
            </div>
            <div class="itm-grid"><?php
                while ( $recent_posts->have_posts() ) {
                    $recent_posts->the_post();
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
                    }  ?>
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
                        </div> 
                        <?php
                        if(!empty(get_field( 'deadline', get_the_ID()))){ ?>
                            <div class="itm__deadline">Deadline: <?php echo esc_html ( get_field( 'deadline', get_the_ID()) ); ?></div><?php
                        }
                        else{ ?>
                            <div class="itm__deadline">Published: <?php echo esc_html (get_the_date()); ?></div>
                        <?php } ?>

                    </a><?php
                } wp_reset_postdata(); ?>
            </div>
        </section><?php
    }
}

/* Project Search */
function latestprojectsearchlist_fn_ajax( $atts ) 
{
    if(!empty($_POST['search']))
    {
        $found_posts = array(

            'post_type' => 'project',

            'post_status'   => 'publish',

            'posts_per_page' => 5,

            'orderby' => 'date',

            'order'   => 'DESC',

            'search_prod_title' => $_POST['search'],

        ); 
    }
    add_filter( 'posts_where', 'title_filter', 10, 2 );
    $wp_query = new WP_Query($found_posts);
    remove_filter( 'posts_where', 'title_filter', 10, 2 );
    if ($wp_query->have_posts())
    { 
        while ($wp_query->have_posts())
        { 
            $wp_query->the_post(); 
            $postid = get_the_ID(); 
            $blogimage = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID(), 'thumbnail'));  
            $postid = get_the_ID();
            $image = wp_get_attachment_url( get_post_thumbnail_id($postid, 'full'));  
            $performance = get_field('performance', get_the_ID());
            if(!empty($performance)){
                $performing_arts = array();
                $topics_covered = array();
                foreach ( $performance as $post ){
                    setup_postdata( $post ); 
                    $performing_arts[] = get_the_terms( get_the_ID(), 'performing_arts' );
                    $topics_covered[] = get_the_terms( get_the_ID(), 'topics_covered' );
                } wp_reset_postdata(); 
            }  ?>
            <a href="<?php echo get_the_permalink(); ?>">
                <div class="search__suggestion__itm current">
                    <div class="">
                        <div class="itm__label__txt"></div>
                    </div>
                    <div id="w-node-_2d2dcde4-f1f8-1776-5c1d-c7830e409966-a709e52f" class="search__img-wrp ss-m">
                        <img src="<?php echo $blogimage; ?>" loading="lazy" sizes="(max-width: 479px) 100vw, 80px" srcset="<?php echo $blogimage; ?>" alt="<?php the_title(); ?>" class="search__img"></div>
                    <div id="w-node-_2d2dcde4-f1f8-1776-5c1d-c7830e409968-a709e52f" class="search__title"><?php echo get_the_title(); ?></div>
                </div>
            </a><?php
        } wp_reset_postdata(); 
    } 
    else{
       echo ' <p class="error-msg">'.get_field("message_for_partner_page","option").'</p>';
    }
   
    die;
}

add_action( 'wp_ajax_search_projects', 'latestprojectsearchlist_fn_ajax' );

add_action( 'wp_ajax_nopriv_search_projects', 'latestprojectsearchlist_fn_ajax' ); 

/* Live Programme Proejct List */

function live_programme_fn_ajax( $atts ) 
{
    $noofposts = 20;

    $page = (int) (!isset($_REQUEST['page']) ? 1 :$_REQUEST['page']);

    $page = ($page == 0 ? 1 : $page);

    $recordsPerPage = $noofposts;

    $start = ($page-1) *$recordsPerPage;

    $adjacents = "1";

    if(isset($_POST['countries']) && !empty($_POST['countries'])){

        $performance = get_posts( array(

            'post_type' => 'performance',
			'posts_per_page' => '-1',

            'post_status'   => array('publish', 'private') ,   

            'orderby' => 'date',

            'order'   => 'DESC',
           
        ) );
        $IDS = array();
		
        foreach ( $performance as $post ) {
		     
            $producers = get_field('producers', $post->ID);  
		 
            if(!empty($producers)){
                foreach ( $producers as $producer ){
                    if (in_array($producer['country'], $_POST['countries'])) {
                      $IDS[] += $post->ID;
                    } 

                } 
            }
        }
		
        if(!empty($IDS)){
            $found_posts = array(

                'post_type' => 'performance',

                 'post_status'   => array('publish', 'private') ,   

                'orderby' => 'date',

                'order'   => 'DESC',

                'posts_per_page' => $recordsPerPage,

                'paged' => $page,

                'post__in' => $IDS,

            );

            $wp_query = new WP_Query($found_posts);
            $count = $wp_query->found_posts;
            if ($wp_query->have_posts())
            { 
              while ($wp_query->have_posts())
              { 
                  $wp_query->the_post(); 
                  $corresponding_project = get_field('corresponding_project', get_the_ID());
                  $performing_arts = get_the_terms( get_the_ID(), 'performing_arts' );
                  $topics_covered = get_the_terms( get_the_ID(), 'topics_covered' );
                  $producers = get_field('producers', get_the_ID());
                  $website_link = get_field('website_link', get_the_ID());
                  if(!empty($website_link)){
                      $link = $website_link;
                  }
                  else{
                      $link = '#';
                  }
                  $project_id = '';
                  if(!empty($corresponding_project)){
                      $project_id = $corresponding_project->ID;
                  }
                  else{
                      $project_id = get_the_ID();
                  }
                  $postid = get_the_ID();
                  $image = wp_get_attachment_url( get_post_thumbnail_id($project_id, 'full'));  
                  if(!empty($producers)){
                      foreach($producers as  $producer){ 
							if (in_array($producer['country'], $_POST['countries'])) {
								
							$style_opcity = '';
							if($producer['start_date']){

								if($producer['end_date'] != '')
								{
									$date_now = time(); //current timestamp
									$date_convert = strtotime($producer['end_date']);

									if ($date_now > $date_convert) {
										$style_opcity = 'style="opacity:40%";';
									}  
								}
								else
								{
									$date_now = time(); //current timestamp
									$date_convert = strtotime($producer['start_date']);

									if ($date_now > $date_convert) {
										$style_opcity = 'style="opacity:40%";';
									}    
								}

							} 	
							?>
                          <div class="project-list__itm-wrp">
                              <a href="<?php echo get_the_permalink($project_id); ?>" class="project-list__itm live-programme w-inline-block" <?php echo $style_opcity;?>>
                                  <div id="w-node-_633d187b-3a7e-6bfe-6654-6229e6d5b331-a709e52f" class="project-list__img-wrp"><?php
                                      if(!empty($image)){ ?>
                                          <img src="<?php echo $image; ?>" loading="lazy" id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067e-a709e52f" alt="<?php get_the_title($project_id); ?>"
                                              class="project-list__img"><?php
                                      } ?>
                                  </div>
                                  <div id="w-node-ba21d53e-eb6f-b34f-b5b9-9e25ecd53609-a709e52f"
                                      class="project__txt-wrp productions">
                                      <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a5016085-a709e52f" class="project-itm__title">
                                          <?php echo get_the_title(); ?></div>
                                          <div class="txt-xxs"><?php echo get_the_title($project_id); ?></div>
                                  </div>
                                  <div id="w-node-b03cb753-b3d8-1dfb-bf4e-df7475ca1b95-a709e52f"
                                      class="project__txt-wrp location"><?php
                                          if(!empty($producer['venue'])){ ?>
                                              <div id="w-node-b03cb753-b3d8-1dfb-bf4e-df7475ca1b96-a709e52f" class="project-itm__txt">
                                              <?php echo $producer['venue']; ?></div><?php
                                          }
                                          if(!empty($producer['country'])){ ?>
                                              <div class="txt-xxs"><?php echo $producer['country']; ?></div><?php
                                          } ?>
                                  </div>
                                  <div id="w-node-_2ccf9e45-fba9-0d34-63de-8438d7516f7c-a709e52f" class="project__txt-wrp dates">
                                      <div id="w-node-_2ccf9e45-fba9-0d34-63de-8438d7516f7d-a709e52f" class="project-itm__txt"><?php if(!empty($producer['start_date'])){ echo $producer['start_date']; } ?> <?php if(!empty($producer['end_date'])){ echo 'to<br> '.$producer['end_date']; } ?>
                                      </div>
                                  </div>
                                  <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a501608c-a709e52f"
                                      class="project-itm__label-wrp performing-arts"><?php
                                      if($performing_arts){
                                          foreach( $performing_arts as $performing_art ) { ?>
                                              <div class="itm__label">
                                                  <div class="itm__label__txt"><?php echo $performing_art->name; ?></div>
                                              </div><?php
                                          }
                                      } ?>
                                  </div>
                                  <div id="w-node-e8d6400b-1e40-5835-4c54-98a2ebbefb35-a709e52f"
                                      class="project-itm__label-wrp topics-covered"><?php
                                      if($topics_covered){
                                          foreach( $topics_covered as $topics ) { ?>
                                              <div class="itm__label">
                                                  <div class="itm__label__txt"><?php echo $topics->name; ?></div>
                                              </div><?php
                                          }
                                      } ?>
                                  </div>

                              </a> 
                              <a href="<?php echo $link; ?>" class="external-link-wrp w-inline-block"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/6500c5fcc13a41e5eff4d118_arrow-yellow.svg" alt="" class="project__arrow"></a>
                          </div><?php }
                      } 
                  }  
              } wp_reset_postdata(); ?>
              <div class="pages__menu-wrp">
                  <div class="pages__menu ajax_pagination">
                      <div class="txt--small">Pages</div>
                      <?php include("ajax_pagination.php"); ?>
                  </div><?php
                  $subscribe_title = get_field('subscribe', 'option'); 
                  if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                      <div class="grid-cta"><?php
                          if(!empty($subscribe_title['description'])){ ?>
                              <?php echo $subscribe_title['description']; ?><?php
                          }
                          if(!empty($subscribe_title['external_link'])){ ?>
                              <a href="<?php echo $subscribe_title['external_link']['url'] ?>" class="btn-transparent--dark w-inline-block">
                                  <div class="txt-block--1rem">Join newsletter</div>
                              </a><?php
                          } ?>
                      </div><?php
                  } ?>
              </div><?php
            }
            else{
             echo "<span class='error-message'>".get_field('message_for_performance_page','option')."</span>";
            }
        }
        else{
         echo "<span class='error-message'>".get_field('message_for_performance_page','option')."</span>";
        }
    }
    else if(isset($_POST['performing']) && !empty($_POST['performing'])){

        $found_posts = array(

            'post_type' => 'performance',

             'post_status'   => array('publish', 'private') ,   

            'orderby' => 'date',

            'order'   => 'DESC',

            'posts_per_page' => $recordsPerPage,

            'paged' => $page,

            'tax_query' => array(

                array(

                    'taxonomy' => 'performing_arts',

                    'field'    => 'term_id',

                    'terms'    => $_POST['performing'],

                ),

            ), 
        );

        $wp_query = new WP_Query($found_posts);
        $count = $wp_query->found_posts;
        if ($wp_query->have_posts())
        { 
          while ($wp_query->have_posts())
          { 
              $wp_query->the_post(); 
              $corresponding_project = get_field('corresponding_project', get_the_ID());
              $performing_arts = get_the_terms( get_the_ID(), 'performing_arts' );
              $topics_covered = get_the_terms( get_the_ID(), 'topics_covered' );
              $producers = get_field('producers', get_the_ID());
              $website_link = get_field('website_link', get_the_ID());
              if(!empty($website_link)){
                  $link = $website_link;
              }
              else{
                  $link = '#';
              }
              $project_id = '';
              if(!empty($corresponding_project)){
                  $project_id = $corresponding_project->ID;
              }
              else{
                  $project_id = get_the_ID();
              }
              $postid = get_the_ID();
              $image = wp_get_attachment_url( get_post_thumbnail_id($project_id, 'full'));  
              if(!empty($producers)){
                  foreach($producers as  $producer){ 
						$style_opcity = '';
							if($producer['start_date']){

								if($producer['end_date'] != '')
								{
									$date_now = time(); //current timestamp
									$date_convert = strtotime($producer['end_date']);

									if ($date_now > $date_convert) {
										$style_opcity = 'style="opacity:40%";';
									}  
								}
								else
								{
									$date_now = time(); //current timestamp
									$date_convert = strtotime($producer['start_date']);

									if ($date_now > $date_convert) {
										$style_opcity = 'style="opacity:40%";';
									}    
								}

							} 	
					?>
                      <div class="project-list__itm-wrp">
                          <a href="<?php echo get_the_permalink($project_id); ?>" class="project-list__itm live-programme w-inline-block" <?php echo $style_opcity;?>>
                              <div id="w-node-_633d187b-3a7e-6bfe-6654-6229e6d5b331-a709e52f" class="project-list__img-wrp"><?php
                                  if(!empty($image)){ ?>
                                      <img src="<?php echo $image; ?>" loading="lazy" id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067e-a709e52f" alt="<?php get_the_title($project_id); ?>"
                                          class="project-list__img"><?php
                                  } ?>
                              </div>
                              <div id="w-node-ba21d53e-eb6f-b34f-b5b9-9e25ecd53609-a709e52f"
                                  class="project__txt-wrp productions">
                                  <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a5016085-a709e52f" class="project-itm__title">
                                          <?php echo get_the_title(); ?></div>
                                          <div class="txt-xxs"><?php echo get_the_title($project_id); ?></div>
                              </div>
                              <div id="w-node-b03cb753-b3d8-1dfb-bf4e-df7475ca1b95-a709e52f"
                                  class="project__txt-wrp location"><?php
                                      if(!empty($producer['venue'])){ ?>
                                          <div id="w-node-b03cb753-b3d8-1dfb-bf4e-df7475ca1b96-a709e52f" class="project-itm__txt">
                                          <?php echo $producer['venue']; ?></div><?php
                                      }
                                      if(!empty($producer['country'])){ ?>
                                          <div class="txt-xxs"><?php echo $producer['country']; ?></div><?php
                                      } ?>
                              </div>
                              <div id="w-node-_2ccf9e45-fba9-0d34-63de-8438d7516f7c-a709e52f" class="project__txt-wrp dates">
                                  <div id="w-node-_2ccf9e45-fba9-0d34-63de-8438d7516f7d-a709e52f" class="project-itm__txt"><?php if(!empty($producer['start_date'])){ echo $producer['start_date']; } ?> <?php if(!empty($producer['end_date'])){ echo 'to<br> '.$producer['end_date']; } ?>
                                  </div>
                              </div>
                              <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a501608c-a709e52f"
                                  class="project-itm__label-wrp performing-arts"><?php
                                  if($performing_arts){
                                      foreach( $performing_arts as $performing_art ) { ?>
                                          <div class="itm__label">
                                              <div class="itm__label__txt"><?php echo $performing_art->name; ?></div>
                                          </div><?php
                                      }
                                  } ?>
                              </div>
                              <div id="w-node-e8d6400b-1e40-5835-4c54-98a2ebbefb35-a709e52f"
                                  class="project-itm__label-wrp topics-covered"><?php
                                  if($topics_covered){
                                      foreach( $topics_covered as $topics ) { ?>
                                          <div class="itm__label">
                                              <div class="itm__label__txt"><?php echo $topics->name; ?></div>
                                          </div><?php
                                      }
                                  } ?>
                              </div>

                          </a> 
                          <a href="<?php echo $link; ?>" class="external-link-wrp w-inline-block"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/6500c5fcc13a41e5eff4d118_arrow-yellow.svg" alt="" class="project__arrow"></a>
                      </div><?php
                  } 
              }  
          } wp_reset_postdata(); ?>
          <div class="pages__menu-wrp">
              <div class="pages__menu ajax_pagination">
                  <div class="txt--small">Pages</div>
                  <?php include("ajax_pagination.php"); ?>
              </div><?php
              $subscribe_title = get_field('subscribe', 'option'); 
              if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                  <div class="grid-cta"><?php
                      if(!empty($subscribe_title['description'])){ ?>
                          <?php echo $subscribe_title['description']; ?><?php
                      }
                      if(!empty($subscribe_title['external_link'])){ ?>
                          <a href="<?php echo $subscribe_title['external_link']['url'] ?>" class="btn-transparent--dark w-inline-block">
                              <div class="txt-block--1rem">Join newsletter</div>
                          </a><?php
                      } ?>
                  </div><?php
              } ?>
          </div><?php
        }
        else{
          echo "<span class='error-message'>".get_field('message_for_performance_page','option')."</span>";
        }
    }
    else if(isset($_POST['topics']) && !empty($_POST['topics'])){

        $found_posts = array(

            'post_type' => 'performance',

             'post_status'   => array('publish', 'private') ,   

            'orderby' => 'date',

            'order'   => 'DESC',

            'posts_per_page' => $recordsPerPage,

            'paged' => $page,

            'tax_query' => array(

                array(

                    'taxonomy' => 'topics_covered',

                    'field'    => 'term_id',

                    'terms'    => $_POST['topics'],

                ),

            ), 
        );

        $wp_query = new WP_Query($found_posts);
        $count = $wp_query->found_posts;
        if ($wp_query->have_posts())
        { 
          while ($wp_query->have_posts())
          { 
              $wp_query->the_post(); 
              $corresponding_project = get_field('corresponding_project', get_the_ID());
              $performing_arts = get_the_terms( get_the_ID(), 'performing_arts' );
              $topics_covered = get_the_terms( get_the_ID(), 'topics_covered' );
              $producers = get_field('producers', get_the_ID());
              $website_link = get_field('website_link', get_the_ID());
              if(!empty($website_link)){
                  $link = $website_link;
              }
              else{
                  $link = '#';
              }
              $project_id = '';
              if(!empty($corresponding_project)){
                  $project_id = $corresponding_project->ID;
              }
              else{
                  $project_id = get_the_ID();
              }
              $postid = get_the_ID();
              $image = wp_get_attachment_url( get_post_thumbnail_id($project_id, 'full'));  
              if(!empty($producers)){
                  foreach($producers as  $producer){
						$style_opcity = '';
							if($producer['start_date']){

								if($producer['end_date'] != '')
								{
									$date_now = time(); //current timestamp
									$date_convert = strtotime($producer['end_date']);

									if ($date_now > $date_convert) {
										$style_opcity = 'style="opacity:40%";';
									}  
								}
								else
								{
									$date_now = time(); //current timestamp
									$date_convert = strtotime($producer['start_date']);

									if ($date_now > $date_convert) {
										$style_opcity = 'style="opacity:40%";';
									}    
								}

							} 	
					?>
                    <div class="project-list__itm-wrp">
                      <a href="<?php echo get_the_permalink($project_id); ?>" class="project-list__itm live-programme w-inline-block" <?php echo $style_opcity;?>>
                          <div id="w-node-_633d187b-3a7e-6bfe-6654-6229e6d5b331-a709e52f" class="project-list__img-wrp"><?php
                              if(!empty($image)){ ?>
                                  <img src="<?php echo $image; ?>" loading="lazy" id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067e-a709e52f" alt="<?php get_the_title($project_id); ?>"
                                      class="project-list__img"><?php
                              } ?>
                          </div>
                          <div id="w-node-ba21d53e-eb6f-b34f-b5b9-9e25ecd53609-a709e52f"
                              class="project__txt-wrp productions">
                              <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a5016085-a709e52f" class="project-itm__title">
                                          <?php echo get_the_title(); ?></div>
                                          <div class="txt-xxs"><?php echo get_the_title($project_id); ?></div>
                          </div>
                          <div id="w-node-b03cb753-b3d8-1dfb-bf4e-df7475ca1b95-a709e52f"
                              class="project__txt-wrp location"><?php
                                  if(!empty($producer['venue'])){ ?>
                                      <div id="w-node-b03cb753-b3d8-1dfb-bf4e-df7475ca1b96-a709e52f" class="project-itm__txt">
                                      <?php echo $producer['venue']; ?></div><?php
                                  }
                                  if(!empty($producer['country'])){ ?>
                                      <div class="txt-xxs"><?php echo $producer['country']; ?></div><?php
                                  } ?>
                          </div>
                          <div id="w-node-_2ccf9e45-fba9-0d34-63de-8438d7516f7c-a709e52f" class="project__txt-wrp dates">
                              <div id="w-node-_2ccf9e45-fba9-0d34-63de-8438d7516f7d-a709e52f" class="project-itm__txt"><?php if(!empty($producer['start_date'])){ echo $producer['start_date']; } ?> <?php if(!empty($producer['end_date'])){ echo 'to<br> '.$producer['end_date']; } ?>
                              </div>
                          </div>
                          <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a501608c-a709e52f"
                              class="project-itm__label-wrp performing-arts"><?php
                              if($performing_arts){
                                  foreach( $performing_arts as $performing_art ) { ?>
                                      <div class="itm__label">
                                          <div class="itm__label__txt"><?php echo $performing_art->name; ?></div>
                                      </div><?php
                                  }
                              } ?>
                          </div>
                          <div id="w-node-e8d6400b-1e40-5835-4c54-98a2ebbefb35-a709e52f"
                              class="project-itm__label-wrp topics-covered"><?php
                              if($topics_covered){
                                  foreach( $topics_covered as $topics ) { ?>
                                      <div class="itm__label">
                                          <div class="itm__label__txt"><?php echo $topics->name; ?></div>
                                      </div><?php
                                  }
                              } ?>
                          </div>

                      </a> 
                      <a href="<?php echo $link; ?>" class="external-link-wrp w-inline-block"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/6500c5fcc13a41e5eff4d118_arrow-yellow.svg" alt="" class="project__arrow"></a>
                    </div><?php
                  } 
              }  
          } wp_reset_postdata(); ?>
          <div class="pages__menu-wrp">
              <div class="pages__menu ajax_pagination">
                  <div class="txt--small">Pages</div>
                  <?php include("ajax_pagination.php"); ?>
              </div><?php
              $subscribe_title = get_field('subscribe', 'option'); 
              if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                  <div class="grid-cta"><?php
                      if(!empty($subscribe_title['description'])){ ?>
                          <?php echo $subscribe_title['description']; ?><?php
                      }
                      if(!empty($subscribe_title['external_link'])){ ?>
                          <a href="<?php echo $subscribe_title['external_link']['url'] ?>" class="btn-transparent--dark w-inline-block">
                              <div class="txt-block--1rem">Join newsletter</div>
                          </a><?php
                      } ?>
                  </div><?php
              } ?>
          </div><?php
        }
        else{
          echo "<span class='error-message'>".get_field('message_for_performance_page','option')."</span>";
        }
    }
    else{
        $found_posts = array(

            'post_type' => 'performance',

             'post_status'   => array('publish', 'private') ,   

            'orderby' => 'date',

            'order'   => 'DESC',

            'posts_per_page' => $recordsPerPage,

            'paged' => $page,
           
        );

        $wp_query = new WP_Query($found_posts);
        $count = $wp_query->found_posts;
        if ($wp_query->have_posts())
        { 
          while ($wp_query->have_posts())
          { 
              $wp_query->the_post(); 
              $corresponding_project = get_field('corresponding_project', get_the_ID());
              $performing_arts = get_the_terms( get_the_ID(), 'performing_arts' );
              $topics_covered = get_the_terms( get_the_ID(), 'topics_covered' );
              $producers = get_field('producers', get_the_ID());
              $website_link = get_field('website_link', get_the_ID());
              if(!empty($website_link)){
                  $link = $website_link;
              }
              else{
                  $link = '#';
              }
              $project_id = '';
              if(!empty($corresponding_project)){
                  $project_id = $corresponding_project->ID;
              }
              else{
                  $project_id = get_the_ID();
              }
              $postid = get_the_ID();
              $image = wp_get_attachment_url( get_post_thumbnail_id($project_id, 'full'));  
              if(!empty($producers)){
                  foreach($producers as  $producer){ 
						$style_opcity = '';
							if($producer['start_date']){

								if($producer['end_date'] != '')
								{
									$date_now = time(); //current timestamp
									$date_convert = strtotime($producer['end_date']);

									if ($date_now > $date_convert) {
										$style_opcity = 'style="opacity:40%";';
									}  
								}
								else
								{
									$date_now = time(); //current timestamp
									$date_convert = strtotime($producer['start_date']);

									if ($date_now > $date_convert) {
										$style_opcity = 'style="opacity:40%";';
									}    
								}

							} 	
					?>
                    <div class="project-list__itm-wrp">
                      <a href="<?php echo get_the_permalink($project_id); ?>" class="project-list__itm live-programme w-inline-block" <?php echo $style_opcity;?>>
                          <div id="w-node-_633d187b-3a7e-6bfe-6654-6229e6d5b331-a709e52f" class="project-list__img-wrp"><?php
                              if(!empty($image)){ ?>
                                  <img src="<?php echo $image; ?>" loading="lazy" id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067e-a709e52f" alt="<?php get_the_title($project_id); ?>"
                                      class="project-list__img"><?php
                              } ?>
                          </div>
                          <div id="w-node-ba21d53e-eb6f-b34f-b5b9-9e25ecd53609-a709e52f"
                              class="project__txt-wrp productions">
                              <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a5016085-a709e52f" class="project-itm__title">
                                          <?php echo get_the_title(); ?></div>
                                          <div class="txt-xxs"><?php echo get_the_title($project_id); ?></div>
                          </div>
                          <div id="w-node-b03cb753-b3d8-1dfb-bf4e-df7475ca1b95-a709e52f"
                              class="project__txt-wrp location"><?php
                                  if(!empty($producer['venue'])){ ?>
                                      <div id="w-node-b03cb753-b3d8-1dfb-bf4e-df7475ca1b96-a709e52f" class="project-itm__txt">
                                      <?php echo $producer['venue']; ?></div><?php
                                  }
                                  if(!empty($producer['country'])){ ?>
                                      <div class="txt-xxs"><?php echo $producer['country']; ?></div><?php
                                  } ?>
                          </div>
                          <div id="w-node-_2ccf9e45-fba9-0d34-63de-8438d7516f7c-a709e52f" class="project__txt-wrp dates">
                              <div id="w-node-_2ccf9e45-fba9-0d34-63de-8438d7516f7d-a709e52f" class="project-itm__txt"><?php if(!empty($producer['start_date'])){ echo $producer['start_date']; } ?> <?php if(!empty($producer['end_date'])){ echo 'to<br> '.$producer['end_date']; } ?>
                              </div>
                          </div>
                          <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a501608c-a709e52f"
                              class="project-itm__label-wrp performing-arts"><?php
                              if($performing_arts){
                                  foreach( $performing_arts as $performing_art ) { ?>
                                      <div class="itm__label">
                                          <div class="itm__label__txt"><?php echo $performing_art->name; ?></div>
                                      </div><?php
                                  }
                              } ?>
                          </div>
                          <div id="w-node-e8d6400b-1e40-5835-4c54-98a2ebbefb35-a709e52f"
                              class="project-itm__label-wrp topics-covered"><?php
                              if($topics_covered){
                                  foreach( $topics_covered as $topics ) { ?>
                                      <div class="itm__label">
                                          <div class="itm__label__txt"><?php echo $topics->name; ?></div>
                                      </div><?php
                                  }
                              } ?>
                          </div>

                      </a> 
                      <a href="<?php echo $link; ?>" class="external-link-wrp w-inline-block"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/6500c5fcc13a41e5eff4d118_arrow-yellow.svg" alt="" class="project__arrow"></a>
                    </div><?php
                  } 
              }  
          } wp_reset_postdata(); ?>
          <div class="pages__menu-wrp">
              <div class="pages__menu ajax_pagination">
                  <div class="txt--small">Pages</div>
                  <?php include("ajax_pagination.php"); ?>
              </div><?php
              $subscribe_title = get_field('subscribe', 'option'); 
              if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                  <div class="grid-cta"><?php
                      if(!empty($subscribe_title['description'])){ ?>
                          <?php echo $subscribe_title['description']; ?><?php
                      }
                      if(!empty($subscribe_title['external_link'])){ ?>
                          <a href="<?php echo $subscribe_title['external_link']['url'] ?>" class="btn-transparent--dark w-inline-block">
                              <div class="txt-block--1rem">Join newsletter</div>
                          </a><?php
                      } ?>
                  </div><?php
              } ?>
          </div><?php
        }
        else{
         echo "<span class='error-message'>".get_field('message_for_performance_page','option')."</span>";
        }
    }
    
    die;
}

add_action( 'wp_ajax_live_programme_project_list', 'live_programme_fn_ajax' );

add_action( 'wp_ajax_nopriv_live_programme_project_list', 'live_programme_fn_ajax' ); 

/* Proejct List */

function project_filter_list_fn_ajax( $atts ) 
{
    $noofposts = 20;

    $page = (int) (!isset($_REQUEST['page']) ? 1 :$_REQUEST['page']);

    $page = ($page == 0 ? 1 : $page);

    $recordsPerPage = $noofposts;

    $start = ($page-1) *$recordsPerPage;

    $adjacents = "1";

    if(isset($_POST['countries']) && !empty($_POST['countries'])){

        $project = get_posts( array(

            'post_type' => 'project',

            'post_status'   => 'publish',

            'orderby' => 'date',

            'order'   => 'DESC',

            'posts_per_page' => -1,

        ) );

        $IDS = array();
        foreach ( $project as $post ) {
            $select_partners = get_field('select_partners', $post->ID);  
            if(!empty($select_partners)){
                foreach ( $select_partners as $partners ){
                    if (in_array($partners['select_partner_country'], $_POST['countries'])) {
                        $IDS[] += $post->ID;
                    } 

                } 
            }
        }
        if(!empty($IDS)){
            $found_posts = array(

                'post_type' => 'project',

                'post_status'   => 'publish',

                'orderby' => 'date',

                'order'   => 'DESC',

                'posts_per_page' => $recordsPerPage,

                'paged' => $page,

                'post__in' => $IDS,

            );

            $wp_query = new WP_Query($found_posts);
            $count = $wp_query->found_posts;
            if ($wp_query->have_posts())
            { 
                
                while ($wp_query->have_posts())
                { 
					$performing_arts_name = array();
                $topics_covered_name = array();
                $select_partner_country = array();
                    $wp_query->the_post(); 
                    $postid = get_the_ID();
                    $image = wp_get_attachment_url( get_post_thumbnail_id($postid, 'full'));  
                    $select_partners = get_field('select_partners', get_the_ID());  
                    $performance = get_field('performance', get_the_ID());
                    if(!empty($performance)){
                        foreach ( $performance as $performanc ){
                            $performing_arts = get_the_terms( $performanc->ID, 'performing_arts' );
                            $topics_covered = get_the_terms( $performanc->ID, 'topics_covered' );
                            if(!empty($performing_arts)){
                                foreach( $performing_arts as $performing_art ) { 
                                   $performing_arts_name[] = $performing_art->name;
                                }
                            }
                            if(!empty($topics_covered)){
                                foreach( $topics_covered as $topics ) { 
                                   $topics_covered_name[] = $topics->name;
                                }
                            }
                        }  
                    }
                    if(!empty($select_partners)){ 
                        foreach($select_partners as $partners){
                            if(!empty($partners['select_partner_country'])){ 
                                $select_partner_country[] = $partners['select_partner_country'];
                            }
                        }
                    } ?>
                    <a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="project-list__itm-wrp w-inline-block">
                        <div class="project-list__itm">
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067d-a709e52f" class="project-list__img-wrp"><?php
                                if(!empty($image)){ ?>
                                    <img src="<?php echo $image; ?>" loading="lazy" id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067e-a709e52f" alt="<?php the_title(); ?>"
                                        class="project-list__img"><?php
                                } ?>
                            </div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067f-a709e52f" class="project-itm__title"><?php echo get_the_title(get_the_ID()); ?></div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c80681-a709e52f"
                                class="project-itm__label-wrp countries"><?php
                                if(!empty($select_partner_country)){ 
                                    foreach(array_unique($select_partner_country) as $country){
                                        if(!empty($partners['select_partner_country'])){ ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $country; ?></div>
                                            </div><?php
                                        }
                                    }
                                } ?>
                            </div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068b-a709e52f"
                                class="project-itm__label-wrp performing-arts"><?php
                                if(!empty($performance) && !empty($performing_arts_name)){
                                    foreach( array_unique($performing_arts_name) as $performing_art ) { 
                                        if(!empty($performing_art)){ ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $performing_art; ?></div>
                                            </div><?php
                                        }
                                    }
                                } ?>
                            </div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068f-a709e52f"
                                class="project-itm__label-wrp topics-covered"><?php
                                if(!empty($performance) && !empty($topics_covered_name)){
                                    foreach( array_unique($topics_covered_name) as $topics_name ) { 
                                        if(!empty($topics_name)){ ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $topics_name; ?></div>
                                            </div><?php
                                        }
                                    }
                                }  ?>
                            </div>
                        </div>
                    </a><?php
                } wp_reset_query(); ?>
                <div class="pages__menu-wrp">
                    <div class="pages__menu ajax_pagination">
                        <div class="txt--small">Pages</div>
                        <?php include("ajax_pagination.php"); ?>
                    </div><?php
                    $subscribe_title = get_field('subscribe', 'option'); 
                    if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                        <div class="grid-cta"><?php
                            if(!empty($subscribe_title['description'])){ ?>
                                <?php echo $subscribe_title['description']; ?><?php
                            }
                            if(!empty($subscribe_title['external_link'])){ ?>
                                <a href="<?php echo $subscribe_title['external_link']['url'] ?>" class="btn-transparent--dark w-inline-block">
                                    <div class="txt-block--1rem">Join newsletter</div>
                                </a><?php
                            } ?>
                        </div><?php
                    } ?>
                </div><?php
            }
            else{
             echo "<span class='error-message'>".get_field('message_for_project_page','option')."</span>";
            }
        }
        else
        {
            echo "<span class='error-message'>".get_field('message_for_project_page','option')."</span>";
        }
    }
    else if(isset($_POST['performing']) && !empty($_POST['performing'])){

        $performance_list = get_posts( array(

            'post_type' => 'performance',

            'post_status'   => 'publish',

            'orderby' => 'date',

            'order'   => 'DESC',

            'posts_per_page' => -1,

            'tax_query' => array(

                array(

                    'taxonomy' => 'performing_arts',

                    'field'    => 'term_id',

                    'terms'    => $_POST['performing'],

                ),

            ), 
        ) );

        $IDS = array();
        foreach ( $performance_list as $post ) {
           $IDS[] += $post->ID;
        }

        $found_posts = array(

            'post_type' => 'project',

            'post_status'   => 'publish',

            'orderby' => 'date',

            'order'   => 'DESC',

            'posts_per_page' => -1,
        );
        $wp_query = new WP_Query($found_posts);
        $count = $wp_query->found_posts;
        $project_IDS = array();
        if ($wp_query->have_posts()){ 
            while ($wp_query->have_posts()){ 
                $wp_query->the_post(); 
                $performance = get_field('performance', get_the_ID());
                if(!empty($performance)){
                    foreach ( $performance as $post ){
                        if (in_array($post->ID, $IDS))
                        {
                            $project_IDS[] = get_the_ID();
                        }
                    } 
                } 
            } wp_reset_postdata(); 
        }
        if(!empty($project_IDS)){

            $found_posts = array(

                'post_type' => 'project',

                'post_status'   => 'publish',

                'orderby' => 'date',

                'order'   => 'DESC',

                'posts_per_page' => $recordsPerPage,

                'paged' => $page,

                'post__in' => $project_IDS,
               
            );
            $wp_query = new WP_Query($found_posts);
            $count = $wp_query->found_posts;
            $perf_IDS = array();
            if ($wp_query->have_posts())
            { 
                
                while ($wp_query->have_posts())
                { 
					$performing_arts_name = array();
                $topics_covered_name = array();
                $select_partner_country = array();
                    $wp_query->the_post(); 
                    $postid = get_the_ID();
                    $image = wp_get_attachment_url( get_post_thumbnail_id($postid, 'full'));  
                    $select_partners = get_field('select_partners', get_the_ID());  
                    $performance = get_field('performance', get_the_ID());
                    if(!empty($performance)){
                        foreach ( $performance as $performanc ){
                            $performing_arts = get_the_terms( $performanc->ID, 'performing_arts' );
                            $topics_covered = get_the_terms( $performanc->ID, 'topics_covered' );
                            if(!empty($performing_arts)){
                                foreach( $performing_arts as $performing_art ) { 
                                   $performing_arts_name[] = $performing_art->name;
                                }
                            }
                            if(!empty($topics_covered)){
                                foreach( $topics_covered as $topics ) { 
                                   $topics_covered_name[] = $topics->name;
                                }
                            }
                        }  
                    }
                    if(!empty($select_partners)){ 
                        foreach($select_partners as $partners){
                            if(!empty($partners['select_partner_country'])){ 
                                $select_partner_country[] = $partners['select_partner_country'];
                            }
                        }
                    } ?>
                    <a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="project-list__itm-wrp w-inline-block">
                        <div class="project-list__itm">
                                <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067d-a709e52f" class="project-list__img-wrp"><?php
                                if(!empty($image)){ ?>
                                    <img src="<?php echo $image; ?>" loading="lazy" id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067e-a709e52f" alt="<?php the_title(); ?>"
                                        class="project-list__img"><?php
                                } ?>
                            </div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067f-a709e52f" class="project-itm__title"><?php echo get_the_title(get_the_ID()); ?></div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c80681-a709e52f"
                                class="project-itm__label-wrp countries"><?php
                                if(!empty($select_partner_country)){ 
                                    foreach(array_unique($select_partner_country) as $country){
                                        if(!empty($partners['select_partner_country'])){ ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $country; ?></div>
                                            </div><?php
                                        }
                                    }
                                } ?>
                            </div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068b-a709e52f"
                                class="project-itm__label-wrp performing-arts"><?php
                                if(!empty($performance) && !empty($performing_arts_name)){
                                    foreach( array_unique($performing_arts_name) as $performing_art ) { 
                                        if(!empty($performing_art)){ ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $performing_art; ?></div>
                                            </div><?php
                                        }
                                    }
                                } ?>
                            </div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068f-a709e52f"
                                class="project-itm__label-wrp topics-covered"><?php
                                if(!empty($performance) && !empty($topics_covered_name)){
                                    foreach( array_unique($topics_covered_name) as $topics_name ) { 
                                        if(!empty($topics_name)){ ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $topics_name; ?></div>
                                            </div><?php
                                        }
                                    }
                                }  ?>
                            </div>
                        </div>
                    </a><?php
                } wp_reset_query();  ?>
                <div class="pages__menu-wrp">
                    <div class="pages__menu ajax_pagination">
                        <div class="txt--small">Pages</div>
                        <?php include("ajax_pagination.php"); ?>
                    </div><?php
                    $subscribe_title = get_field('subscribe', 'option'); 
                    if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                        <div class="grid-cta"><?php
                            if(!empty($subscribe_title['description'])){ ?>
                                <?php echo $subscribe_title['description']; ?><?php
                            }
                            if(!empty($subscribe_title['external_link'])){ ?>
                                <a href="<?php echo $subscribe_title['external_link']['url'] ?>" class="btn-transparent--dark w-inline-block">
                                    <div class="txt-block--1rem">Join newsletter</div>
                                </a><?php
                            } ?>
                        </div><?php
                    } ?>
                </div><?php
            } 
            else{
             echo "<span class='error-message'>".get_field('message_for_project_page','option')."</span>";
            }
        } 
        else
        {
           echo "<span class='error-message'>".get_field('message_for_project_page','option')."</span>";
        }
    }
    else if(isset($_POST['topics']) && !empty($_POST['topics'])){

        $topics_list = get_posts( array(

            'post_type' => 'performance',

            'post_status'   => 'publish',

            'orderby' => 'date',

            'order'   => 'DESC',

            'posts_per_page' => -1,

            'tax_query' => array(

                array(

                    'taxonomy' => 'topics_covered',

                    'field'    => 'term_id',

                    'terms'    => $_POST['topics'],

                ),

            ), 
        ) );

        $IDS = array();
        foreach ( $topics_list as $post ) {
           $IDS[] += $post->ID;
        }

        $found_posts = array(

            'post_type' => 'project',

            'post_status'   => 'publish',

            'orderby' => 'date',

            'order'   => 'DESC',

            'posts_per_page' => -1,
        );
        $wp_query = new WP_Query($found_posts);
        $count = $wp_query->found_posts;
        $project_IDS = array();
        if ($wp_query->have_posts()){ 
            while ($wp_query->have_posts()){ 
                $wp_query->the_post(); 
                $performance = get_field('performance', get_the_ID());
                if(!empty($performance)){
                    foreach ( $performance as $post ){
                        if (in_array($post->ID, $IDS))
                        {
                            $project_IDS[] = get_the_ID();
                        }
                    } 
                } 
            } wp_reset_postdata(); 
        }
        if(!empty($project_IDS)){

            $found_posts = array(

                'post_type' => 'project',

                'post_status'   => 'publish',

                'orderby' => 'date',

                'order'   => 'DESC',

                'posts_per_page' => $recordsPerPage,

                'paged' => $page,

                'post__in' => $project_IDS,
               
            );
            $wp_query = new WP_Query($found_posts);
            $count = $wp_query->found_posts;
            $perf_IDS = array();
            if ($wp_query->have_posts())
            { 
                
                while ($wp_query->have_posts())
                { 
					$performing_arts_name = array();
                $topics_covered_name = array();
                $select_partner_country = array();
                    $wp_query->the_post(); 
                    $postid = get_the_ID();
                    $image = wp_get_attachment_url( get_post_thumbnail_id($postid, 'full'));  
                    $select_partners = get_field('select_partners', get_the_ID());  
                    $performance = get_field('performance', get_the_ID());
                    if(!empty($performance)){
                        foreach ( $performance as $performanc ){
                            $performing_arts = get_the_terms( $performanc->ID, 'performing_arts' );
                            $topics_covered = get_the_terms( $performanc->ID, 'topics_covered' );
                            if(!empty($performing_arts)){
                                foreach( $performing_arts as $performing_art ) { 
                                   $performing_arts_name[] = $performing_art->name;
                                }
                            }
                            if(!empty($topics_covered)){
                                foreach( $topics_covered as $topics ) { 
                                   $topics_covered_name[] = $topics->name;
                                }
                            }
                        }  
                    }
                    if(!empty($select_partners)){ 
                        foreach($select_partners as $partners){
                            if(!empty($partners['select_partner_country'])){ 
                                $select_partner_country[] = $partners['select_partner_country'];
                            }
                        }
                    } ?>
                    <a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="project-list__itm-wrp w-inline-block">
                        <div class="project-list__itm">
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067d-a709e52f" class="project-list__img-wrp"><?php
                                if(!empty($image)){ ?>
                                    <img src="<?php echo $image; ?>" loading="lazy" id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067e-a709e52f" alt="<?php the_title(); ?>"
                                        class="project-list__img"><?php
                                } ?>
                            </div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067f-a709e52f" class="project-itm__title"><?php echo get_the_title(get_the_ID()); ?></div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c80681-a709e52f"
                                class="project-itm__label-wrp countries"><?php
                                if(!empty($select_partner_country)){ 
                                    foreach(array_unique($select_partner_country) as $country){
                                        if(!empty($partners['select_partner_country'])){ ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $country; ?></div>
                                            </div><?php
                                        }
                                    }
                                } ?>
                            </div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068b-a709e52f"
                                class="project-itm__label-wrp performing-arts"><?php
                                if(!empty($performance) && !empty($performing_arts_name)){
                                    foreach( array_unique($performing_arts_name) as $performing_art ) { 
                                        if(!empty($performing_art)){ ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $performing_art; ?></div>
                                            </div><?php
                                        }
                                    }
                                } ?>
                            </div>
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068f-a709e52f"
                                class="project-itm__label-wrp topics-covered"><?php
                                if(!empty($performance) && !empty($topics_covered_name)){
                                    foreach( array_unique($topics_covered_name) as $topics_name ) { 
                                        if(!empty($topics_name)){ ?>
                                            <div class="itm__label">
                                                <div class="itm__label__txt"><?php echo $topics_name; ?></div>
                                            </div><?php
                                        }
                                    }
                                }  ?>
                            </div>
                        </div>
                    </a><?php
                } wp_reset_query(); ?>
                <div class="pages__menu-wrp">
                    <div class="pages__menu ajax_pagination">
                        <div class="txt--small">Pages</div>
                        <?php include("ajax_pagination.php"); ?>
                    </div><?php
                    $subscribe_title = get_field('subscribe', 'option'); 
                    if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                        <div class="grid-cta"><?php
                            if(!empty($subscribe_title['description'])){ ?>
                                <?php echo $subscribe_title['description']; ?><?php
                            }
                            if(!empty($subscribe_title['external_link'])){ ?>
                                <a href="<?php echo $subscribe_title['external_link']['url'] ?>" class="btn-transparent--dark w-inline-block">
                                    <div class="txt-block--1rem">Join newsletter</div>
                                </a><?php
                            } ?>
                        </div><?php
                    } ?>
                </div><?php
            }
            else{
             echo "<span class='error-message'>".get_field('message_for_project_page','option')."</span>";
            }
        } 
        else
        {
          echo "<span class='error-message'>".get_field('message_for_project_page','option')."</span>";
        }
    }
    else{
        $found_posts = array(

            'post_type' => 'project',

            'post_status'   => 'publish',

            'orderby' => 'title',
            'order'   => 'ASC',

            'posts_per_page' => $recordsPerPage,

            'paged' => $page,
           
        );

        $wp_query = new WP_Query($found_posts);
        $count = $wp_query->found_posts;
        if ($wp_query->have_posts())
        { 
           
            while ($wp_query->have_posts())
            { 
				 $performing_arts_name = array();
            $topics_covered_name = array();
            $select_partner_country = array();
                $wp_query->the_post(); 
                $postid = get_the_ID();
                $image = wp_get_attachment_url( get_post_thumbnail_id($postid, 'full'));  
                $select_partners = get_field('select_partners', get_the_ID());  
                $performance = get_field('performance', get_the_ID());
                if(!empty($performance)){
                    foreach ( $performance as $performanc ){
                        $performing_arts = get_the_terms( $performanc->ID, 'performing_arts' );
                        $topics_covered = get_the_terms( $performanc->ID, 'topics_covered' );
                        if(!empty($performing_arts)){
                            foreach( $performing_arts as $performing_art ) { 
                               $performing_arts_name[] = $performing_art->name;
                            }
                        }
                        if(!empty($topics_covered)){
                            foreach( $topics_covered as $topics ) { 
                               $topics_covered_name[] = $topics->name;
                            }
                        }
                    }  
                }
                if(!empty($select_partners)){ 
                    foreach($select_partners as $partners){
                        if(!empty($partners['select_partner_country'])){ 
                            $select_partner_country[] = $partners['select_partner_country'];
                        }
                    }
                } ?>
                <a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="project-list__itm-wrp w-inline-block">
                    <div class="project-list__itm">
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067d-a709e52f" class="project-list__img-wrp"><?php
                            if(!empty($image)){ ?>
                                    <img src="<?php echo $image; ?>" loading="lazy" id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067e-a709e52f" alt="<?php the_title(); ?>"
                                        class="project-list__img"><?php
                            } ?>
                        </div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067f-a709e52f" class="project-itm__title"><?php echo get_the_title(get_the_ID()); ?></div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c80681-a709e52f"
                            class="project-itm__label-wrp countries"><?php
                            if(!empty($select_partner_country)){ 
                                foreach(array_unique($select_partner_country) as $country){
                                    if(!empty($partners['select_partner_country'])){ ?>
                                        <div class="itm__label">
                                            <div class="itm__label__txt"><?php echo $country; ?></div>
                                        </div><?php
                                    }
                                }
                            } ?>
                        </div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068b-a709e52f"
                            class="project-itm__label-wrp performing-arts"><?php
                            if(!empty($performance) && !empty($performing_arts_name)){
                                foreach( array_unique($performing_arts_name) as $performing_art ) { 
                                    if(!empty($performing_art)){ ?>
                                        <div class="itm__label">
                                            <div class="itm__label__txt"><?php echo $performing_art; ?></div>
                                        </div><?php
                                    }
                                }
                            } ?>
                        </div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068f-a709e52f"
                            class="project-itm__label-wrp topics-covered"><?php
                            if(!empty($performance) && !empty($topics_covered_name)){
                                foreach( array_unique($topics_covered_name) as $topics_name ) { 
                                    if(!empty($topics_name)){ ?>
                                        <div class="itm__label">
                                            <div class="itm__label__txt"><?php echo $topics_name; ?></div>
                                        </div><?php
                                    }
                                }
                            }  ?>
                        </div>
                    </div>
                </a><?php
            } wp_reset_query();  ?>
            <div class="pages__menu-wrp">
                <div class="pages__menu ajax_pagination">
                    <div class="txt--small">Pages</div>
                    <?php include("ajax_pagination.php"); ?>
                </div><?php
                $subscribe_title = get_field('subscribe', 'option'); 
                if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                    <div class="grid-cta"><?php
                        if(!empty($subscribe_title['description'])){ ?>
                            <?php echo $subscribe_title['description']; ?><?php
                        }
                        if(!empty($subscribe_title['external_link'])){ ?>
                            <a href="<?php echo $subscribe_title['external_link']['url'] ?>" class="btn-transparent--dark w-inline-block">
                                <div class="txt-block--1rem">Join newsletter</div>
                            </a><?php
                        } ?>
                    </div><?php
                } ?>
            </div><?php
        }
        else{
         echo "<span class='error-message'>".get_field('message_for_project_page','option')."</span>";
        }
    }
   
    die;
}

add_action( 'wp_ajax_project_filter_list', 'project_filter_list_fn_ajax' );

add_action( 'wp_ajax_nopriv_project_filter_list', 'project_filter_list_fn_ajax' ); 

/* Project Year List */

function project_year_list_fn_ajax( $atts ) 
{
    $noofposts = 20;

    $page = (int) (!isset($_REQUEST['page']) ? 1 :$_REQUEST['page']);

    $page = ($page == 0 ? 1 : $page);

    $recordsPerPage = $noofposts;

    $start = ($page-1) *$recordsPerPage;

    $adjacents = "1";

    if(isset($_POST['year']) && !empty($_POST['year'])){
        $found_posts = array(
            'post_type' => 'project',
            'post_status'   => array('publish', 'private'),
            'orderby' => 'title',
            'order'   => 'ASC',
            'posts_per_page' => $recordsPerPage,
            'paged' => $page,
            'meta_query'    => array(
                array(
                    'key'       => 'edition',
                    'value'     => array($_POST['year']),
                    'compare'   => 'IN',
                ),
            ),
        );
        $wp_query = new WP_Query($found_posts);
        $count = $wp_query->found_posts;
        if ($wp_query->have_posts()){ 
            
            while ($wp_query->have_posts())
            { 
				$performing_arts_name = array();
            $topics_covered_name = array();
            $select_partner_country = array();
                $wp_query->the_post(); 
                $postid = get_the_ID();
                $image = wp_get_attachment_url( get_post_thumbnail_id($postid, 'full'));  
                $select_partners = get_field('select_partners', get_the_ID()); 
                $performance = get_field('performance', get_the_ID());                    
                if(!empty($performance)){
                    foreach ( $performance as $performanc ){
                        $performing_arts = get_the_terms( $performanc->ID, 'performing_arts' );
                        $topics_covered = get_the_terms( $performanc->ID, 'topics_covered' );
                        if(!empty($performing_arts)){
                            foreach( $performing_arts as $performing_art ) { 
                               $performing_arts_name[] = $performing_art->name;
                            }
                        }
                        if(!empty($topics_covered)){
                            foreach( $topics_covered as $topics ) { 
                               $topics_covered_name[] = $topics->name;
                            }
                        }
                    }  
                }
                if(!empty($select_partners)){ 
                    foreach($select_partners as $partners){
                        if(!empty($partners['select_partner_country'])){ 
                            $select_partner_country[] = $partners['select_partner_country'];
                        }
                    }
                }  ?>
                <a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="project-list__itm-wrp w-inline-block">
                    <div class="project-list__itm">
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067d-a709e52f" class="project-list__img-wrp"><?php
                             if(!empty($image)){ ?>
                                <img src="<?php echo $image; ?>" loading="lazy" id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067e-a709e52f" alt="<?php the_title(); ?>"
                                    class="project-list__img"><?php
                             } ?>
                        </div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067f-a709e52f" class="project-itm__title"><?php echo get_the_title(get_the_ID()); ?></div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c80681-a709e52f"
                            class="project-itm__label-wrp countries"><?php
                            if(!empty($select_partner_country)){ 
                                foreach(array_unique($select_partner_country) as $country){
                                    if(!empty($partners['select_partner_country'])){ ?>
                                        <div class="itm__label">
                                            <div class="itm__label__txt"><?php echo $country; ?></div>
                                        </div><?php
                                    }
                                }
                            } ?>
                        </div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068b-a709e52f"
                            class="project-itm__label-wrp performing-arts"><?php
                            if(!empty($performance) && !empty($performing_arts_name)){
                                foreach( array_unique($performing_arts_name) as $performing_art ) { 
                                    if(!empty($performing_art)){ ?>
                                        <div class="itm__label">
                                            <div class="itm__label__txt"><?php echo $performing_art; ?></div>
                                        </div><?php
                                    }
                                }
                            } ?>
                        </div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068f-a709e52f"
                            class="project-itm__label-wrp topics-covered"><?php
                            if(!empty($performance) && !empty($topics_covered_name)){
                                foreach( array_unique($topics_covered_name) as $topics_name ) { 
                                    if(!empty($topics_name)){ ?>
                                        <div class="itm__label">
                                            <div class="itm__label__txt"><?php echo $topics_name; ?></div>
                                        </div><?php
                                    }
                                }
                            }  ?>
                        </div>
                    </div>
                </a><?php
            } wp_reset_query(); ?>
            <div class="pages__menu-wrp">
                <div class="pages__menu ajax_pagination">
                    <div class="txt--small">Pages</div>
                    <?php include("ajax_pagination.php"); ?>
                </div><?php
                $subscribe_title = get_field('subscribe', 'option'); 
                if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                    <div class="grid-cta"><?php
                        if(!empty($subscribe_title['description'])){ ?>
                            <?php echo $subscribe_title['description']; ?><?php
                        }
                        if(!empty($subscribe_title['external_link'])){ ?>
                            <a href="<?php echo $subscribe_title['external_link']['url'] ?>" class="btn-transparent--dark w-inline-block">
                                <div class="txt-block--1rem">Join newsletter</div>
                            </a><?php
                        } ?>
                    </div><?php
                } ?>
            </div><?php
        }
        else{
         echo "<span class='error-message'>".get_field('message_for_project_page','option')."</span>";
        }
    }
    else{
        $found_posts = array(

            'post_type' => 'project',

            'post_status'   => array('publish', 'private'),

            'orderby' => 'date',

            'order'   => 'DESC',

            'posts_per_page' => $recordsPerPage,

            'paged' => $page,
           
        );

        $wp_query = new WP_Query($found_posts);
        $count = $wp_query->found_posts;
        if ($wp_query->have_posts())
        { 
           
            while ($wp_query->have_posts())
            { 
				 $performing_arts_name = array();
            $topics_covered_name = array();
            $select_partner_country = array();
                $wp_query->the_post(); 
                $postid = get_the_ID();
                $image = wp_get_attachment_url( get_post_thumbnail_id($postid, 'full'));  
                $select_partners = get_field('select_partners', get_the_ID());  
                $performance = get_field('performance', get_the_ID());                    
                if(!empty($performance)){
                    foreach ( $performance as $performanc ){
                        $performing_arts = get_the_terms( $performanc->ID, 'performing_arts' );
                        $topics_covered = get_the_terms( $performanc->ID, 'topics_covered' );
                        if(!empty($performing_arts)){
                            foreach( $performing_arts as $performing_art ) { 
                               $performing_arts_name[] = $performing_art->name;
                            }
                        }
                        if(!empty($topics_covered)){
                            foreach( $topics_covered as $topics ) { 
                               $topics_covered_name[] = $topics->name;
                            }
                        }
                    }  
                }
                if(!empty($select_partners)){ 
                    foreach($select_partners as $partners){
                        if(!empty($partners['select_partner_country'])){ 
                            $select_partner_country[] = $partners['select_partner_country'];
                        }
                    }
                } ?>
                <a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="project-list__itm-wrp w-inline-block">
                    <div class="project-list__itm">
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067d-a709e52f" class="project-list__img-wrp"><?php
                            if(!empty($image)){ ?>
                                    <img src="<?php echo $image; ?>" loading="lazy" id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067e-a709e52f" alt="<?php the_title(); ?>"
                                        class="project-list__img"><?php
                            } ?>
                        </div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067f-a709e52f" class="project-itm__title"><?php echo get_the_title(get_the_ID()); ?></div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c80681-a709e52f"
                            class="project-itm__label-wrp countries"><?php
                            if(!empty($select_partner_country)){ 
                                foreach(array_unique($select_partner_country) as $country){
                                    if(!empty($partners['select_partner_country'])){ ?>
                                        <div class="itm__label">
                                            <div class="itm__label__txt"><?php echo $country; ?></div>
                                        </div><?php
                                    }
                                }
                            } ?>
                        </div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068b-a709e52f"
                            class="project-itm__label-wrp performing-arts"><?php
                            if(!empty($performance) && !empty($performing_arts_name)){
                                foreach( array_unique($performing_arts_name) as $performing_art ) { 
                                    if(!empty($performing_art)){ ?>
                                        <div class="itm__label">
                                            <div class="itm__label__txt"><?php echo $performing_art; ?></div>
                                        </div><?php
                                    }
                                }
                            } ?>
                        </div>
                        <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8068f-a709e52f"
                            class="project-itm__label-wrp topics-covered"><?php
                            if(!empty($performance) && !empty($topics_covered_name)){
                                foreach( array_unique($topics_covered_name) as $topics_name ) { 
                                    if(!empty($topics_name)){ ?>
                                        <div class="itm__label">
                                            <div class="itm__label__txt"><?php echo $topics_name; ?></div>
                                        </div><?php
                                    }
                                }
                            }  ?>
                        </div>
                    </div>
                </a><?php
            } wp_reset_query();  ?>
            <div class="pages__menu-wrp">
                <div class="pages__menu ajax_pagination">
                    <div class="txt--small">Pages</div>
                    <?php include("ajax_pagination.php"); ?>
                </div><?php
                $subscribe_title = get_field('subscribe', 'option'); 
                if(!empty($subscribe_title['description'])|| !empty($subscribe_title['external_link'])){ ?>
                    <div class="grid-cta"><?php
                        if(!empty($subscribe_title['description'])){ ?>
                            <?php echo $subscribe_title['description']; ?><?php
                        }
                        if(!empty($subscribe_title['external_link'])){ ?>
                            <a href="<?php echo $subscribe_title['external_link']['url'] ?>" class="btn-transparent--dark w-inline-block">
                                <div class="txt-block--1rem">Join newsletter</div>
                            </a><?php
                        } ?>
                    </div><?php
                } ?>
            </div><?php
        }
        else{
         echo "<span class='error-message'>".get_field('message_for_project_page','option')."</span>";
        }
    }
     ?>
     <script type="text/javascript">
     $('.list__itm-wrp').on('mouseenter mouseleave', function () {
    $(".cursor-wrp").toggleClass('hide');
});

$('.project-list__itm').on('mouseenter mouseleave', function () {
    $(".cursor-wrp").toggleClass('hide');
});
</script>
     <?php   

    die;
}

add_action( 'wp_ajax_project_year_list', 'project_year_list_fn_ajax' );

add_action( 'wp_ajax_nopriv_project_year_list', 'project_year_list_fn_ajax' ); 

/* Partners Search */
function partners_search_list( $atts ) 
{
    if(!empty($_POST['search'])){
		  
		
        $users = new WP_User_Query( array(            
          
            'role' => 'Subscriber', 
            'exclude' => array( get_current_user_id() ),
            'meta_query'    => array(
                'relation' => 'AND', 
                array( 
                    'key'     => 'wpforms-pending',                            
                    'compare' => 'NOT EXISTS',
                ),
                array( 
                    'key'     => 'make_profile_private',
                    'value'   => 2,
                    'compare' => '=',
                ),
				array(
					'key' => 'name_of_organisation',
					'value' => $_POST['search'],
				   'compare' => 'LIKE'
            	)
            )
        ) );
	 
        $users_found = $users->get_results();
    }
    if(!empty($users_found)){
        foreach($users_found as $users){ 
            $user_meta = get_user_meta($users->data->ID); 
            $full_name = $user_meta['first_name'][0].' '.$user_meta['last_name'][0];?>
             <a href="<?php echo esc_url( get_author_posts_url($users->data->ID) ) ;?>" target="_blank">
              <div class="search__suggestion__itm">
                
                    <?php 
                      foreach($user_meta['performing_art_forms'] as $performing_arts){ 
                       if(is_serialized($performing_arts)){
                          $get_performaing = unserialize($performing_arts);
                        }
                        else{
                          $get_performaing = $user_meta['performing_art_forms'];
                        } 
                        if(!empty($get_performaing)){
                            echo '<div class="label" style="display:none;"><div class="label__txt txt-up" >';
                            echo implode(', ',$get_performaing); 
                            echo '</div></div>';
                        } 
                      } ?>
                    
                <?php
                if(!empty($user_meta['cover_picture']) && !empty($user_meta['cover_picture'][0])){
                    $get_cover = $user_meta['cover_picture'][0];
                    //$cover_pic = wp_get_attachment_url($get_cover[0]);
                  ?>
                  <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e7a-a709e52f" class="search__img-wrp">
                      <img src="<?php echo $get_cover; ?>" loading="lazy" sizes="100vw" alt="" class="search__img">
                  </div><?php
                } ?>
                <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e7c-a709e52f" class="search__title">
                <?php if($user_meta['account_type'][0] == 'Organisation')
                {
                echo $user_meta['name_of_organisation']['0'];
                }else{
                echo $full_name;    
                } ?>
                </div>
            </div>
          </a><?php
        }
    }
    else{
        echo ' <p class="error-msg">'.get_field("message_for_partner_page","option").'</p>';
    }
    die;
}

add_action( 'wp_ajax_search_partners', 'partners_search_list' );

add_action( 'wp_ajax_nopriv_search_partners', 'partners_search_list' ); 

/* Partners Filter */
function partners_filter_list( $atts ) 
{
			$no = 100;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            if($paged==1){
              $offset=0;  
            }else {
               $offset= ($paged-1)*$no;
            }
	
    if(!empty($_POST['countries']) && $_POST['performing'] != '' && $_POST['topics'] != '' ){
        $user_query = new WP_User_Query( 
            array(
				 'number' => $no, 
                    'offset' => $offset,
              'role' => 'Subscriber',  
              'exclude' => array( get_current_user_id() ),
              'meta_query'    => array(
                'relation' => 'AND', 
                    array( 
                      'key'     => 'make_profile_private',
                      'value'   => 2,
                      'compare' => '=',
                    ),
                    array(
                        'key'     => 'country',
                        'value'   => $_POST['countries'],
                        'meta_compare' => 'IN',
                    ),
                    array(
                        'key'     => 'performing_art_forms',
                        'value' => $_POST['performing'],
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'topics_covered',
                        'value' => $_POST['topics'],
                        'compare' => 'LIKE'
                    ),
                    array( 
                        'key'     => 'wpforms-pending',                            
                        'compare' => 'NOT EXISTS',
                    )
              )
          ) 
        );
    }
    else if(!empty($_POST['countries']) && $_POST['performing'] != ''){
	 
        $user_query = new WP_User_Query( 
            array(
					 'number' => $no, 
                    'offset' => $offset,
              'role' => 'Subscriber',  
              'exclude' => array( get_current_user_id() ),
              'meta_query'    => array(
                'relation' => 'AND', 
                    array( 
                      'key'     => 'make_profile_private',
                      'value'   => 2,
                      'compare' => '=',
                    ),
                    array(
                        'key'     => 'country',
                        'value'   => $_POST['countries'],
                        'meta_compare' => 'IN',
                    ),
                    array(
                        'key'     => 'performing_art_forms',
                        'value' => $_POST['performing'],
                        'compare' => 'LIKE',
                    ),
                    array( 
                        'key'     => 'wpforms-pending',                            
                        'compare' => 'NOT EXISTS',
                    )
              )
          ) 
        );
    }
    else if(!empty($_POST['countries']) && $_POST['topics'] != ''){
        $user_query = new WP_User_Query( 
            array(
					 'number' => $no, 
                    'offset' => $offset,
              'role' => 'Subscriber',  
              'exclude' => array( get_current_user_id() ),
              'meta_query'    => array(
                'relation' => 'AND', 
                    array( 
                      'key'     => 'make_profile_private',
                      'value'   => 2,
                      'compare' => '=',
                    ),
                    array(
                        'key'     => 'country',
                        'value'   => $_POST['countries'],
                        'compare' => 'IN',
                    ),
                    array(
                        'key'     => 'topics_covered',
                        'value' => $_POST['topics'],
                        'compare' => 'LIKE'
                    ),
                    array( 
                        'key'     => 'wpforms-pending',                            
                        'compare' => 'NOT EXISTS',
                    )
              )
          ) 
        );
    }
    else if($_POST['performing'] != '' && $_POST['topics'] != ''){
        $user_query = new WP_User_Query( 
            array(
					 'number' => $no, 
                    'offset' => $offset,
              'role' => 'Subscriber',  
              'exclude' => array( get_current_user_id() ),
              'meta_query'    => array(
                'relation' => 'AND', 
                    array( 
                      'key'     => 'make_profile_private',
                      'value'   => 2,
                      'compare' => '=',
                    ),
                    array(
                        'key'     => 'topics_covered',
                        'value' => $_POST['topics'],
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'performing_art_forms',
                        'value' => $_POST['performing'],
                        'compare' => 'LIKE'
                    ),
                    array( 
                        'key'     => 'wpforms-pending',                            
                        'compare' => 'NOT EXISTS',
                    )
              )
          ) 
        );
    }
    else if(isset($_POST['countries']) && !empty($_POST['countries'])){
        $user_query = new WP_User_Query( 
          array(
			  	 'number' => $no, 
                    'offset' => $offset,
              'role' => 'Subscriber',  
              'exclude' => array( get_current_user_id() ),
              'meta_query'    => array(
                'relation' => 'AND', 
                    array( 
                      'key'     => 'make_profile_private',
                      'value'   => 2,
                      'compare' => '=',
                    ),
                    array(
                        'key'     => 'country',
                        'value'   => $_POST['countries'],
                        'meta_compare' => 'IN',
                    ),
                    array( 
                        'key'     => 'wpforms-pending',                            
                        'compare' => 'NOT EXISTS',
                    )
              )
          ) 
      );
    }
    else if(isset($_POST['performing']) && !empty($_POST['performing']) && $_POST['performing'] != ''){
		 
        $user_query = new WP_User_Query( 
          array(
			  	 'number' => $no, 
                    'offset' => $offset,
              'role' => 'Subscriber',  
              'exclude' => array( get_current_user_id() ),
              'meta_query'    => array(
                'relation' => 'AND', 
                  array( 
                      'key'     => 'make_profile_private',
                      'value'   => 2,
                      'compare' => '=',
                  ),
                  array(
                    'key'     => 'performing_art_forms',
                    'value' => $_POST['performing'],
                    'compare' => 'LIKE',
                  ),
                   array( 
                        'key'     => 'wpforms-pending',                            
                        'compare' => 'NOT EXISTS',
                    )
              )
          ) 
      );
       
    }
    else if(isset($_POST['topics']) && !empty($_POST['topics']) && $_POST['topics'] != ''){
        $user_query = new WP_User_Query( 
          array(
			  	 'number' => $no, 
                    'offset' => $offset,
              'role' => 'Subscriber',  
              'exclude' => array( get_current_user_id() ),
              'meta_query'    => array(
                'relation' => 'AND', 
                    array( 
                        'key'     => 'make_profile_private',
                        'value'   => 2,
                        'compare' => '=',
                    ),
                    array(
                        'key'     => 'topics_covered',
                        'value' => $_POST['topics'],
                        'compare' => 'LIKE'
                    ),
                    array( 
                        'key'     => 'wpforms-pending',                            
                        'compare' => 'NOT EXISTS',
                    )
              )
          ) 
      );
    }
    else{
        $user_query = new WP_User_Query( 
          array(
			  	 'number' => $no, 
                    'offset' => $offset,
              'role' => 'Subscriber',  
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
    }
 
    if ( ! empty( $user_query->results ) ) {
      foreach ( $user_query->results as $user ) {
        $user_meta = get_user_meta($user->ID); 
        $get_email = get_userdata($user->ID);         
        $full_name = $user_meta['first_name'][0].' '.$user_meta['last_name'][0]; ?>
        <div class="project-list__itm-wrp">
            <a href="<?php echo esc_url( get_author_posts_url($user->ID) ) ;?>" class="project-list__itm find-partners w-inline-block" target="_blank">
				<div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e9f-a709e52f" class="project-list__img-wrp">
				<?php
                  if(!empty($user_meta['cover_picture']) && !empty($user_meta['cover_picture'][0])){ ?>
                      
                           <img src="<?php echo $user_meta['cover_picture'][0]; ?>" loading="lazy" id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea0-a709e52f" alt="" class="project-list__img">
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
                        </div><?php
                      $select_your_country = '';
                                if(!empty($user_meta['country']) && !empty($user_meta['country'][0])){ 
                                    $select_your_country = $user_meta['country'][0];
                                } 
                                if(!empty($select_your_country)){ ?>
                                  <div class="txt-xxs"><?php echo $select_your_country; ?></div><?php
                                } 
                                                               
                                    if(!empty($user_meta['organisation_type']) && !empty($user_meta['organisation_type'][0])){  
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
                                    }  
                               
                                ?>
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
                    if(!empty($user_meta['performing_art_forms']) && !empty($user_meta['performing_art_forms'][0])){ 
                      global $post; 
                      $get_performaings= array();
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
                      if(is_array($get_performaings)){ ?>
                        <div class="itm__label bg-magenta">
                          <div class="itm__label__txt"><?php echo implode(', ',$get_performaings);  ?></div>
                        </div><?php
                      }
                  } ?>
                </div>
               <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0eb4-a709e52f" class="project-itm__label-wrp topics-covered"><?php
                   if(!empty($user_meta['topics_covered']) && !empty($user_meta['topics_covered'][0])){ 
                    $topics_covereds= array();
                    $get_covered = unserialize($user_meta['topics_covered'][0]);
                    if(is_serialized($user_meta['topics_covered'][0])){
                                            $topics_covered = unserialize($user_meta['topics_covered'][0]);
                                                foreach($topics_covered as $display_topics)
                                                    {
                                                     //$display_topic_cat =  get_term_by('id', $display_topics, 'topics_covered');
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
                    } 
                  } ?>
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
        echo "<span class='error-message'>".get_field('message_for_partner_page','option')."</span>";
    }  
    die;
}

add_action( 'wp_ajax_partners_filter_list', 'partners_filter_list' );

add_action( 'wp_ajax_nopriv_partners_filter_list', 'partners_filter_list' ); 

function template_redirect_fn()
{
    if(is_page_template( 'partners.php' ) && !is_user_logged_in()){
        $loginUrl = home_url('/login/');
        wp_redirect($loginUrl);
        exit(); 
    }
    else if(is_page_template( 'templates/profile.php' ) && !is_user_logged_in()){
      $loginUrl = home_url('/login/');
        wp_redirect($loginUrl);
        exit(); 
    }
}
add_action( 'template_redirect', 'template_redirect_fn' );


function private_profile_checked( $atts ) 
{
  if(!empty($_POST['user_id']) && !empty($_POST['checkbox'])){
    update_user_meta( $_POST['user_id'], 'make_profile_private', $_POST['checkbox'] );
  }
  die;
}

add_action( 'wp_ajax_private_profile_checked', 'private_profile_checked' );

add_action( 'wp_ajax_nopriv_private_profile_checked', 'private_profile_checked' ); 


function sent_match_request( $atts ) 
{
  if(!empty($_POST['user_id']) && !empty($_POST['sent_request_notify'])){
    update_user_meta( $_POST['user_id'], 'sent_request_notify', $_POST['sent_request_notify'] );
  }
  die;
}

add_action( 'wp_ajax_sent_match_request', 'sent_match_request' );

add_action( 'wp_ajax_nopriv_sent_match_request', 'sent_match_request' );

function accept_user_request( $atts ) 
{
  if(!empty($_POST['user_id']) && !empty($_POST['accept_request_notify'])){
    update_user_meta( $_POST['user_id'], 'accept_request_notify', $_POST['accept_request_notify'] );
  }
  die;
}

add_action( 'wp_ajax_accept_user_request', 'accept_user_request' );

add_action( 'wp_ajax_nopriv_accept_user_request', 'accept_user_request' );


function request_rejected( $atts ) 
{
  if(!empty($_POST['user_id']) && !empty($_POST['request_not_accept'])){
    update_user_meta( $_POST['user_id'], 'request_not_accept', $_POST['request_not_accept'] );
  }
  die;
}

add_action( 'wp_ajax_request_rejected', 'request_rejected' );

add_action( 'wp_ajax_nopriv_request_rejected', 'request_rejected' );

/* Partners Actions */
add_action( 'user_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save( $user_id ) {
    update_user_meta($user_id, 'make_profile_private', 2);
}

add_action("init", "create_required_table");
function create_required_table(){
     global $wpdb;
     require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
     $db_table_name = "partners_status";
     if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
         if (!empty($wpdb->charset))
             $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
         if (!empty($wpdb->collate))
              $charset_collate .= " COLLATE $wpdb->collate";

         $sql = "CREATE TABLE $db_table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            user_id int(11) NOT NULL,
            current_user_id int(11) NOT NULL,
            status varchar(50) NOT NULL,
            created DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY id (id)
     ) $charset_collate;";
         dbDelta($sql);
     }
    
    $fav_db_table_name = 'favourite_partners';
    if ($wpdb->get_var("SHOW TABLES LIKE '$fav_db_table_name'") != $fav_db_table_name) {
         if (!empty($wpdb->charset))
             $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
         if (!empty($wpdb->collate))
              $charset_collate .= " COLLATE $wpdb->collate";

         $sql = "CREATE TABLE $fav_db_table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            current_user_id int(11) NOT NULL,
            fav_user_id int(11) NOT NULL,            
            created DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY id (id)
     ) $charset_collate;";
         dbDelta($sql);
     }
    
}


function quickmatch( $atts ) {

    if(!empty($_POST['user_id']) && !empty($_POST['current_user_id'])){
        
        global $wpdb;

        $table_name = "partners_status";

        $wpdb->insert( 

            $table_name, 

            array( 

               'user_id' => $_POST['user_id'], 

               'current_user_id'=> $_POST['current_user_id'],

               'status'=> 'request',

               'created'=> date('Y-m-d h:i:s'), 

            ) 

        ); 
        $lastid = $wpdb->insert_id;
        $user_info = get_userdata($_POST['user_id']);
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;
        $full_name = $first_name.' '.$last_name;
        $user_email = $user_info->user_email;
		$user_meta = get_user_meta($_POST['user_id']);
		$userorganisation_name = $user_meta['name_of_organisation']['0'];

        $current_user = get_userdata($_POST['current_user_id']);
        $current_first_name = $current_user->first_name;
        $current_last_name = $current_user->last_name;
        $current_full_name = $current_first_name.' '.$current_last_name;
		$current_user_meta = get_user_meta($_POST['current_user_id']);
		$current_organisation_name = $current_user_meta['name_of_organisation']['0'];
			
        if($lastid){
            $sent_request_notify = get_user_meta( $_POST['user_id'], 'sent_request_notify' , true );
            if($sent_request_notify == 1){ 
                $to = $user_email;
                $subject = "Perform Europe: Someone wants to partner up with you";

                $message = '<div class="table-wrapper" style="max-width: 1270px;">
<div style="margin: 0; text-align: left; font-size: 16px; line-height: 40px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-style: normal; font-weight: 500; color: #000000;">Dear '.$full_name.',<br><br>Congratulations! You received a Quick Match request from '.$current_full_name.' \('.$current_organisation_name.'\).<br><br>Would you like to accept this request?<br><br><b>If yes, please <a href="https://performeurope.eu/partners" target=_blank>log in</a>, navigate to <i>Find Partners</i>, select <i>Requests</i> and accept the match request. Once accepted, both of you will gain access to each other\'s contact details to further establish a potential partnership.<br><br><b>If not</b>, you can decline the request. In this case, the user will be notified that the request was declined and your contact details will remain private for them. Feel free to browse through other profiles.<br><br>Best regards,<br>Perform Europe
</div>
                </div>';

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                $headers .= 'From: Perform Europe <wordpress@performeurope.eu>' . "\r\n";

                wp_mail($to,$subject,$message,$headers);
            }
            echo json_encode(array('status' => "success")); 
        }
    }

  die;
}

add_action( 'wp_ajax_quickmatch', 'quickmatch' );

add_action( 'wp_ajax_nopriv_quickmatch', 'quickmatch' );

function declined_request( $atts ) {

    if(!empty($_POST['user_id']) && !empty($_POST['current_user_id'])){
        
        global $wpdb;

        $table_name = "partners_status";

        $wpdb->query($wpdb->prepare("UPDATE $table_name SET status='declined' WHERE (user_id=".$_POST['current_user_id']." AND current_user_id = ".$_POST['user_id'].") "));

        $user_info = get_userdata($_POST['user_id']);
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;
        $full_name = $first_name.' '.$last_name;
        $user_email = $user_info->user_email;
        
        $current_user = get_userdata($_POST['current_user_id']);
        $current_first_name = $current_user->first_name;
        $current_last_name = $current_user->last_name;
        $current_full_name = $current_first_name.' '.$current_last_name;

        $request_not_accept = get_user_meta( $_POST['user_id'], 'request_not_accept' , true );
        if($request_not_accept == 1){ 

            $to = $user_email;
            $subject = "Perform Europe: Quick Match request declined";

            $message = '<div class="table-wrapper" style="max-width: 1270px;">
                                                    <div style="margin: 0; text-align: left; font-size: 16px; line-height: 40px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-style: normal; font-weight: 500; color: #000000;">Dear '.$full_name.',</div><br><br>No luck this time! Your Quick Match request has been declined by '.$current_full_name.' \('.$current_organisation_name.'\). Don’t hesitate to browse through <a href="https://performeurope.eu/partners" target=_blank>all profiles on the Perform Europe website</a> and send more Quick Match requests.<br>Best regards,<br>Perform Europe</div>
            </div>';

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $headers .= 'From: Perform <wordpress@performeurope.eu>' . "\r\n";

            wp_mail($to,$subject,$message,$headers);
        }

        echo json_encode(array('status' => "success")); 
    }

  die;
}

add_action( 'wp_ajax_declined_request', 'declined_request' );

add_action( 'wp_ajax_nopriv_declined_request', 'declined_request' );

function approve_request( $atts ) {

    if(!empty($_POST['user_id']) && !empty($_POST['current_user_id'])){
        
        global $wpdb;

        $table_name = "partners_status";

        $wpdb->query($wpdb->prepare("UPDATE $table_name SET status='approve' WHERE (user_id=".$_POST['current_user_id']." AND current_user_id = ".$_POST['user_id'].") "));

        $user_info = get_userdata($_POST['user_id']);
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;
        $full_name = $first_name.' '.$last_name;
        $user_email = $user_info->user_email;
        
        $current_user = get_userdata($_POST['current_user_id']);
        $current_first_name = $current_user->first_name;
        $current_last_name = $current_user->last_name;
        $current_full_name = $current_first_name.' '.$current_last_name;

        $accept_request_notify = get_user_meta( $_POST['user_id'], 'accept_request_notify' , true );
        if($accept_request_notify == 1){ 
            $to = $user_email;
            $subject = "Perform Europe: It’s a match!";

            $message = '<div class="table-wrapper" style="max-width: 1270px;">
<div style="margin: 0; text-align: left; font-size: 16px; line-height: 40px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-style: normal; font-weight: 500; color: #000000;">Dear '.$full_name.',<br><br>Congratulations, it’s a match with '.$current_full_name.'! Contact details are now unlocked and you can start a conversation about a potential Perform Europe partnership.<br><br><a href="https://performeurope.eu/partners" target=_blank>Login</a> to view their profile.<br><br>Good luck building your Perform Europe partnership!<br><br>Best regards,<br>Perform Europe.
</div>
            </div>';

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $headers .= 'From: Perform <wordpress@performeurope.eu>' . "\r\n";

            wp_mail($to,$subject,$message,$headers);
        }

        echo json_encode(array('status' => "success")); 
    }

  die;
}

add_action( 'wp_ajax_approve_request', 'approve_request' );

add_action( 'wp_ajax_nopriv_approve_request', 'approve_request' );


function get_matches( $atts ) {

    if(!empty($_POST['current_user_id'])){
        global $wpdb;
        $table_name = 'partners_status';
        $fetch_total_approve = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".$_POST['current_user_id']." AND status = 'approve' OR current_user_id = ".$_POST['current_user_id']." AND status = 'approve') ");
        if(!empty($fetch_total_approve)){
            foreach($fetch_total_approve as $approve){
                if($approve->user_id == $_POST['current_user_id']){
                    $user_meta = get_user_meta($approve->current_user_id); 
                    $get_email = get_userdata($approve->current_user_id);   
                    $full_name = $user_meta['first_name'][0].' '.$user_meta['last_name'][0]; ?>
                    <div class="project-list__itm-wrp">
                        <a href="<?php echo esc_url( get_author_posts_url($approve->current_user_id) ) ;?>" class="project-list__itm find-partners w-inline-block" target="_blank"><div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e9f-a709e52f" class="project-list__img-wrp"><?php
                            if(!empty($user_meta['cover_picture']) && !empty($user_meta['cover_picture'][0])){ 
                                $get_cover = $user_meta['cover_picture'][0];
                                //$cover_pic = wp_get_attachment_url($get_cover[0]);
                            ?>
                                
                                    <img src="<?php echo $get_cover; ?>" loading="lazy" id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea0-a709e52f" alt="" class="project-list__img">
                                <?php
                            } ?></div>
                            <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea1-a709e52f" class="project__txt-wrp productions">
                                <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea2-a709e52f" class="project-itm__title">
                                    <?php if($user_meta['account_type'][0] == 'Organisation')
                                    {
                                    echo $user_meta['name_of_organisation']['0'];
                                    }else{
                                    echo $full_name;    
                                    }  ?>
                                    </div> <?php
                                $select_your_country = '';
                                if(!empty($user_meta['country']) && !empty($user_meta['country'][0])){ 
                                    $select_your_country = $user_meta['country'][0];
                                } 
                                if(!empty($select_your_country)){ ?>
                                  <div class="txt-xxs"><?php echo $select_your_country; ?></div><?php
                                } 
                                                            
                                        if(!empty($user_meta['organisation_type']) && !empty($user_meta['organisation_type'][0])){  
                                            if(is_serialized($user_meta['organisation_type'][0])){
                                                $location = unserialize($user_meta['organisation_type'][0]);
                                            }
                                            else{
                                                $location = $user_meta['organisation_type'];
                                            }                                                                                                               
                                            if(is_array($location))
                                            { ?>                                  
                                                <div class="txt-xxs"><?php echo implode(', ',$location); ?></div><?php
                                            }
                                        }  
                                   
                                ?>
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
                                if(!empty($user_meta['performing_art_forms']) && !empty($user_meta['performing_art_forms'][0])){ 
                                    global $post;
                                    $get_performaings = array();
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
                        <div id="w-node-f573d56b-449d-184f-bf69-7a7c4302a870-a709e52f" class="project__itm__cta"><?php
                                global $wpdb;
                                $total_favs = $wpdb->get_results("SELECT fav_user_id from favourite_partners WHERE (user_id = ".$approve->current_user_id.")"); 
                                $array_fav = array();
                                foreach($total_favs as $get_fev_list)
                                {                                    
                                    array_push($array_fav,$get_fev_list->fav_user_id);
                                }
                                if(in_array($approve->current_user_id,$array_fav))
                                {
                                    echo '<div class="star__icon remove_fav active" data-id="'.$approve->current_user_id.'"></div>';    
                                }
                                else{
                                    echo '<div class="star__icon add_fav" data-id="'.$approve->current_user_id.'"></div>';  
                                } ?>
                                <div class="btn--match"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/match-icon.svg" loading="lazy" alt="" class="quickmatch__icon">
                                <div class="txt-block">It`s a match!</div>
                                </div>
                                <a href="mailto:<?php echo $get_email->user_email;?>"><div class="mail__icon"></div></a><?php
                             
                             ?>
                        </div>
                    </div><?php
                }
                else{
                    $get_email = get_userdata($approve->user_id);
                    if(!empty($get_email)){
                        $user_meta = get_user_meta($approve->user_id); 
                        $full_name = $user_meta['first_name'][0].' '.$user_meta['last_name'][0]; ?>
                        <div class="project-list__itm-wrp">
                            <a href="<?php echo esc_url( get_author_posts_url($approve->user_id) ) ;?>" class="project-list__itm find-partners w-inline-block" target="_blank"><div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e9f-a709e52f" class="project-list__img-wrp"><?php
                                if(!empty($user_meta['cover_picture']) && !empty($user_meta['cover_picture'][0])){ 
                                    $get_cover = $user_meta['cover_picture'][0];
                                    //$cover_pic = wp_get_attachment_url($get_cover[0]);
                                ?>
                                    
                                        <img src="<?php echo $get_cover; ?>" loading="lazy" id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea0-a709e52f" alt="" class="project-list__img">
                                    <?php
                                } ?></div>
                                <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea1-a709e52f" class="project__txt-wrp productions">
                                    <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea2-a709e52f" class="project-itm__title">
                                        <?php if($user_meta['account_type'][0] == 'Organisation')
                                        {
                                        echo $user_meta['name_of_organisation']['0'];
                                        }else{
                                        echo $full_name;    
                                        }  ?>
                                        </div> <?php
                                    $select_your_country = '';
                                    if(!empty($user_meta['country']) && !empty($user_meta['country'][0])){ 
                                        $select_your_country = $user_meta['country'][0];
                                    } 
                                    if(!empty($select_your_country)){ ?>
                                      <div class="txt-xxs"><?php echo $select_your_country; ?></div><?php
                                    } 
                                                                  
                                            if(!empty($user_meta['organisation_type']) && !empty($user_meta['organisation_type'][0])){  
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
                                            }  
                                       
                                    ?>
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
                                    if(!empty($user_meta['performing_art_forms']) && !empty($user_meta['performing_art_forms'][0])){ 
                                        global $post;
                                        $get_performaings = array();
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
                                    $total_favs = $wpdb->get_results("SELECT fav_user_id from favourite_partners WHERE (user_id = ".$approve->user_id.")"); 
                                    $array_fav = array();
                                    foreach($total_favs as $get_fev_list)
                                    {                                    
                                        array_push($array_fav,$get_fev_list->fav_user_id);
                                    }
                                    if(in_array($approve->user_id,$array_fav))
                                    {
                                        echo '<div class="star__icon remove_fav active" data-id="'.$approve->user_id.'"></div>';    
                                    }
                                    else{
                                        echo '<div class="star__icon add_fav" data-id="'.$approve->user_id.'"></div>';  
                                    } ?>
                                    <div class="btn--match"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/match-icon.svg" loading="lazy" alt="" class="quickmatch__icon">
                                    <div class="txt-block">It`s a match!</div>
                                    </div>
                                    <a href="mailto:<?php echo $get_email->user_email;?>"><div class="mail__icon"></div></a><?php
                                 
                                 ?>
                            </div>
                        </div><?php
                    }
                    else{
                        echo "<span class='error-message'>This user not exist.</span>";
                    }
                }
            }
        } 
        else{
            echo "<span class='error-message'>".get_field('message_for_partner_page','option')."</span>";
        } 
    }

  die;
}

add_action( 'wp_ajax_get_matches', 'get_matches' );

add_action( 'wp_ajax_nopriv_get_matches', 'get_matches' );

function get_recive_request( $atts ) {

    if(!empty($_POST['current_user_id'])){
        global $wpdb;
        $table_name = 'partners_status';
        $total_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND status = 'request') ");
        if(!empty($total_request)){
            foreach($total_request as $approve){
                $user_meta = get_user_meta($approve->current_user_id); 
                $get_email = get_userdata($approve->current_user_id);   
                $full_name = $user_meta['first_name'][0].' '.$user_meta['last_name'][0]; ?>
                <div class="project-list__itm-wrp">
                    <a href="<?php echo esc_url( get_author_posts_url($approve->current_user_id) ) ;?>" class="project-list__itm find-partners w-inline-block" target="_blank"> <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e9f-a709e52f" class="project-list__img-wrp"><?php
                        if(!empty($user_meta['cover_picture']) && !empty($user_meta['cover_picture'][0])){ 
                            $get_cover = $user_meta['cover_picture'][0];
                           // $cover_pic = wp_get_attachment_url($get_cover[0]);
                        ?>
                           
                                <img src="<?php echo $get_cover; ?>" loading="lazy" id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea0-a709e52f" alt="" class="project-list__img">
                            <?php
                        } ?></div>
                        <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea1-a709e52f" class="project__txt-wrp productions">
                             <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea2-a709e52f" class="project-itm__title">
                                <?php if($user_meta['account_type'][0] == 'Organisation')
                                {
                                echo $user_meta['name_of_organisation']['0'];
                                }else{
                                echo $full_name;    
                                }  ?>
                                </div> <?php
                            $select_your_country = '';
                            if(!empty($user_meta['country']) && !empty($user_meta['country'][0])){ 
                                $select_your_country = $user_meta['country'][0];
                            } 
                            if(!empty($select_your_country)){ ?>
                              <div class="txt-xxs"><?php echo $select_your_country; ?></div><?php
                            } 
                                                         
                                    if(!empty($user_meta['organisation_type']) && !empty($user_meta['organisation_type'][0])){  
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
                                    }  
                              
                            ?>
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
                            if(!empty($user_meta['performing_art_forms']) && !empty($user_meta['performing_art_forms'][0])){ 
                                global $post;
                                $get_performaings = array();
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
                            if(in_array($approve->current_user_id,$array_fav))
                            {
                                echo '<div class="star__icon remove_fav active" data-id="'.$approve->current_user_id.'"></div>';    
                            }
                            else{
                                echo '<div class="star__icon add_fav" data-id="'.$approve->current_user_id.'"></div>';  
                            }

                        $table_name = 'partners_status';

                        $send_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".$approve->current_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'request') ");

                        $recived_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (current_user_id = ".$approve->current_user_id." AND user_id = ".get_current_user_id()." AND status = 'request') "); 

                        $approve_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$approve->current_user_id." AND status = 'approve' OR user_id = ".$approve->current_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'approve') ");

                        $declined_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$approve->current_user_id." AND status = 'approve' OR user_id = ".$approve->current_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'declined') ");
                        
                        if(!empty($send_request)){ ?>
                            <div class="btn--send">
                                <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow.svg" loading="lazy" alt="" class="send__icon">
                                <div class="txt-block">sent</div>
                            </div><?php
                        }
                        else if(!empty($recived_request)){ ?>
                            <div class="btn--approve">
                                <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                                <div class="txt-block approve-request" data-id="<?php echo $approve->current_user_id; ?>">approve</div>
                            </div>
                            <div class="remove__icon declined-request" data-id="<?php echo $approve->current_user_id; ?>"></div><?php
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
                            <div class="btn--quickmatch" data-id="<?php echo $approve->current_user_id; ?>"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                                <div class="txt-block">quick match</div>
                            </div><?php
                        } ?>
                    </div>
                </div><?php
            }
        } 
        else{
           echo "<span class='error-message'>".get_field('message_for_partner_page','option')."</span>";
        } 
    }

  die;
}

add_action( 'wp_ajax_get_recive_request', 'get_recive_request' );

add_action( 'wp_ajax_nopriv_get_recive_request', 'get_recive_request' );


function get_sent_request( $atts ) {

    if(!empty($_POST['current_user_id'])){
        global $wpdb;
        $table_name = 'partners_status';
        $send_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (current_user_id = ".get_current_user_id()." AND status = 'request') ");
        if(!empty($send_request)){
            foreach($send_request as $approve){
                $user_meta = get_user_meta($approve->user_id); 
                $get_email = get_userdata($approve->user_id);       
                if(!empty($get_email)){
                    $full_name = $user_meta['first_name'][0].' '.$user_meta['last_name'][0]; ?>
                    <div class="project-list__itm-wrp">
                        <a href="<?php echo esc_url( get_author_posts_url($approve->user_id) ) ;?>" class="project-list__itm find-partners w-inline-block" target="_blank"> <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e9f-a709e52f" class="project-list__img-wrp"><?php
                            if(!empty($user_meta['cover_picture']) && !empty($user_meta['cover_picture'][0])){ 
                                $get_cover = $user_meta['cover_picture'][0];
                               // $cover_pic = wp_get_attachment_url($get_cover[0]);
                            ?>
                         
                        <img src="<?php echo $get_cover; ?>" loading="lazy" id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea0-a709e52f" alt="" class="project-list__img">
                          <?php
                            } ?> </div>
                            <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea1-a709e52f" class="project__txt-wrp productions">
                                 <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea2-a709e52f" class="project-itm__title">
                                    <?php if($user_meta['account_type'][0] == 'Organisation')
                                    {
                                   echo $user_meta['name_of_organisation']['0'];
                                    }else{
                                    echo $full_name;    
                                    }  ?>
                                    </div> <?php
                                $select_your_country = '';
                                if(!empty($user_meta['country']) && !empty($user_meta['country'][0])){ 
                                    $select_your_country = $user_meta['country'][0];
                                } 
                                if(!empty($select_your_country)){ ?>
                                  <div class="txt-xxs"><?php echo $select_your_country; ?></div><?php
                                } 
                                                            
                                        if(!empty($user_meta['organisation_type']) && !empty($user_meta['organisation_type'][0])){  
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
                                        }  
                                  
                                ?>
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
                                if(!empty($user_meta['performing_art_forms']) && !empty($user_meta['performing_art_forms'][0])){ 
                                    global $post;
                                    $get_performaings = array();
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
                                if(in_array($approve->user_id,$array_fav))
                                {
                                    echo '<div class="star__icon remove_fav active" data-id="'.$approve->user_id.'"></div>';    
                                }
                                else{
                                    echo '<div class="star__icon add_fav" data-id="'.$approve->user_id.'"></div>';  
                                }
                             

                            $table_name = 'partners_status';
                            $send_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".$approve->user_id." AND current_user_id = ".get_current_user_id()." AND status = 'request') ");

                                $recived_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (current_user_id = ".$approve->user_id." AND user_id = ".get_current_user_id()." AND status = 'request') "); 

                                $approve_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$approve->user_id." AND status = 'approve' OR user_id = ".$approve->user_id." AND current_user_id = ".get_current_user_id()." AND status = 'approve') ");

                                $declined_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$approve->user_id." AND status = 'approve' OR user_id = ".$approve->user_id." AND current_user_id = ".get_current_user_id()." AND status = 'declined') ");
                            
                            if(!empty($send_request)){ ?>
                                <div class="btn--send">
                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow.svg" loading="lazy" alt="" class="send__icon">
                                    <div class="txt-block">sent</div>
                                </div><?php
                            }
                            else if(!empty($recived_request)){ ?>
                                <div class="btn--approve">
                                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                                    <div class="txt-block approve-request" data-id="<?php echo $approve->user_id; ?>">approve</div>
                                </div>
                                <div class="remove__icon declined-request" data-id="<?php echo $approve->user_id; ?>"></div><?php
                            }
                            else if(!empty($approve_request)){ ?>
                                <div class="btn--match"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/match-icon.svg" loading="lazy" alt="" class="quickmatch__icon">
                                <div class="txt-block">It`s a match!</div>
                                </div>
                                <a href="mailto:<?php echo $get_email->user_email;?>"><div class="mail__icon"></div></a>
                            <?php
                            }
                            else if(!empty($declined_request)){ ?>
                                <div class="btn--declined">
                                    <div class="txt-block">declined</div>
                                </div><?php
                            }
                            else{ ?>
                                <div class="btn--quickmatch" data-id="<?php echo $approve->user_id; ?>"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                                    <div class="txt-block">quick match</div>
                                </div><?php
                            }  ?>
                        </div>
                    </div><?php
                }
                else{
                    echo "<span class='error-message'>This user not exist.</span>";
                }
            }
        } 
        else{
           echo "<span class='error-message'>".get_field('message_for_partner_page','option')."</span>";
        } 
    }

  die;
}

add_action( 'wp_ajax_get_sent_request', 'get_sent_request' );

add_action( 'wp_ajax_nopriv_get_sent_request', 'get_sent_request' );

function delete_account( $atts ) {

    if(!empty($_POST['user_id'])){
        wp_delete_user($_POST['user_id']);
    }
    die;
}

add_action( 'wp_ajax_delete_account', 'delete_account' );

add_action( 'wp_ajax_nopriv_delete_account', 'delete_account' );

function favorites_user( $atts ) {

    if(!empty($_POST['current_user_id']) && !empty($_POST['user_id'])){
        
        global $wpdb;
     
        $table_name = "favourite_partners";     
        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE `current_user_id` = '".$_POST['current_user_id']."' AND `fav_user_id` = '".$_POST['user_id']."'");
        if(!$result){   
        $wpdb->insert( 

            $table_name, 

            array( 

               'current_user_id' => $_POST['current_user_id'], 

               'fav_user_id'=> $_POST['user_id'],

            ) 

        ); 
            echo "success"; 
        }
       
        
    }

  die;
}

add_action( 'wp_ajax_favorites_user', 'favorites_user' );

add_action( 'wp_ajax_nopriv_favorites_user', 'favorites_user' );

function remove_favorites_user( $atts ) {

    if(!empty($_POST['current_user_id']) && !empty($_POST['user_id'])){
        
        global $wpdb;
     
        $table_name = "favourite_partners";     
        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE `current_user_id` = '".$_POST['current_user_id']."' AND `fav_user_id` = '".$_POST['user_id']."'");         
        if($result){    
            $get_user_id = $result[0]->id;           
            $table = 'favourite_partners';
            $wpdb->delete( $table, array( 'id' => $get_user_id ) );
            echo "success"; 
        }
       
        
    }

  die;
}

add_action( 'wp_ajax_remove_favorites_user', 'remove_favorites_user' );

add_action( 'wp_ajax_nopriv_remove_favorites_user', 'remove_favorites_user' );

function get_fav_matches( $atts ) {

    if(!empty($_POST['current_user_id'])){
        global $wpdb;
        $table_name = 'favourite_partners';
        $fetch_total_approve = $wpdb->get_results("SELECT * FROM $table_name WHERE current_user_id = ".$_POST['current_user_id']."");
        if(!empty($fetch_total_approve)){
            foreach($fetch_total_approve as $approve){
                $user_meta = get_user_meta($approve->fav_user_id); 
                $get_email = get_userdata($approve->fav_user_id);       
                $full_name = $user_meta['first_name'][0].' '.$user_meta['last_name'][0]; ?>
                <div class="project-list__itm-wrp">
                    <a href="<?php echo esc_url( get_author_posts_url($approve->fav_user_id) ) ;?>" class="project-list__itm find-partners w-inline-block" target="_blank">
                        <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0e9f-a709e52f" class="project-list__img-wrp"><?php
                            if(!empty($user_meta['cover_picture']) && !empty($user_meta['cover_picture'][0])){ 
                                $get_cover = $user_meta['cover_picture'][0]; ?>
                                    <img src="<?php echo $get_cover; ?>" loading="lazy" id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea0-a709e52f" alt="" class="project-list__img"><?php
                            } ?>
                        </div>
                        <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea1-a709e52f" class="project__txt-wrp productions">
                             <div id="w-node-_59eadda0-27b2-2543-83db-fe5e946d0ea2-a709e52f" class="project-itm__title"><?php 
                                if($user_meta['account_type'][0] == 'Organisation')
                                {
                                    echo $user_meta['name_of_organisation']['0'];
                                }
                                else{
                                    echo $full_name;    
                                }  ?>
                            </div><?php 
                            $select_your_country = '';
                            if(!empty($user_meta['country']) && !empty($user_meta['country'][0])){ 
                                $select_your_country = $user_meta['country'][0];
                            } 
                            if(!empty($select_your_country)){ ?>
                              <div class="txt-xxs"><?php echo $select_your_country; ?></div><?php
                            }                                                         
                            if(!empty($user_meta['organisation_type']) && !empty($user_meta['organisation_type'][0])){  
                                if(is_serialized($user_meta['organisation_type'][0])){
                                    $location = unserialize($user_meta['organisation_type'][0]);
                                }
                                else{
                                    $location = $user_meta['organisation_type'];
                                }                                                                                                               
                                if(is_array($location))
                                { ?>                                  
                                    <div class="txt-xxs"><?php echo implode(', ',$location); ?></div><?php
                                }
                            }  ?>
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
                            if(!empty($user_meta['performing_art_forms']) && !empty($user_meta['performing_art_forms'][0])){ 
                                global $post;
                                $get_performaings = array();
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
                                { ?>
                                    <div class="itm__label bg-magenta">
                                        <div class="itm__label__txt"><?php echo implode(', ',$topics_covereds); ?></div>
                                    </div><?php
                                } 
                            } ?>
                        </div>
                    </a>
                    <div id="w-node-f573d56b-449d-184f-bf69-7a7c4302a870-a709e52f" class="project__itm__cta"><?php 
                        global $wpdb;
                             
                        echo '<div class="star__icon remove_fav active" data-id="'.$approve->fav_user_id.'"></div>';    
                             
                
                        $table_name = 'partners_status';

                        $send_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".$approve->fav_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'request') ");

                            $recived_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (current_user_id = ".$approve->fav_user_id." AND user_id = ".get_current_user_id()." AND status = 'request') "); 

                            $approve_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$approve->fav_user_id." AND status = 'approve' OR user_id = ".$approve->fav_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'approve') ");

                            $declined_request = $wpdb->get_results("SELECT * FROM $table_name WHERE (user_id = ".get_current_user_id()." AND current_user_id = ".$approve->fav_user_id." AND status = 'approve' OR user_id = ".$approve->fav_user_id." AND current_user_id = ".get_current_user_id()." AND status = 'declined') ");
                        
                        if(!empty($send_request)){ ?>
                            <div class="btn--send">
                                <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow.svg" loading="lazy" alt="" class="send__icon">
                                <div class="txt-block">sent</div>
                            </div><?php
                        }
                        else if(!empty($recived_request)){ ?>
                            <div class="btn--approve">
                                <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                                <div class="txt-block approve-request" data-id="<?php echo $approve->fav_user_id; ?>">approve</div>
                            </div>
                            <div class="remove__icon declined-request" data-id="<?php echo $approve->fav_user_id; ?>"></div><?php
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
                            <div class="btn--quickmatch" data-id="<?php echo $approve->fav_user_id; ?>"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/651096160e884035b5434375_Group.svg" loading="lazy" alt="" class="quickmatch__icon">
                                <div class="txt-block">quick match</div>
                            </div><?php
                        } ?>
                    </div>
                </div><?php
            }
        } 
        else{
            echo "<span class='error-message'>".get_field('message_for_partner_page','option')."</span>";
        } 
    }

  die;
}

add_action( 'wp_ajax_get_fav_matches', 'get_fav_matches' );

add_action( 'wp_ajax_nopriv_get_fav_matches', 'get_fav_matches' );

add_action( 'pre_user_query', 'my_random_user_query' );

function my_random_user_query( $class ) {
    if( 'rand' == $class->query_vars['orderby'] )
        $class->query_orderby = str_replace( 'user_login', 'RAND()', $class->query_orderby );

    return $class;
}