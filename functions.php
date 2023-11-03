<?php
/**
 *
 */

require_once("inc/register-apps.php");
require_once("inc/custom-settings.php");



register_meta('post', 'youtube_link', [
    'object_subtype' => 'post', // Limit to a post type.
    'type'           => 'string',
    'description'    => 'Link to a youtube video',
    'single'         => true,
    'show_in_rest'   => true,
]);

register_meta('post', 'video_link', [
    'object_subtype' => 'post', // Limit to a post type.
    'type'           => 'string',
    'description'    => 'Link to an uploaded video',
    'single'         => true,
    'show_in_rest'   => true,
]);
