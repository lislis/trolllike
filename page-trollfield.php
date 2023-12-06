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
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>Trolllike</title>
        <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/apps/trollfield/dist/favicon.ico" />

        <?php wp_head(); ?>
    </head>
    <body>
        <div id="trollfield-app"></div>
        <noscript>Diese App benötigt JavaScript. Bitte aktiviere JavaScript in deinen Browsereinstellungen.</noscript>

        <?php wp_footer(); ?>
    </body>
</html>
<?php
