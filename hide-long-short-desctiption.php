<?php

/**
 * Show more to WordPress short text 
 * 
 */
add_filter( 'woocommerce_short_description', 'svitim_read_more_single_text' );
function svitim_read_more_single_text( $short_description ) {

	$words = explode(' ', $short_description);
    
    if (count($words) > $n) {
		$new_string = '';		
		foreach( $words as $key => $word ) {
			if ( 20 == $key ) {
				$new_string .= $word . ' <span class="short-description-show">' . esc_html__( 'Read more', 'theme' ) . '</span><span class="short-description-hide" id="short-description-hide">';
			} else {
				$new_string .= $word . ' ';
			}
		}
        $short_description = $new_string . '</span>';
    }

    return $short_description;

}

?>
<!-- js code -->
<script>
  document.addEventListener( 'click', (event) => {
	  if ( event.target.classList.contains( 'short-description-show' ) ) {
		  event.preventDefault();
		  document.getElementById( 'short-description-hide' ).style.display = 'inline';
		  event.target.style.display = 'none';
	  }
  });
</script>
