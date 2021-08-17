<?php
/*
Plugin Name: poppro

*/

if (false === defined('ABSPATH')) {
    die();
}

add_action( 'init',function(){
    add_rewrite_tag('%product_id%','([0-9]+)');
    add_rewrite_rule('ajax_api/product/([0-9]+)/?','index.php?product_id=$matches[1]','top');
});

add_action( 'template_redirect','ajax_callback_from_rewrite_rule' ,10); 


function ajax_callback_from_rewrite_rule(){
    global $wp_query;
    
    $productId = $wp_query->get('product_id');
    if(!empty($productId)){
      
    $args = array(
        'p' => $productId,
        'post_type' => 'product',
    );
    $loop = new WP_Query( $args );
    
    if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post();
        ?><div class="stom-product-pop-modal-content"><div class="modal-header"><span id="stom-product-pop-modal-close" class="close">&times;</span></div>
            <div class="modal-body">
                <div class="modal-image" style="background-image: url(<?php echo get_the_post_thumbnail_url( $productId ); ?>)"></div>
                <div id="product-<?php the_ID(); ?>" <?php post_class(); ?> style="margin:2rem">
                <?php do_action( 'woocommerce_single_product_summary'); ?>                  
                </div>
            </div>
            <div class="modal-footer"></div></div><?php
        endwhile;
    endif;
    
    wp_send_json_success(true);
       wp_reset_postdata();
       wp_die();
    }
     
}


function stom_product_pop_load_style(){
    wp_enqueue_style('stom_product_pop_style',plugin_dir_url(__FILE__) . 'assets/css/popstyles.css', array(), '1.0.1', 'all');
}
add_action('wp_enqueue_scripts', 'stom_product_pop_load_style',100);

function stom_product_pop_load_js(){
    wp_enqueue_script('stom_product_pop_js', plugin_dir_url(__FILE__) . 'assets/js/popjs.js', array('jquery'), '1.0.1', true);
}
add_action('wp_enqueue_scripts', 'stom_product_pop_load_js');

add_action( 'wp_footer', 'my_ajax_without_file' );

function my_ajax_without_file() { ?>

    <script type="text/javascript" >

    jQuery(document).ready(function($) {
      

        $.ajaxPrefilter(function(data){
          
            if(data && data.url.indexOf('ajax_api/product/')>0){
                $('#stom-product-pop-overlay').fadeIn(300);
            }
        })
        
        $(document).ajaxComplete(function(event,xhr,settings){
          
            if(settings.data.length===0){
                add_stom_product_pop();
            }
        })
       
        $('#stom-product-pop-overlay').hide();

        add_stom_product_pop = ()=>{
            $('.add_to_cart_button').hide();
            $('.product_type_grouped').hide();
            $('.product_type_external').hide();
        
            $('.woocommerce-LoopProduct-link').on('click',(e)=>{
                e.preventDefault();
                let closest = $(e.target).closest('li')
                let product_class = $(closest[0]).attr('class');
                let post_id = product_class.match(/post\-\d+/);
                let product_id = post_id[0].replace(/[^0-9]/g, '');

                let ajaxurl = '<?php echo get_site_url()?>/ajax_api/product/'+product_id;
                 console.log(ajaxurl);
                var data = {
                    'action': 'frontend_action_without_file', 
                    'product_id':product_id,
                    'product_url':$(e.target).attr('href')
                 };

                jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data:  data,
                    dataType: 'text',
                    contentType: 'application/json',
                    success: function (response) {
                        $('#stom-product-pop-overlay').hide();
                        $('#stom_product_pop_modal').empty().append(response.replace('{"success":true,"data":true}',''));
                        $('#stom-product-pop-modal-close').on('click',()=>{
                            $('#stom_product_pop_modal').hide();
                        });
                        $('#stom_product_pop_modal').show();
                    },
                    error:function(xhr, status, error){
                       console.log(status);
                    },
                });
            })

        }
        add_stom_product_pop();

        window.onclick = function(event) {
            if (event.target.id == 'stom_product_pop_modal') {
                $('#stom_product_pop_modal').hide();
            }
        }
        
        
    });
    </script>
    <div id="stom-product-pop-overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    <div id="stom_product_pop_modal" class="stom-product-pop-modal"></div>
    <?php
}