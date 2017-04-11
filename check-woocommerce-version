/**
 *
 * Check WooCommerce version
 *
 */ 
if( !function_exists( 'toret_check_wc_version' ) ){

    function toret_check_wc_version( $version = '2.6.14' ){
        if ( function_exists( 'WC' ) && ( version_compare( WC()->version, $version, ">" ) ) ) {
            return true;
        }else{
            return false;
        }
    }   
}
