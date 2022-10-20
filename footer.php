<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Universalist
 */
?>

			<br class="clear" />
			
			<!--div id="affiliations">
				<a href="http://www.anglicancommunion.org/" rel="external" class="" target="_blank"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/graphics/affiliation-icon-wac.png" alt="WAC logo" /></a><a href="http://www.anglicancommunion.org/" rel="external" id="affiliation-wac" class="affiliation" target="_blank">Worldwide Anglican Communion</a>
				<a href="http://www.episcopalchurch.org/" rel="external" class="" target="_blank"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/graphics/affiliation-icon-ecu.png" alt="ECU logo" /></a><a href="http://www.episcopalchurch.org/" rel="external" id="affiliation-ecu" class="affiliation" target="_blank">Episcopal Church in the USA</a>
				<a href="http://www.dioceseny.org/" rel="external" class="" target="_blank"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/graphics/affiliation-icon-edny.png" alt="EDNY logo" /></a><a href="http://www.dioceseny.org/" rel="external" id="affiliation-edny" class="affiliation" target="_blank">Episcopal Diocese of New York</a>
			</div-->
			
		</div><!-- .site-content -->

	</div><!-- .site-inner -->

		<footer id="colophon" class="site-footer" role="contentinfo">

			<div class="site-info">

				<div id="footer-nav">
					<?php if ( has_nav_menu( 'footer-nav' ) ) : ?>
						<nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'twentysixteen' ); ?>">
							<?php
								wp_nav_menu(
									array(
										'theme_location' => 'footer-nav',
										'menu_class'     => 'footer-menu',
										/*'container'		=> 'div',
										'container_class' => '',
										'container_id'    => 'footer-nav',
										'menu_id'         => 'footer-nav',*/
									)
								);
							?>
						</nav><!-- .main-navigation -->
					<?php endif; ?>

					<?php if ( has_nav_menu( 'social' ) ) : ?>
						<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentysixteen' ); ?>">
							<?php
								wp_nav_menu(
									array(
										'theme_location' => 'social',
										'menu_class'     => 'social-links-menu',
										'depth'          => 1,
										'link_before'    => '<span class="screen-reader-text">',
										'link_after'     => '</span>',
									)
								);
							?>
						</nav><!-- .social-navigation -->
					<?php endif; ?>
				
				</div><!-- #footer-nav -->
			
			<div class="copyright site-title">©2022 Unitarian Church of All Souls | Website by <a href="https://birdhive.com/" target="_blank">Birdhive Development & Design</a></div>
				
			</div><!-- .site-info -->
			
			<br class="minimal" />
			
		</footer><!-- .site-footer -->
</div><!-- #wrapper .site -->

<?php wp_footer(); ?>
</body>
</html>
