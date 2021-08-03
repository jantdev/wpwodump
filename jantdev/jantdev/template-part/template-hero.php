<?php

$the_query = new WP_Query( array( 'category_name' => 'intro',"post_status"=>"publish") ); 

if ( $the_query->have_posts() ) {
    $the_query->the_post();
    $blocks = parse_blocks(get_the_content());
      $image="";
    $paragraf = "";
    foreach($blocks as $block){
        if($block["blockName"]=="core/image"){
           $image = strip_tags(render_block($block),"<img>");
       }
         if($block["blockName"]=="core/paragraph"){
       
            $paragraf .= strip_tags(render_block($block),"");
          
       
       }
    }
?>


  <section class="hero">
              <div class="greetings">
                <div class="profilpicture">
                  <?php echo $image;?>                </div>
                <div class="hello">
                  <h1><?php echo get_the_title();?></h1>
                  <p> <?php echo $paragraf;?></p>
                </div>
              </div>
              <div class="moreinfo">
                <a href="#gotoquot"><i class="arrordown"></i></a>
              </div>
            </section>


<?php
}
?>            