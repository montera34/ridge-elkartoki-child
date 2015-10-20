<?php
// theme setup main function
add_action( 'after_setup_theme', 'elkartoki_theme_setup' );
function elkartoki_theme_setup() {

	/* Load JavaScript files */
	add_action( 'wp_print_scripts', 'elkartoki_load_frontend_scripts',100);

	// Custom taxonomies
	add_action( 'init', 'elkartoki_build_taxonomies', 0 );

	// load text domain for child theme
	load_child_theme_textdomain( 'elkartoki', get_stylesheet_directory() . '/languages' );

	/* Meta Box plugin CF registration */
	add_filter( 'rwmb_meta_boxes', 'elkartoki_extra_metaboxes' );
}

// load js scripts to avoid conflicts
function elkartoki_load_frontend_scripts() {
	wp_dequeue_script('ridge-functions');
//	wp_deregister_script( 'ridge-functions' );
	wp_enqueue_script(
		'elkartoki-ridge-functions',
		get_stylesheet_directory_uri().'/js/theme_trust.js',
		array( 'jquery' ),
		'1.0',
		true
	);
	wp_enqueue_script(
		'elkartoki-functions',
		get_stylesheet_directory_uri().'/js/elkartoki.js',
		array( 'jquery' ),
		'1.0',
		true
	);

} // end load frontend js scripts to avoid conflicts

// register taxonomies
function elkartoki_build_taxonomies() {
	register_taxonomy( 'eskola', 'post', array(
		'hierarchical' => true,
		'label' => __('School','elkartoki' ),
		'query_var' => true,
		'rewrite' => array( 'slug' => 'eskola', 'with_front' => false )
	));
} // END register taxonomies

// generate metadata output for project CPT
function elkartoki_post_meta() {

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
		$fields[__('School','elkartoki')] = $schools_out;
	 }

	$output	= '<ul class="elkartoki-project-meta">';
	foreach ( $fields as $k=>$f ) {
		$output .= "<li><strong>".$k."</strong> $f</li>";
	}
	$output	.= '</ul>';
	return $output;
} // END generate metadata output for project CPT

// Function to get all terms in a taxonomy
// prepared to use them in a select field in a form
function elkartoki_get_terms_as_select_options($taxonomy) {

	$args = array(
		'orderby'    => 'name',
		'hide_empty' => '0'
	);
	$terms = get_terms( $taxonomy,$args );
	$options = array();
	foreach ( $terms as $r ) { $options[$r->term_id] = $r->name; }
	return $options;
} // end elkartoki_get_terms_as_select_options

/**
 * extra meta boxes
 * out of Meta Box plugin
 */
function elkartoki_extra_metaboxes( $meta_boxes ) {
	/**
	* prefix of meta keys (optional)
	* Use underscore (_) at the beginning to make keys hidden
	* Alt.: You also can make prefix empty to disable it
	*/
	// Better has an underscore as last sign
	$prefix = '_elkartoki_';

	$cats = elkartoki_get_terms_as_select_options('category');
	// Project meta boxex
	$meta_boxes[] = array(	
		'id' => 'filters',// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'title' => __('Mosaic category filters (only for the Posts Masonry template)'), // Meta box title - Will appear at the drag and drop handle bar. Required.	
		'post_types' => array( 'page' ), // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'context' => 'normal', // Where the meta box appear: normal (default), advanced, side. Optional.	
		'priority' => 'high',// Order of meta box: high (default), low. Optional.	
		'autosave' => true,// Auto save: true, false (default). Optional.
		// List of meta fields
		'fields' => array(
			array(
				'name' => __('Filters'),
				'desc' => __('Add new filters with the blue button; drag and drop the select boxes to order the filters.'),
				'id' => "{$prefix}filters",
				'type' => 'select',
				'options' => $cats,
				'clone' => true,
				'sort_clone' => true
			),
		)
	);
	return $meta_boxes;

} // end elkartoki_extra_metaboxes


/**
 * Builds and prints the categories filter nav, hiding any skills without associated projects
 * 
 * Based in ridge_filter_nav function from Ridge theme
 *
 * @param str $post_type    Optional. Accepts project or post for use in the portfolio
 *   and blog.
 * @since 1.0
 */
if( ! function_exists( 'elkartoki_filter_nav' ) ) :
	function elkartoki_filter_nav( $post_type = 'post' ) {

		global $post;
		if( 'post' != $post_type )
			return;

		$taxonomy = 'category';
		$filters = get_post_meta($post->ID,'_elkartoki_filters');
		$filter_ids = implode(",",$filters[0]);
		$args = array(
			'orderby'    => 'none',
			'include'    => $filter_ids,
			'hide_empty' => 0
		);

		$categories = get_terms( $taxonomy,$args );

		//Display FilterNav only if there is more than one skill

		if( sizeof( $categories ) > 0 ) { ?>
			<ul id="filter-nav" class="clearfix">
				<li class="all-btn"><a href="#" data-filter="*" class="selected"><?php _e( 'All', 'ridge' ); ?></a></li>
				<?php
				foreach( $categories as $pcat ) {
					$output = sprintf( '<li><a href="#" data-filter=".%1$s">%2$s</a></li>%3$s',
							esc_attr( $pcat->slug ),
							ucfirst( esc_attr( $pcat->name ) ),
							"\n"
						);

					echo $output;

				} // foreach

				?>
			</ul>
		<?php
		} // if

	} // ridge_filter_nav
endif;


/* REDEFINITIONS
 * OF RIDGE
 * PARENT THEME
 * FUNCTIONS
 */

/**
 * Register Google Fonts
 *
 * @since 1.0
 *
 * @return string $fonts_url Google fonts URL for the theme.
 */
function ridge_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lato, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$lato = _x( 'on', 'Lato font: on or off', 'ridge' );

	if ( 'off' !== $lato || 'off' !== $lato ) {
		$font_families = array();

		if ( 'off' !== $lato ) {
			$font_families[] = 'Quicksand:400,700,300';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

	} // if()

	return $fonts_url;

} // ridge_fonts_url


?>
