<?php
class SettingsUI
{add_action( 'admin_menu', 'srftp_create_options_page' );

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
}
