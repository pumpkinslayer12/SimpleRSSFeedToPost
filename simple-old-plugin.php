<?php
<<<<<<< Updated upstream
/* * Plugin Name: Simple RSS Feed to Post 
=======
/* 
* Plugin Name: Simple RSS Feed to Post 
>>>>>>> Stashed changes
* Description: Plugin that creates posts from another WordPress RSS feed.
* Version: 1.0 
* License: GPL v3 or later 
* License URI: https://www.gnu.org/licenses/gpl-3.0.html 
* Text Domain: simple-rss-feed-to-post
* Domain Path: /languages 
*/

<<<<<<< Updated upstream

// RSS Feed to Post Admin menu creation and display callback
add_action( 'admin_menu', 'srftp_create_options_page' );

function srftp_create_options_page(){
=======
// RSS Feed to Post Admin menu creation and display callback
add_action( 'admin_menu', 'srftp_admin_menu' );

function srftp_admin_menu() {
 
>>>>>>> Stashed changes
    add_options_page(
        'Simple RSS Feed to Post',            
        'Simple RSS Feed to Post',            
        'manage_options',            
        'srftp_options_page',   
<<<<<<< Updated upstream
        'srftp_options_page_callback'
=======
        'srftp_display'
>>>>>>> Stashed changes
    );
}
<<<<<<< Updated upstream

function srftp_options_page_callback() {
?>
    <div class="wrap">
        <h2>Simple RSS Feed to Post Options</h2>
        <form action="options.php" method="post">
            <?php 
=======

 
function srftp_display() {
?>

<div class="wrap">
    <h2>RSS Feed to Post Options</h2>
    <form action="options.php" method="post">
        <?php 
>>>>>>> Stashed changes
                    settings_fields( 'srftp_options' );
                    do_settings_sections( 'srftp_options_page' );
                    submit_button('Save Changes', 'primary'); 
                ?>
        </form>
    </div>
    <?php
} 

<<<<<<< Updated upstream
// Create initial plugin admin settings and display callbacks
add_action('admin_init', 'srftp_initialize_settings');
function srftp_create_settings() {
=======
function srftp_initialize_settings() {
>>>>>>> Stashed changes
    register_setting(
        'srftp_options',
        'srftp_options'
    );
    
    add_settings_section(
        'srftp_settings_section',        
        'Simple RSS Feed to Post Settings',                  
        'srftp_settings_section_callback', 
        'srftp_options_page'    
    );
     

    add_settings_field( 
        'srftp_feed_url', 
        'RSS Feed URL',                           
<<<<<<< Updated upstream
        'srftp_url_callback',  
        'srftp_options_page',    
        'srftp_settings_section'         
    );
    add_settings_fields(
        'srftp_default_user',
        'Default Post Author',
        'srftp_default_user_callback',
        'srftp_options_page',
        'srftp_settings_section'
    );

=======
        'srftp_feed_url_callback',  
        'srftp_options_page',    
        'srftp_settings_section'         
    );   
    
	add_settings_field( 
        'srftp_default_user', 
        'Default Post Author',                           
        'srftp_default_user_callback',  
        'srftp_options_page',    
        'srftp_settings_section'         
    );  
    
>>>>>>> Stashed changes
} 
// Create initial plugin admin settings and display callbacks

<<<<<<< Updated upstream
function srftp_settings_section_callback(){
    echo '<p>Please enter the url below to setup the feed to post.</p>';
}

function srftp_url_callback() {
     
    $options = get_option('srftp_options');
    
=======
add_action('admin_init', 'srftp_initialize_settings');

function srftp_settings_section_callback(){
    echo '<p>Please enter the url below to setup the feed to post.</p>';
}
function srftp_feed_url_callback() {
     
    $options = get_option('srftp_options');    
>>>>>>> Stashed changes
     
    echo '<input id="srftp_feed_url" name="srftp_options[srftp_feed_url]" type="text" value="' . 
        esc_attr(isset($options['srftp_feed_url']) ? $options['srftp_feed_url'] : '') . 
        '"/>';  
}

function srftp_default_user_callback(){
<<<<<<< Updated upstream
    $options = get_option('srftp_options');
    
    wp_dropdown_users([
        'name' => 'srftp_options[srftp_default_user]',
        'id' => 'srftp_default_user',
        'selected' => isset($options['srftp_default_user']) ? $options['srftp_default_user'] : 0,
        ]
    );
=======
    wp_dropdown_users([
        'name' => 'srftp_options[srftp_default_user]',
        'id' => 'srftp_default_user',
        'selected' => srftp_default_author(),
        ]
    );
	echo '<p>The current value is: '.srftp_default_author().'</p>';
>>>>>>> Stashed changes
}

// Parse RSS Feed functionality
function srftp_load_rss_from_url($url){
    return simplexml_load_file($url);}

// Expects rss item node from simplexml
function srftp_parse_rss_feed_item($item){
    return [
    // Title
    'title' => (string)$item -> title,
    // Full URL link. Link is php function. Using alternative access method for 'link' node
    'link' => (string)$item -> {'link'},
    // Publish Date
    'pubDate' => (string)$item -> pubDate,
    // GUID or permanent url for post
    'guid' => (string)$item -> guid,
    // Post Excerpt
    'description' => (string)$item -> description.'</strong>',
    // Post content
    'content' => (string)$item -> children('content',true) -> encoded
    ];
}

function srftp_parse_rss_feed($url){
    $xml = srftp_load_rss_from_url($url);
    $feed_items = [];
    foreach ($xml -> channel -> item as $item){
        $feed_items[] = srftp_parse_rss_feed_item($item);
    }
    return $feed_items;
}

// Create new post from RSS entries functionality
function srftp_create_post($post_arguments){
<<<<<<< Updated upstream
    
    //send error on failure or post_id number on completion
    return wp_insert_post(srftp_post_template($post_arguments),true);
    
=======
    
    //send error on failure or post_id number on completion
    return wp_insert_post(srftp_post_template($post_arguments),true);
    
>>>>>>> Stashed changes
    }

//Checks if a default user is set. If not, returns 0.
function srftp_default_author(){
<<<<<<< Updated upstream
    return isset($options['srftp_default_user']) ? $options['srftp_default_user'] : 0;
=======
	$options = get_option('srftp_options');
    return isset($options['srftp_default_user']) ? $options['srftp_default_user'] : 0;
}

function srftp_post_template($post_arguments){
          return  ['post_author' => srftp_default_author(),
              'post_date' => $post_arguments['pubDate'],
              'post_content' => $post_arguments['content'],
              'post_title' => $post_arguments['title'],
              'post_excerpt' => $post_arguments['description'],
              'post_type' => 'post',               
            ];
>>>>>>> Stashed changes
}

function srftp_post_template($post_arguments){
          return  ['post_author' => srftp_default_author(),
              'post_date' => $post_arguments['pubDate'],
              'post_content' => $post_arguments['content'],
              'post_title' => $post_arguments['title'],
              'post_excerpt' => $post_arguments['description'],
              'post_type' => 'post',               
            ];
}