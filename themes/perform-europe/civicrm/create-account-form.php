<?php
/**
 * Create Account form
 */

get_header();


?>


<section class="section-wrp s-login">
    <div class="page-content-wrp">
        <div class="page__title-wrp">
            <h1 class="page__title"><?php echo get_field('create_an_account_form_heading','option');?></h1>
        </div>
    </div>
</section>
<section class="section-wrp s-login-form">

    <?php
        if (isset($_SESSION['civicrm_theme_notices']) && $_SESSION['civicrm_theme_notices']) {
            if (isset($_SESSION['civicrm_theme_notices']['type']) && $_SESSION['civicrm_theme_notices']['type'] == 'error') { ?>
                <div style="color: red;"><?php echo $_SESSION['civicrm_theme_notices']['message']; ?></div>
        <?php }
        }
    ?>  

    <div class="create-account-wrp">
        <form class="create-account__form" method="POST" action="<?php echo site_url(); ?>/wp-admin/admin-post.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="muyadev_save_partner_front"/>
            <div class="form">
                <div class="form__title">
                    <h3 class="txt--h2"><?php echo get_field('create_an_account_form_sub_heading','option');?></h3>
                    <?php echo get_field('create_an_account_form_description','option');?>
                </div>
                <div class="form__itm-wrp">
                    <div class="form__itm-i">
                        <div class="form__txt-i">My first name</div>
                        <input class="form__input" name="first_name" type="text" placeholder="">
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm-i">
                        <div class="form__txt-i">My last name</div>
                        <input class="form__input" name="last_name" type="text" placeholder="">
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm-i">
                        <div class="form__txt-i">My job title</div>
                        <input class="form__input" name="jobtitle" type="text" placeholder="">
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm-i">
                        <div class="form__txt-i">My Email</div>
                        <input class="form__input" name="email" type="email" placeholder="">
                        <div class="form__required">*</div>
                    </div>

                    <div class="form__radio--margin">
                        <div class="check-box is--checked"></div>
                        <div class="form__txt--small">This is the email I want to receive the notifications to.*
                        </div>
                    </div>
                    <div class="form__itm">
                        <input class="form__input" name="confirmemail" type="email" placeholder="Confirm Email">
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm">
                        <input class="form__input" name="password" type="text" placeholder="Password">
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm">
                        <input class="form__input" name="confirmpassword" type="text" placeholder="Confirm Password">
                        <div class="form__required">*</div>
                    </div>
                </div>
            </div>
            <div class="form sticky">
                <div class="form__title">
                    <h3 class="txt--h2"><?php echo get_field('organization_freelancer_heading','option');?></h3>
                </div>
                <div class="form__itm-wrp">
                    <div class="form__itm__upload">
                        <div class="form__txt">Cover Picture</div>

                        <input type="file" name="cover" id="cover">                        
                        <!-- <a href="#" class="btn--black w-inline-block">
                            <div class="txt-block--1rem">upload</div>
                        </a> -->
                        <div id="w-node-_13ae074b-aa62-2da1-90a9-f43f0b7a7769-a709e52f" class="upload__txt-wrp">
                            <div class="txt-block">A real-life picture that best describes your activity.</div>
                            <div class="txt--50">.png or .jpg (max. 500kb)</div>
                        </div>
                        <!-- <div id="w-node-_0b4cbac9-551a-8e06-8e92-90d4a5e696ae-a709e52f" class="upload__txt-wrp">
                            <div class="txt--50">loremipsumfilename_123654.jpg uploaded</div>
                            <div class="txt__link--black">remove</div>
                        </div> -->
                    </div>
                    <div class="form__itm">
                        <select class="form__select" name="accounttype">
                            <option value="I am an Organization">I am a organization</option>
                            <option value="I am a Person">I am a person</option>
                        </select>
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm">
                        <input class="form__input" name="orgname" type="text" placeholder="Organization name">
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm">
                        <select class="form__select" name="country">
                            <option value="">Select a country</option>                            
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
                            <option value="1082">Germany</option>    
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
                            <option value="Poland" >Poland</option>  
                            <option value="Portugal">Portugal</option>  
                            <option value="Romania">Romania</option>  
                            <option value="Serbia">Serbia</option>  
                            <option value="Slovakia">Slovakia</option>  
                            <option value="Slovenia">Slovenia</option>  
                            <option value="Spain">Spain</option>  
                            <option value="Sweden">Sweden</option>  
                            <option value="Tunisia">Tunisia</option>  
                            <option value="Turkey">Turkey</option>  
                            <option value="Ukraine">Ukraine</option>   
                        </select>
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm">
                        <input class="form__input" name="city" type="text" placeholder="Your city">
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__subtitle--margin">Short description</div>
                    <div class="form__itm__large">
                        <div class="form__itm__large__txt">
                            <div class="txt-block">Who are you and what are you looking for?</div>
                            <div class="txt--50">Example: Festival X is an outdoor circus festival focused on
                                sustainability based in Slovenia (...). We are looking for new partnerships, to
                                expand our contacts, specifically to enrich the programme of our next edition
                                with emerging artists. We are exploring new ideas to make our festival more
                                inclusive.</div>
                        </div>
                        <div class="form__itm--top">
                            <textarea name="shortdesc" class="form__input__area" rows="4" placeholder="Type your text here"></textarea>
                            <div class="form__required">*</div>
                        </div>
                    </div>
                    <div class="form__itm__large">
                        <div class="form__itm__large__txt">
                            <div class="txt-block">Summarize it one line what you offer (Your offer):</div>
                            <div class="txt--50">Example: A platform for circus artists and companies, both
                                emerging and established ones, to showcase their works during our festival in
                                Slovenia.</div>
                        </div>
                        <div class="form__itm--top">
                            <textarea class="form__input__area" rows="4" name="youroffer"
                                placeholder="Type your text here (max. 280 characters)"></textarea>
                            <div class="form__required">*</div>
                        </div>
                    </div>
                    <div class="form__itm__large">
                        <div class="form__itm__large__txt">
                            <div class="txt-block">Summarize it one line what you’re looking for (Your needs):
                            </div>
                            <div class="txt--50">Example: Emerging circus artists or companies interested in the
                                next edition of our festival, collaborations with other venues or festivals with
                                similar values.</div>
                        </div>
                        <div class="form__itm--top">
                            <textarea class="form__input__area" rows="4" name="yourneeds"
                                placeholder="Type your text here (max. 280 characters)"></textarea>
                            <div class="form__required">*</div>
                        </div>
                    </div>
                </div>
                <div id="w-node-_0246cced-2d63-c13d-409b-a2b5454abf90-a709e52f" class="form__preview-wrp">
                    <div id="w-node-ec3cd385-1cfd-6c73-3ee1-fbaf59f0f91c-a709e52f" class="form__preview">
                        <div class="txt-block">This is how your profile will look like:</div><img
                            src="https://uploads-ssl.webflow.com/64ecbdf64d19097aeaa7b60d/650185e68e222f81a7159f0a_profile.svg"
                            loading="lazy" alt="" class="form__preview__img">
                    </div>
                </div>
            </div>
            <div class="form">
                <div class="form__title">
                    <h3 class="txt--h2"><?php echo get_field('activities_heading','option');?></h3>
                </div>
                <div class="form__itm-wrp">
                    <div class="form__subtitle">Type</div>
                    <div class="form__itm__filter">
                        <div class="form__itm__filter-cont">
                            <div class="form-filter-itm">
                                <div class="form-filter-itm__head">
                                    <div class="filter-itm__type">Type</div>
                                    <div class="form-filter-itm__order">Any<span class="txt-space"> </span><span
                                            class="txt__arrow">↓</span></div>
                                </div>
                                <div class="form-filter-wrp hide">
                                    <div class="form-filter-itm__search">
                                        <div class="filter-itm__searchbar">
                                            <input class="searchbar__txt" type="text" placeholder="search something">
                                        </div>
                                        <div class="filter-itm__search-results">
                                            <div class="search-results">
                                                <div class="search-result__itm filter--focoused">Romania</div>
                                                <div class="search-result__itm">Romania</div>
                                                <div class="search-result__itm">Romania</div>
                                                <div class="search-result__itm">Romania</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-itm__selected">
                                        <div class="selected-itm">
                                            <div class="selected-itm__remove"></div>
                                            <div class="selected-itm__txt">Venue</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-filter-itm">
                                <div class="form-filter-itm__head">
                                    <div class="filter-itm__type">Performing arts</div>
                                    <div class="form-filter-itm__order">Any<span class="txt-space"> </span><span
                                            class="txt__arrow">↓</span></div>
                                </div>
                                <div class="form-filter-wrp hide">
                                    <div class="form-filter-itm__search">
                                        <div class="filter-itm__searchbar">
                                            <input class="searchbar__txt" type="text" placeholder="search something">
                                        </div>
                                        <div class="filter-itm__search-results">
                                            <div class="search-results">
                                                <div class="search-result__itm filter--focoused">Romania</div>
                                                <div class="search-result__itm">Romania</div>
                                                <div class="search-result__itm">Romania</div>
                                                <div class="search-result__itm">Romania</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-itm__selected">
                                        <div class="selected-itm">
                                            <div class="selected-itm__remove"></div>
                                            <div class="selected-itm__txt">Dance</div>
                                        </div>
                                        <div class="selected-itm">
                                            <div class="selected-itm__remove"></div>
                                            <div class="selected-itm__txt">Dance</div>
                                        </div>
                                        <div class="selected-itm">
                                            <div class="selected-itm__remove"></div>
                                            <div class="selected-itm__txt">Dance</div>
                                        </div>
                                        <div class="selected-itm">
                                            <div class="selected-itm__remove"></div>
                                            <div class="selected-itm__txt">Dance</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-filter-itm">
                                <div class="form-filter-itm__head">
                                    <div class="filter-itm__type">Topics covered</div>
                                    <div class="form-filter-itm__order">Any<span class="txt-space"> </span><span
                                            class="txt__arrow">↓</span></div>
                                </div>
                                <div class="form-filter-wrp hide">
                                    <div class="form-filter-itm__search">
                                        <div class="filter-itm__searchbar">
                                            <input class="searchbar__txt" type="text" placeholder="search something">
                                        </div>
                                        <div class="filter-itm__search-results">
                                            <div class="search-results">
                                                <div class="search-result__itm filter--focoused">Romania</div>
                                                <div class="search-result__itm">Romania</div>
                                                <div class="search-result__itm">Romania</div>
                                                <div class="search-result__itm">Romania</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-itm__selected">
                                        <div class="selected-itm">
                                            <div class="selected-itm__remove"></div>
                                            <div class="selected-itm__txt">LGTBQIA+</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form__subtitle">Offer</div>
                    <div class="form__itm__complex">
                        <div class="form__radio">
                            <div class="check-box is--checked"></div>
                            <div class="form__txt--small">Productions</div>
                        </div>
                        <div class="form__itm__complex-cont">
                            <p class="paragraph--15rem">List and describe your productions that you want to list
                                in your Perform Europe profile.</p>
                            <div class="form__itm__complex__input">
                                <div class="form__itm--25rem">
                                    <input class="form__input" type="text" placeholder="Production name">
                                    <div class="form__required">*</div>
                                </div>
                                <div class="form__itm--top">
                                    <textarea class="form__input__area" rows="4"
                                        placeholder="Type your text here (max. 280 characters)"></textarea>
                                    <div class="form__required">*</div>
                                </div>

                                <div class="form__itm--25rem">
                                    <input class="form__input" type="text" placeholder="Production name">
                                    <div class="form__required">*</div>
                                </div>
                                <div class="form__itm--top">
                                    <textarea class="form__input__area" rows="4"
                                        placeholder="Type your text here (max. 280 characters)"></textarea>
                                    <div class="form__required">*</div>
                                </div>

                                <div class="form__itm--25rem">
                                    <input class="form__input" type="text" placeholder="Production name">
                                    <div class="form__required">*</div>
                                </div>
                                <div class="form__itm--top">
                                    <textarea class="form__input__area" rows="4"
                                        placeholder="Type your text here (max. 280 characters)"></textarea>
                                    <div class="form__required">*</div>
                                </div>

                                <div class="form__itm--25rem">
                                    <input class="form__input" type="text" placeholder="Production name">
                                    <div class="form__required">*</div>
                                </div>
                                <div class="form__itm--top">
                                    <textarea class="form__input__area" rows="4"
                                        placeholder="Type your text here (max. 280 characters)"></textarea>
                                    <div class="form__required">*</div>
                                </div>

                                <a href="#" class="btn-transparent--dark w-inline-block" style="display: none;">
                                    <div class="txt-block--1rem">+ add production</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form__itm__complex">
                        <div class="form__radio">
                            <div class="check-box is--checked"></div>
                            <div class="form__txt--small">Touring opportunities</div>
                        </div>
                        <div class="form__itm__complex-cont">
                            <p class="paragraph--15rem">List and describe the touring opportunities you want to
                                list in your Perform Europe profile. These can be a venue, a residency, a
                                festival etc.</p>
                            <div class="form__itm__complex__input">
                                <div class="form__itm--25rem">
                                    <input class="form__input" type="text" placeholder="Production name">
                                    <div class="form__required">*</div>
                                </div>
                                <div class="form__itm--top">
                                    <textarea class="form__input__area" rows="4"
                                        placeholder="Type your text here (max. 280 characters)"></textarea>
                                    <div class="form__required">*</div>
                                </div>

                                <div class="form__itm--25rem">
                                    <input class="form__input" type="text" placeholder="Production name">
                                    <div class="form__required">*</div>
                                </div>
                                <div class="form__itm--top">
                                    <textarea class="form__input__area" rows="4"
                                        placeholder="Type your text here (max. 280 characters)"></textarea>
                                    <div class="form__required">*</div>
                                </div>

                                <div class="form__itm--25rem">
                                    <input class="form__input" type="text" placeholder="Production name">
                                    <div class="form__required">*</div>
                                </div>
                                <div class="form__itm--top">
                                    <textarea class="form__input__area" rows="4"
                                        placeholder="Type your text here (max. 280 characters)"></textarea>
                                    <div class="form__required">*</div>
                                </div>

                                <div class="form__itm--25rem">
                                    <input class="form__input" type="text" placeholder="Production name">
                                    <div class="form__required">*</div>
                                </div>
                                <div class="form__itm--top">
                                    <textarea class="form__input__area" rows="4"
                                        placeholder="Type your text here (max. 280 characters)"></textarea>
                                    <div class="form__required">*</div>
                                </div>

                                <div class="form__itm--25rem">
                                    <input class="form__input" type="text" placeholder="Production name">
                                    <div class="form__required">*</div>
                                </div>
                                <div class="form__itm--top">
                                    <textarea class="form__input__area" rows="4"
                                        placeholder="Type your text here (max. 280 characters)"></textarea>
                                    <div class="form__required">*</div>
                                </div>

                                <div class="form__itm--25rem">
                                    <input class="form__input" type="text" placeholder="Production name">
                                    <div class="form__required">*</div>
                                </div>
                                <div class="form__itm--top">
                                    <textarea class="form__input__area" rows="4"
                                        placeholder="Type your text here (max. 280 characters)"></textarea>
                                    <div class="form__required">*</div>
                                </div>
                                <a href="#" class="btn-transparent--dark w-inline-block" style="display:none;">
                                    <div class="txt-block--1rem">+ add venue</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form__submit-wrp">
                <div class="btn-wrp">
                    <div class="form__radio">
                        <div class="check-box is--checked"></div>
                        <div class="form__txt--small">I have read the <a href="/terms"
                                class="paragraph__link--black">Terms &amp; Conditions</a></div>
                    </div>
                    <div class="btn-large">
                        <input class="btn__submit" type="submit">
                        <div class="btn__txt">create an account</div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


<?php
get_footer();?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("body").addClass('pe-body--mint');
        jQuery(".footer").addClass('footer--dark');
    });
</script>