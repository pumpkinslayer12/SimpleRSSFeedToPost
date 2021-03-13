<?php

namespace SimpleRSSFeedToPost;

require_once('Loader.php');

class Installer
{

    public static function install()
    {
        SettingsRegistration::registerSettingsUI();
    }

    public static function uninstall()
    {
        SettingsRegistration::unregisterSettingsUI();
    }
}
