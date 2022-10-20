<?php
/**
* Template Name: Homepage Template
*
* @package WordPress
* @subpackage Universalist
*/


get_header(); ?>

<div id="primary" class="fullwidth content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) :
			the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// End of the loop.
		endwhile;
		?>
	</main><!-- .site-main -->
	<?php get_sidebar( 'homepage-features' ); ?>
</div><!-- .content-area -->

<?php get_footer(); ?>
