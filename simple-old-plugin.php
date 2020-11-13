<?php
/*
* Plugin Name: Simple Old Plugin
* Description: This is a practice plugin to explore wordpress development
* Version: 1.0
* License: GPL v3 or later
* License URI: https://www.gnu.org/licenses/gpl-3.0.html
* Text Domain: simple-old-plugin
* Domain Path: /languages
*/

 // ------------------------------------------------------------------
 // Add all your sections, fields and settings during admin_init
 // ------------------------------------------------------------------
 //
// Register and define settings at plugin activation

add_action('admin_init','sop_plugin_admin_init');

function sop_plugin_admin_init(){
    $args = [
        'type' => 'string',
        'sanitize_callback' => 'sop_plugin_validate_options',
        'default' => NULL
    ];
    //Register our settings
    register_setting('sop_plugin_options', 
                     'sop_plugin_options',
                    $args);
}


// Add a menu using admin_menu hook
add_action('admin_menu', 'sop_plugin_add_settings_menu');

function sop_plugin_add_settings_menu(){
    
    add_options_page('SOP plugin Settings', 
                     'SOP Settings', 
                     'manage_options',
                    'sop_plugin',
                    'sop_plugin_option_page');
}

// Create the option page

function sop_plugin_option_page(){
    ?>
<div class="wrap">
    <h2>My plugin</h2>
    <form action="options.php" method="post">
        <?php
    settings_fields('sop_plugin_options');
    do_settings_sections('sop_plugin');
    submit_button('Save Changes');
    ?>
    </form>
</div>
<?php
}
