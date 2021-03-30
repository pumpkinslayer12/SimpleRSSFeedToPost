<?php
/* 
* Plugin Name: Simple RSS Feed to Post 
* Description: Plugin that creates posts from another WordPress RSS feed.
* Version: 1.0 
* License: GPL v3 or later 
* License URI: https://www.gnu.org/licenses/gpl-3.0.html 
* Text Domain: simple-rss-feed-to-post
* Domain Path: /languages 
*/


// RSS Feed to Post Admin menu creation and display callback
add_action( 'admin_menu', 'srftp_create_options_page' );

function srftp_create_options_page() {
 
    add_options_page(
        'Simple RSS Feed to Post',            
        'Simple RSS Feed to Post',            
        'manage_options',            
       'srftp_options_page',
        'srftp_options_page_callback'
    );
}
 
function srftp_options_page_callback() {
?>

<div class="wrap">
    <h2>Simple RSS Feed to Post Options</h2>
    <?php
    $error_messages = get_option('srftp_rss_feed_errors');
    if ($error_messages !== ''){
        ?>
    <div class="error notice">
        <p>
            <?php
        sanitize_textarea_field($error_messages);
    
    ?>
        </p>
    </div>

    <?php } ?>
    <form action="options.php" method="post">
        <?php       
                    settings_fields('srftp_options_page_settings');
                    do_settings_sections('srftp_options_page');
                    submit_button('Save Changes', 'primary'); 
                ?>
    </form>
</div>
<?php
} 

// Create initial plugin admin settings and display callbacks
add_action('admin_init', 'srftp_initialize_options_page_settings');
function srftp_initialize_options_page_settings() {
    add_option('srftp_rss_feed_errors', '');
    
    register_setting(
        'srftp_options_page_settings',
        'srftp_options_page_settings',
        ['sanitize_callback' => 'srftp_sanitize_options_page_settings']
    );
    
    add_settings_section(
        'srftp_settings_section',        
        'Settings',                 
        'srftp_settings_section_callback', 
        'srftp_options_page'    
    );
    add_settings_field( 
        'srftp_feed_url', 
        'RSS Feed URL',                           
        'srftp_url_callback',  
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
    
}     

function srftp_settings_section_callback(){
    echo '<p>Please enter a valid RSS url and select a default user for imported posts.</p>';
}
function srftp_url_callback() {
     
    $options = get_option('srftp_options_page_settings');
     
    echo '<input id="srftp_feed_url" name="srftp_options_page_settings[srftp_feed_url]" type="text" value="' . 
        esc_attr(array_key_exists('srftp_feed_url',$options) ? $options['srftp_feed_url'] : '' ). 
        '"/>'; 
}

function srftp_default_user_callback(){
    
    wp_dropdown_users([
        'name' => 'srftp_options_page_settings[srftp_default_user]',
        'id' => 'srftp_default_user',
        'selected' => srftp_default_author()
        ]
    );
}

function srftp_sanitize_options_page_settings($submitted_fields){
    
    // Validate and sanitize rss url
    $options = get_option('srftp_options_page_settings');
    $valid_fields = [];
    
    
    $valid_fields['srftp_feed_url'] = esc_url_raw($submitted_fields['srftp_feed_url']);
    $valid_fields['srftp_default_user'] = intval($submitted_fields['srftp_default_user']);
    
    if ($valid_fields['srftp_feed_url'] !== $submitted_fields['srftp_feed_url']){
        add_settings_error('srftp_options_page_settings',
                          'feed_url_error',
                          'Please enter a valid RSS feed url');
        return $options;
    }
    
    if (!is_user_member_of_blog($valid_fields['srftp_default_user'])){
                add_settings_error('srftp_options_page_settings',
                          'user_error',
                          'Please select a valid default user');
        return $options;
    }
        
    
    return $valid_fields;
    
}

// Parse RSS Feed functionality
function srftp_load_rss_from_url($url){
    libxml_use_internal_errors(true);
    $xml = simplexml_load_file($url);
    
    if ($xml===false){
        $error_str='';
        foreach(libxml_get_errors() as $error) {
        $error_str .= (string)$error->message.'<br>';        
            }
        update_option('srftp_rss_feed_errors',wp_kses($error_str, ['br' => []]));
        libxml_use_internal_errors(false);
        return $xml;
    }
    update_option('srftp_rss_feed_errors','');
    
    return simplexml_load_file($url);
}

// Expects rss item node from simplexml
function srftp_parse_rss_feed_item($item){
    return [
    // Title
    'title' => empty($item -> title) ? '' : sanitize_text_field((string)$item -> title),
    // Full URL link. Link is php function. Using alternative access method for 'link' node
    'link' => empty($item -> {'link'}) ? '' : esc_url_raw((string)$item -> {'link'}),
    // Publish Date
    'pubDate' => empty($item -> pubDate) ? '' : filter_var((string)$item -> pubDate,FILTER_SANITIZE_STRING),
    // GUID or permanent url for post
    'guid' => empty($item -> guid) ? '' : esc_url_raw((string)$item -> guid),
    // Post Excerpt
    'description' => empty($item -> description) ? '' : sanitize_text_field((string)$item -> description),
    // Post content
    'content' => empty($item -> children('content',true) -> encoded) ? '' : wp_kses_post((string)$item -> children('content',true) -> encoded)
    ];
}

function srftp_parse_rss_feed($xml){
    $feed_items = [];
    foreach ($xml -> channel -> item as $item){
        $feed_items[] = srftp_parse_rss_feed_item($item);
    }
    return $feed_items;
}


//Checks if a default user is set. If not, returns 0.
function srftp_default_author(){
	    $options = get_option('srftp_options_page_settings');
    
    return array_key_exists('srftp_default_user', $options) ? intval($options['srftp_default_user']) : 0;
}

function srftp_post_template($post_arguments){
          return  ['post_author' => srftp_default_author(),
              'post_date' => $post_arguments['pubDate'],
              'post_content' => $post_arguments['content'],
              'post_title' => $post_arguments['title'],
              'post_excerpt' => $post_arguments['description'],
              'post_type' => 'post', 
              'meta_input' => ['srftp_source_url' => $post_arguments['guid']]
            ];
}

// Create new post from RSS entries functionality
function srftp_create_post($post_arguments){    
    //send error on failure or post_id number on completion
    return wp_insert_post(srftp_post_template($post_arguments),true);

    }

function srftp_get_added_posts(){
$post_filters=['meta_value' => 'srftp_source_url'];

    return get_posts($post_filters);
    
}

// Add custom metadata field for posts and sanitization function
function srftp_authorized_to_edit_meta_url($user){
    return current_user_can('manage_options');
}

register_activation_hook(__FILE__,'srftp_register_post_source_url_meta');

function srftp_register_post_source_url_meta(){
    $meta_args = ['type' => 'string',
                 'description' => 'Source url for imported post.',
                 'single' => true,
                 'sanitize_callback' => function($url){return esc_url_raw($url);},
                  //'auth_callback' => 'srftp_authorized_to_edit_meta_url'
                 ];
    register_post_meta('post', 'srftp_source_url', $meta_args);
}


// Cron setup
register_activation_hook(__FILE__,'srftp_cron_schedule');

function srftp_cron_schedule(){
    if(!wp_next_scheduled('srftp_cron_hook')){
        wp_schedule_event(time(),'hourly','srftp_cron_hook');
    }
}

add_action('srftp_cron_hook', 'srftp_rss_processing_orchestration');

function srftp_rss_filter_items($rss_array, $wp_array){
    return array_udiff($rss_array, $wp_array,
                function($arg1,$arg2){
                    return strcmp($arg1['guid'],get_post_meta($arg2 -> ID,'srftp_create_post',true));
                }
               );
}
function srftp_rss_processing_orchestration(){}
function srftp_rss_processing_orchestration_work(){
    $options = get_option('srftp_options_page_settings');
    
    if(array_key_exists('srftp_feed_url',$options) && get_option('srftp_rss_feed_errors') === ''){
        $xml=srftp_load_rss_from_url(esc_url_raw($options['srftp_feed_url']));
        if($xml !== false){
            $current_posts = srftp_get_added_posts();
            $xml_items = srftp_parse_rss_feed($xml);
            $filtered_posts = srftp_rss_filter_items($xml_items, $current_posts);
            $post_ids = array_map($filtered_posts,'srftp_create_post');
        }
        
    }
}
              
add_action('update_option_srftp_options_page_settings', function($option,$old,$new){srftp_rss_processing_orchestration();},10,3);
