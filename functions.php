<?php
// theme setup main function
add_action( 'after_setup_theme', 'elkartoki_theme_setup' );
function elkartoki_theme_setup() {

	// Custom taxonomies
	add_action( 'init', 'elkartoki_build_taxonomies', 0 );

	// load text domain for child theme
	load_theme_textdomain( 'elkartoki', get_stylesheet_directory_uri() . '/languages' );
}

// register taxonomies
function elkartoki_build_taxonomies() {
	register_taxonomy( 'eskola', 'project', array(
		'hierarchical' => true,
		'label' => __('School','elkartoki' ),
		'query_var' => true,
		'rewrite' => array( 'slug' => 'eskola', 'with_front' => false )
	));
} // END register taxonomies

// generate metadata output for project CPT
function elkartoki_project_meta() {

	global $post;
	$fields = array();
	$fields[__('Date','elkartoki')] = get_the_date();
	$fields[__('Author','elkartoki')] = get_the_author();

	$cats = get_the_terms( $post->ID, 'category' );
	 if ( $cats && ! is_wp_error( $cats ) ) {
	 	$cats_out = array();
		foreach ( $cats as $cat ) { $cats_out[] = $cat->name; }
		$cats_out = implode(',',$cats_out);
		$fields[__('Category','elkartoki')] = $cats_out;
	 }
	$schools = get_the_terms( $post->ID, 'eskola' );
	 if ( $schools && ! is_wp_error( $schools ) ) {
	 	$schools_out = array();
		foreach ( $schools as $school ) { $schools_out[] = $school->name; }
		$schools_out = implode(',',$schools_out);
		$fields[__('Schools','elkartoki')] = $schools_out;
	 }

	$output	= '<ul class="elkartoki-project-meta">';
	foreach ( $fields as $k=>$f ) {
		$output .= "<li><strong>".$k."</strong> $f</li>";
	}
	$output	.= '</ul>';
	return $output;
} // END generate metadata output for project CPT

?>
