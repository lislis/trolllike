<?php
/*
 * Template Name: Trollfield
 *
 */

//get_header();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

        <title>Trollfeld</title>
        <?php wp_head(); ?>
    </head>
    <body>

        <script async src="https://unpkg.com/es-module-shims@1.6.3/dist/es-module-shims.js"></script>

        <script async type="importmap">
         {
             "imports": {
	         "three": "<?php echo get_stylesheet_directory_uri(); ?>/js/three/build/three.module.min.js",
	         "three/addons/": "<?php echo get_stylesheet_directory_uri(); ?>/js/three/examples/jsm/",
                 "three-noise": "<?php echo get_stylesheet_directory_uri(); ?>/js/three-noise/three-noise.module.js"
             }
         }
        </script>
        <script asyc type="module" src="<?php echo get_stylesheet_directory_uri(); ?>/js/scene.js"></script>

    </body>
</html>
<?php
