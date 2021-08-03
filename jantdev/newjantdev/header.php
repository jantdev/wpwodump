<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jantdev - Freelancer - webdeveloper</title>
    
    
        <meta name="description" content="jantdev.com, Freelance webdeveloper, creates and maintains responsive websites, SPA and Designs user interfaces" />
    <meta name="keywords" content="html,css,javascript,react,vue,webpack,nodejs,npm,photoshop,figma,spa,wordpress,mysql,php,freelancer,typescript" />
    <?php wp_head();?>
</head>

<body <?php body_class('main'); ?>>
 

        <div class="grid-container">
            <header>
                <div class="header-container">
                    <div class="logo"><a href="/">jantdev</a></div>

                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <nav>
                        <?php wp_nav_menu( array("theme_location"=>"top-menu","class"=>"topnavigation"));?>
                     
                    </nav>
                </div>
            </header>
            