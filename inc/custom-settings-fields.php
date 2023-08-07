<?php

function frontpage_section_description() {
    echo '<p>Social Media und andere Links</p>';
}

function main_filter_cat_display() { ?>
    <input type="text" name="main_filter_cat" id="main_filter_cat" value="<?php echo get_option('main_filter_cat'); ?>" />
<?php
}



function trolllike_theme_settings(){
    add_option('first_field_option', 1);// add theme option to database
    add_settings_section( 'front_page', 'Haupteinstellungen',
                          'frontpage_section_description','theme-options');

    add_settings_field("main_filter_cat", "Hauptcategorie für Archiv", "main_filter_cat_display", "theme-options", "front_page");
    register_setting( 'theme-options-grp', 'main_filter_cat');

}
add_action('admin_init','trolllike_theme_settings');
