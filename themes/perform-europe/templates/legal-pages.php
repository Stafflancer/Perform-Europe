<?php /* Template Name: Legal Pages */

get_header();
?>
<section class="section-wrp s-project-first legal-page">
       <div class="page-content-wrp">
            <h1 class="page__title"><?php the_title();?></h1>
            <?php the_content();?>
      </div>
      <?php
       if( have_rows('accordian_section') ):
        ?>
        <div class="page-content-wrp marin-top">
          <div class="dropdown-list">
        <?php    $i=0;
          while( have_rows('accordian_section') ) : the_row();

              // Get parent value.
              $heading = get_sub_field('heading');
              if($i == 0)
              {
                $class_add = 'dd-open';
                $visible = 'visible';
              }
              else
              {
                $class_add = '';
                $visible = '';
                 
              }
              echo '<div class="dropdown-itm '.$class_add.'">
                <div class="txt-h2">'.$heading.'</div>
                <div class="dd__txt '.$visible.'">';

                  $add_content = get_sub_field('content');
                      echo $add_content;
              echo '</div></div>';
              $i++;
          endwhile;
          echo "</div></div>";
      endif;
      ?>
</section>
<style type="text/css">
 .legal-page .dd__txt.visible {
    display: block;
    margin: 0px;    
}
 .legal-page .dd__txt li{
  letter-spacing: -.02rem;
    margin-bottom: 0;
    font-size: 1rem;
}
</style>
<?php
get_footer();
