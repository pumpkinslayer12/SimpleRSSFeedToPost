<?php
/* * Plugin Name: Simple Old Plugin 
* Description: This is a practice plugin to explore wordpress development * Version: 1.0 
* License: GPL v3 or later 
* License URI: https://www.gnu.org/licenses/gpl-3.0.html 
* Text Domain: simple-old-plugin 
* Domain Path: /languages 
*/

function rss_feed_to_post_admin_menu() {
 
    add_options_page(
        'RSS Feed to Post',            
        'RSS Feed to Post',            
        'manage_options',            
        'rss_feed_to_post',   
        'rss_feed_to_post_display'
    );
 
}
add_action( 'admin_menu', 'rss_feed_to_post_admin_menu' );
 
function rss_feed_to_post_display() {
?>

<div class="wrap">
    <h2>RSS Feed to Post Options</h2>
    <form action="options.php" method="post">
        <?php 
                    settings_fields( 'rss_feed_to_post_options' );
                    do_settings_sections( 'rss_feed_to_post' );
                    submit_button('Save Changes', 'primary'); 
                ?>
    </form>
</div>

<?php
} 

function initialize_rss_feed_to_post_settings_and_options() {
        register_setting(
        'rss_feed_to_post_options',
        'rss_feed_to_post_options'
    );
    
    add_settings_section(
        'rss_feed_to_post_settings_section',        
        'RSS Feed to Post Settings',                  
        'rss_feed_to_post_settings_section_callback', 
        'rss_feed_to_post'    
    );
     

    add_settings_field( 
        'rss_feed_to_post_feed_url', 
        'RSS Feed URL',                           
        'rss_feed_to_post_feed_url_callback',  
        'rss_feed_to_post',    
        'rss_feed_to_post_settings_section'         
    );
    add_settings_field(
        'rss_feed_to_post_delete_settings',
        'Clear Settings On Uninstall',
        'rss_feed_to_post_delete_settings_callback',
        'rss_feed_to_post',
        'rss_feed_to_post_settings_section');
     
    
} 

add_action('admin_init', 'initialize_rss_feed_to_post_settings_and_options');

function rss_feed_to_post_settings_section_callback(){
    echo '<p>Please enter the url below to setup the feed to post.</p>';
}
function rss_feed_to_post_feed_url_callback() {
     
    $options = get_option('rss_feed_to_post_options');    
     
    echo '<input id="rss_feed_to_post_feed_url" name="rss_feed_to_post_options[rss_feed_to_post_feed_url]" type="text" value="' . 
        esc_attr(isset($options['rss_feed_to_post_feed_url']) ? $options['rss_feed_to_post_feed_url'] : '') . 
        '"/>';  
}

function rss_feed_to_post_delete_settings_callback(){
    $options = get_option('rss_feed_to_post_options');
    
    echo '<input type="checkbox" id="rss_feed_to_post_delete_settings" name="rss_feed_to_post_options[rss_feed_to_post_delete_settings]" value="1"' . 
        checked(1, $options['rss_feed_to_post_delete_settings'], false) .
        '>' .
        '<label for="rss_feed_to_post_delete_settings">Check to uninstall settings on plugin deletion.</label>';
}

//Uninstall Functions

register_uninstall_hook(__FILE__, 'rss_feed_to_post_uninstall');

function rss_feed_to_post_uninstall(){
    unregister_setting('rss_feed_to_post_options');
    delete_option('rss_feed_to_post_options');
    }
?>
