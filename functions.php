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


function add_cors_http_header(){
  header("Access-Control-Allow-Origin: *");
}
//add_action('init', 'add_cors_http_header');

function thumbnail_url($id, $type) {
    $filename = md5($id).'.jpg';
    $fallback = 'youtube_fallback.png';
    $folder_name = 'video-thumbnails';
    $folder_public = wp_upload_dir()['baseurl'].'/'.$folder_name;
    $folder_path = wp_upload_dir()['basedir'].'/'.$folder_name;
    if( !file_exists($folder_path) ) {
        mkdir($folder_path);
    }
    if( file_exists($folder_path.'/'.$filename) ) {
        return $folder_public.'/'.$filename;
    }
    if($type === 'youtube') {
        $content = file_get_contents('https://img.youtube.com/vi/'. $id .'/0.jpg');
    }
    if($type === 'vimeo') {
        $content = file_get_contents('https://vimeo.com/api/v2/video/' . $this->queryString['vimeoid'] . '.json');
        if ($content != '') {
            $content = json_decode($content);
            $content = file_get_contents($content[0]->thumbnail_large);
        }
    }
    if( $content == '' ) {
        return $folder_public.'/'.$fallback;
    }
    $written = file_put_contents($folder_path.'/'.$filename, $content, 0755);
    return $folder_public.'/'.$filename;
}
