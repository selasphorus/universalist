<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Universalist
 */
?>

<!-- wpt: template-parts/content-program -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php twentysixteen_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();
		
		echo get_cpt_program_content( );
		/*
		// TODO: move some or all of this program creation code into a function for reuse elsewhere (e.g. Event pages)
		echo "<p>Program Personnel:</p>";
		
		if ( have_rows('personnel') ): ?>

			<ul class="slides">

			<?php while( have_rows('personnel') ): the_row(); 

				// vars
				$role = get_sub_field('role');
				$person_objects = get_sub_field('person');
				
				if( $person_objects ):
					foreach( $person_objects as $p): // variable must NOT be called $post (IMPORTANT)
						//$person_id = $p->ID;
						//$person_name = get_the_title($p);
						$person_name = get_the_title( $p->ID );
    				endforeach;
				endif;
				?>

				<li class="program_person">
					
					<?php echo $role . ": " . $person_name; ?>
					<?php //echo $content; ?>

				</li>

			<?php endwhile; ?>

			</ul>

		<?php 
		endif;
		
		echo "<p>Program Items:</p>";
		
		if( have_rows('program_items') ): ?>

			<ul class="slides">

			<?php while( have_rows('program_items') ): the_row(); 

				// vars
				$item_label = get_sub_field('item_label');
				$item_objects = get_sub_field('program_item');
				
				if( $item_objects ):
					foreach( $item_objects as $p): // variable must NOT be called $post (IMPORTANT)
						$item_name = get_the_title( $p->ID );
						$item_post_type = $p->post_type;
    				endforeach;
				endif;
				?>

				<li class="program_item">
					
					<?php 
					if ($item_label) { echo $item_label . ": "; }
					if ($item_name) { echo $item_name . " (post_type: " . $item_post_type . ")"; }
					?>
					<?php //echo $content; ?>

				</li>

			<?php endwhile; ?>

			</ul>

		<?php 
		endif;
		*/
		?>
		
		<?php

		wp_link_pages(
			array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
				get_the_title()
			),
			'<footer class="entry-footer"><span class="edit-link">',
			'</span></footer><!-- .entry-footer -->'
		);
		?>

</article><!-- #post-<?php the_ID(); ?> -->
