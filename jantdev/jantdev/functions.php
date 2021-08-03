<?php

function load_css(){
    wp_register_style("mythemecss", get_template_directory_uri(  ) ."/assets/css/mythemecss.css",array(),"1.0.0","all" );
    wp_enqueue_style( "mythemecss");
}
add_action("wp_enqueue_scripts","load_css");

function load_js(){
    wp_enqueue_script('jquery');
    wp_register_script( 'mythemejs', get_template_directory_uri() .'/assets/js/mythemejs.js','jquery','1.0.0',true);
    wp_enqueue_script( 'mythemejs' );
}

add_action( 'wp_enqueue_scripts','load_js' );

function load_menus(){
    register_nav_menus(array("top-menu"=>__("top-menu"),"footer-menu"=>__("footer-menu")));
}

add_action( "init","load_menus" );

if ( is_page_template( 'page-templates/template-moreinfo.php' ) ) {
    include_once 'page-templates/template-moreinfo.php';
}


       
add_action( 'wp_ajax_contactForm', 'contact_Form');
add_action( 'wp_ajax_nopriv_contactForm', 'contact_Form');

function contact_form(){
    $postdata = [];

    wp_parse_str( $_POST['contactForm'], $postdata);

    $admin_email = get_option( 'admin_email');

    $headers[] = 'Content-Type: text/html charset=UTF-8';
    $headers[] = 'From: jantdev <' . $admin_email . '>';
    $headers[] = 'Reply-to' . $postdata['email'];

    $send_to = $admin_email;

    $subject = 'Contact me ' . $postdata['name'];

    $message = $postdata['message'];

    try {
        if(wp_mail($send_to, $subject, $message, $headers)){
            wp_send_json_success( 'form successfull sendt' );
        }else{
            wp_send_json_error( 'form error' );
        }
    }
    catch (Exception $e){
        wp_send_json_error( $e->getMessage() );
    }

}