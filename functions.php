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
?>
