<?php

function opgave_register_parallax_images( $wp_customize){

    $wp_customize->add_section(
        'opgave_parallax',array(
            'title'=>'Opgave Parallax',
            'description'=>'Her kan du ændre de to billeder i parallax functionen',
            'priority'          => 70
        )
    );
    
   $wp_customize->add_setting(
       'opgave_parallax_background_image', array(
           'type'                  =>  'theme_mod',
            'capability'            =>  'edit_theme_options',
            'default'           => get_template_directory_uri() . '/assets/images/photo-1579403124614-197f69d8187b.jpg',
           'transport'         => 'refresh'
        
  
    ));
  
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'opgave_parallax_background_image', array(
        'label'    => __('Baggrunds billede', 'opgave'),
        'section'  => 'opgave_parallax',
        'settings' => 'opgave_parallax_background_image',
    )));

     $wp_customize->add_setting(
       'opgave_parallax_scroll_image', array(
           'type'                  =>  'theme_mod',
            'capability'            =>  'edit_theme_options',
            'default'           => get_template_directory_uri() . '/assets/images/photo-1542546068979-b6affb46ea8f.jpg',
            'transport'         => 'refresh'
        
  
    ));
  
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'opgave_parallax_scroll_image', array(
        'label'    => __('Scroll billede', 'opgave'),
        'section'  => 'opgave_parallax',
        'settings' => 'opgave_parallax_scroll_image',
    )));


}

add_action( 'customize_register', 'opgave_register_parallax_images' );


function opgave_register_carousel_images( $wp_customize){

    $wp_customize->add_section(
        'opgave_carousel',array(
            'title'=>'Opgave carousel',
            'description'=>'Her kan du ændre de billeder der er i karusellen',
            'priority' => 80
        )
    );
   

    
  $caruosel =$GLOBALS['OPGAVE_CARUOSEL'];
    
    
   
    $image_count=1;

    foreach($caruosel as $image=>$path){
        $wp_customize->add_setting(
       'opgave_carousel_image_'.$image_count, array(
           'type'                  =>  'theme_mod',
            'capability'            =>  'edit_theme_options',
            'default'           => $path,
           'transport'         => 'refresh'
        
  
    ));
      $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'opgave_carousel_image_'.$image_count, array(
        'label'    => __('Billede '.$image_count, 'opgave'),
        'section'  => 'opgave_carousel',
        'settings' => 'opgave_carousel_image_'.$image_count,
    )));

    ++$image_count;
    }
}

add_action( 'customize_register', 'opgave_register_carousel_images' );