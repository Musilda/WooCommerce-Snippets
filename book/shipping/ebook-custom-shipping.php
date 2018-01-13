/**
 * @package   eBook Custom Shipping
 * @author    Vladislav Musílek
 * @license   GPL-2.0+
 * @link      
 * @copyright 2018 Toret
 *
 * @wordpress-plugin
 * Plugin Name:       eBook Custom Shipping
 * Plugin URI:        
 * Description:       eBook Custom Shipping
 * Version:           1.0
 * Author:            Vladislav Musílek
 * Author URI:        https://toret.cz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'woocommerce_ebook_shipping_init' ) ) { 
		
	add_action( 'plugins_loaded', 'woocommerce_ebook_shipping_init' );

	function woocommerce_ebook_shipping_init(){


		if ( !class_exists( 'WC_Shipping_Method' ) ) 
      		return;
 
		if ( ! class_exists( 'WC_Ebook_Shipping_Method' ) ) {

			class WC_Ebook_Shipping_Method extends WC_Shipping_Method {

    				/**
    				 * Plugin slug
    				 *
    				 */        
	    			private $plugin_slug = 'ebook-shipping';

	    			/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct( $instance_id = 0 ) {
        
                    
					$this->id                 = 'ebook'; 
                    			$this->instance_id        = absint( $instance_id );
                    			$this->method_title       = __( 'Ebook', $this->plugin_slug );                                    
                    			$this->method_description = __( 'Ebook shipping', $this->plugin_slug );


                    			$this->supports           = array(
                        			'shipping-zones',
                        			'instance-settings',
                        			'instance-settings-modal',
                    			);
	
	                    		$this->init();

				}

                		/**
                		 * Initialize local pickup.
                		 */
                		public function init() {

                    			// Load the settings.
                    			$this->init_form_fields();
                    			$this->init_settings();

                    			// Define user set variables
                    			$this->title            = $this->get_option( 'title' );
					$this->cost             = $this->get_option( 'cost' );

                    			// Actions
                    			add_action( 
						'woocommerce_update_options_shipping_' . $this->id, 
						array( $this, 'process_admin_options' ) 
					);

                		}
 
       
                		function init_form_fields() {
					
					$this->instance_form_fields = array(
						'title' => array(
							'title'       	=> __( 'Title', $this->plugin_slug ),
							'type'        	=> 'text',
							'description' 	=> __( 'Title', $this->plugin_slug ),
							'default'     	=> __( 'Ebook', $this->plugin_slug ),
							),
						'cost' => array(
							'title' 	=> __( 'Cost', $this->plugin_slug ),
							'type' 		=> 'text',
							'placeholder'	=> '0',
							'description'	=> __( 'Optional cost for shipping.', $this->plugin_slug ),
							'default'	=> '',
							'desc_tip'	=> true,
						),
					);

				}

                
				/**
				 * calculate_shipping function.
				 *
				 */
				public function calculate_shipping( $package = array() ) {
                            
                        		$this->add_rate( array(
						'label'	     => $this->title,
						'package'    => $package,
						'cost'       => $this->cost,
					) );
           
				}

		}//End class
 
	/**
    	 *
    	 *  Add the Shipping to WooCommerce
    	 *       
    	 */
                 
  	function add_ebook_shipping_method( $methods ) {
		$methods['ebook'] = 'WC_Ebook_Shipping_Method';
		return $methods;
	}
    	add_filter( 'woocommerce_shipping_methods', 'add_ebook_shipping_method' );
    
}  
