<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : 
        
        require_once(__DIR__ . '/custom_variation.php');
        $variable = get_the_Meta_from_product();
      	$sorting = 0;
        ?>
    <pre><?php print_r($variable)?></pre>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $variable as $items) : ?>
					<tr>
						<td class="label"><label for="<?php echo esc_attr( sanitize_title( $items["attribute_label"]) ); ?>"><?php echo wc_attribute_label( $items["attribute_label"] ); // WPCS: XSS ok. ?></label></td>
						<td class="value custom_product_variation">
							<?php 
                            
                                $output = '';
								
								foreach($items['data'] as $item){
                                    $variation_name = 'attribute_pa_'.strtolower(str_replace(' ', '-',$items['attribute_label']));
								    $variation_value = strtolower(str_replace(' ', '-',$item['name']));
                                    $output .= sprintf('<div><input type="radio" class="variant-input-hidden radio-variation" data-sorting="%s" data-price="%s" data-id="%s" id="%s" name="%s" value="%s">',$sorting,$item['price'],$item['id'],$item['name'],$variation_name,$variation_value);
                                    $output .= sprintf('<label for="%s">',$item['name']);
                                    $output .= sprintf('<img src="%s" alt="%s" width="100"></label>',$item['image'],$item['name']);
                                    $output .= sprintf('<label class="label">%s</label></div>',$item['name']);
								
                                }    
                                echo $output;
                               
							?>
						</td>
					</tr>
				<?php
			
				 ++$sorting;
			endforeach; ?>
			
			</tbody>
		</table>
		<div class="variations hiddenselector">

	<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					
							<?php
								wc_dropdown_variation_attribute_options(
									array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
									)
								);
															?>
					
	
				<?php endforeach; ?>

		</div>
		<a class="cart-customlocation" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
	<div class="single_variation_wrap">
			<?php

			add_action( 'woocommerce_before_add_to_cart_quantity', 'func_option_valgt' );
function func_option_valgt() {
    global $product;

    if ( $product->is_type('variable') ) {
        $variations_data =[]; // Initializing
		
        // Loop through variations data
        foreach($product->get_available_variations() as $variation ) {
            // Set for each variation ID the corresponding price in the data array (to be used in jQuery)
            $variations_data[$variation['variation_id']] = $variation['display_price'];
        }

    }
}

				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
