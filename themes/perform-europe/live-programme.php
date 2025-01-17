<?php /* Template Name: Live Programme */
get_header(); 
if ( have_posts() ) : while ( have_posts() ) : the_post();?>
    <section class="section-wrp s-project-first">
        <div class="page-content-wrp">
            <h1 class="page__title"><?php the_title(); ?></h1>
            <div class="page__head__cont">
                <p class="paragraph"><?php the_content(); ?></p>
            </div>
        </div>
    </section><?php
endwhile;
endif; ?>
<section class="section-wrp s-project-search">
    <div class="search-wrp" style="display:none;">
        <div class="search__bar">
            <input class="searchbar__txt search__bar__txt search-input-ajax" name="keyword" type="text" placeholder="search something">
        </div>
        <div class="search__suggestions"></div>
    </div>
    <div class="project__list">
        <div class="project-list__head">
            <div class="project-list__itm live-programme">
                <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a5016079-a709e52f" class="txt-block hide-mobile" style="visibility: hidden;">
                    Preview</div>
                <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a501607b-a709e52f" class="txt-block">Artistic works and partnership</div>
                <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a501607d-a709e52f" class="txt-block hide-mobile">
                    Venue and location</div>
                <div id="w-node-_9be0afe8-f5f1-47d4-c3a7-88640c5087ea-a709e52f" class="txt-block hide-mobile">
                    Dates</div>
                <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a501607f-a709e52f" class="txt-block hide-mobile">
                    Performing arts</div>
                <div id="w-node-_17ce8762-19b5-27f7-4a5c-1b32a5016081-a709e52f" class="txt-block hide-mobile">
                    Topics covered</div>
                <div id="w-node-d437d2e0-8c8d-18ee-e3e1-a385c87d9eca-a709e52f" class="txt-block hide-mobile">
                    Website</div>
            </div>
        </div>
        <div class="product-row"><?php
            $noofposts = 20;
            $page = (int) (!isset($_REQUEST['page']) ? 1 :$_REQUEST['page']);
            $page = ($page == 0 ? 1 : $page);
            $recordsPerPage = $noofposts;
            $start = ($page-1) *$recordsPerPage;
            $adjacents = "1";
            $found_posts = array(
                'post_type' => 'performance',
                'post_status'   => 'publish',
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
      data: ({ action : 'search_projects', search : search}),
     
      success: function(response)
      {   
        jQuery('.search__suggestions').html( response );
        jQuery('.search__suggestions').show();
      }
      
    });

  }
  jQuery(document).on("click",".product-row .ajax_pagination .active_cell",function()
  {
    var page = jQuery(this).attr('p');
    var countries = jQuery('.country-select').val();
    var performing = jQuery('.performing-arts').val();
    var topics = jQuery('.topics-covered').val();
    call_ajax(page,countries,performing,topics);
    return false;
  });
  jQuery(document).on("change",".country-select",function()
  {
    var page = jQuery('.active').attr('p');
    var countries = jQuery(this).val();
    var performing = jQuery('.performing-arts').val();
    var topics = jQuery('.topics-covered').val();
    call_ajax(page,countries,performing,topics);
    return false;
  });
  jQuery(document).on("change",".performing-arts",function()
  {
    var page = jQuery('.active').attr('p');
    var performing = jQuery(this).val();
    var countries = jQuery('.country-select').val();
    var topics = jQuery('.topics-covered').val();
    call_ajax(page,countries,performing,topics);
    return false;
  });
  jQuery(document).on("change",".topics-covered",function()
  {
    var page = jQuery('.active').attr('p');
    var topics = jQuery(this).val();
    var countries = jQuery('.country-select').val();
    var performing = jQuery('.performing-arts').val();
    call_ajax(page,countries,performing,topics);
    return false;
  });
  function call_ajax(page,countries,performing,topics)
  {
    jQuery.ajax({
      type: "POST",
      url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data: ({ action : 'live_programme_project_list', page : page, countries : countries, performing : performing, topics : topics}),
      success: function(response)
      {   
        jQuery('.product-row').html( response );
      }
      
    });
  } 
});
</script>