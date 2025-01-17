<?php
/**
 * Submit Proposal
 */

get_header();
?>
<div class="action-warning">
            <div class="warning__cont">
                <p class="txt-2rem">Thank you! We’ll carefully review your proposal and get back to you.</p>
                <div class="warning__cta"><a href="/create-account-form" class="btn-large--warning w-inline-block">
                        <div class="btn__txt">Return to My Proposals</div>
                    </a></div>
            </div>
        </div>
 <section class="section-wrp s-project-first">
            <div class="page-content-wrp">
                <div class="page__title-wrp">
                    <h1 class="page__title">Submit a proposal</h1><a href="/open-call"
                        class="btn-transparent--dark w-inline-block">
                        <div class="txt-block--1rem">read open call</div>
                    </a>
                </div> <div>
                <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet vehicula
                    lacus id convallis. Pellentesque finibus urna metus, et vehicula enim cursus sed. Aliquam vitae
                    placerat metus, sit amet bibendum lectus. Nulla sagittis eros erat, vel sollicitudin felis semper
                    ac. Maecenas interdum nibh ac imperdiet gravida. Lorem ipsum dolor sit amet, consectetur adipiscing
                    elit. Duis tristique molestie mauris, ac dignissim dolor pretium eget. Cras rutrum faucibus purus,
                    ac scelerisque massa mollis vitae. Etiam pharetra lobortis diam, in eleifend nibh interdum quis.
                    Vivamus pretium sem ornare lacus suscipit, sit amet dapibus ante auctor. Quisque sagittis odio nec
                    enim finibus, ac gravida enim interdum.</p>
                    <p class="paragraph"><span class="paragraph__subtitle--1">Subtitle 1</span>
                        <p><span
                            class="paragraph__subtitle--2">Subtitle 2</span></p>
                            <p>Lorem ipsum
                                dolor sit amet, consectetur adipiscing elit. Curabitur rutrum malesuada quam, non venenatis arcu
                                sagittis quis. Phasellus ipsum enim, accumsan ac finibus nec, euismod at velit. Suspendisse dolor
                                nisi, vestibulum sed volutpat a, facilisis eget est. Pellentesque habitant morbi tristique senectus
                                et netus et malesuada fames ac turpis egestas. Quisque sit amet imperdiet lacus. Cras finibus
                                volutpat magna, in dictum ante sagittis sed. Ut eleifend lorem ut est consectetur euismod. Ut vel
                                diam at tortor feugiat scelerisque. Maecenas sollicitudin nunc vitae nunc convallis vulputate.
                                Mauris blandit convallis purus, ac maximus purus suscipit sed. Proin euismod consequat arcu ut
                                malesuada. Nulla non orci cursus, malesuada leo ut, varius tellus.
                    </p>
                </div>
                <div class="form">
                    <div class="form__itm-wrp">
                        <div class="form__radio">
                            <div class="check-box is--checked"></div>
                            <div class="form__txt--small">I am the representative of this project</div>
                        </div>
                        <div class="form__itm__partners">
                            <div class="form__subtitle--small">My Partners</div>
                            <div class="form__itm__filter-cont">
                                <div class="form-filter-itm">
                                    <div class="form-filter-wrp">
                                        <div class="form-filter-itm__search">
                                            <div class="filter-itm__searchbar">
                                                <input class="searchbar__txt" type="text" placeholder="Partner">
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
                                                <div class="selected-itm__txt">Name</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form__itm-i --25">
                                <div class="form__txt-i">Amount asked (€)</div>
                                <input class="form__input" type="text" placeholder="">
                                <div class="form__required">*</div>
                            </div>
                        </div>
                        <div class="form__itm__large-input">
                            <div class="form__itm__large__txt">
                                <div class="txt-block">Who are you and what are you looking for?</div>
                                <div class="txt--50">Example: Festival X is an outdoor circus festival focused on
                                    sustainability based in Slovenia (...). We are looking for new partnerships, to
                                    expand our contacts, specifically to enrich the programme of our next edition with
                                    emerging artists. We are exploring new ideas to make our festival more inclusive.
                                </div>
                            </div>
                            <div class="form__itm--top">
                                <div class="form__itm-i --top">
                                <div class="form__txt-i">Type your text here</div>
                                <textarea class="form__input__area" rows="4" placeholder="" type="text" placeholder=""></textarea>
                                <div class="form__required">*</div>
                                </div>
                            </div>
                        </div>
                        <div class="form__itm__upload">
                            <div class="form__txt">Upload PDF</div><a href="#" class="btn--black w-inline-block">
                                <div class="txt-block--1rem">upload</div>
                            </a>
                            <div id="w-node-ba4e01f9-a7b0-3aaf-b8ce-baeaf8edb462-a709e52f" class="upload__txt-wrp">
                                <div class="txt-block">lorem ipsum</div>
                                <div class="txt--50">.pdf (max. 2mb)</div>
                            </div>
                            <div id="w-node-ba4e01f9-a7b0-3aaf-b8ce-baeaf8edb467-a709e52f" class="upload__txt-wrp">
                                <div class="txt--50">loremipsumfilename_123654.pdf uploaded</div>
                                <div class="txt__link--black">remove</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php
get_footer();?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("body").addClass('pe-body--white');
        jQuery(".footer").addClass('footer--dark');
    });
</script>