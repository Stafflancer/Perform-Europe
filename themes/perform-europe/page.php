<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>
  <section class="section-wrp s-project-first">
            <?php

            // Start the Loop.
            while ( have_posts() ) :
                the_post();

               the_content();

                 
            endwhile; // End the loop.
            ?>
  </section>
<?php
get_footer();
