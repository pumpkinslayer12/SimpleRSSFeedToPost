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

 
function rss_feed_to_post_admin_menu() {
 
    add_options_page(
        'RSS Feed to Post',            // The title to be displayed in the browser window for this page.
        'RSS Feed to Post',            // The text to be displayed for this menu item
        'manage_options',            // Which type of users can see this menu item
        'rss-feed-to-post',    // The unique ID - that is, the slug - for this menu item
        'rss_feed_to_post_display'     // The name of the function to call when rendering this menu's page
    );
 
} // end sandbox_example_theme_menu
add_action( 'admin_menu', 'rss_feed_to_post_admin_menu' );
 
/**
 * Renders a simple page to display for the theme menu defined above.
 */
function rss_feed_to_post_display() {
?>
<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap">

    <h2>RSS Feed to Post Options</h2>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php settings_fields( 'rss_feed_to_post_options' ); ?>
        <?php do_settings_sections( 'rss-feed-to-post' ); ?>
        <?php submit_button(); ?>
    </form>

</div><!-- /.wrap -->
<?php
} 
 
function initialize_rss_feed_to_post_settings_and_options() {
 
    // If the theme options don't exist, create them.
    if( false == get_option( 'rss_feed_to_post_options' ) ) {  
        add_option( 'rss_feed_to_post_options' );
    } // end if
 
    // First, we register a section. This is necessary since all future options must belong to a 
    add_settings_section(
        'rss_feed_to_post_settings_section',         // ID used to identify this section and with which to register options
        'RSS Feed to Post Settings',                  // Title to be displayed on the administration page
        '', // Callback used to render the description of the section
        'rss-feed-to-post'     // Page on which to add this section of options
    );
     
    // Next, we'll introduce the fields for toggling the visibility of content elements.
    add_settings_field( 
        'rss_feed_to_post_feed_url',                      // ID used to identify the field throughout the theme
        'RSS Feed URL',                           // The label to the left of the option interface element
        'rss_feed_to_post_feed_url_callback',   // The name of the function responsible for rendering the option interface
        'rss-feed-to-post',    // The page on which this option will be displayed
        'rss_feed_to_post_settings_section'         // The name of the section to which this field belongs
    );
     
    // Finally, we register the fields with WordPress
    register_setting(
        'rss_feed_to_post_options',
        'rss_feed_to_post_options'
    );
     
} // end sandbox_initialize_theme_options
add_action('admin_init', 'initialize_rss_feed_to_post_settings_and_options');
 
function rss_feed_to_post_feed_url_callback() {
     
    // First, we read the options collection
    $options = get_option('rss_feed_to_post_options');
     
    echo '<input type="text" id="feed-url" name=rss_feed_to_post_options[feed_url] value="' . isset($options['feed_url']) ? $options['feed_url'] : '' . '"/>';
   
     
} // end sandbox_twitter_callback

?>
