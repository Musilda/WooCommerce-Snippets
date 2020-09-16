<?php

/**
 *
 * Recalcute cart
 *
 */
if (!function_exists('woo_print_autoload_js')) { 
    add_action( 'woocommerce_review_order_after_submit' , 'woo_print_autoload_js' );

    function woo_print_autoload_js(){
		$chosen_payment_method = WC()->session->get('chosen_payment_method');
		?><script type="text/javascript">
        jQuery(document).ready(function($){
	         $(document.body).on('change', 'input[name="payment_method"]', function() {
			   var ajax_url = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
			   var data = {
      				action: 'update_order_review',
      				security: wc_checkout_params.update_order_review_nonce,
      				post_data: $( 'form.checkout' ).serialize()
    			};

    			jQuery.post( ajax_url, data, function( response )
    			{
      				$( 'body' ).trigger( 'update_checkout' );
    			});
	       });
        });
 		</script><?php 
    }

}
function load_ajax() {
	if ( !is_user_logged_in() ){
		add_action( 'wp_ajax_nopriv_update_order_review', 'musilda_update_order_review' );
	} else{
		add_action( 'wp_ajax_update_order_review',        'musilda_update_order_review' );
	}
  }
  add_action( 'init', 'load_ajax' );

function musilda_update_order_review() {
	$values = array();
	parse_str($_POST['post_data'], $values);
	$cart = $values['cart'];
	foreach ( $cart as $cart_key => $cart_value ){
		WC()->cart->calculate_totals();
		woocommerce_cart_totals();
	}
	wp_die();
  }
