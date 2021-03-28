<?php

namespace SimpleRSSFeedToPost;

class SettingsRegistration
{
    public static function registerSettingsUI()
    {
        register_setting(
            AppDefaultValues::SettingsSlug,
            AppDefaultValues::SettingsSlug,
            ['sanitize_callback' => [SettingsUI::class, 'sanitizeSettings']]
        );
        add_action(AppDefaultValues::AdminMenuHook, [self::class, 'addOptionsPage'], 10, 0);
        add_action(AppDefaultValues::AdminMenuHook, [self::class, 'addSettingsSection'], 11, 0);
        add_action(AppDefaultValues::UpdateSettingsOptionHook, [ProcessFeed::class, 'processRSSFeedAsWordPressPost']);
    }

    public static function addOptionsPage()
    {
        add_options_page(
            AppDefaultValues::SettingsTitle,
            AppDefaultValues::SettingsTitle,
            AppDefaultValues::MinimumAccessCapability,
            AppDefaultValues::SettingsSlug,
            [SettingsUI::class, 'settingsPageMarkup']
        );
    }
    public static function addSettingsSection()
    {
        add_settings_section(
            AppDefaultValues::SettingsSlug,
            AppDefaultValues::SettingsTitle,
            [SettingsUI::class, 'sectionDescription'],
            AppDefaultValues::SettingsSlug
        );
        add_settings_field(
            AppDefaultValues::UrlSettingSlug,
            AppDefaultValues::UrlSettingsTitle,
            [SettingsUI::class, 'inputFieldURL'],
            AppDefaultValues::SettingsSlug,
            AppDefaultValues::SettingsSlug,
            [AppDefaultValues::SettingsSlug, AppDefaultValues::UrlSettingSlug]
        );

        add_settings_field(
            AppDefaultValues::DefaultAuthorSettingSlug,
            AppDefaultValues::DefaultAuthorTitle,
            [SettingsUI::class, 'defaultUserListing'],
            AppDefaultValues::SettingsSlug,
            AppDefaultValues::SettingsSlug,
            [AppDefaultValues::SettingsSlug, AppDefaultValues::DefaultAuthorSettingSlug]
        );
    }

    public static function unregisterSettingsUI()
    {
        remove_action(AppDefaultValues::AdminMenuHook, [self::class, 'addOptionsPage'], 10);
        remove_action(AppDefaultValues::AdminMenuHook, [self::class, 'addSettingsSection'], 11);
        unregister_setting(AppDefaultValues::SettingsSlug, AppDefaultValues::SettingsSlug);
        delete_option(AppDefaultValues::SettingsSlug);
    }
}
