<?php

namespace SimpleRSSFeedToPost;

class AppDefaultValues
{
    const AppTitle = 'Simple RSS Feed to Post';
    const AppSlug = 'SimpleRSSFeedtoPost';

    private const SectionStub = 'Section';
    const SectionSlug = self::AppSlug . self::SectionStub;
    const SectionTitle = self::AppTitle . ' ' . self::SectionStub;

    private const SettingsStub = 'Settings';
    const SettingsTitle = self::AppTitle . ' ' . self::SettingsStub;
    const SettingsSlug = self::AppSlug . self::SettingsStub;

    private const UrlStub = 'URL';
    const UrlSettingSlug = self::SettingsSlug . self::UrlStub;
    const UrlSettingsTitle = self::UrlStub;

    private const DefaultAuthorStub = 'DefaultAuthor';
    const DefaultAuthorTitle = 'Default Author';
    const DefaultAuthorSettingSlug = self::SettingsSlug . self::DefaultAuthorStub;

    private const LastJobRanStatusStub = 'LastJobRanStatus';
    const LastJobRanStatusSlug = self::SettingsSlug . self::LastJobRanStatusStub;

    const CronAction = self::AppSlug . 'Cron';
    const CronFrequency = 'hourly';

    const MinimumAccessCapability = 'manage_options';
    const AdminMenuHook = 'admin_menu';
    const AdminInitHook = 'admin_init';
    const UpdateOptionHook = 'update_option';
    const UpdateSettingsOptionHook = self::UpdateOptionHook . '_' . self::SettingsSlug;

    const installSettingSlug = self::AppSlug . 'Install';
    const AppNameSpace = __NAMESPACE__ . '\\';
}
