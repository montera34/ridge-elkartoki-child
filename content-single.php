<?php
/**
 * @package Ridge
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-meta">
		<?php // project author, date, category and school
		// function defined in child theme functions.php
			echo elkartoki_post_meta();
			//ridge_post_meta(); ?>
	</div><!-- .entry-meta -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'ridge' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php edit_post_link( __( 'Edit This Post', 'ridge' ), '<span class="edit-link">', '</span>' ); ?>
		<?php ridge_post_nav(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
