<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package spinalelements
 */

get_header();
?>
 <section class="section-wrp s-404">
            <div class="page__title-wrp">
                <h1 class="page__title">Oops!</h1><a href="<?php echo site_url();?>" class="btn-yellow">
                    <div class="txt-block--1rem">return to homepage</div>
                </a>
            </div>
        </section>
	 

<?php
get_footer();
