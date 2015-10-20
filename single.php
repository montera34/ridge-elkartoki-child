<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Ridge
 * @since 1.0
 */

get_header(); ?>
<?php // parallax banner
if ( has_post_thumbnail() ) {
	$single_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'ridge_full_width' ); ?>

	<div id="single-banner" data-parallax="scroll" data-image-src="" data-speed="0.4">
		<div class="bg" style="background-image: url(<?php echo esc_url( $single_img[0] ); ?>);">
			<div class="inner">
			</div>
		</div>
	</div>
<?php } ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the post format-specific template for the content
			 */
			get_template_part( 'content', 'single' );

			// If comments are open or we have at least one comment, load the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
