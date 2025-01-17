<?php /* Template Name: Open Call Page */
get_header(); ?>
<section class="section-wrp s-project-first legal-page">
            <div class="page-content-wrp">
                <div class="page__title-wrp">
                    <h1 class="page__title"><?php the_title();?></h1>
                    <?php if(!empty(get_field('pdf')))
                    { ?>
                        <a href="<?php echo get_field('pdf');?>" class="btn-t-icon w-inline-block" download="Perform-Europe-Open-Call-and-Guidelines">
                            <img src="https://performeurope.eu/wp-content/uploads/2023/11/6500279b74faa0f223854e75_Vector.svg" loading="eager" alt="" class="btm__icon">
                            <div class="txt-block--1rem">Call Guidelines PDF</div>
                        </a> 
                    <?php } ?>
                    <?php if(!empty(get_field('audio')))
                    { ?>
                    <a href="<?php echo get_field('audio');?>" download="Audio-Version-of-the-Perform-Europe-Open-Call-and-Guidelines" class="btn-t-icon w-inline-block"><img src="https://performeurope.eu/wp-content/uploads/2023/11/650027de34b9fe56bb69797d_Group-116.svg"
                            loading="eager" alt="" class="btm__icon">
                        <div class="txt-block--1rem">audio</div>
                    </a>
                    <?php } ?>
                </div>
                <?php the_content();?>
            </div>
            <?php
                   if( have_rows('accordian_section') ):
                    ?>
                    <div class="page-content-wrp marin-top">
                      <div class="dropdown-list">
                    <?php    $i=0;
                      while( have_rows('accordian_section') ) : the_row();
							$class_add = '';
                            $class_visiable = '';
                          // Get parent value.
                          $heading = get_sub_field('heading');
                          if($i == 0)
                          {
                            //$class_add = 'dd-open';
                            //$class_visiable = 'visible';
                          }
                          else
                          {
                            $class_add = '';
                            $class_visiable = '';
                          }
                          echo '<div class="dropdown-itm dd-itm--dark '.$class_add.'">
                            <div class="txt-h2">'.$heading.'</div>
                              <ul class="dd__txt '.$class_visiable.'">';
                          // Loop over sub repeater rows.
                          //if( have_rows('content') ):
                            //  while( have_rows('content') ) : the_row();

                                  // Get sub value.
                                  $add_content = get_sub_field('content');
                                  echo ''.$add_content.'';

                            // endwhile;
                         // endif; 
                          $i++;
                          echo '</ul></div>';
                      endwhile;
                      echo "</div></div>";
                  endif;
                  ?>
		<div class="page-content-wrp marin-top">                
                <?php echo get_field('additional_description');?>
            </div>
        </section>
       
<style type="text/css">
 .legal-page .dd__txt.visible {
    display: block;
    margin: 0px;
    padding-left: 0px;
}
 .legal-page .dd__txt li{
  letter-spacing: -.02rem;
    margin-bottom: 0;
    font-size: 1rem;
}
</style>
<?php
get_footer();
?>
<a href="/login" class="fixed__cta w-inline-block">
        <div class="fixed__cta__txt">Ready? Login to apply</div><img
            src="https://performeurope.eu/wp-content/uploads/2023/11/arrow-btns.svg"
            alt="" class="cta__arrow__img">
    </a>