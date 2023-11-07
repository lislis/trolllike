<?php
/*
 * Template Name: Load images
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

        <title>Load images</title>

        <?php wp_head(); ?>
    </head>
    <body>
        <?php
        $posts = get_posts(array('type' => 'post',
                                 'numberposts' => -1));

        $urls = array();
        foreach ($posts as $post) {
            $meta = get_post_meta($post->ID, 'youtube_link', true);
            if ($meta != "") {
                //print_r($post->ID);
                //print_r($meta);
                $pos  = strpos($meta, '=');
                $id = substr($meta, $pos + 1);
                //             print_r($id);
                $url = thumbnail_url($id, 'youtube');

                echo "<img src='". $url ."'><br>";
                echo "<img src='https://img.youtube.com/vi/". $id ."/sddefault.jpg'><br>";
            }
        }

        ?>
        <?php wp_footer(); ?>
    </body>
</html>
<?php
