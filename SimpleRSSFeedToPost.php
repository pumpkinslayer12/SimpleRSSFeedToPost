<?php
/* 
* Plugin Name: Simple RSS Feed to Post 
* Description: Plugin that creates posts from another WordPress RSS feed.
* Version: 1.0 
* License: GPL v3 or later 
* Author: pumpkinslayer12
* License URI: https://www.gnu.org/licenses/gpl-3.0.html 
* Text Domain: SimpleRSSFeedToPost
* Domain Path: /languages 
*/

namespace SimpleRSSFeedToPost;

require(__NAMESPACE__ . DIRECTORY_SEPARATOR . 'Loader.php');
SettingsRegistration::registerSettingsUI();
ProcessFeed::scheduleProcessFeed();
register_deactivation_hook(__FILE__, [SettingsRegistration::class, 'unregisterSettingsUI']);
register_deactivation_hook(__FILE__, [ProcessFeed::class, 'unscheduleProcessFeed']);
