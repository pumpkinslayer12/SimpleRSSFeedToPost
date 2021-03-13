<?php

namespace SimpleRSSFeedToPost;

class Defaults
{
    const AppTitle = 'Simple RSS Feed to Post';
    const AppSlug = 'SimpleRSSFeedtoPost';

    const SectionStub = 'Section';
    const SectionSlug = self::AppSlug . self::SectionStub;
    const SectionTitle = self::AppTitle . ' ' . self::SectionStub;

    const SettingsStub = 'Settings';
    const SettingsTitle = self::AppTitle . ' ' . self::SettingsStub;
    const SettingsSlug = self::AppSlug . self::SettingsStub;

    const UrlStub = 'URL';
    const UrlSettingSlug = self::SettingsSlug . self::UrlStub;

    const DefaultAuthorStub = 'DefaultAuthor';
    const DefaultAuthorTitle = 'Default Author';
    const DefaultAuthorSettingSlug = self::SettingsSlug . self::DefaultAuthorStub;

    const MinimumAccessCapability = 'manage_options';
}
