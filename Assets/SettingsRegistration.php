<?php

namespace SimpleRSSFeedToPost;

class SettingsRegistration
{
    public static function registerSettingsUI()
    {
        if (!get_option(AppDefaultValues::installSettingSlug)) {
            self::registerSetting();
        }
        add_action('admin_menu', [get_called_class(), 'addOptionsPage'], 10);
        add_action(AppDefaultValues::AdminMenuHook, [get_called_class(), 'addSettingsSection'], 11);
    }

    private static function registerSetting()
    {
        register_setting(
            AppDefaultValues::SettingsSlug,
            AppDefaultValues::SettingsSlug,
            ['sanitize_callback' => ['SettingsUI', 'sanitizeSettings']]
        );
        add_option(AppDefaultValues::installSettingSlug, 1);
    }
    public static function addOptionsPage()
    {
        add_options_page(
            AppDefaultValues::SettingsTitle,
            AppDefaultValues::SettingsTitle,
            AppDefaultValues::MinimumAccessCapability,
            AppDefaultValues::SettingsSlug,
            ['SettingsUI', 'settingsPageMarkup']
        );
    }
    public static function addSettingsSection()
    {

        add_settings_section(
            AppDefaultValues::SectionSlug,
            AppDefaultValues::SectionTitle,
            [SettingsUI::class, 'sectionDescription'],
            AppDefaultValues::SettingsSlug
        );
        add_settings_field(
            AppDefaultValues::UrlSettingSlug,
            AppDefaultValues::UrlSettingSlug,
            [SettingsUI::class, 'inputFieldURL'],
            AppDefaultValues::SettingsSlug,
            AppDefaultValues::SectionSlug,
            [AppDefaultValues::SettingsSlug, AppDefaultValues::UrlSettingSlug]
        );
        add_settings_field(
            AppDefaultValues::DefaultAuthorSettingSlug,
            AppDefaultValues::DefaultAuthorTitle,
            [SettingsUISettingsUI::class, 'defaultUserListing'],
            AppDefaultValues::SettingsSlug,
            AppDefaultValues::SectionSlug,
            [AppDefaultValues::SettingsSlug, AppDefaultValues::DefaultAuthorSettingSlug]
        );
    }

    public static function unregisterSettingsUI()
    {
        remove_action(AppDefaultValues::AdminMenuHook, [get_called_class(), 'addOptionsPage'], 10);
        remove_action(AppDefaultValues::AdminMenuHook, [get_called_class(), 'addSettingsSection'], 11);
        delete_option(AppDefaultValues::installSettingSlug);
        unregister_setting(AppDefaultValues::SettingsSlug, AppDefaultValues::SettingsSlug);
    }
}
