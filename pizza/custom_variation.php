<?php
/**
 * Function to get a product attributs and its variations
 * it taks one parameter from what product is active on the variable page
 * returns a array of the product attributs and variation
 */


 function get_the_Meta_from_product(){
     
global $product;
  $product_variations = [];
   // if(empty($product)) wp_die();

   
  if($product->has_child()) {
                $attributes = $product->get_attributes();
                $variations = $product->get_available_variations();
                
                $variationsArray = array();
                foreach ($attributes as $attr => $attr_deets) {
                    $variationArray = array();
                    $attribute_label = wc_attribute_label($attr);
                    $variationArray["attribute_label"] = $attribute_label;
                    if (isset($attributes[$attr]) || isset($attributes['pa_' . $attr])) {
                        $attribute = isset($attributes[$attr]) ? $attributes[$attr] : $attributes['pa_' . $attr];
                         
                        if ($attribute['is_taxonomy']) {
                            $variationArray["attribute_name"] = $attribute['name'];
                            $data = array();
                            foreach ($variations as $variation) {
                                if (!empty($variation['attributes']['attribute_' . $attribute['name']])) {
            
                                    $taxonomy = $attribute['name'];
                                    $meta = get_post_meta($variation['variation_id'], 'attribute_'.$taxonomy, true);

                                  
                                    $term = get_term_by('slug', $meta, $taxonomy);
                                    $variation_name = $term->name;



                                      $stuff = array(
                                        'id'=>$variation['variation_id'],
                                        'name'=>$variation_name,
                                        'image'=>$variation['image']['thumb_src'],
                                        'price'=>$variation['display_regular_price'],
                                     );

                                  array_push($data,$stuff);
                                   
                                }
                            }
                             $variationArray["data"] =$data;
                        
                        }
                    }

                    array_push($variationsArray, $variationArray);
                 
                }
                
            }

        $product_variations = $variationsArray;
          
         
return $product_variations;


 }

