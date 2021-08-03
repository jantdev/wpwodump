<?php

namespace COMPO_PRODUCT\includes;

use COMPO_PRODUCT\includes\traits\singleton;

class compo_product_init{
use singleton;
    public function __construct(){
        $this->set_hooks();
    }

    public function set_hooks(){
        add_filter('woocommerce_product_data_tabs',array($this,'add_compo_product_tab'));
        add_action('woocommerce_product_data_panels',array($this,'setup_admin_product_fields'));

    }

    public function setup_admin_product_fields(){
       global $post;

      $post_id = $post->ID;
     $input_radio = get_post_meta( $post_id, '_input_radio', true );
         if( empty( $input_radio ) ) $input_radio = ''; // set default value

        
        echo '<div id="compofields_options" class="panel woocommerce_options_panel"><div class="options_group">';
  woocommerce_wp_radio( array(
        'id'            => '_input_radio',
        'wrapper_class' => array( 'show_if_simple', 'show_if_variable'  ),
        'label'         => __('Size'),
        'description'   => __( 'Delivery Period Description' ).'<br>',
        'options'       => array(
            'Small'       => __('6 inth'),
            'Medium'       => __('10 inch'),
            'Large'       => __('15 inch'),
        ),
        'value'         => $input_radio, 
    ) );



   echo '</div></div>';

    }



    public function add_compo_product_tab($tabs){

        $tabs['compofields'] = array(
            'label'		=> __( 'Compo fields', 'compo-fields-woocommerce' ),
            'target'	=> 'compofields_options',
            'class'		=> array( 'show_if_simple', 'show_if_variable'  ),
            );
        return $tabs;
    
    }

   
}    