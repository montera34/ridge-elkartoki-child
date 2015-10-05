<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Ridge
 * @since 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="project entry-header">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
				?>
				<?php // project author, date, category and school
				// function defined in child theme functions.php
				echo elkartoki_project_meta(); ?>
				<?php $manual_excerpt = $post->post_excerpt; ?>		
				<?php if( $manual_excerpt ) { ?>
				<p class="entry-excerpt">
					<?php echo $manual_excerpt; ?>
				</p>
				<?php } ?>
		<?php
			else :
				the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
			endif;
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<div class="inner">

			<?php

			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'ridge' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'ridge' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'ridge' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
			?>
		</div><!-- .inner -->

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php edit_post_link( __( 'Edit This Post', 'ridge' ), '<span class="edit-link">', '</span>' ); ?>
		<?php ridge_post_nav(); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
