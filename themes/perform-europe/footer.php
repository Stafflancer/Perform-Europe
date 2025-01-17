<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bopper
 */

if (is_page(array(57,195,197,1020,1086,1196))){
    $footer_class = 'footer--dark';    
}
else{
    $footer_class = 'footer';
}   ?>
    <footer class="<?php echo $footer_class;?>">        
        <div class="footer-link-wrp">
            <div class="footer__cont">
                <?php if(!empty(get_field('footer_logos','option'))) { ?>
                <div id="w-node-_07065ce3-1e5f-55c9-bd78-95b6f1a207cf-f1a207ce" class="link-wrp-logo">
                    <img src="<?php echo get_field('footer_logos','option');?>"loading="lazy" alt="" class="img-100">
                </div>
                <?php } ?>
                <div id="w-node-_07065ce3-1e5f-55c9-bd78-95b6f1a207d2-f1a207ce" class="link-wrp-2-1">
                   
                    <div class="footer__link-wrp"><a href="/privacy" class="footer__link">Privacy Policy</a>
                         <?php if(get_field('privacy_policy_section_hide','option') != 1)
                        { ?> 
                        <a href="/terms" class="footer__link">Terms &amp; Conditions</a>
                        <?php } ?>
                    </div>
                        
                    <?php if(!empty(get_field('developed_by', 'option'))){ 
                            $get_url = get_field('developed_by', 'option');                                
                        ?>
                    <div class="footer__txt">Developed by <a href="<?php echo $get_url['url'];?>" class="footer__link--100" target="_blank"><?php echo $get_url['title'];?></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="footer__cont">
                <?php if( have_rows('social_media', 'option') ): ?>
                    <div class="link-wrp-2-2">

                    <?php while( have_rows('social_media', 'option') ) : the_row(); 

                        if(!empty(get_sub_field('social_media_url'))){
                        ?>

                        <a href="<?php the_sub_field('social_media_url'); ?>" class="footer__link"><?php the_sub_field('social_media'); ?></a>

                    <?php }  endwhile; ?>

                    </div>
                <?php endif; ?>
                <?php if(!empty(get_field('email_address', 'option'))){ ?>                     
                <div class="link-wrp-2-3">
                    <div class="footer__txt">Email us at</div>
                    <a href="mail:<?php echo get_field('email_address', 'option');?>" class="footer__link"><?php echo get_field('email_address', 'option');?></a>
                <?php   
                $subscribe_title = get_field('subscribe', 'option');                 
                if(!empty($subscribe_title['external_link'])){ ?>
                    <a href="<?php echo $subscribe_title['external_link']['url'] ?>" target="_blank" class="btn--newsletter w-inline-block">
                        <div class="txt-block--1rem">Join newsletter</div>
                    </a><?php
                } ?>                    
                </div>
                <?php } ?>
            </div>
        </div>
    </footer>
</main>
</div><?php
$iframe = get_field('hello_video', 37); 
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
    </div><?php
} ?>

<?php $page_id = get_the_ID(); 
if($page_id == 195){ ?>
    <div class="fixed__filter-menu"><img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="filter-menu__arrow">
        <div class="filter-menu__head">
            <div class="fixed__cta__txt">Use filters</div>
            <div id="filter-reset" class="btn-reset reset-filter">
                <div class="txt-block--1rem">reset</div>
            </div>
            <div class="fixed__cta__txt__close">Close</div>
        </div>
        <div class="filter-menu__cont">
            <div class="filter-itm">
                <div class="filter-itm__head">
                    <div class="filter-itm__type">Country</div>                
                </div>
                <div class="filter-itm__search">
                    <div class="filter-itm__search">
                    <div class="filter-itm__search-results">
                        <div class="search-results">
                            <select class="country-select select for" multiple="multiple" name="countries[]" style="width: 100%" >
                                <option value="Albania">Albania</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Austria">Austria</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="Germany">Germany</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Greece">Greece</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Italy">Italy</option>
                                <option value="Kosovo">Kosovo</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Malta">Malta</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="North Macedonia">North Macedonia</option>
                                <option value="Norway">Norway</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Romania">Romania</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Spain">Spain</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Tunisia">Tunisia</option>                             
                                <option value="Ukraine">Ukraine</option>
                          
                            </select>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="filter-itm">
                <div class="filter-itm__head">
                    <div class="filter-itm__type">Performing arts</div>                
                </div>
                <div class="filter-itm__search"><?php
                    $terms = get_terms( array(
                        'taxonomy'   => 'performing_arts',
                        'hide_empty' => false,
                    ) ); 
                    if(!empty($terms)){ ?>
                        <div class="filter-itm__search-results">
                            <div class="search-results">
                                <select class="performing-arts select for" multiple="multiple" name="performing_arts[]" style="width: 100%" ><?php
                                    foreach($terms as $term){ ?>
                                        <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option><?php
                                    } ?>
                                </select>
                            </div>
                        </div><?php
                    } ?>
                </div>
            </div>
            <div class="filter-itm">
                <div class="filter-itm__head">
                    <div class="filter-itm__type">Topics covered</div>                
                </div>
                <div class="filter-itm__search"><?php
                    $terms = get_terms( array(
                        'taxonomy'   => 'topics_covered',
                        'hide_empty' => false,
                    ) ); 
                    if(!empty($terms)){ ?>
                        <div class="filter-itm__search-results">
                            <div class="search-results">
                                <select class="topics-covered select for" multiple="multiple" name="topics_covered[]" style="width: 100%" ><?php
                                    foreach($terms as $term){ ?>
                                        <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option><?php
                                    } ?>
                                </select>
                            </div>
                        </div><?php
                    } ?>
                </div>
                <div class="filter-itm__selected" style="display:none;">
                    <div class="selected-itm">
                        <div class="selected-itm__remove"></div>
                        <div class="selected-itm__txt"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter-menu__open"></div>
    </div><?php 
} 

else if($page_id == 197){ ?>
    <div class="fixed__filter-menu">
        <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="filter-menu__arrow">
        <div class="filter-menu__head">
                <div class="fixed__cta__txt">Use filters</div>
                <div id="filter-reset" class="btn-reset reset-filter">
                    <div class="txt-block--1rem">reset</div>
                </div>
                <div class="fixed__cta__txt__close">Close</div>
            </div>
        <div class="filter-menu__cont">
            <div class="filter-itm">
                <div class="filter-itm__head">
                    <div class="filter-itm__type">Country</div>
                   <!--  <div class="filter-itm__order">Any<span class="txt-space"> </span>↓</div> -->
                </div>
                <div class="filter-itm__search">
                    <div class="filter-itm__search-results">
                        <div class="search-results">
                            <select class="country-select select for" multiple="multiple" name="countries[]" style="width: 100%" >
                                <option value="Albania">Albania</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Austria">Austria</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="Germany">Germany</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Greece">Greece</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Italy">Italy</option>
                                <option value="Kosovo">Kosovo</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Malta">Malta</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="North Macedonia">North Macedonia</option>
                                <option value="Norway">Norway</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Romania">Romania</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Spain">Spain</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Tunisia">Tunisia</option>
                               
                                <option value="Ukraine">Ukraine</option>
                            
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter-itm">
                <div class="filter-itm__head">
                    <div class="filter-itm__type">Performing arts</div>
                   <!--  <div class="filter-itm__order">Any<span class="txt-space"> </span>↓</div> -->
                </div>
                <div class="filter-itm__search"><?php
                    $terms = get_terms( array(
                        'taxonomy'   => 'performing_arts',
                        'hide_empty' => false,
                    ) ); 
                    if(!empty($terms)){ ?>
                        <div class="filter-itm__search-results">
                            <div class="search-results">
                                <select class="performing-arts select for" multiple="multiple" name="performing_arts[]" style="width: 100%" ><?php
                                    foreach($terms as $term){ ?>
                                        <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option><?php
                                    } ?>
                                </select>
                            </div>
                        </div><?php
                    } ?>
                </div>
            </div>
            <div class="filter-itm">
                <div class="filter-itm__head">
                    <div class="filter-itm__type">Topics covered</div>
                   <!--  <div class="filter-itm__order">Any<span class="txt-space"> </span>↓</div> -->
                </div>
                <div class="filter-itm__search"><?php
                    $terms = get_terms( array(
                        'taxonomy'   => 'topics_covered',
                        'hide_empty' => false,
                    ) ); 
                    if(!empty($terms)){ ?>
                        <div class="filter-itm__search-results">
                            <div class="search-results">
                                <select class="topics-covered select for" multiple="multiple" name="topics_covered[]" style="width: 100%" ><?php
                                    foreach($terms as $term){ ?>
                                        <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option><?php
                                    } ?>
                                </select>
                            </div>
                        </div><?php
                    } ?>
                </div>
                <div class="filter-itm__selected" style="display:none;">
                    <div class="selected-itm">
                        <div class="selected-itm__remove"></div>
                        <div class="selected-itm__txt"></div>
                    </div>
                </div>
            </div>        
        </div>
        <div class="filter-menu__open"></div>
    </div><?php
} 
else if($page_id == 1020){ ?>
    <div class="fixed__filter-menu">
        <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/arrow-btn.svg" alt="" class="filter-menu__arrow">
        <div class="filter-menu__head">
            <div class="fixed__cta__txt">Use filters<span class="filter-menu--extra__txt"> and Quick match</span></div>
            <div id="filter-reset" class="btn-reset reset-filter">
                <div class="txt-block--1rem">reset</div>
            </div>
            <div class="fixed__cta__txt__close">Close</div>
        </div>
        <div class="filter-menu__cont">
            <div class="filter-itm">
                <div class="filter-itm__head">
                    <div class="filter-itm__type">Country</div>
                   <!--  <div class="filter-itm__order">Any<span class="txt-space"> </span>↓</div> -->
                </div>
                <div class="filter-itm__search">
                    <div class="filter-itm__search-results">
                        <div class="search-results">
                            <select class="country-select select for" multiple="multiple" name="countries[]" style="width: 100%" >
                                <option value="Albania">Albania</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Austria">Austria</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="Germany">Germany</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Greece">Greece</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Italy">Italy</option>
                                <option value="Kosovo">Kosovo</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Malta">Malta</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="North Macedonia">North Macedonia</option>
                                <option value="Norway">Norway</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Romania">Romania</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Spain">Spain</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Tunisia">Tunisia</option>
                              
                                <option value="Ukraine">Ukraine</option>
                             
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter-itm">
                <div class="filter-itm__head">
                    <div class="filter-itm__type">Performing arts</div>
                   <!--  <div class="filter-itm__order">Any<span class="txt-space"> </span>↓</div> -->
                </div>
                <div class="filter-itm__search"> 
                        <div class="filter-itm__search-results">
                            <div class="search-results">
                                <select class="performing-arts select for" name="performing_arts[]" style="width: 100%" >
									<option value="Any">Any</option>
                                    <option value="Circus">Circus</option>
									<option value="Dance">Dance</option>
									<option value="Mime">Mime</option>
									<option value="Music Theatre">Music Theatre</option>
									<option value="New technologies">New technologies</option>
									<option value="Other">Other</option>
									<option value="Performance Art">Performance Art</option>
									<option value="Physical Theatre">Physical Theatre</option>
									<option value="Playwriting">Playwriting</option>
									<option value="Puppetry / Object Theatre">Puppetry / Object Theatre</option>
									<option value="Site specific work">Site specific work</option>
									<option value="Street arts">Street arts</option>
									<option value="Theatre">Theatre</option>
									<option value="Youth Theatre">Youth Theatre</option>
                                </select>
                            </div>
                        </div> 
                </div>
            </div>
            <div class="filter-itm">
                <div class="filter-itm__head">
                    <div class="filter-itm__type">Topics covered</div>
                   <!--  <div class="filter-itm__order">Any<span class="txt-space"> </span>↓</div> -->
                </div>
                <div class="filter-itm__search">
                        <div class="filter-itm__search-results">
                            <div class="search-results">
                               <select class="topics-covered select for"  name="topics_covered[]" style="width: 100%" >															  					   <option value="Any">Any</option>
								   <option value="Activism">Activism</option>
								   <option value="Advocacy">Advocacy</option>
								   <option value="Artistic freedom">Artistic freedom</option>
								   <option value="Artistic development">Artistic development</option>
								   <option value="Audience development">Audience development</option>
								   <option value="Business models">Business models</option>
								   <option value="Climate justice">Climate justice</option>
								   <option value="Conflict">Conflict</option>
								   <option value="Cross-sectoral collaboration">Cross-sectoral collaboration</option>
								   <option value="Decolonisation">Decolonisation</option>
								   <option value="Disability">Disability</option>
								   <option value="Education">Education</option>
								   <option value="Environment">Environment</option>
								   <option value="Equity and Equality">Equity and Equality</option>
								   <option value="Diversity">Diversity</option>
								   <option value="Feminism">Feminism</option>
								   <option value="Freedom of expression">Freedom of expression</option>
								   <option value="Gender">Gender</option>
								   <option value="Globalisation">Globalisation</option>
								   <option value="Heritage">Heritage</option>
								   <option value="Human rights">Human rights</option>
								   <option value="Identity">Identity</option>
								   <option value="Inclusion">Inclusion</option>
								   <option value="LGBTQIA+">LGBTQIA+</option>
								   <option value="Mental health">Mental health</option>
								   <option value="Migration">Migration</option>
								   <option value="Mobility">Mobility</option>
								   <option value="New technologies">New technologies</option>
								   <option value="Refugees">Refugees</option>
								   <option value="Rural context">Rural context</option>
								   <option value="Status of the Artist">Status of the Artist</option>
								   <option value="Social justice">Social justice</option>
								   <option value="Sustainability">Sustainability</option>
								   <option value="Urbanism">Urbanism</option>
								   <option value="Working conditions">Working conditions</option>
								   <option value="Youth">Youth</option>
								   <option value="Elderly">Elderly</option>
								   <option value="Other">Other</option>								 
                                </select>
                            </div>
                        </div> 
                </div>
                <div class="filter-itm__selected" style="display:none;">
                    <div class="selected-itm">
                        <div class="selected-itm__remove"></div>
                        <div class="selected-itm__txt"></div>
                    </div>
                </div>
            </div>        
        </div>
        <p class="filter-menu__paragraph"><span class="paragraph__subtitle--2">Quick Match</span></p>
        <p><?php echo get_field('quick_match_description','option');?></p>
        <div class="filter-menu__open"></div>
    </div><?php
} ?>
<div class="cookie-banner">
    <div class="txt-2rem">
        We use third-party <a href="/privacy#cookie-section" target="_blank"
            class="txt-link-underline txt-black">cookies</a>
        in order to personalize your experience
    </div>
    <div class="btn-wrp">
        <a id="cookie-accept" href="#" class="btn-black w-inline-block">
            <div class="txt-block-1rem">accept</div>
        </a>
        <a href="#" id="cookie-decline" class="txt-link txt-up txt-black txt-100">Decline</a>
    </div>
</div>

<div class="cursor-wrp hide">
    <div class="custom-cursor">
        <div class="cursor-btn">
            <div class="txt-block-1rem">learn more</div>
            <div class="btn-icon"></div>
        </div>
    </div>
</div>
<script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=64ecbdf64d19097aeaa7b60d" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/ScrollTrigger.min.js"></script>
<?php
wp_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/ScrollTrigger.min.js"></script>
<script src="<?php echo site_url();?>/wp-content/themes/perform-europe/assets/js/scrollsmoother.js" type="text/javascript"></script>
<script>
// Init Scroolsmoother Effect -->
gsap.registerPlugin(ScrollTrigger, ScrollSmoother);
let smoother = ScrollSmoother.create({
    smooth: 1.5
});
smoother.effects(".card-wrp", {speed: 0.9, lag: 0});
smoother.effects(".l__img.bottom-left", {speed: 0.95, lag: 0});
smoother.effects(".l__img.bottom-right", {speed: 0.98, lag: 0});
smoother.effects(".l__img.top-right", {speed: 1.09, lag: 0});
gsap.to(".marquee__txt", {
    marginLeft: "-30vw", 
    scrollTrigger: {
        trigger: ".marquee__txt", // Element that triggers the animation
        start: "top bottom", // Start the animation when the top of the trigger element hits the center of the viewport
        end: "bottom top", // End the animation when the bottom of the trigger element hits the center of the viewport
        scrub: 1, // Enables scrubbing for smooth scrolling
    },
});   
</script><?php 
if($page_id == 43)
{ ?>
    <script>
        // Init Scroolsmoother Effect -->
        // Init Scroolsmoother Effect -->  
        smoother.effects(".land__img", {speed: 0.85, lag: 0});
        gsap.utils.toArray(".site-menu a").forEach(function (button, i) {
            button.addEventListener("click", (e) => {
                var id = e.target.getAttribute("href");
                console.log(id);
                smoother.scrollTo(id, true, "top top");
                e.preventDefault();
            });
        });
        // to view navigate to -  
        window.onload = (event) => {
            console.log("page is fully loaded");

            let urlHash = window.location.href.split("#")[1];

            let scrollElem = document.querySelector("#" + urlHash);

            console.log(scrollElem, urlHash);

            if (urlHash && scrollElem) {
                gsap.to(smoother, {
                    scrollTop: smoother.offset(scrollElem, "top top"),
                    duration: 1,
                    delay: 0
                });
            }
        };
    </script><?php 
} 
if($page_id == 1086)
{ ?>
    <script>
        // Init Scroolsmoother Effect -->
        gsap.registerPlugin(ScrollTrigger, ScrollSmoother);
        let smoother = ScrollSmoother.create({
            smooth: 1.5
        });
        smoother.effects(".profile__img--large", {speed: 0.85, lag: 0});
    </script><?php
} ?>
</body>
</html>