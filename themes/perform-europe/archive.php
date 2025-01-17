<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bopper
 */  

get_header();  
$current_category = get_the_category(); ?>
<section class="section-wrp s-news-land">
    <h1 class="page__title">Activities</h1>
    <div class="search-wrp">
        <div class="search__bar">
            <input class="searchbar__txt search__bar__txt search-input-ajax" name="keyword" type="text" placeholder="search something">
        </div>
        <div class="search__suggestions" style="display: none;"></div>
    </div>
</section><?php 
$categories = get_categories( array(
	'orderby' => 'name',
	'parent'  => 0,
	'hide_empty' => true,
) ); ?>
<section class="section-wrp s-news-search-results">
    <div class="search__list"><?php
        if(!empty($categories)){ ?>
            <div class="search__list__menu-wrp">
                <div class="search__list__menu tabs">
                    <div class="search__filter filter__type">
                        <div class="txt-block">Type</div>
                    </div>
                    <div class="search__filter">
                        <div class="txt-block newsortby" value="">All</div>
                    </div><?php
                    foreach( $categories as $category ) { 
                        $category_link = get_category_link( $category->term_id ); 
                        $active_class = '';
                        if(!empty($current_category)){
                        	$category_id = $current_category[0]->cat_ID;
                        	if($category_id == $category->term_id){
                        		$active_class = 'filter--current';
                        	}
                        } ?>
                        <div class="search__filter <?php echo $active_class; ?>">
                            <div class="txt-block newsortby" value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></div>
                            <div class="filter__highlight <?php if($category->name == 'News'){ echo 'bg-red'; } else if($category->name == 'Events'){ echo 'bg-yellow'; } else if($category->name == 'Open Call'){ echo 'bg-pink'; } else if($category->name == 'Resources'){ echo 'bg-green'; } else if($category->name == 'Resources'){ echo 'bg-white'; }  else if($category->name == 'Stories'){ echo 'bg-magenta'; }?>"></div>
                        </div><?php
                    } ?>
                </div>
            </div><?php
        } ?>
        <div class="search__results product-row"><?php
        	$get_pinned_post = get_field('select_pinned_post', 'option');
            if (!empty($get_pinned_post))
            {
	              $categories = get_the_category($get_pinned_post->ID); 
                $category_id = '';
                if(!empty($current_category)){
	                $category_id = $current_category[0]->cat_ID;
                }
	              $get_pinned_category_id = $categories[0]->cat_ID;
	              if($category_id == $get_pinned_category_id){
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
		                      <div class="itm__deadline">Published: <?php echo esc_html (get_the_date()); ?></div>
		                  <?php } ?>
		              </a><?php
		          }
            }
        	if(!empty($current_category)){
				$category_id = $current_category[0]->cat_ID;
	            $noofposts = 9;
	            $page = (int) (!isset($_REQUEST['page']) ? 1 :$_REQUEST['page']);
	            $page = ($page == 0 ? 1 : $page);
	            $recordsPerPage = $noofposts;
	            $start = ($page-1) *$recordsPerPage;
	            $adjacents = "1";
	            $found_posts = array(
	                'post_type' => 'post',
	                'post_status'   => 'publish',
	                'orderby' => 'date',
	                'order'   => 'DESC',
	                'posts_per_page' => $recordsPerPage,
	                'post__not_in' => array($get_pinned_post->ID),
	                'paged' => $page,
			            'tax_query' => array(

			                array(

			                    'taxonomy' => 'category',

			                    'field'    => 'term_id',

			                    'terms'    => array($category_id),

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
	        } 
	        /*else{ ?>
	          	<h2>Nothing Found!</h2><?php
	        }*/ ?>
        </div>
    </div>
</section>
<?php
get_footer(); ?>
<script>
jQuery(document).ready(function($)
{ 
  jQuery(document).on("click",".product-row .ajax_pagination .active_cell",function()
  {
    var page = jQuery(this).attr('p');
    var newsortby = jQuery(".tabs .newsortby.active").attr("value");
    call_ajax(page,newsortby);
    return false;
  });
  jQuery(document).on("click",".tabs .newsortby",function()
  {
    var page = jQuery('.active').attr('p');
    jQuery(".tabs .search__filter").removeClass("filter--current");
    jQuery(this).parent('.search__filter').addClass("filter--current");
    var newsortby = jQuery(this).attr("value");
    call_ajax(page,newsortby);
    return false;
  });
  function call_ajax(page,newsortby)
  {
    jQuery.ajax({
      type: "POST",
      url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data: ({ action : 'blogs', page : page, newsortby : newsortby}),
     
      success: function(response)
      {   
        jQuery('.product-row').html( response );
      }
      
    });

  } 
  jQuery(document).on("keyup",".search-input-ajax",function()
  {
	var page = 1;
	var search = jQuery(this).val();
	var withoutSpace = search.replace(/ /g, '').length; 
	if(withoutSpace > 3){
    	call_search_ajax(search);
    }
    else{
		jQuery('.search__suggestions').hide();
	}
    return false;
  });
  function call_search_ajax(search)
  {
    jQuery.ajax({
      type: "POST",
      url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data: ({ action : 'search_blogs', search : search}),
     
      success: function(response)
      {   
        jQuery('.search__suggestions').html( response );
        jQuery('.search__suggestions').show();
      }
      
    });

  } 
});
</script>