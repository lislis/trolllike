<?php
/**
 *
 */

require_once("inc/register-apps.php");
require_once("inc/custom-settings.php");



register_meta('post', 'youtube_link', [
    'object_subtype' => 'post', // Limit to a post type.
    'type'           => 'string',
    'description'    => 'TEst',
    'single'         => true,
    'show_in_rest'   => true,
]);
