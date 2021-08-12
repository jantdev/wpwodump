<?php
/*
Theme Name: Opgave
Author: Wordpress Developer
Author URI: https://wordpress.org
Description: Her er min løsning til Bærnholdt frontend opgave 1.0.
Version: 1.0
Text Domain: opgave
*/
?>
<?php get_header(); ?>
    <div class="main-container">
    <?php
      $opgave_parallax_background_image_frontend = '';
      if(get_theme_mod('opgave_parallax_background_image')){
         $opgave_parallax_background_image_frontend= get_theme_mod( 'opgave_parallax_background_image' ); 
      }else{
        $opgave_parallax_background_image_frontend = get_template_directory_uri() . '/assets/images/photo-1579403124614-197f69d8187b.jpg';
      }
      ?>
      <div class="image2" style="background-image:url(<?php echo $opgave_parallax_background_image_frontend;?>"></div>
      <div class="parallexImage3">
      <?php
      $opgave_parallax_scroll_image_frontend = '';
      if(get_theme_mod('opgave_parallax_scroll_image')){
         $opgave_parallax_scroll_image_frontend = get_theme_mod( 'opgave_parallax_scroll_image' ); 
      }else{
        $opgave_parallax_scroll_image_frontend =  get_template_directory_uri() . '/assets/images/photo-1542546068979-b6affb46ea8f.jpg';
      } 
      ?>
      <div class="image3" style="background-image:url(<?php echo $opgave_parallax_scroll_image_frontend;?>)"></div>
        </div>
        <div class="reference-block">
          <div class="reference-text">
           <?php
                $args = array(
                'category_name' => 'opgave'
                );
                $query = new WP_Query( $args );
                if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        echo '<h2>'.get_the_title().'</h2>';
                        echo get_the_content( );
                    }
                }
                    wp_reset_postdata();
            ?>
          
          </div>
        </div>
      
<?php echo do_shortcode("[caruosel]"); ?>
          </div>

<?php get_footer(); ?>