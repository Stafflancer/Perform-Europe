<?php /* Template Name: Project */
get_header(); 
$edition_show = get_field('edition_show', get_the_ID());
$edition_1 = get_field_object('edition_1', get_the_ID());
$edition_2 = get_field_object('edition_2', get_the_ID()); 
$value1 = $edition_1['value'];
$label1 = $edition_1['choices'][ $value1 ]; 
$value2 = $edition_2['value'];
$label2 = $edition_2['choices'][ $value2 ];  ?>
<section class="section-wrp s-project-first">
    <div class="page-content-wrp">
        <h1 class="page__title">Selected Projects</h1>
        <div class="page__head__cont"><?php
            if($edition_show == 1){ ?>
              <div class="project__years"><?php
			          if(!empty($label2)){
                    $args = array(
                        'post_type' => 'project',
                        'post_status'   => 'publish',
                        'orderby' => 'rand',                                
                        'posts_per_page' =>1,
                        'meta_query'    => array(
                            array(
                                'key'       => 'edition',
                                'value'     => array('2024-2026'),
                                'compare'   => 'IN',
                            ),
                        ),
                    );
                    $project_list = get_posts( $args ); 
                    if(empty($project_list)){ 

                        $get_edition_number = $value1;
						$edition_2_heading = get_field('edition_2_heading',get_the_ID());
						$edition_1_heading = get_field('edition_1_heading',get_the_ID());
                        $get_description = get_field('description', get_the_ID());
                        ?>
                         <a href="javascript:;" style="pointer-events: none;" class="project__year w-inline-block">
                            <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="filter__year__arrow">
                            <div class="filter__year__txt fetch-year" data-year="<?php echo $value2; ?>" data-description="<?php echo get_field('edition_2_description', get_the_ID()); ?>"><?php echo $edition_2_heading; ?></div>
                        </a>                                
                        <?php
                          if(!empty($label1)){ ?>
                                <a href="javascript:;" class="project__year filter--current w-inline-block"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="filter__year__arrow">
                                    <div class="filter__year__txt fetch-year" data-year="<?php echo $value1; ?>" data-description="<?php echo get_field('description', get_the_ID()); ?>"><?php echo $edition_1_heading; ?></div>
                                </a><?php
                            } 
                    }
                    else
                    {   
                        $get_edition_number = $value2;
						$edition_2_heading = get_field('edition_2_heading',get_the_ID());
						$edition_1_heading = get_field('edition_1_heading',get_the_ID());
                        $get_description = get_field('edition_2_description', get_the_ID()); ?>
                         <a href="javascript:;" class="project__year filter--current w-inline-block"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="filter__year__arrow">
                            <div class="filter__year__txt fetch-year" data-year="<?php echo $value2; ?>" data-description="<?php echo get_field('edition_2_description', get_the_ID()); ?>"><?php echo $edition_2_heading; ?></div>
                        </a><?php
                        if(!empty($label1)){ ?>
                            <a href="javascript:;" class="project__year w-inline-block"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="filter__year__arrow">
                                <div class="filter__year__txt fetch-year" data-year="<?php echo $value1; ?>" data-description="<?php echo get_field('description', get_the_ID()); ?>"><?php echo $edition_1_heading; ?></div>
                            </a><?php
                        } 
                    }    
                } ?>
              </div><?php
            } ?>
            <p class="paragraph update_paragraph"><?php echo $get_description; ?></p>
        </div>
    </div>
</section>
<section class="section-wrp s-project-search">
    <div class="search-wrp">
        <div class="search__bar">
            <input class="searchbar__txt search__bar__txt search-input-ajax" name="keyword" type="text" placeholder="search something">
        </div>
        <div class="search__suggestions"></div>
    </div>
    <div class="project__list">
        <div class="project-list__head">
            <div class="project-list__itm">
                <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c80671-a709e52f" class="txt-block hide-mobile">
                    Preview</div>
                <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c80673-a709e52f" class="txt-block">Project name
                </div>
                <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c80675-a709e52f" class="txt-block hide-mobile">
                    Countries</div>
                <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c80677-a709e52f" class="txt-block hide-mobile">
                    Performing arts</div>
                <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c80679-a709e52f" class="txt-block hide-mobile">
                    Topics covered</div>
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
                'post_type' => 'project',
                'post_status'   => 'publish',
                'orderby' => 'title',
                'order'   => 'ASC',
                'posts_per_page' => $recordsPerPage,
                'paged' => $page,
                'meta_query'    => array(
                    array(
                        'key'       => 'edition',
                        'value'     => array($get_edition_number),
                        'compare'   => 'IN',
                    ),
                ),
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
						$select_partner_country = array();
                        foreach($select_partners as $partners){
                            if(!empty($partners['select_partner_country'])){ 
                                $select_partner_country[] = $partners['select_partner_country'];
                            }
                        }
                    }  ?>
                    <a href="<?php echo get_the_permalink(get_the_ID()); ?>" class="project-list__itm-wrp w-inline-block">
                        <div class="project-list__itm cursor-show">
                            <div id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067d-a709e52f" class="project-list__img-wrp"><?php
                                 if(!empty($image)){ ?>
                                    <img src="<?php echo $image; ?>" id="w-node-_88aae460-144b-7d8f-4f1a-81cdf7c8067e-a709e52f" alt="<?php the_title(); ?>"
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
    call_ajax(page);
    return false;
  });
  jQuery(document).on("change",".country-select",function()
  {
    var page = jQuery('.active').attr('p');
    var countries = jQuery(this).val();
    jQuery.ajax({
      type: "POST",
      url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data: ({ action : 'project_filter_list', page : page, countries : countries}),
      success: function(response)
      {   
        jQuery('.product-row').html( response );
      }
      
    });
  });
  jQuery(document).on("change",".performing-arts",function()
  {
    var page = jQuery('.active').attr('p');
    var performing = jQuery(this).val();
    jQuery.ajax({
      type: "POST",
      url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data: ({ action : 'project_filter_list', page : page, performing : performing}),
      success: function(response)
      {   
        jQuery('.product-row').html( response );
      }
      
    });
  });
  jQuery(document).on("change",".topics-covered",function()
  {
    var topics = jQuery(this).val();
    var page = jQuery('.active').attr('p');
    var performing = jQuery(this).val();
    jQuery.ajax({
      type: "POST",
      url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data: ({ action : 'project_filter_list', page : page, topics : topics}),
      success: function(response)
      {   
        jQuery('.product-row').html( response );
      }
      
    });
  });
  function call_ajax(page,countries,performing,topics,year)
  {
    jQuery.ajax({
      type: "POST",
      url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data: ({ action : 'project_filter_list', page : page }),
     
      success: function(response)
      {   
        jQuery('.product-row').html( response );
      }
      
    });
  }
  jQuery(document).on("click",".fetch-year",function()
  {
    var get_description = $(this).attr('data-description');
    $(".update_paragraph").html(get_description);
    $('.project__year').removeClass('filter--current');
    $(this).parent('a').addClass('filter--current');
    var year = $(this).attr('data-year');
    var page = jQuery('.active').attr('p');
    call_year_ajax(page,year);
    return false;
  });
  function call_year_ajax(page,year)
  {
    jQuery.ajax({
      type: "POST",
      url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
      data: ({ action : 'project_year_list', page : page, year : year}),
     
      success: function(response)
      {   
        jQuery('.product-row').html( response );
      }
      
    });
  }
});
</script>


