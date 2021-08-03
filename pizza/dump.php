    <?php    
    if ( $product->has_child() ) {

    $variationss = $product->get_children();
  print_r($variationss);
    foreach ( $variationss as $variation ) {
      
        if ( has_post_thumbnail( $variation ) ) {

                echo get_the_post_thumbnail( $variation );
        }
    }
}
?>
    <pre>
							<?php print_r($attributes); ?>
						</pre>



<?php foreach ( $attributes as $attribute_name => $options ) : ?>
<?php print_r($attribute_keys);?><br/>
<?php print_r($attribute_name);?><br/>
<?php print_r($options);?>
<br/>
	<?php endforeach; ?>    
    
    

<pre>
    <?php

    /*
  foreach ($product->get_available_variations() as $variation) {
        foreach (wc_get_product($variation['variation_id'])->get_variation_attributes() as $attr) {
            echo '<pre>'; var_dump($attr); echo '</pre>';
        }
$variation = wc_get_product($item['variation_id']);
$variation_attributes = $variation->get_variation_attributes();
    }
    $id = $available_variations;
    */
    
    if($product->has_child()) {
                $attributes = $product->get_attributes();
                $variations = $product->get_available_variations();
                
                $variationsArray = array();
                foreach ($attributes as $attr => $attr_deets) {
                    $variationArray = array();
                    $attribute_label = wc_attribute_label($attr);
                    $variationArray["attribute_label"] = $attribute_label;
                    if (isset($attributes[$attr]) || isset($attributes['pa_' . $attr])) {
                        $attribute = isset($attributes[$attr]) ? $attributes[$attr] : $attributes['pa_' . $attr];
                         
                        if ($attribute['is_taxonomy']) {
                           
                            $variationArray["attribute_name"] = $attribute['name'];
                            $variationIds = array();
                            $variationNames = array();
                            $variationPrices = array();
                            $variationImage = array();
                          
                            foreach ($variations as $variation) {
                                if (!empty($variation['attributes']['attribute_' . $attribute['name']])) {
                                    array_push($variationIds, $variation['variation_id']);
                                  
                                    $taxonomy = $attribute['name'];
                                    $meta = get_post_meta($variation['variation_id'], 'attribute_'.$taxonomy, true);

                                  
                                    $term = get_term_by('slug', $meta, $taxonomy);
                                    $variation_name = $term->name;
                                    array_push($variationNames, $variation_name);
                                    array_push($variationPrices, $variation['display_regular_price']);
                                    array_push($variationImage, $variation['image']['thumb_src']);
                                }
                            }
                            $variationArray["variation_prices"] = $variationPrices;
                            $variationArray["variations"] = array_combine($variationIds, $variationNames);
                            $variationArray["image"] = array_combine($variationIds, $variationImage);
                            
                        }
                    }
                    array_push($variationsArray, $variationArray);
                }
                
            }

            $product_variations = $variationsArray;
echo '<pre>'; print_r($product_variations);echo '</pre>';
  woocommerce_form_field( 'custom_field_Sizes', array(
                                        'type'            => 'radio',
                                        'required'        => true,
                                        'class'           => array('custom-field-sizes'),
                                        'options'         => $item['variations']
                                    ),$item['variation_prices']);
?>
</pre>

 <pre><?php print_r($variable);?></pre>

<?php
 add_action( 'woocommerce_after_add_to_cart_form', 'total_product_and_subotal_price' );
function total_product_and_subotal_price() {
    global $product;

    $product_price = (float) wc_get_price_to_display( $product );
    $cart_subtotal = (float) WC()->cart->subtotal + $product_price;

    $price_0_html  = wc_price( 0 ); // WooCommmerce formatted zero price (formatted model)
    $price_html    = '<span class="amount">'.number_format($product_price, 2, ',', ' ').'</span>';
    $subtotal_html = '<span class="amount">'.number_format($cart_subtotal, 2, ',', ' ').'</span>';

    // Display formatted product price total and cart subtotal amounts
    printf('<div id="totals-section"><p class="product-total">%s</p><p class="cart-subtotal">%s</p></div>',
        str_replace([' amount','0,00'], ['',$price_html], $price_0_html), // formatted html product price
        str_replace([' amount','0,00'], ['',$subtotal_html], $price_0_html) // Formatted html cart subtotal
    );
    ?>
    <script>
    jQuery( function($){
        var productPrice      = <?php echo $product_price; ?>,
            startCartSubtotal = <?php echo $cart_subtotal; ?>;

        function formatNumber( floatNumber ) {
            return floatNumber.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ').replace('.', ',');
        }

        $('input[name=quantity]').on( 'input change', function(){
            var productQty   =  $(this).val() == '' ? 1 : $(this).val(),
                productTotal = parseFloat(productPrice * productQty),
                cartSubtotal = productTotal + startCartSubtotal - productPrice;

            cartSubtotal = $(this).val() > 1 ? parseFloat(cartSubtotal) : parseFloat(startCartSubtotal);

            $('#totals-section > .product-total .amount').html( formatNumber(productTotal) );
            $('#totals-section > .cart-subtotal .amount').html( formatNumber(cartSubtotal) );
        });
    });
    </script>
    <?php
}
    



    
/*
add_filter( 'woocommerce_add_to_cart_fragments', 'header_add_to_cart_fragment', 30, 1 );
function header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;

    ob_start();

    ?>
    <a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
    <?php
    $fragments['a.cart-customlocation'] = ob_get_clean();

    return $fragments;
}

require_once(__DIR__ . '/custom_variation.php');



$variable = [];
function getMeta(){
$variable = get_the_Meta_from_product();
print_r($variable);
}


do_action( 'woocommerce_before_add_to_cart_form','getMeta',10,0);
*/

/*
function njengah_woo_attribute(){
 
    global $product;
 
    $attributes = $product->get_attributes();
 
    if ( ! $attributes ) {
 
        return;
 
    }
 
    $display_result = '';
 
 
    foreach ( $attributes as $attribute ) {
 
        if ( $attribute->get_variation() ) {
            continue;
        }
 
        $name = $attribute->get_name();
 
        if ( $attribute->is_taxonomy() ) {
 
            $terms = wp_get_post_terms( $product->get_id(), $name, 'all' );
 
            $njengahtax = $terms[0]->taxonomy;
 
            $njengah_object_taxonomy = get_taxonomy($njengahtax);
 
            if ( isset ($njengah_object_taxonomy->labels->singular_name) ) {
 
                $tax_label = $njengah_object_taxonomy->labels->singular_name;
 
            } elseif ( isset( $njengah_object_taxonomy->label ) ) {
 
                $tax_label = $njengah_object_taxonomy->label;
 
                if ( 0 === strpos( $tax_label, 'Product ' ) ) {
 
                    $tax_label = substr( $tax_label, 8 );
 
                }
 
            }
 
            $display_result .= $tax_label . ': ';
 
            $tax_terms = array();
 
            foreach ( $terms as $term ) {
 
                $single_term = esc_html( $term->name );
 
                array_push( $tax_terms, $single_term );
 
            }
 
            $display_result .= implode(', ', $tax_terms) .  '<br />';
 
 
 
 
        } else {
 
            $display_result .= $name . ': ';
 
            $display_result .= esc_html( implode( ', ', $attribute->get_options() ) ) . '<br />';
 
        }
 
    }
 
    echo $display_result;
 
}
add_action('woocommerce_single_product_summary', 'njengah_woo_attribute', 25);



function my_custom_product_template($template, $slug, $name) {
	
global $post;


$terms = get_the_terms( $post->ID, 'product_cat' );
foreach ($terms as $term) {
    $product_cat_name = $term->name;
    break;
}


    if ($name === 'single-product' && $slug === 'content') {
		

		
	
        $temp = locate_template(array("{$slug}-{$name}-{$product_cat_name}.php", WC()->template_path() . "{$slug}-{$name}-{$product_cat_name}.php"));
		
        if($temp) {
           $template = $temp;
        }
    }
    return $template;
}

add_filter('wc_get_template_part', 'my_custom_product_template', 10, 3);



 add_action( 'woocommerce_before_add_to_cart_form', 'total_product_and_subotal_price' );
function total_product_and_subotal_price() {
    global $product;

    $product_price = (float) wc_get_price_to_display( $product );
    $cart_subtotal = (float) WC()->cart->subtotal + $product_price;

    $price_0_html  = wc_price( 0 ); // WooCommmerce formatted zero price (formatted model)
    $price_html    = '<span class="amount">'.number_format($product_price, 2, ',', ' ').'</span>';
    $subtotal_html = '<span class="amount">'.number_format($cart_subtotal, 2, ',', ' ').'</span>';

    // Display formatted product price total and cart subtotal amounts
    printf('<div id="totals-section"><p class="product-total">%s</p><p class="cart-subtotal">%s</p></div>',
        str_replace([' amount','0,00'], ['',$price_html], $price_0_html), // formatted html product price
        str_replace([' amount','0,00'], ['',$subtotal_html], $price_0_html) // Formatted html cart subtotal
    );
    ?>
    <script>
    jQuery( function($){
        var productPrice      = <?php echo $product_price; ?>,
            startCartSubtotal = <?php echo $cart_subtotal; ?>;

        function formatNumber( floatNumber ) {
            return floatNumber.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ').replace('.', ',');
        }

        $('input[name=quantity]').on( 'input change', function(){
            var productQty   =  $(this).val() == '' ? 1 : $(this).val(),
                productTotal = parseFloat(productPrice * productQty),
                cartSubtotal = productTotal + startCartSubtotal - productPrice;

            cartSubtotal = $(this).val() > 1 ? parseFloat(cartSubtotal) : parseFloat(startCartSubtotal);

            $('#totals-section > .product-total .amount').html( formatNumber(productTotal) );
            $('#totals-section > .cart-subtotal .amount').html( formatNumber(cartSubtotal) );
        });
    });
    </script>
<?php
}


add_action( 'woocommerce_init', 'force_non_logged_user_wc_session' );
function force_non_logged_user_wc_session(){ 
    if( is_user_logged_in() || is_admin() )
       return;

    if ( isset(WC()->session) && ! WC()->session->has_session() ) 
       WC()->session->set_customer_session_cookie( true ); 
}
function filter_woocommerce_add_to_cart_validation( $passed, $product_id, $quantity, $variation_id = null, $variations = null ) {
    // Set max allowed
    $max_allowed = 10;
    
    // Error message
    $message = 'max ' . $max_allowed . ' products allowed';
    
    // quantity > max allowed || elseif = when cart not empty
    if ( $quantity > $max_allowed ) {
        wc_add_notice( __( $message, 'woocommerce' ), 'error' );
        $passed = false;   
    } elseif ( ! WC()->cart->is_empty() ) {
        // Get current product id
        $product_id = $variation_id > 0 ? $variation_id : $product_id;
    
        // Cart id
        $product_cart_id = WC()->cart->generate_cart_id( $product_id );
    
        // Find product in cart
        $in_cart = WC()->cart->find_product_in_cart( $product_cart_id );
        
        // True
        if ( $in_cart ) {
            // Get cart
            $cart = WC()->cart->get_cart();

            // Current quantity in cart
            $quantity_in_cart = $cart[$product_cart_id]['quantity'];
            
            // Condition: quanitity in cart + new add quantity greater than max allowed
            if ( $quantity_in_cart + $quantity > $max_allowed ) {           
                wc_add_notice( __( $message, 'woocommerce' ), 'error' );
                $passed = false;
            }
        }
    }
    
    return $passed;
}
add_filter( 'woocommerce_add_to_cart_validation', 'filter_woocommerce_add_to_cart_validation', 10, 5 );


function disable_add_to_cart_till_required_fields_filled(){
    ?>
    <script type="text/javascript">
        (function($, window, document) {
            function may_disable_add_to_cart_button(){
                var req_fields = $('.thwepof-input-field.validate-required');
                var disabled = false;
                
                $.each(req_fields, function(index, elm){
                    var value = '';
                    var finput = $(elm);

                    var type = finput.getType();
                    var name = finput.prop('name');

                    if(type == 'radio'){
                      value = $("input[type=radio][name='"+name+"']:checked").val();

                    }else if(type == 'checkbox'){
                      value = $("input[type=checkbox][name='"+name+"']:checked").val();

                    }else{
                      value = finput.val();
                    }
                
                    if(isEmpty(value)){
                        disabled = true;
                    }
                });
                $('.single_add_to_cart_button').prop("disabled", disabled);
            }

            $.fn.getType = function(){
              try{
                return this[0].tagName == "INPUT" ? this[0].type.toLowerCase() : this[0].tagName.toLowerCase(); 
              }catch(err) {
                return 'E001';
              }
            }

            function isEmpty(str){ 
              return (!str || 0 === str.length); 
            }

            $('.thwepof-input-field').on('keyup change', function(){
                may_disable_add_to_cart_button();
            });
            may_disable_add_to_cart_button();
            
        }(window.jQuery, window, document));
    </script>
<?php
}
add_action('wp_footer', 'disable_add_to_cart_till_required_fields_filled');



remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

add_action( 'woocommerce_before_single_product_summary', function(){
	echo "hello";
});



*/