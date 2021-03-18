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

namespace SimpleRSSFeedToPost;

require('Assets/AppDefaultValues.php');
require('Assets/SettingsUI.php');
require('Assets/SettingsRegistration.php');
SettingsRegistration::registerSettingsUI();

register_deactivation_hook(__FILE__, ['SettingsUI', 'unregisterSettings']);
