<?php

add_action("wp_enqueue_scripts", "troll_scripts");

function troll_scripts() {

    if (is_page_template('page-trollfield.php')) {
        wp_register_script('poisson-disk',
                           get_stylesheet_directory_uri() .'/js/poisson-disk.min.js',
                           array(),
                           false, false);
        wp_enqueue_script('poisson-disk');


        /* wp_register_script('aframe-fork',
         *                    'https://cdn.jsdelivr.net/gh/akbartus/A-Frame-Component-Postprocessing/dist/aframe.min.js',
         *                    array(),
         *                    false, false);
         * wp_enqueue_script('aframe-fork');

         * wp_register_script('aframe-post-plugin',
         *                    'https://cdn.jsdelivr.net/gh/akbartus/A-Frame-Component-Postprocessing/dist/post-processing.min.js',
         *                    array('aframe-fork'),
         *                    false, false);
         * wp_enqueue_script('aframe-post-plugin');
         */

        /* wp_register_script('aframe',
         *                    get_stylesheet_directory_uri() .'/js/aframe.min.js',
         *                    array(),
         *                    false, false);
         * wp_enqueue_script('aframe');

         * wp_register_script('aframe-extras',
         *                    get_stylesheet_directory_uri() .'/js/aframe-extras.min.js',
         *                    array('aframe'),
         *                    false, false);
         * wp_enqueue_script('aframe-extras');

         * wp_register_script('aframe-env',
         *                    get_stylesheet_directory_uri() .'/js/aframe-environment-component.min.js',
         *                    array('aframe'),
         *                    false, false);
         * wp_enqueue_script('aframe-env');

         * wp_register_script('postprocessing',
         *                    get_stylesheet_directory_uri() .'/js/postprocessing.min.js',
         *                    array('aframe'),
         *                    false, false);
         * wp_enqueue_script('postprocessing');

         * wp_register_script('aframe-cursor',
         *                    get_stylesheet_directory_uri() .'/js/cursor-component.js',
         *                    array('aframe'),
         *                    false, false);
         * wp_enqueue_script('aframe-cursor');

         * wp_register_script('post',
         *                    get_stylesheet_directory_uri() .'/js/postprocessing.js',
         *                    array('aframe', 'postprocessing'),
         *                    false, false);
         * wp_enqueue_script('post');
         */

        wp_register_script('trollfield',
                           get_stylesheet_directory_uri() .'/apps/trollfield/dist/index.js',
                           array ('poisson-disk'),
                           '0.1.0', true);

        $posts = get_posts(array('type' => 'post',
                                 'numberposts' => -1));

        $urls = array();
        foreach ($posts as $post) {
            $meta = get_post_meta($post->ID, 'youtube_link', true);
            if ($meta != "") {
                $pos = strpos($meta, '=');
                $id = substr($meta, $pos + 1);
                $url = thumbnail_url($id, 'youtube');

                $urls[$post->ID] = $url;
            }
        }

        wp_localize_script(
            'trollfield',
            'wpData',
            array(
                'template_directory_uri' => get_stylesheet_directory_uri(), // child theme directory path.
                'rest_url' => untrailingslashit( esc_url_raw( rest_url() ) ),
                'base_url' => get_site_url(),
                'main_filter_cat' => get_option('main_filter_cat'),
                'youtube_tag_id' => get_option('youtube_tag'),
                'video_tag_id' => get_option('video_tag'),
                'link_tag_id' => get_option('link_tag'),
                'text_tag_id' => get_option('text_tag'),
                'document_tag_id' => get_option('document_tag'),
                'about_page_id' => get_option('about_page_id'),
                'youtube_urls' => $urls,
            )
        );

        wp_enqueue_script('trollfield');

        wp_enqueue_style( 'trolllike-style', get_stylesheet_uri(), array(), "0.0.1" );
        wp_enqueue_style( 'trolllike-app-style', get_stylesheet_directory_uri() . "/app/trollfield/dist/assets/index.css", array('troll_style'), "0.0.1" );
        wp_enqueue_style( 'preview-visual-link', plugins_url( 'visual-link-preview/dist/public.css', dirname(__FILE__) ) );
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
