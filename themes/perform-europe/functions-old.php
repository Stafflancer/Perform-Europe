<?php

add_action('init', function(){


    $result['attachment'] = civicrm_api3('Attachment', 'create', [
        'name' => $name,
        'mime_type' => $_FILES['image']['type'],
        'entity_id' => $result['contact']['id'],
        'field_name' => 'custom_3',
        'content' => $_FILES['image'],
    ]);


    $userdata = [
        'user_pass'				=> 'Tabby1990!@#',
        'user_email' 			=> 'questwebssdssaaas@yopmail.com',
        'first_name' 			=> 'Quests',
        'last_name' 			=> 'webs'
    ];

    $user_id = wp_insert_user( $userdata);

    $error = null;

    if (isset($user_id->errors) && $user_id->errors) {

        if (isset($user_id->errors['existing_user_login'][0]) && $user_id->errors['existing_user_login'][0]) {
            $error = $user_id->errors['existing_user_login'][0];
        } else {
            $error = 'Unknown error';
        }
        return [
            'status' => 'error',
            'message' => $error
        ];
    }

    $user = get_user_by( 'id', $user_id );

    if (!$user) {
        return [
            'status' => 'error',
            'message' => $error
        ];
    }

    $result = civicrm_api3('Contact', 'getsingle', array(
        'email' => $user->user_email,
    ));

    if (isset($result['contact_id']) && $result['contact_id']) {
        civicrm_api3('Contact', 'create', array(
            'id' => $result['contact_id'],
            'phone' => '0722323232',
            'country' => 1112,
            'job_title' => 'Marketer',
            'nick_name' => 'Madayer',        
            'contact_type' => 'Individual',
            //'custom_8' , // Cover pic
            'custom_2' => 'person', // Contact type
            'custom_3' => 'Madayer Org', // Organisation
            'custom_10' => 1112, // Country
            'custom_5' => 'Nakuru', // City
            'custom_6' => 'Short desc', // Short description
            'custom_7' => 'My offer', // Your offer
        ));
    }else {
        return [
            'status' => 'error',
            'message' => 'Contact ID not fount in CIVICRM'
        ];
    }
}, 1100);







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
	wp_enqueue_script( 'gsap-script', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js' );
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
     if ( is_page(57) )
          $classes[] = 'pe-body--mint';
 	
 	if ( is_page(195) )
 		$classes[] = 'pe-body--pink';
	
	if ( is_page(197) )
 		$classes[] = 'pe-body--beige';
 		 	
     return $classes; 
}

// add post image
add_theme_support( 'post-thumbnails' );

/**
 * Displays numeric pagination on archive pages.
 *
 * @author BopDesign
 *
 * @param array    $args  Array of params to customize output.
 * @param WP_Query $query The Query object; only passed if a custom WP_Query is used.
 */
function print_numeric_pagination() {
	if ( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}

	// Make the pagination work on custom query loops.
	$total_pages = isset( $query->max_num_pages ) ? $query->max_num_pages : 1;

	// Set defaults.
	$defaults = [
		'prev_text' => '',
		'next_text' => '',
		'mid_size'  => 4,
		'total'     => $total_pages,
	];

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	if ( null === paginate_links( $args ) ) {
		return;
	}
	?>
	<div class="pagination-set">
		<div class="pagination-bottom d-flex justify-content-center pagination" aria-label="<?php esc_attr_e( 'numeric pagination', THEME_TEXT_DOMAIN ); ?>">
			<?php echo paginate_links( $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK. ?>
		</div>
	</div>
	<?php
}

/* Blog Filter */

function latestnewslist_fn_ajax( $atts ) 
{
    $noofposts = 9;

    $page = (int) (!isset($_REQUEST['page']) ? 1 :$_REQUEST['page']);

    $page = ($page == 0 ? 1 : $page);

    $recordsPerPage = $noofposts;

    $start = ($page-1) *$recordsPerPage;

    $adjacents = "1";

    if(!empty($_POST['newsortby']))
    {

        $found_posts = array(

            'post_type' => 'post',

            'post_status'   => 'publish',

            'posts_per_page' => $recordsPerPage,

            'paged' => $page,

            'orderby' => 'date',

            'order'   => 'DESC',

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
               
            );
    }
    $wp_query = new WP_Query($found_posts);
    $count = $wp_query->found_posts;
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
            </div>
            <div id="w-node-_5375aeed-c089-51f4-511b-318aa04264c8-a709e52f" class="grid-cta">
                <h4 class="h4">Don’t miss out on latest news, <br>announcements, publications and tips</h4>
                <a href="#" class="btn--transparent w-inline-block">
                    <div class="txt-block--1rem">subscribe</div>
                </a>
            </div>
    	</div><?php
    } 
    die;
}

add_action( 'wp_ajax_blogs', 'latestnewslist_fn_ajax' );

add_action( 'wp_ajax_nopriv_blogs', 'latestnewslist_fn_ajax' ); 


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

            's' => $_POST['search'],

        ); 
    }
    $wp_query = new WP_Query($found_posts);
    if ($wp_query->have_posts())
    { 
        while ($wp_query->have_posts())
        { 
            $wp_query->the_post(); 
            $postid = get_the_ID(); 
            $blogimage = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID(), 'thumbnail'));  
            $categories = get_the_category();  ?>
            <div class="search__suggestion__itm"><?php 
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
	                else if($category->name == 'Open Call'){ ?>
	                    <div class="label">
	                        <div class="label__txt"><?php echo $category->name; ?></div>
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
            </div><?php
        } wp_reset_postdata(); 
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
                <a href="/news/" class="txt-block txt-up">view all </a>
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
                        else if($category->name == 'Event'){
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
                                if($pinned == 1){ ?>
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
                        </div><?php
                        if(!empty($deadline)){ ?>
                            <div class="itm__deadline">Deadline: <?php echo esc_html ( get_field( 'deadline', get_the_ID()) ); ?></div><?php
                        } ?>
                    </a><?php
                } wp_reset_postdata(); ?>
            </div>
        </section><?php
    }
}