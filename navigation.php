<?php 
global $wp_rewrite;			

$projects->query_vars['paged'] > 1 ? $current = $projects->query_vars['paged'] : $current = 1;
$total = $projects->max_num_pages;

$pagination = array(
	'total' => $total,
	'current' => $current,
	'show_all' => false,
	'mid_size' => 3,
	'end_size' => 2,
	'prev_text' => __('«'),
	'next_text' => __('»'),
	'type' => 'list',
);

$url_raw = "http://" .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url_raw = preg_replace('/\/page\/[0-9]*/','',$url_raw);
$pt_current = sanitize_text_field( $_GET['post_type'] );
if( $wp_rewrite->using_permalinks() )
	$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg(array('s','post_type'),$url_raw ) ) . "page/%#%/", 'paged');

if( $pt_current != '' )
	$pagination['add_args'] = array('post_type'=>$pt_current);

echo "<nav class='navega' role='navigation'>";
echo paginate_links($pagination);
echo "</nav>";
?>
