	/**
	 * Register new sidebar
	 *
	 */
	if( !function_exists( 'tdua_widget_init' ) ){
		add_action( 'widgets_init', 'tdua_widget_init' );
		function tdua_widget_init(){
			register_sidebar( 
				array(
					'name' => esc_html__( 'Eshop sidebar', 'Divi' ),
					'id' => 'sidebar-shop',
					'before_widget' => '<div id="%1$s" class="et_pb_widget %2$s">',
					'after_widget' => '</div> <!-- end .et_pb_widget -->',
					'before_title' => '<h4 class="widgettitle">',
					'after_title' => '</h4>',
				) 
			);
		}
	}

	/**
	 * Change woo pages output
	 *
	 */	
	if( !function_exists( 'tdua_output_content_wrapper_end' ) ){
		function tdua_output_content_wrapper_end(){
 			echo '</div> <!-- #left-area -->';
 			echo '<div id="sidebar">';
 			if (
  				( is_product() && 'et_full_width_page' !== get_post_meta( get_the_ID(), '_et_pb_page_layout', true ) )
  				||
  				( ( is_shop() || is_product_category() || is_product_tag() ) && 'et_full_width_page' !== et_get_option( 'divi_shop_page_sidebar', 'et_right_sidebar' ) )
 			) {
  				dynamic_sidebar( 'sidebar-shop' );
 			}
 			echo '
    				</div>
	    			</div> <!-- #content-area -->
   				</div> <!-- .container -->
  			</div> <!-- #main-content -->
  			';
		}
	}

	/**
	 * Change woo pages output
	 *
	 */
	if( !function_exists( 'tdua_woocommerce_custom_sidebar' ) ){
		add_action( 'after_setup_theme', 'tdua_woocommerce_custom_sidebar', 50 );
		function tdua_woocommerce_custom_sidebar() {
 			remove_action( 'woocommerce_after_main_content', 'et_divi_output_content_wrapper_end', 10 );
 			add_action( 'woocommerce_after_main_content', 'tdua_output_content_wrapper_end', 10 );
		}
	}
