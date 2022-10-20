<?php
/**
* Template Name: Modal Page
*
* @package WordPress
* @subpackage Universalist
*/
?>

<?php if (!$_GET) { get_header(); } ?>

<?php 
$modal = get_query_var( 'TB_iframe', false );
//echo "Query var is [".$modal."]; 
?>

<div id="primary" class="fullwidth content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) :
			the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php if (!$_GET) { get_footer(); } ?>