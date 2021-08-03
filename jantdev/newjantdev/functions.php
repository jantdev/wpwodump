<?php

function load_css_and_js(){

    wp_enqueue_style( "appcss", get_template_directory_uri(  ) ."/dist/css/app.css",array(),"1.0.0","all");
    wp_enqueue_script( "appjs", get_template_directory_uri(  ) . "/dist/js/app.js", array(),"1.0.0",true);
}
add_action("wp_enqueue_scripts","load_css_and_js");

function load_menus(){
    register_nav_menus(array("top-menu"=>__("top-menu"),"footer-menu"=>__("footer-menu")));
}

add_action( "init","load_menus" );



?>