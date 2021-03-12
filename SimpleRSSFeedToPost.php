<?php
/* 
* Plugin Name: Simple RSS Feed to Post 
* Description: Plugin that creates posts from another WordPress RSS feed.
* Version: 1.0 
* License: GPL v3 or later 
* License URI: https://www.gnu.org/licenses/gpl-3.0.html 
* Text Domain: SimpleRSSFeedToPost
* Domain Path: /languages 
*/


register_activation_hook(__FILE__, 'WCM_Setup_Demo_on_activation');
register_deactivation_hook(__FILE__, 'WCM_Setup_Demo_on_deactivation');
register_uninstall_hook(__FILE__, 'WCM_Setup_Demo_on_uninstall');
