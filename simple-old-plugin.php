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

//Add a menu for our option page
//WordPress hook to add to menu
add_action('admin_menu', 'sop_plugin_add_settings_menu');
//Function to add settings
function sop_plugin_add_settings(){

    add_options_page('Simple Old Plugin Settings',
                    'Simple Old Plugin Settings',
                    'manage_options',
                    'sop_plugin',
                    'sop_plugin_option_page');
}
//Create actual options page 
function sop_plugin_option_page(){
    ?>
<div class="wrap">
    <h2>My Plugin</h2>
    <form action="options.php" method="post">
        <?php 
    settings_fields('')
    ?>
    </form>
</div>
<?php
}

?>
