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

add_shortcode("practice_shortcode", "path_output");

function path_output(){
    
    echo '<p>'.plugin_dir_path(__FILE__).'</p>';
    echo '<p>'.plugin_dir_url()(__FILE__).'</p>';
}
