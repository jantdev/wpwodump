

<?php 
get_header();
$templatePath = "template-part/template";
?>
 <main>
    <div class="main-container">
<?php get_template_part($templatePath,"hero");?>
<?php get_template_part($templatePath,"quot");?>
<?php get_template_part($templatePath,"subject",array("name"=>"UX/UI design","id"=>"portfolio"));?>
<?php get_template_part($templatePath,"product",array("product"=>"Post Danmark ePosthuset"));?>
<?php get_template_part($templatePath,"product",array("product"=>"Post Danmark Pakkeboks"));?>
<?php get_template_part($templatePath,"subject",array("name"=>"Webdesign","id"=>"webdesign"));?>
<?php get_template_part($templatePath,"product",array("product"=>"Humledrengene"));?>
<?php get_template_part($templatePath,"product",array("product"=>"Fleksibil"));?>
  <section class="morewebsites">
    <div class="linkcontentmore">
        <a href="#" class="btn--link">MORE WEBSITES</a>
    </div>
</section>
<?php get_template_part($templatePath,"subject",array("name"=>"Frontend","id"=>"frontend"));?>
<?php get_template_part($templatePath,"product",array("product"=>"Custom Pizza Builder"));?>
<?php get_template_part($templatePath,"product",array("product"=>"Seder"));?>
<?php get_template_part($templatePath,"contactform");?>
</div>
 </main>
<?php get_footer(); ?>