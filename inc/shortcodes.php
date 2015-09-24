<?php

/* Responsive Columns Module */
function row_shortcode( $atts, $content = null ) {

	$attribute = shortcode_atts( array(
		'align_items' => '',
		'align_content' => '',
		'justify_content' => '',
		'class'           => '',
		'style'           => ''
	), $atts );

	$attribute['style'] = $attribute['style'] ? 'style="'.$attribute['style'].'"' : '';
	$attribute['class'] = $attribute['class'] ? ' '.$attribute['class'] : '';
	$attribute['align_items'] = $attribute['align_items'] ? ' align-items-'.$attribute['align_items'] : '';
	$attribute['align_content'] = $attribute['align-content'] ? ' align-content-'.$attribute['align_content'] : '';
	$attribute['justify_content'] = $attribute['justify_content'] ? ' justify-content-'.$attribute['justify_content'] : '';

	return '<div '.$attribute['style']
		   .' class="row'.$attribute['class']
		   .$attribute['align_items']
		   .$attribute['align_content']
		   .$attribute['justify_content'].'">'
		   . do_shortcode($content) . '</div>';
}
add_shortcode( 'row', 'row_shortcode' );

// Col shortcode
add_shortcode( 'col', 'col_shortcode' );
function col_shortcode( $atts, $content = null ) {

	$attribute = shortcode_atts( array(
		'num' => '1',
		'class' => '',
		'style' => ''
	), $atts );

	$attribute['style'] = $attribute['style'] ? 'style="'.$attribute['style'].'"' : '';
	$attribute['num'] = $attribute['num'] ? 'col-'.$attribute['num'] : '';
	$classes = $attribute['class'] ? 'col'. ' ' . $attribute['num'] . ' ' . $attribute['class'] : 'col'. ' ' . $attribute['num'];
	return '<div '.$attribute['style'].' class="' . $classes . '">' . do_shortcode($content) . '</div>';
}


/* Archive short-code, pulling posts */
add_shortcode( 'archive', 'archive_shortcode' );
function archive_shortcode( $atts ) {
	ob_start();
	$attribute = shortcode_atts( array(
		'post_type' => "",
		'posts_per_page' => "",
		'category_slug' => "",
		'order' => "",
		'orderby' => "",
		'tax_query' =>"",
		'relation'    =>"AND"
	), $atts );

	// Variables 
	$post_type = $attribute['post_type'];
	$posts_per_page = $attribute['posts_per_page'];
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$category = get_category_by_slug( $attribute['category_slug'] ); 
	$category_id = $category->term_id;
	$order   = $attribute['order'];
	$orderby = $attribute['orderby'];
	$tax_queries = $attribute['tax_query'] ? explode('+', $attribute['tax_query'] ) : array();
	$tax_query_data = array();
	$relation = $attribute['relation'];

	if( count($tax_queries) >= 1 ){
		foreach ( $tax_queries as $tax_query ) {
			$tax_query = explode(':', $tax_query);
			$tax_query_data[] = array(
				'taxonomy' => trim($tax_query[0]),
				'field'    => 'slug',
				'terms'    => explode( ',', $tax_query[1] ),
				'operator' => $tax_query[2] ? trim($tax_query[2]) : 'IN'
			);
		}
	} 

	print_r($tax_query_data);

	
	if( count($tax_queries) >= 2 ){
		$tax_query_data['relation'] = $relation;
	}

	$args = array (
		'post_type'      => $post_type,
		'posts_per_page' => $posts_per_page,
		'paged'          => $paged,
		'cat'            => $category_id ? $category_id : '',
		'order'          => $order,
		'orderby'        => $orderby,
		'tax_query'      => $tax_query_data,
	);

	$query = new WP_Query( $args );


	if ( $query->have_posts() ): 
		// insert wrapper 
		echo '<div class="page-archive-content page-archive-content--'.$post_type.'">';
			while ( $query->have_posts() ) : $query->the_post();
					
				/* Grab Content Parts */
				$post_format_temp = get_post_format( get_the_ID() ) ? '-'.get_post_format( get_the_ID() ) : '';
				get_template_part( 'template-parts/content', $post_type.$post_format_temp );
		
			endwhile; // end of the loop
			wp_reset_postdata();
		echo '</div>'; // page-archive 
	endif;
	return ob_get_clean();
}


/* Buttons */
add_shortcode('button', 'sh_button');
function sh_button( $atts, $content = null ){
	$atts = shortcode_atts(
		array(
			'type'  => 'action',
			'text'  => '',
			'class' => '',
			'url' => '',
			'target' => '_self',
		), $atts, 'button' );
	$classes = $atts["class"] ? $atts["class"] . ' ' . 'button-' . $atts["type"] : 'button--' . $atts["type"];
	return '<a target="'.$atts['target'].'" href="'.$atts["url"].'"" class="' . $classes . '">'.$atts["text"].'</a>';
}


?>