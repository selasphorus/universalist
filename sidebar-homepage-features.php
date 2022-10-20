<?php
/**
 * The template for the content bottom widget areas on the homeapge
 *
 */

if ( ! is_active_sidebar( 'homepage-features' ) ) {
	return;
}

// If we get this far, we have widgets. Let's do this.
?>
<aside id="homepage-feature-widgets" class="content-bottom-widgets homepage-widgets" role="complementary">
	<?php if ( is_active_sidebar( 'homepage-features' ) ) : ?>
		<div class="widget-area">
			<?php dynamic_sidebar( 'homepage-features' ); ?>
		</div><!-- .widget-area -->
	<?php endif; ?>
</aside><!-- .content-bottom-widgets -->
