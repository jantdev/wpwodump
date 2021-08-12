<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header>
     
      <div class="header-image" style="background-image: url(<?php header_image(); ?>);"></div>
      <div class="introtext-outer">
        <div class="introtext-inner">
         <?php
         if( have_posts() ) :
            while ( have_posts() ) : the_post(); 
	            if( get_option( 'page_on_front' ) ) {
             the_title('<h1>','</h1>'); 
                echo apply_filters( 'the_content', get_post( get_option( 'page_on_front' ) )->post_content );
            }
            endwhile;
        endif; 
         
?>
        </div>
      </div>
    </header>
    <main>

 