<?php
/**
 *
 */

add_action("wp_enqueue_scripts", "troll_scripts");

function troll_scripts() {

    if (is_page_template('page-trollfield.php')) {
        /*wp_register_script('threejs',
                           get_stylesheet_directory_uri() .'/js/three.min.js',
                           array (),
                           false, false);
        wp_enqueue_script('threejs');
*/
        wp_register_script('trollfield',
                           get_stylesheet_directory_uri() .'/js/trollfield.js',
                           array (),
                           false, false);


        wp_localize_script(
            'trollfield',
            'wpData',
            array(
                'template_directory_uri' => get_stylesheet_directory_uri(), // child theme directory path.
                'rest_url' => untrailingslashit( esc_url_raw( rest_url() ) ),
                'base_url' => get_site_url(),
            )
        );

        wp_enqueue_script('trollfield');

        wp_enqueue_style( 'trolllike-style', get_stylesheet_uri(), array(), "0.0.1" );
    }
}
