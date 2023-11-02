<?php

add_action("wp_enqueue_scripts", "troll_scripts");

function troll_scripts() {

    if (is_page_template('page-trollfield.php')) {
        wp_register_script('poisson-disk',
                           get_stylesheet_directory_uri() .'/js/poisson-disk.min.js',
                           array(),
                           false, false);

        wp_enqueue_script('poisson-disk');

        /* wp_register_script('aframe',
         *                    get_stylesheet_directory_uri() .'/js/aframe.min.js',
         *                    array(),
         *                    false, false);
         * wp_enqueue_script('aframe');
         */
        /* wp_register_script('aframe-extras',
         *                    get_stylesheet_directory_uri() .'/js/aframe-extras.min.js',
         *                    array('aframe'),
         *                    false, false);
         * wp_enqueue_script('aframe-extras'); */

        /* wp_register_script('aframe-env',
         *                    get_stylesheet_directory_uri() .'/js/aframe-environment-component.min.js',
         *                    array('aframe'),
         *                    false, false);
         * wp_enqueue_script('aframe-env');
         */


        wp_register_script('trollfield',
                           get_stylesheet_directory_uri() .'/apps/trollfield/dist/index.js',
                           array ('poisson-disk'),
                           '0.1.0', true);

        wp_localize_script(
            'trollfield',
            'wpData',
            array(
                'template_directory_uri' => get_stylesheet_directory_uri(), // child theme directory path.
                'rest_url' => untrailingslashit( esc_url_raw( rest_url() ) ),
                'base_url' => get_site_url(),
                'main_filter_cat' => get_option('main_filter_cat'),
                'youtube_tag_id' => get_option('youtube_tag'),
            )
        );

        wp_enqueue_script('trollfield');

        wp_enqueue_style( 'trolllike-style', get_stylesheet_uri(), array(), "0.0.1" );
        wp_enqueue_style( 'trolllike-app-style', get_stylesheet_directory_uri() . "/app/trollfield/dist/assets/index.css", array('troll_style'), "0.0.1" );
    }
}


add_action( 'rest_api_init', function () {
    register_rest_route( 'trolllike-theme/v1', '/tags/', array(
        'methods' => 'GET',
        'callback' => 'troll_get_tags',
        'permissions_callback' => __return_true()
    ) );
} );


function troll_get_tags($data) {

    $cat = get_category(get_option('main_filter_cat'));

    $posts = get_posts(array('post_type' => 'post',
                             'category' => $cat->ID,
                             'numberposts' => 100));

    $tags = array();

    foreach ($posts as $post) {
        $t = wp_get_post_tags($post->ID);
        $tags = array_merge($tags, $t);
    }

    return $tags;
}
