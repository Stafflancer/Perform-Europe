<?php
/**
 * Profile
 */

get_header();


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
    
} catch (\Throwable $th) {}

?>
<section class="section-wrp s-profile-first"><a href="/user/partners/" class="btn--transparent w-inline-block">
        <div class="txt-block--1rem">more partners</div>
    </a>
    <h1 class="page__title">Teren</h1>
    <h3 class="page__subtitle"><?php echo $cividata['custom_5'] ?? ''; ?>, <?php echo $countryname; ?></h3>
    <div class="profile__gradient"></div><img
        src="<?php echo $coverimage; ?>"
        loading="eager" sizes="100vw"
        alt="" class="profile__img--large" data-savee-read="true">
</section>
<section class="section-wrp s-profile-cont">
    <div class="contact__card">
        <h2 class="contact__title">Main contact</h2>
        <div class="contact__cont">
            <div id="w-node-f12c6a42-82d1-3833-cdc5-3183de4864a0-eaa7b610" class="txt--50">First name</div>
            <div id="w-node-_4c584b2d-ceeb-0347-4563-e76a3d1c6d1c-eaa7b610" class="contact__txt"><?php echo $firstname; ?></div>
            <div id="w-node-_25b55a23-e3a1-3790-2883-4fbabf2bddaa-eaa7b610" class="txt--50">Last name</div>
            <div id="w-node-_7da1bc62-71b7-9889-b8ba-27bd893782e2-eaa7b610" class="contact__txt"><?php echo $lastname; ?></div>
            <div id="w-node-cde51876-eeea-72a1-eb71-0cc5e0b3e8e6-eaa7b610" class="txt--50">Pronouns</div>
            <div id="w-node-_409def6e-6945-7491-1358-b3d561f48cfd-eaa7b610" class="contact__txt">He/him</div>
            <div id="w-node-_75df46e6-519b-8e81-6d8e-95d20c3dcf3c-eaa7b610" class="txt--50">Job title</div>
            <div id="w-node-edbb892d-c20a-c6e8-e1d7-0ac9d6f3cde7-eaa7b610" class="contact__txt"><?php echo $cividata['job_title'] ?? ''; ?></div>
            <div id="w-node-_9ab6c798-6186-e2b2-f2c1-588b2cc2a21c-eaa7b610" class="txt--50">Email</div>
            <div id="w-node-_12b1bc94-6974-3f4c-7d81-62ffdd66eced-eaa7b610" class="contact__txt"><?php echo $email; ?></div>
            <div id="w-node-_799383c1-b9ff-44fb-4d92-9c1fc41ae660-eaa7b610" class="txt--50">Website/Social media
            </div>
            <div id="w-node-_18ab124a-4ffa-1c70-71b1-f4031a129d3b-eaa7b610" class="contact__txt">doe.com</div>
        </div>
        <div class="contact__cta">
            <div class="star__icon"></div>
            <div class="btn--send"><img
                    src="https://uploads-ssl.webflow.com/64ecbdf64d19097aeaa7b60d/65085c898ba81eec461f0fba_Vector%20(1).svg"
                    loading="lazy" alt="" class="send__icon">
                <div class="txt-block">send</div>
            </div>
        </div>
    </div>
    <div class="profile__desrc">
        <p id="w-node-dfdc8035-6611-c5e5-af55-be3829234b5a-eaa7b610" class="descr__paragraph"><?php echo $cividata['custom_6'] ?? ''; ?></p>
        <div id="w-node-a3aff3d3-9355-d8b4-7516-cf9bec708b5e-eaa7b610" class="desrc__itm">
            <div class="desrc__head">Offer</div>
            <p class="paragraph"><?php echo $cividata['custom_7'] ?? ''; ?></p>
        </div>
        <div id="w-node-_2313233f-2589-703f-26f8-039797616b55-eaa7b610" class="desrc__itm">
            <div class="desrc__head">Needs</div>
            <p class="paragraph"><?php echo $cividata['custom_11'] ?? ''; ?></p>
        </div>
    </div>
     <div class="profile__activities">
                <h2 class="activities__title">Activities</h2>
                <div class="activities-wrp">
                    <div class="type-wrp">
                        <div class="type__itm">
                            <div class="profile__subtitle">Type</div>
                            <div class="type__selected">
                                <div class="selected-itm">
                                    <div class="selected-itm__remove"></div>
                                    <div class="selected-itm__txt">Venue</div>
                                </div>
                                <div class="selected-itm">
                                    <div class="selected-itm__remove"></div>
                                    <div class="selected-itm__txt">Festival</div>
                                </div>
                                <div class="selected-itm">
                                    <div class="selected-itm__remove"></div>
                                    <div class="selected-itm__txt">Performing</div>
                                </div>
                            </div>
                        </div>
                        <div class="type__itm">
                            <div class="profile__subtitle">Performing arts</div>
                            <div class="type__selected">
                                <div class="selected-itm">
                                    <div class="selected-itm__remove"></div>
                                    <div class="selected-itm__txt">Venue</div>
                                </div>
                                <div class="selected-itm">
                                    <div class="selected-itm__remove"></div>
                                    <div class="selected-itm__txt">Festival</div>
                                </div>
                            </div>
                        </div>
                        <div class="type__itm">
                            <div class="profile__subtitle">Topics covered</div>
                            <div class="type__selected">
                                <div class="selected-itm">
                                    <div class="selected-itm__remove"></div>
                                    <div class="selected-itm__txt">Festival</div>
                                </div>
                                <div class="selected-itm">
                                    <div class="selected-itm__remove"></div>
                                    <div class="selected-itm__txt">Performing</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile__slider">
                        <div class="profile__subtitle">Productions</div>
                        <div class="slider-wrp">
                            <div class="p-slider">
                                <div class="slider__itm first">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
                                <div class="slider__itm">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
                                <div class="slider__itm">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
                                <div class="slider__itm">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
								
								 <div class="slider__itm">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
								 <div class="slider__itm">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile__slider">
                        <div class="profile__subtitle">Touring opportunities</div>
                        <div class="slider-wrp">
                            <div class="p-slider">
                                <div class="slider__itm first">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
                                <div class="slider__itm">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
                                <div class="slider__itm">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
                                <div class="slider__itm">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
								 <div class="slider__itm">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
								 <div class="slider__itm">
                                    <div class="slider__title">Title</div>
                                    <div class="slider__txt">Reality Surfing by art collective PYL is a non-narrative
                                        visual performance, which proposes to the audience to experience an alternative
                                        model of coexistence of people and inanimate entities. It uncovers new relations
                                        between daily objects through their materiality and presence in a space,
                                        acquiring an equivalent value as the presence of a human body.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>

<?php
get_footer(); ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("body").addClass('pe-body--white');
        jQuery(".footer").addClass('footer--dark');
    });
</script>