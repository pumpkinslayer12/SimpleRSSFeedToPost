<?php
namespace SimpleRSSFeedToPost;
class Run
{
    public static function run()
    {
        self::loader();
        define('DIR_BASE', dirname(__FILE__) . '/');
        define('DIR_DATAGATEWAYS', DIR_BASE . 'DataGateways/');
        define('DIR_DATASTRUCTURES', DIR_BASE . 'DataStructures/');
        define('DIR_PARSERS', DIR_BASE . 'Parsers/');
        define('DIR_SETTINGS', DIR_BASE . 'Settings/');
        define('DIR_SYSTEMS', DIR_BASE . 'Systems/');

        require DIR_DATAGATEWAYS . 'WordPressPostDataGateway.php';

        require DIR_DATASTRUCTURES . 'RSSDataTemplate.php';
        require DIR_DATASTRUCTURES . 'WordPressPostDataTemplate.php';

        require DIR_PARSERS . 'FeedParser.php';
        require DIR_PARSERS . 'RSSParser.php';

        require DIR_SETTINGS . 'SettingsUI.php';

        require DIR_SYSTEMS . 'FeedURISystem.php';
        require DIR_SYSTEMS . 'PostingSystem.php';
        require DIR_SYSTEMS . 'WordPressPostingSystem.php';
    }
    public static function loader(){

    }
}
