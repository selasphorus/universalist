<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Universalist
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
    
    <?php /* 
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXXXXXXX-X"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-XXXXXXXXX-X');
        </script>
    <!-- /Google Analytics -->
    */?>
    
</head>

<body <?php body_class(); ?>>

<?php if ( function_exists('display_banner') && is_dev_site () && (is_front_page() || is_page('home')) ){ echo display_banner(); } ?>
    
<div id="wrapper" class="site<?php if ( (is_front_page() || is_page('home')) ) { echo " has-banner"; } ?>">
	
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a>

		<button class="toggle-menu">Menu</button>
		
		<div class="overlay-menu">
		
			<div class="full-screen-menu">
				<div class="container">
					<button class="toggle-menu">Close Menu</button>
					<nav class="menu-column">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'full_screen_menu_primary',
							'container' => false,
							'menu_class' => 'menu',
						));
						?>
					</nav>
					<nav class="menu-column">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'full_screen_menu_secondary',
							'container' => false,
							'menu_class' => 'menu overlay-menu',
						));
						?>
					</nav>
				</div>
			</div>
		
		</div>
		
		<header id="masthead" class="site-header" role="banner">
			<div class="site-header-main">
				
				<div class="site-branding">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/graphics/allsouls-logo.png" alt="AllSoulsNYC logo" /></a>
				</div><!-- .site-branding -->
				
                <!--div class="header-search">
                    <?php //get_search_form(); ?>
                </div-->
                
				<?php /*<div id="giving-cta" class="header-call-to-action">
					<a href="/product-category/giving/"><span class="button-text">Give to Saint Thomas Church</span></a>
				</div> */ ?>
				
				<?php /*if ( has_nav_menu( 'secondary-header-nav' ) ) : ?>
					<div id="secondary-header-nav">
					<nav id="site-navigation-secondary" class="secondary-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Secondary Header Menu', 'twentysixteen' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'secondary-header-nav',
									'menu_class' => 'secondary-header-menu',
								)
							);
						?>
					</nav>
					</div>
				<?php endif;*/ ?>
				
			</div><!-- .site-header-main -->
			
			<?php /*	
			<div id="site-header-menu" class="site-header-menu">
				
				<?php if ( has_nav_menu( 'header-tabs' ) ) : ?>
					<div id="header-tabs">
					<nav id="site-navigation-tertiary" class="tertiary-navigation" aria-label="<?php esc_attr_e( 'Header Tabs Menu', 'twentysixteen' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'header-tabs',
									'menu_class' => 'header-tabs',
								)
							);
						?>
					</nav>
					</div>
				<?php endif; ?>

				<?php if ( has_nav_menu( 'primary' ) ) : ?>
					<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'twentysixteen' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu_class' => 'primary-menu',
								)
							);
						?>
					</nav><!-- .main-navigation -->
				<?php endif; ?>
			</div><!-- .site-header-menu -->
			*/?>
			
			<?php if ( get_header_image() ) : ?>
				<?php
					/**
					 * Filter the default twentysixteen custom header sizes attribute.
					 *
					 * @since Twenty Sixteen 1.0
					 *
					 * @param string $custom_header_sizes sizes attribute
					 * for Custom Header. Default '(max-width: 709px) 85vw,
					 * (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px'.
					 */
					$custom_header_sizes = apply_filters( 'twentysixteen_custom_header_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px' );
				?>
				<div class="header-image">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id ) ); ?>" sizes="<?php echo esc_attr( $custom_header_sizes ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
					</a>
				</div><!-- .header-image -->
			<?php endif; // End header image check. ?>
			
		</header><!-- .site-header -->
	
	<div class="site-inner">
		
		<?php 
        if ( is_front_page() OR is_page('home') ) {
            
            //atc_display_slider();
            
        } elseif ( ( is_single() || is_page() ) 
                  && ( get_field('youtube_id') || get_field('vimeo_video') || get_field('featured_video') )
                 ) {
        
            // TODO: make new featured_video function
            
            $youtube_id = get_field('youtube_id');
            $vimeo_video = get_field('vimeo_video');
            $video_file = get_field('featured_video');
            
            //https://player.vimeo.com/external/548976247.hd.mp4?s=5a2b54e046121eb83f09e080d8d2fc6172197840&profile_id=175
            
            //echo "<pre>".print_r($video_file,true)."</pre>"; // tft
            
            //$video = '<video poster="" id="section-home-hero-video" class="section-home-hero-video" src="'.$video_url.'" autoplay="autoplay" loop="loop" preload="auto" muted="true" playsinline="playsinline"></video>';
            
            if ( $youtube_id ) {
                $video = '<div class="hero youtube-responsive-container">';
                $video .= '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/'.$youtube_id.'?&autoplay=1&mute=1" title="YouTube video player" frameborder="0" allowfullscreen></iframe>'; // controls=0 // allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                $video .= '</div>';
            } else if ( $vimeo_video ) {
                $video = '<div class="hero video-container">';
                $video .= '<video poster="" id="section-home-hero-video" class="hero-video" src="'.$vimeo_video.'" autoplay="autoplay" loop="loop" preload="auto" muted="true" playsinline="playsinline" controls></video>';
                $video .= '</div>';
            } else if ( $video_file ) {
                $video = '<div class="hero video-container">';
                $video .= '<video poster="" id="section-home-hero-video" class="hero-video" src="'.$video_file['url'].'" autoplay="autoplay" loop="loop" preload="auto" muted="true" playsinline="playsinline"></video>';
                $video .= '</div>';
            }
            
            echo $video;                
        
        } elseif ( is_page_template('page-centered.php') && get_field('featured_image_display') == "banner" ) { ?>
        
			<?php 
			$banner_img = get_the_post_thumbnail();
			//$banner_img = wp_get_attachment_url( get_the_post_thumbnail() );
			?>		
			<div class="featured-image-banner">
			<?php 
			if( $banner_img ) : 
				echo $banner_img;
			endif; ?>
		  	</div>
        
		<?php } ?>
		
		<?php
		// TO DO: write JS to scale based on width of window/scaled image, not max width of image
	
		$background_img_url = null;
		$inline_style = "";
		// TO DO: write JS to scale based on width of window/scaled image, not max width of image
        if ( ( is_page() || is_single() ) 
            && ( get_field('featured_image_display') == "background" && has_post_thumbnail() ) ) {
            
            $background_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
            
            if ( $background_img_url ) { 
                $inline_style = atc_background_styles();
            }
		}
		?>

		<div id="content" class="site-content<?php if ($background_img_url) { echo " custom-page-background"; } ?>" style="<?php echo $inline_style; ?>">
