<?php

function frontpage_section_description() {
    echo '<p>IDs von Kategorien und Tags mit spezieller Bedeutung</p>';
}

function main_filter_cat_display() { ?>
    <input type="text" name="main_filter_cat" id="main_filter_cat" value="<?php echo get_option('main_filter_cat'); ?>" />
<?php
}

function youtube_tag_display() { ?>
    <input type="text" name="youtube_tag" id="youtube_tag" value="<?php echo get_option('youtube_tag'); ?>" />
<?php
}

function video_tag_display() { ?>
    <input type="text" name="video_tag" id="video_tag" value="<?php echo get_option('video_tag'); ?>" />
<?php
}



function trolllike_theme_settings(){
    add_option('first_field_option', 1);// add theme option to database
    add_settings_section( 'front_page', 'Haupteinstellungen',
                          'frontpage_section_description','theme-options');

    add_settings_field("main_filter_cat", "Hauptcategorie für Archiv", "main_filter_cat_display", "theme-options", "front_page");
    register_setting( 'theme-options-grp', 'main_filter_cat');


    add_settings_field("youtube_tag", "Tag-ID für YouTube", "youtube_tag_display", "theme-options", "front_page");
    register_setting( 'theme-options-grp', 'youtube_tag');

    add_settings_field("video_tag", "Tag-ID für Video", "video_tag_display", "theme-options", "front_page");
    register_setting( 'theme-options-grp', 'video_tag');

}
add_action('admin_init','trolllike_theme_settings');
