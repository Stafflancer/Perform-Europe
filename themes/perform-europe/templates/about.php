<?php /* Template Name: About Us */
get_header(); ?>
 <section class="section-wrp s-about-land">
            <h1 class="page__title">About Us</h1>
            <?php if(get_field('play_documentary_url_')) { ?> 
            <div class="play-btn" id="open-video">
                <div class="txt-block--1rem">play documentary</div>
                <div class="play-btn__icon"></div>
            </div>
            <?php }?>
            <?php if(!empty(get_field('video_link')))
            { ?> 
            <div class="land__img"> 
				<?php if ( wp_is_mobile() ) : ?>
					<div class="landing__image--mobile">
					<img src="<?php echo get_field('mobile_video');?>">				 
				    </div>
				<?php else : ?>
					<video autoplay muted loop class="land__img__video">
                    <source src="<?php echo get_field('video_link');?>" type="video/mp4">
                </video>
				<?php endif; ?>
                
				
            </div>
            <?php } ?>
        </section>
        <section id="who-we-are" class="section-wrp s-about-who">
            
            <div class="section__title-wrp">
                <h2 class="section__title"><?php echo get_field('who_we_are_title');?></h2>
            </div>
            <p class="paragraph--2coll"><?php echo get_field('who_we_are_description');?></p>            
        </section>
        <section id="timeline" class="section-wrp s-about-timeline">
            <div class="section__title-wrp">
                <h2 class="section__title"><?php echo get_field('timeline_title');?></h2>
            </div>
            <div class="timeline-wrp">
                <?php 
                if( have_rows('add_date') ): 
                                
                    while( have_rows('add_date') ) : the_row();

                        $date = get_sub_field('date');                        
                        $date_description = get_sub_field('date_description');                        
                    ?>
                    <div class="timeline__itm">
                    <div class="timeline__point"></div>
                    <div class="timeline__time"><?php echo $date;?></div>
                    <p class="timeline__txt"><?php echo $date_description;?></p>
                     </div>
                <?php
                    endwhile;
                
                endif;
            ?>                         
            </div>
        </section>
        <section id="teams" class="section-wrp s-about-teams">
            <h2 class="section__title--big">Teams</h2>
            <?php 
                if( have_rows('add_new_group') ): 
                  echo '<div class="teams__grid">';              
                    while( have_rows('add_new_group') ) : the_row();                       
                     $teams_background_color = get_sub_field('teams_background_color');                     
                     $group_name = get_sub_field('group_name');                                          

                        if( have_rows('add_person') ):
                    ?>
                    <div id="<?php echo strtolower(str_replace(' ','-',$group_name));?>" class="europe-team">
                        <div class="grid__head">
                            <div class="section__title-wrp">
                                <h2 class="section__title"><?php echo $group_name;?></h2>
                            </div>
                        </div>                   
                    <div class="itms__grid">
                    <?php
                            while( have_rows('add_person') ) : the_row();                            
                                $photo = get_sub_field('photo');
                                $name = get_sub_field('name');
                                $pronouns = get_sub_field('pronouns');
                                $country = get_sub_field('country');
                                $job_title = get_sub_field('job_title');
                                $short_description = get_sub_field('short_description');
                                $email = get_sub_field('email');

                    ?>                              
                            <div class="grid__itm">
                                <div class="grid__img-wrp" style="background-color:<?php echo  $teams_background_color;?>">
                                    <img src="<?php echo $photo;?>" class="grid__img"></div>
                                <div class="grid__itm__head">
                                    <h4 class="grid__itm__name"><?php echo $name;?></h4>
                                    <div class="grid__itm__pronouns"><?php echo $pronouns;?></div>
                                </div>
                                <div class="grid__itm__country-wrp">
                                    <div class="grid__itm__txt--small">Country:</div>
                                    <div class="grid__itm__label">
                                        <div class="grid__itm__country"><?php echo $country;?></div>
                                    </div>
                                </div>
                                <div class="grid__itm__descr-wrp">
                                    <div class="grid__itm__txt--small"><?php echo $job_title;?></div>
                                    <p class="paragraph"><?php echo $short_description;?></p>
                                    <?php if($email){ ?>
                                    <a href="mailto:<?php echo $email;?>" class="btn--transparent w-inline-block"><div class="txt-block--1rem">email</div></a>
                                    <?php } ?>
                                </div>
                            </div>                      
                    <?php
                               endwhile;
                            echo '</div>';
                            endif;
                    ?>                    
                <?php
                    endwhile;
                echo '</div>';
                endif;
            ?>                     
        </section>
        <section id="consortium-partners" class="section-wrp s-about-partners">
            <h2 class="section__title--big"><?php echo get_field('title_consortium_partners');?></h2>
            <div class="max-widht-24rem">
                <p class="paragraph"><?php echo get_field('description_consortium_partners');?></p>
            </div>
            <div class="partner__list">
            <?php 
                if( have_rows('add_consortium_partner') ): 
                ?>
                <div class="list__itm-menu-wrp">
                    <div class="partner__list__menu">
                        <div id="w-node-_2a5723ef-a274-74ca-9b69-fd99b3158551-a709e52f" class="txt-block hide-mobile">
                            Logo</div>
                        <div id="w-node-_2a5723ef-a274-74ca-9b69-fd99b3158553-a709e52f" class="txt-block hide-mobile">
                            Name</div>
                        <div id="w-node-_2a5723ef-a274-74ca-9b69-fd99b3158555-a709e52f" class="txt-block hide-mobile">
                            Description</div>
                        <div id="w-node-_4ccc4192-3e6d-76fe-615d-d77fb112d5d7-a709e52f" class="show-mobile"></div>
                    </div>
                </div>
                <?php                   
                    while( have_rows('add_consortium_partner') ) : the_row();

                        $logo = get_sub_field('logo');                        
                        $name = get_sub_field('name');
                        $description = get_sub_field('description');
						$consortium_partner_link = get_sub_field('consortium_partner_link');				 
                    ?>
                    <a href="<?php echo $consortium_partner_link['url'];?>" class="list__itm-wrp w-inline-block" target="<?php echo $consortium_partner_link['target'];?>">
                        <div class="partner__list__itm">
                            <div id="w-node-_8d990e79-8042-daca-5a12-6584c22905ee-a709e52f" class="itm__logo-wrp">
                                <img src="<?php echo $logo;?>" loading="lazy" alt="" class="itm__logo">
                            </div>
                            <div id="w-node-_2a5723ef-a274-74ca-9b69-fd99b315855d-a709e52f" class="itm__title hide-mobile">
                                <?php echo $name;?></div>
                            <p id="w-node-_7cd4ccd2-f7db-62b7-46a5-051a78a970fe-a709e52f" class="paragraph"><?php echo $description;?></p><img
                                src="https://performeurope.eu/wp-content/uploads/2023/11/arrow-btn-1.svg"
                                alt="" class="partner__list__icon">
                        </div>
                    </a>
                <?php
                    endwhile;
                
                endif;
            ?> 
            </div>
        </section>
        <?php
$iframe = get_field('play_documentary_url_'); 
if(!empty($iframe)){ ?>
    <div class="video__embed-wrp">
        <div class="video__embed"><?php
            // Use preg_match to find iframe src.
            preg_match('/src="(.+?)"/', $iframe, $matches);
            $src = $matches[1];

            // Add extra parameters to src and replace HTML.
            $params = array(
                'controls'  => 0,
                'hd'        => 1,
                'autohide'  => 1
            );
            $new_src = add_query_arg($params, $src);
            $iframe = str_replace($src, $new_src, $iframe);

            // Add extra attributes to iframe HTML.
            $attributes = 'frameborder="0"';
            $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

            // Display customized HTML.
            echo $iframe; ?>
        </div>
        <div id="close-video" class="video-close__link">Close</div>
    </div>



    <?php
} 
get_footer(); ?>
    <style>
        .tab-links.current {
            color: #000;
        }
    </style>
    <script>
    jQuery(document).ready(function ($) {
         gsap.utils.toArray(".tab-links").forEach(function (button, i) {
            button.addEventListener("click", (e) => {
                var id = e.target.getAttribute("href");
                console.log(id);
                smoother.scrollTo(id, true, "top top");
                e.preventDefault();
            });
        });
        $('.tab-links').click(function () {
            $('.common-tab').removeClass('current');
            $(this).addClass('current'); 
        });
    });
    </script>
    <div class="site-menu">
        <a href="#who-we-are" class="common-tab site-menu__link current tab-links">About Us</a>
        <div class="link-wrp">
            <a href="#who-we-are" class="common-tab site-menu__link--sub tab-links">Who we are</a>
            <a href="#timeline" class="common-tab site-menu__link--sub tab-links">Timeline</a>
        </div>
        <a href="#teams" class="common-tab site-menu__link tab-links">Teams</a>
        <div class="link-wrp">
            <a href="#perform-europe-team" class="common-tab site-menu__link--sub tab-links">Perform Europe Team</a>
            <a href="#board-members" class="common-tab site-menu__link--sub tab-links">Board Members</a>           
        </div>
        <a href="#consortium-partners" class="common-tab site-menu__link tab-links">Consortium Partners</a>
        <img src="https://assets-global.website-files.com/64ecbdf64d19097aeaa7b60d/652fec9b4b55a603d3ed4c54_pe-about-menu.svg" loading="lazy" alt="" class="menu__small-img">
    </div> 
    <div class="side-menu--mobile">
        <div class="menu__titles">
            <div class="common-tab menu__title about tab-links" href="#who-we-are">about</div>
            <div class="common-tab menu__title about tab-links" href="#teams" >teams</div>
            <div class="common-tab menu__title about tab-links" href="#consortium-partners">consortium partners</div>
        </div>
        <div class="menu__dots">
            <a href="#who-we-are" class="menu__dot--big current w-inline-block tab-links">
                <div class="menu__dot--big"></div>
            </a>
            <div class="menu__dot"></div>
            <div class="menu__dot"></div>
            <a href="#teams" class="menu__dot--big current w-inline-block tab-links">
                <div class="menu__dot--big"></div>
            </a>
            <div class="menu__dot"></div>
            <div class="menu__dot"></div>
            <div class="menu__dot"></div>
            <div class="menu__dot"></div>
            <a href="#consortium-partners" class="menu__dot--big current w-inline-block tab-links">
                <div class="menu__dot--big"></div>
            </a>
        </div>
    </div>