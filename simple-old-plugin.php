<?php
/* * Plugin Name: Simple Old Plugin 
* Description: This is a practice plugin to explore wordpress development * Version: 1.0 
* License: GPL v3 or later 
* License URI: https://www.gnu.org/licenses/gpl-3.0.html 
* Text Domain: simple-old-plugin 
* Domain Path: /languages 
*/

/**
* ADDRESSES BUFFER ERROR THAT STARTED APPEARING ON WEBSITE
* CAUSE WAS FROM A FAILED CACHING PLUGIN.
 * Proper ob_end_flush() for all levels
 *
 * This replaces the WordPress `wp_ob_end_flush_all()` function
 * with a replacement that doesn't cause PHP notices.
 */
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
add_action( 'shutdown', function() {
   while ( @ob_end_flush() );
} );



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
        'rss_feed_to_post_settings_section'
    );

    
     
    
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

// Nonce Example

add_action('admin_menu','pdev_nonce_example_menu');
add_action('admin_init','pdev_nonce_example_verify');

function pdev_nonce_example_menu(){
    
    add_menu_page('Nonce Example',
                  'Nonce Example',
                  'manage_options',
                  'pdev-nonce-example',
                  'pdev_nonce_example_template');
}

function pdev_nonce_example_verify(){
    // Bail if no nonce field
    if(!isset($_POST['pdev_nonce_name'])){
        return;
    }
    // Display error and die if not verified
    if (! wp_verify_nonce($_POST['pdev_nonce_name'],'pdev_nonce_action')){
        wp_die('Your nonce could not be verified.');
    }
    
    // Sanitize and update the option if it's set.
    if(isset($_POST['pdev_nonce_example'])){
        update_option(
            'pdev_nonce_example',
            wp_strip_all_tags($_POST['pdev_nonce_example'])
        );
    }
}

function pdev_nonce_example_template(){?>
<div class="wrap">
    <h1 class="wp-heading-inline">Nonce Example</h1>
    <?php $value = get_option('pdev_nonce_example'); ?>

    <form method="post" action="">
        <?php wp_nonce_field('pdev_nonce_action', 'pdev_nonce_name');?>
        <p>
            <label>
                Enter your name:
                <input type="text" name="pdev_nonce_example" value="<?php echo esc_attr($value); ?>" />

            </label>
        </p>
        <?php submit_button('Submit','Primary'); ?>
    </form>
</div>
<?php }
// HOOKS AND FILTER CHAPTER 5 NOTES

// adding something to the footer via footer Wordpress hook.
add_action('wp_footer', 'pdev_footer_message', PHP_INT_MAX);
function pdev_footer_message(){
    esc_html_e('This site is powered by Wordpress.','pdev');
}

// Adding Excerpts to page post types
add_action('init','pdev_page_excerpts');

function pdev_page_excerpts(){
    add_post_type_support('page',['excerpt']);
}

// Using filter, add a class to the body element

add_filter('body_class', 'pdev_body_class');

function pdev_body_class($classes){
    
    $classes[]='pdev-example';
    
    return $classes;
}

//Using content filter, will add a contact form to single posts

add_filter('the_content','pdev_content_subscription_form',PHP_INT_MAX);

function pdev_content_subscription_form($content){
    
    if(is_singular('post') && in_the_loop()){
        
        $content .= '<div class="pdev-subscription"
                <p>Thank you for reading. Please subscribe to my email list for updates</p>
                <form method="post">
                <p>
                <label>
                    Email:
                    <input type="email" value=""/>
                </label>
                </p>
                <p>
                    <input type ="submit" value="Submit"/>
                </p>
                </form>
                </div>';
    }
    return $content;
}
