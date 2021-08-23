<?php
      
//Step 1 - logo
add_filter( 'musilda_cart_shipping_method_full_label', 'filter_woocommerce_cart_shipping_method_full_label', 10, 2 ); 
function filter_woocommerce_cart_shipping_method_full_label( $label, $method_id ) { 

	if( $method_id == 'zasilkovna>z-points' ) {
		$label = '<span>' . $label . '</span><img class="shipping-label-image" src="' . get_template_directory_uri() . '/assets/images/zasilkovna-logo-web-80.png" alt="Zásilkovna" />';
	}elseif( $method_id == 'intime-pickup' ) {
		$label = '<span>' . $label . '</span><img class="shipping-label-image" src="' . get_template_directory_uri() . '/assets/images/wedo-80.jpg" alt="WEDO" />';    
	}elseif( $method_id == 'intime' ) {
		$label = '<span>' . $label . '</span><img class="shipping-label-image" src="' . get_template_directory_uri() . '/assets/images/wedo-80.jpg" alt="WEDO" />';    
	}elseif( $method_id == 'local_pickup:10' ) {
		$label = '<span>' . $label . '</span><img class="shipping-label-image" src="' . get_template_directory_uri() . '/assets/images/osobni-odber-80.png" alt="Vyzvednutí na prodejně" />';    
	}
	return $label; 
}

//Step 2 - description
add_action( 'woocommerce_after_shipping_rate', 'action_after_shipping_rate', 100000, 2 );
function action_after_shipping_rate ( $method, $index ) {
	
	if( 'intime-pickup' === $method->id ) {
		echo __( '<span class="shipping-label-description" style="width:100%;text-align:left;">Doručení obvykle 2-3 pracovní dny
		</span>', 'musilda' );
	}
	if( 'intime' === $method->id ) {
		echo __( '<span class="shipping-label-description" style="width:100%;text-align:left;">Doručení obvykle 2-3 pracovní dny</span>', 'musilda' );
	}
	if( 'local_pickup:10' === $method->id ) {
		echo __( '<span class="shipping-label-description" style="width:100%;text-align:left;">Strakonice, Na Stráži 340 - zavoláme vám</span>', 'musilda' );
	}
	if( 'zasilkovna>z-points' === $method->id ) {
		echo __( '<span class="shipping-label-description" style="width:100%;text-align:left;">Doručení obvykle 2-3 pracovní dny</span>', 'musilda' );
	}
}

//Step 3 - edit template file woocommerce/cart/cart-shipping.php

//remove th cell and add colspan for td
?>
<th><?php echo wp_kses_post( $package_name ); ?></th>
<?php
//edit shipping list 

    if ( 1 === count( $available_methods ) ) :
				$method = current( $available_methods );
			?>
				<ul id="shipping_method" class="woocommerce-shipping-methods">	
					<li>
						<input type="hidden" name="shipping_method[<?php echo $index; ?>]" data-index="<?php echo $index; ?>" id="shipping_method_<?php echo $index; ?>" value="<?php echo esc_attr( $method->id ); ?>" class="shipping_method" />
						<?php $label = apply_filters( 'musilda_cart_shipping_method_full_label', wp_kses_post( $method->label ), $method->id ); ?>
						<label for="shipping_method_<?php echo $index; ?>_<?php echo sanitize_title( $method->id ); ?>"><?php echo $label; ?></label>
						<span class="custom-method-price"><?php echo wc_price( $method->cost + $method->get_shipping_tax() ); ?></span>
						<?php do_action( 'woocommerce_after_shipping_rate', $method, $index ); ?>
					</li>
				</ul>

			<?php else : ?>
       
				<ul id="shipping_method">
					<?php foreach ( $available_methods as $method ) : ?>
          				<li>
							<input type="radio" name="shipping_method[<?php echo $index; ?>]" data-index="<?php echo $index; ?>" id="shipping_method_<?php echo $index; ?>_<?php echo sanitize_title( $method->id ); ?>" value="<?php echo esc_attr( $method->id ); ?>" <?php checked( $method->id, $chosen_method ); ?> class="shipping_method" />
							<?php $label = apply_filters( 'musilda_cart_shipping_method_full_label', wp_kses_post( $method->label ), $method->id ); ?>
							<label for="shipping_method_<?php echo $index; ?>_<?php echo sanitize_title( $method->id ); ?>"><?php echo $label; ?></label>
							<span class="custom-method-price"><?php echo wc_price( $method->cost + $method->get_shipping_tax() ); ?></span>
							<?php do_action( 'woocommerce_after_shipping_rate', $method, $index ); ?>
						</li>
					<?php endforeach; ?>
				</ul>

			<?php endif; 

//That's all folks

