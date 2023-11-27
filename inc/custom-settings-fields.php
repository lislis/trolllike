<?php

function frontpage_section_description() {
    echo '<p>IDs von Kategorien und Tags mit spezieller Bedeutung</p>';
}

function about_page_id_display() { ?>
    <input type="text" name="about_page_id" id=""about_page_id" value="<?php echo get_option('about_page_id'); ?>" />
<?php
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

function link_tag_display() { ?>
    <input type="text" name="link_tag" id="link_tag" value="<?php echo get_option('link_tag'); ?>" />
<?php
}

function text_tag_display() { ?>
    <input type="text" name="text_tag" id="text_tag" value="<?php echo get_option('text_tag'); ?>" />
<?php
}



function trolllike_theme_settings(){
    add_option('first_field_option', 1);// add theme option to database
    add_settings_section( 'front_page', 'Haupteinstellungen',
                          'frontpage_section_description','theme-options');

    add_settings_field("about_page_id", "ID der About-Seite", "about_page_id_display", "theme-options", "front_page");
    register_setting( 'theme-options-grp', 'about_page_id');

    add_settings_field("main_filter_cat", "Hauptcategorie für Archiv", "main_filter_cat_display", "theme-options", "front_page");
    register_setting( 'theme-options-grp', 'main_filter_cat');


    add_settings_field("youtube_tag", "Tag-ID für YouTube", "youtube_tag_display", "theme-options", "front_pa
    ge");
    register_setting( 'theme-options-grp', 'youtube_tag');

    add_settings_field("video_tag", "Tag-ID für Video", "video_tag_display", "theme-options", "front_page");
    register_setting( 'theme-options-grp', 'video_tag');

    add_settings_field("link_tag", "Tag-ID für Links", "link_tag_display", "theme-options", "front_page");
    register_setting( 'theme-options-grp', 'link_tag');

    add_settings_field("text_tag", "Tag-ID für Text", "text_tag_display", "theme-options", "front_page");
    register_setting( 'theme-options-grp', 'text_tag');

}
add_action('admin_init','trolllike_theme_settings');
