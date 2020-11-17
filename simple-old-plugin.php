<?php
/* * Plugin Name: Simple Old Plugin * Description: This is a practice plugin to explore wordpress development * Version: 1.0 * License: GPL v3 or later * License URI: https://www.gnu.org/licenses/gpl-3.0.html * Text Domain: simple-old-plugin * Domain Path: /languages */

 //Good
function rss_feed_to_post_admin_menu() {
 
    add_options_page(
        'RSS Feed to Post',            // The title to be displayed in the browser window for this page.
        'RSS Feed to Post',            // The text to be displayed for this menu item
        'manage_options',            // Which type of users can see this menu item
        'rss_feed_to_post',    // The unique ID - that is, the slug - for this menu item
        'rss_feed_to_post_display'     // The name of the function to call when rendering this menu's page
    );
 
} // end sandbox_example_theme_menu
add_action( 'admin_menu', 'rss_feed_to_post_admin_menu' );
 
/**
 * Renders a simple page to display for the theme menu defined above.
 */
//Good
function rss_feed_to_post_display() {
?>
    <!-- Create a header in the default WordPress 'wrap' container -->
    <div class="wrap">
        <h2>RSS Feed to Post Options</h2>
        <?php settings_errors(); ?>
            <form action="options.php" method="post">
                <?php 
                    settings_fields( 'rss_feed_to_post_options' );
                    do_settings_sections( 'rss_feed_to_post' );
                    submit_button('Save Changes', 'primary'); 
                ?>
            </form>
    </div>
    <!-- /.wrap -->
    <?php
} 

function initialize_rss_feed_to_post_settings_and_options() {
        register_setting(
        'rss_feed_to_post_options',
        'rss_feed_to_post_options'
    );
    // First, we register a section. This is necessary since all future options must belong to a 
    add_settings_section(
        'rss_feed_to_post_settings_section',         // ID used to identify this section and with which to register options
        'RSS Feed to Post Settings',                  // Title to be displayed on the administration page
        'rss_feed_to_post_settings_section_callback', // Callback used to render the description of the section
        'rss_feed_to_post'     // Page on which to add this section of options
    );
     
    // Next, we'll introduce the fields for toggling the visibility of content elements.
    add_settings_field( 
        'rss_feed_to_post_feed_url',                      // ID used to identify the field throughout the theme
        'RSS Feed URL',                           // The label to the left of the option interface element
        'rss_feed_to_post_feed_url_callback',   // The name of the function responsible for rendering the option interface
        'rss_feed_to_post',    // The page on which this option will be displayed
        'rss_feed_to_post_settings_section'         // The name of the section to which this field belongs
    );
     
    // Finally, we register the fields with WordPress

     
} // end sandbox_initialize_theme_options

//Good
add_action('admin_init', 'initialize_rss_feed_to_post_settings_and_options');

//Good
function rss_feed_to_post_settings_section_callback(){
    echo '<p>Please enter the url below to setup the feed to post.</p>';
}
function rss_feed_to_post_feed_url_callback() {
     
    // First, we read the options collection
    $options = get_option('rss_feed_to_post_options');
    $setting = $options['rss_feed_to_post_feed_url'];
     
    echo "<input id='rss_feed_to_post_feed_url' name='rss_feed_to_post_options[rss_feed_to_post_feed_url]' type='text' value='" . esc_attr($setting) . "'/>";
   
     
} // end sandbox_twitter_callback


?>