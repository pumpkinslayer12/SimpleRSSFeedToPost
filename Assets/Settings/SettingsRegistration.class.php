<?php

namespace SimpleRSSFeedToPost;

class SettingsRegistration
{
    private const AdminMenuHook = 'admin_menu';

    public static function registerSettingsUI()
    {
        self::registerSettingsPage();
        self::registerSettingsSection();
    }

    private static function registerSettingsPage()
    {
        add_action(self::AdminMenuHook, [self::class, 'addOptionsPage'], 10);
    }
    private static function registerSettingsSection()
    {
        add_action(self::AdminMenuHook, [self::class, 'addSettingsSection'], 11);
    }
    private static function addOptionsPage()
    {
        add_options_page(
            Defaults::SettingsTitle,
            Defaults::SettingsTitle,
            Defaults::MinimumAccessCapability,
            Defaults::SettingsSlug,
            [SettingsUI::class, 'settingsPageMarkup']
        );
    }

    private static function addSettingsSection()
    {
        register_setting(
            Defaults::SettingsSlug,
            Defaults::SettingsSlug,
            ['sanitize_callback' => [SettingsUI::class, 'sanitizeSettings']]
        );

        add_settings_section(
            Defaults::SectionSlug,
            Defaults::SectionTitle,
            [SettingsUI::class, 'sectionDescription'],
            Defaults::SettingsSlug
        );
        add_settings_field(
            Defaults::UrlSettingSlug,
            Defaults::UrlSettingSlug,
            [SettingsUI::class, 'inputFieldURL'],
            Defaults::SettingsSlug,
            Defaults::SectionSlug,
            [Defaults::SettingsSlug, Defaults::UrlSettingSlug]
        );
        add_settings_field(
            Defaults::DefaultAuthorSettingSlug,
            Defaults::DefaultAuthorTitle,
            [SettingsUISettingsUI::class, 'defaultUserListing'],
            Defaults::SettingsSlug,
            Defaults::SectionSlug,
            [Defaults::SettingsSlug, Defaults::DefaultAuthorSettingSlug]
        );
    }
    public static function unregisterSettingsUI()
    {
        self::unregisterSettingsPage();
        self::unregisterSettingsSection();
    }
    private static function unregisterSettingsPage()
    {
        remove_action(self::AdminMenuHook, [self::class, 'addOptionsPage'], 10);
        remove_action(self::AdminMenuHook, [self::class, 'addSettingsSection'], 11);
    }

    private static function unregisterSettingsSection()
    {
        unregister_setting(Defaults::SettingsSlug, Defaults::SettingsSlug);
    }
}
