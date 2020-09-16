<?php

/**
* Add new column to products  
 */
add_filter( 'manage_edit-product_columns', 'new_product_column' );
function new_product_column( $columns ) {

		$new_columns = array();
		foreach( $columns as $key  => $column ) {
			$new_columns[$key] = $column;
			if ( $key == 'name' ) {
				$new_columns['column'] = __( 'Column', 'lang );
			} 
		}
		return $new_columns;
}

/**
 * Display custom column value
 */
add_filter( 'manage_product_posts_custom_column', 'show_column_data' );
function show_column_data( $column ) {
		global $post;

    	if ( 'columne' === $column ) {
		
			$value = get_post_meta( $post->ID, 'data', true );
			if ( !empty( $value ) ) {
				echo $value;
			}
		
		}
}
