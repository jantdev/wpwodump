    <?php

$the_query = new WP_Query( array( 'category_name' => 'quot',"post_status"=>"publish") ); 

if ( $the_query->have_posts() ) {

    $the_query->the_post();
    $blocks = parse_blocks(get_the_content());
     
    $quot = "";
    foreach($blocks as $block){
   
        if($block["blockName"]=="core/quote"){
           
           $quot = strip_tags(render_block($block),"");
       }
        
    }

?>
    
    
    
    <section class="quot" id="gotoquot">
              <div class="storytelling">
               <?php echo $quot;?>
              </div>
              <a href="#portfolio" class="linkportfolio">Portfolio</a>
            </section>

 <?php
 
}
?>