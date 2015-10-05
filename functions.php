<?php
// theme setup main function
add_action( 'after_setup_theme', 'elkartoki_theme_setup' );
function elkartoki_theme_setup() {

	// Custom taxonomies
	add_action( 'init', 'elkartoki_build_taxonomies', 0 );

}

// register taxonomies
function elkartoki_build_taxonomies() {
	register_taxonomy( 'eskola', 'project', array(
		'hierarchical' => true,
		'label' => __('School','elkartoki' ),
		'query_var' => true,
		'rewrite' => array( 'slug' => 'eskola', 'with_front' => false )
	));
}

/* RIDGE
 * PARENT
 * THEME
 * REDEFINITIONS
 */

/**
 * Generate the project thumb title for the portfolio masonry view
 *
 * @since 1.0
 */
 if( ! function_exists( 'ridge_the_thumb_title' ) ) :
	 function ridge_the_thumb_title(){
		 global $post;
		 global $ttrust_config; // Grabs the isotope classes
		 $skills_ucfirst    = array();

		 // school child theme taxonomy terms
		 $schools = get_the_terms( $post->ID, 'eskola' );
		 if ( $schools && ! is_wp_error( $schools ) ) {
		 	$schools_out = array();
		 	foreach ( $schools as $school ) { $schools_out[] = $school->name; }
		 } else { $schools_out = ""; }
		 
		 if( ! empty( $ttrust_config['isotope_names'] ) )
			 $skills = $ttrust_config['isotope_names'];

		 // Begin building the string with the project title
		 $output = the_title( '<h2 class="entry-title">', "</h2>\n" );

		 // Add skills if there are any
		 if( ! empty( $skills ) ) {

			 $output .= "\n<h3>";

			 foreach( $skills as $skill ){

				 $skills_ucfirst[] = ucfirst( esc_attr( $skill ) );

			 }

			 $output .= implode(', ', $skills_ucfirst );
			 if ( $schools_out != '' ) {
				$output .= '<span class="mosac-schools">';
				$output .= __('Schools','elkartoki');
				$output .= ': ';
				$output .= implode(', ', $schools_out );
				$output .= '</span>';
			 }
			 $output .= "</h3>";

		 } // if

		 echo $output;

	 } // ridge_the_thumb_title
 endif;

?>
