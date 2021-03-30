<?php

namespace SimpleRSSFeedToPost;

use Exception;

class ProcessFeed
{
    public static function scheduleProcessFeed()
    {
        if (!wp_next_scheduled(AppDefaultValues::CronAction)) {
            wp_schedule_event(time(), AppDefaultValues::CronFrequency, AppDefaultValues::CronAction, [], true);
        }
        add_action(AppDefaultValues::CronAction, [get_called_class(), 'processRSSFeedAsWordPressPost'], 10, 0);
    }

    public static function processRSSFeedAsWordPressPost()
    {
        $options = get_option(AppDefaultValues::SettingsSlug);
        if (array_key_exists(AppDefaultValues::UrlSettingSlug, $options)) {
            try {
                $rss = RSSParser::getFeedItems(esc_url_raw($options[AppDefaultValues::UrlSettingSlug]));
                $wordPress = WordPressPostingSystem::RSSPostsToWordPress($rss);
                update_option(AppDefaultValues::LastJobRanStatusSlug, $wordPress);
            } catch (Exception $e) {
                update_option(AppDefaultValues::LastJobRanStatusSlug, $e->getMessage());
            }
        }
    }

    public static function runAfterSaveProcessRSSFeedAsWordPressPost($OldSettingValue, $NewSettingValue)
    {
        self::processRSSFeedAsWordPressPost();
    }

    public static function unscheduleProcessFeed()
    {
        $nextEventTime = wp_next_scheduled(AppDefaultValues::CronAction);
        if ($nextEventTime) {
            wp_unschedule_event($nextEventTime, AppDefaultValues::CronAction);
        }
        remove_action(AppDefaultValues::CronAction, [get_called_class(), 'processRSSFeedAsWordPressPost'], 10);
        delete_option(AppDefaultValues::LastJobRanStatusSlug);
    }
}
