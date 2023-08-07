<?php

require_once("custom-settings-fields.php");

function add_trolllike_theme_page() {
    add_theme_page("Trolllike Theme Einstellungen",
                   "Trolllike Theme Einstellungen",
                   "manage_options",
                   "theme-options",
                   "theme_option_page", null, 99);

}
add_action( 'admin_menu', 'add_trolllike_theme_page' );

function theme_option_page() {
?>
    <div class="wrap">
        <h1>Trolllike Theme Einstellungen</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields("theme-options-grp");
            do_settings_sections("theme-options");
            submit_button();
            ?>
        </form>
    </div>
<?php
}
