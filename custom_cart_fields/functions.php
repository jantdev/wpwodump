<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style()
{
    wp_dequeue_style('storefront-style');

    wp_dequeue_style('storefront-woocommerce-style');
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */
function load_js()
{	

		wp_enqueue_script('jquery');

wp_register_script('app', get_template_directory_uri() ."-child/app.js",  'jquery', false, true);
wp_enqueue_script( "app");
}
add_action("wp_enqueue_scripts", "load_js");

/**
 * Author Name: jantdev.com
 */
// Tilføj to nye felter til produkter, vist under produktet generel fanden. 


/*Navn felt*/
function jantdev_add_navn_field()
{
    $args = array(
        'id' => 'custom_text_field_navn',
        'label' => __('Navn', 'jantdev'),
        'class' => 'jantdev-custom-navn-field',
        'desc_tip' => false,
        'placeholder' => __('Skriv dit navn', 'ctwc'),
    );
    woocommerce_wp_text_input($args);
}
add_action('woocommerce_product_options_general_product_data', 'jantdev_add_navn_field');

/* Alder felt*/
function jantdev_add_alder_field()
{
    $args = array(
        'id' => 'custom_text_field_alder',
        'label' => __('Alder', 'jantdev'),
        'class' => 'jantdev-custom-alder-field',
        'desc_tip' => false,
        'placeholder' => __('Skriv din alder', 'ctwc'),
    );
    woocommerce_wp_text_input($args);
}
add_action('woocommerce_product_options_general_product_data', 'jantdev_add_alder_field');


/* Gem felter i databasen under wp_postmeta tabellen */

function jantdev_save_fields_data($post_id)
{
    $product = wc_get_product($post_id);
    $navn = isset($_POST['custom_text_field_navn']) ? $_POST['custom_text_field_navn'] : '';
    $alder = isset($_POST['custom_text_field_alder']) ? $_POST['custom_text_field_alder'] : '';
    $product->update_meta_data('custom_text_field_navn', sanitize_text_field($navn));
    $product->update_meta_data('custom_text_field_alder', sanitize_text_field($alder));
    $product->save();
}

add_action('woocommerce_process_product_meta', 'jantdev_save_fields_data');

/* Vis de to nye felter på produkt siden*/

function jantdev_display_fields()
{
    global $post;
    $template = '<div class="jantdev_text_field" style="margin-bottom:30px;"><label for="custom_text_field_%s" style="margin-right:30px;">%s:</label><input type="text" id="custom_text_field_%s" name="custom_text_field_%s"  value="%s"/></div>';
    $product = wc_get_product($post->ID);
    $navn = $product->get_meta('custom_text_field_navn');
    $alder = $product->get_meta('custom_text_field_alder');
    printf($template, "navn", "Navn", "navn", "navn", esc_html($navn));
    printf($template, "alder", "Alder", "alder", "alder", esc_html($alder));
}

add_action('woocommerce_before_add_to_cart_button', 'jantdev_display_fields');

/* Validere input før produktet tilføjes til kurv */

function jantdev_validate_fields($passed)
{
    if (empty($_POST['custom_text_field_navn'])) {
        $passed = false;
        wc_add_notice(__('Udfyld dit navn', 'navn'), 'error');
    }

    if (empty($_POST['custom_text_field_alder'])) {
        $passed = false;
        wc_add_notice(__('Udfyld din alder', 'alder'), 'error');
    }

    return $passed;
}
add_filter('woocommerce_add_to_cart_validation', 'jantdev_validate_fields', 10, 3);


/* Gem data i kurven */


function jantdev_save_fields_data_productpage($data)
{
    if (!empty($_POST['custom_text_field_navn'])) {
        // Add the item data
        $data['custom_text_field_navn'] = $_POST['custom_text_field_navn'];
        $data['custom_text_field_alder'] = $_POST['custom_text_field_alder'];
    }
    return $data;
}
add_filter('woocommerce_add_cart_item_data', 'jantdev_save_fields_data_productpage', 10, 4);


/* Vis de nye felter i kurven */
function jantdev_field_to_cart($product, $cart_item)
{
    if (isset($cart_item['custom_text_field_navn'])) {
        $product .= sprintf(
            '<p>Navn: %s</p>',
            esc_html($cart_item['custom_text_field_navn'])
        );
    }
    if (isset($cart_item['custom_text_field_alder'])) {
        $product .= sprintf(
            '<p>Alder: %s</p>',
            esc_html($cart_item['custom_text_field_alder'])
        );
    }

    return $product;
}
add_filter('woocommerce_cart_item_name', 'jantdev_field_to_cart', 10, 3);

/* tilføj produkt til order */

function jantdev_add_data_to_order($item, $cart_item_key, $values)
{
    foreach ($item as $cart_item_key => $values) {
        if (isset($values['custom_text_field_navn'])) {
            $item->add_meta_data(__('custom_text_field_navn:', 'navn'), $values['custom_text_field_navn'], true);
        }
        if (isset($values['custom_text_field_alder'])) {
            $item->add_meta_data(__('custom_text_field_alder:', 'alder'), $values['custom_text_field_alder'], true);
        }
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'jantdev_add_data_to_order', 10, 4);

function getCount(){
    global $wpdb;
    $query_test = $wpdb->get_row( "SELECT post_title FROM {$wpdb->prefix}posts WHERE post_title='Build your custom Pizza' AND post_status='publish' AND post_type='product'" );
    if(empty($query_test)){
        echo "empty";
    }
}
