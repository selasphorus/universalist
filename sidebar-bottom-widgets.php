<?php
/**
 * The template for the content bottom widget areas on the homeapge
 *
 */

if ( ! is_active_sidebar( 'bottom-widgets' ) ) {
	return;
}

// If we get this far, we have widgets. Let's do this.
?>
<aside id="page-bottom-widgets" class="content-bottom-widgets" role="complementary">
	<?php if ( is_active_sidebar( 'bottom-widgets' ) ) : ?>
		<div class="widget-area">
			<?php dynamic_sidebar( 'bottom-widgets' ); ?>
		</div><!-- .widget-area -->
	<?php endif; ?>
</aside><!-- .content-bottom-widgets -->
