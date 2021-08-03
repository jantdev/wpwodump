<?php 




$the_query = new WP_Query( array( 'category_name' => 'frontpage',"title" =>$args["product"],"post_status"=>"publish") ); 

// The Loop
if ( $the_query->have_posts() ) {
    while ( $the_query->have_posts() ) {
        global $post;
    $the_query->the_post();
    $blocks = parse_blocks(get_the_content());
    //var_dump($blocks);
    $quote = "";
    $image="";
    $paragraf = "";
    $button = "";
    foreach($blocks as $block){
        if($block["blockName"]=="core/quote"){
          $quote = strip_tags(render_block($block),"");
        }
       if($block["blockName"]=="core/image"){
           $image .= strip_tags(render_block($block),"<img>");
       }
       if($block["blockName"]=="core/paragraph"){
       
            $paragraf .= strip_tags(render_block($block),"");
          
       
       }
       if($block["blockName"]=="core/buttons"){
 $innerHTML="Missing";
 
           if($block["innerBlocks"]){
               $innerBlock = $block["innerBlocks"][0];
         
                $innerHTML = $innerBlock["innerHTML"];             
              }
           $button = strip_tags(render_block($innerBlock),"<a>");
       }
    }

?>

<section class="product <?php echo str_replace(" ","",get_the_title());?>">
    <div class="intro">
        <h3><?php echo get_the_title();?></h3>
        <p>
         <?php echo $quote;?>
        </p>
    </div>
    <div class="display">
        <div class="img">
            <?php echo $image;?>
        </div>
        <div class="capturetext">
           <?php echo $paragraf;?>
        </div>
         <?php echo get_post_meta($post->ID,"textx",true);?>
        <?php if($button!=""):?>
        <div class="linkcontent">
           <?php echo $button;?>
          
        </div>
        <?php endif;?>
    </div>
    <svg viewBox="0 0 1140 150" class="nextthing">
        <polygon points="0,0 570,150 1140,0" style="fill: white" />
        Sorry, your browser does not support inline SVG.
    </svg>
</section>
<?php
}
}


 
/* Restore original Post Data */
wp_reset_postdata();

