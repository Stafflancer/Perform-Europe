<?php
/**
 * Create Account form
 */

$current_user = wp_get_current_user();

$firstname = $current_user->first_name;
$lastname = $current_user->last_name;
$email = $current_user->user_email;

try {
    $cividata = civicrm_api3('Contact', 'getsingle', array(
        'email' => $email,
        'return' => [
            'id',
            'job_title',
            'nick_name',
            'contact_type',
            'custom_8',
            'custom_2',
            'custom_3',
            'custom_10',
            'custom_5',
            'custom_6',
            'custom_7',
            'custom_11',
            'custom_12'
            //default data
        ],
    ));

    $coverimage = 'https://uploads-ssl.webflow.com/64ecbdf64d19097aeaa7b60d/650857e72272bf8f15ae7a86_fc6c5c82cfde94edf6fda6d0e94ea79f.png';

    if (isset($cividata['custom_8']) && $cividata['custom_8']) {
        $cover = civicrm_api3('Attachment', 'getsingle', [
            'id' => $cividata['custom_8'],
        ]);

        if (isset($cover['url']) && $cover['url']) {
            $coverimage = $cover['url'];
        }
    }

    $countryname = 'Kenya';

    if (isset($cividata['custom_12']) && $cividata['custom_12']) {
        switch ($cividata['custom_12']) {
            case 1082:
                $countryname = 'Germany';
                break;

            case 1157:
                $countryname = 'Nigeria';
                break;

            case 1101:
                $countryname = 'India';
                break;
            
            default:
                $countryname = 'Kenya';
                break;
        }
    }

    //dd($cividata);
    
} catch (\Throwable $th) {}

get_header();

?>


<section class="section-wrp s-login">
    <div class="page-content-wrp">
        <div class="page__title-wrp">
            <h1 class="page__title">Edit my account</h1>
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
            <input type="hidden" name="action" value="muyadev_edit_user_front"/>
            <input type="hidden" name="wordpressid" value="<?php echo $current_user->ID;  ?>"/>
            <input type="hidden" name="civicrmid" value="<?php echo $cividata['id'] ?? '';  ?>"/>
            <div class="form">
                <div class="form__title">
                    <h3 class="txt--h2">Main contact</h3>
                    <p class="account__paragraph">Your main contact person will be the person receiving all the
                        Perform Europe notifications and information. Their full name, pronouns, job title and
                        email address will only be made public to profiles with whom you’ve had a match.</p>
                </div>
                <div class="form__itm-wrp">
                    <div class="form__itm-i">
                        <div class="form__txt-i">My first name</div>
                        <input class="form__input" name="first_name" value="<?php echo $firstname ?? '';  ?>" type="text" placeholder="">
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm-i">
                        <div class="form__txt-i">My last name</div>
                        <input class="form__input" name="last_name" value="<?php echo $lastname ?? '';  ?>" type="text" placeholder="">
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm-i">
                        <div class="form__txt-i">My job title</div>
                        <input class="form__input" name="jobtitle" value="<?php echo $cividata['job_title'] ?? ''; ?>" type="text" placeholder="">
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm-i">
                        <div class="form__txt-i">My Email</div>
                        <input class="form__input" name="email" readonly value="<?php echo $email;  ?>" type="email" placeholder="">
                        <div class="form__required">*</div>
                    </div>

                </div>
            </div>
            <div class="form sticky">
                <div class="form__title">
                    <h3 class="txt--h2">Organization/ Freelancer</h3>
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
                            <option <?php $cividata['custom_2'] == 'I am an Organization' ? 'I am an Organization' : '' ?> value="I am an Organization">I am a organization</option>
                            <option <?php $cividata['custom_2'] == 'I am a Person' ? 'I am a Person' : '' ?> value="I am a Person">I am a person</option>
                        </select>
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm">
                        <input class="form__input" name="orgname" value="<?php echo $cividata['custom_3'] ?? '';  ?>" type="text" placeholder="Organization name">
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm">
                        <select class="form__select" name="country">
                            <option value="">Select a country</option>
                            <option <?php echo $cividata['custom_12'] == '1082' ? 'selected' : '' ?> value="1082">Germany</option>
                            <option <?php echo $cividata['custom_12'] == '1112' ? 'selected' : '' ?> value="1112">Kenya</option>
                            <option <?php echo $cividata['custom_12'] == '1157' ? 'selected' : '' ?> value="1157">Nigeria</option>
                            <option <?php echo $cividata['custom_12'] == '1101' ? 'selected' : '' ?> value="1101">India</option>
                        </select>
                        <div class="form__required">*</div>
                    </div>
                    <div class="form__itm">
                        <input class="form__input" name="city" value="<?php echo $cividata['custom_5'] ?? '';  ?>" type="text" placeholder="Your city">
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
                            <textarea name="shortdesc" class="form__input__area" rows="4" placeholder="Type your text here"><?php echo $cividata['custom_6'] ?? '';  ?></textarea>
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
                                placeholder="Type your text here (max. 280 characters)"><?php echo $cividata['custom_7'] ?? '';  ?></textarea>
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
                                placeholder="Type your text here (max. 280 characters)"><?php echo $cividata['custom_11'] ?? '';  ?></textarea>
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
                    <h3 class="txt--h2">Activities</h3>
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
                                </div><a href="#" class="btn-transparent--dark w-inline-block">
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
                                </div><a href="#" class="btn-transparent--dark w-inline-block">
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
get_footer(); ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("body").addClass('pe-body--mint');
        jQuery(".footer").addClass('footer--dark');
    });
</script>