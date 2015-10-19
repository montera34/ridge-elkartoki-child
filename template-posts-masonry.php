<?php
/**
 * Template Name: Posts Masonry
 *
 * @package Ridge
 * @since 1.0
 * modified by @montera34
 * for elkartoki.com
 */

get_header();

?>

	<div id="primary" class="content-area middle portfolio">
		<main id="main" class="site-main " role="main">

			<div id="elkartoki-tagline"><?php echo get_bloginfo('description'); ?></div>
			<?php

			// Don't show the description for the front page
			if( ! is_front_page() ) {

				while ( have_posts() ) : the_post(); ?>

					<div id="portfolio-content">
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                        </header>
						<?php the_content(); ?>
					</div>

				<?php endwhile;
			} // if

			/**
			 * Set up the skills and projects
			 *
			 * @see inc/template-tags.php
			 */

			// FilterNav output
			//ridge_filter_nav();
			//ridge_filter_nav('post');
			elkartoki_filter_nav('post');

			// Get the projects WP_Query object
			//$projects = ridge_posts_setup('project');
			$projects = ridge_posts_setup('post');

			?>

			<div id="projects" class="masonry">
				<div class="thumbs clearfix">
					<?php  while ( $projects->have_posts()) : $projects->the_post();

						global $ttrust_config;

						// Get the skills for each project for the .js data attribute
//						$skills = ridge_get_tax( $post );
//print_r($skills);
						get_template_part( 'content', 'post-small-masonry' ); ?>

					<?php endwhile; ?>
				</div><!-- .thumbs -->
			</div><!-- #projects -->

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
