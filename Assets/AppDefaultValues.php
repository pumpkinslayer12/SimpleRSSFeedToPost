<?php
namespace SimpleRSSFeedToPost;

class AppDefaultValues{
const AppTitle = 'Simple RSS Feed to Post';
const AppSlug = 'SimpleRSSFeedtoPost';

const SectionStub = 'Section';
const SectionSlug = AppSlug . SectionStub;
const SectionTitle = AppTitle . ' ' . SectionStub;

const SettingsStub = 'Settings';
const SettingsTitle = AppTitle . ' ' . SettingsStub;
const SettingsSlug = AppSlug . SettingsStub;

const UrlStub = 'URL';
const UrlSettingSlug = SettingsSlug . UrlStub;

const DefaultAuthorStub = 'DefaultAuthor';
const DefaultAuthorTitle = 'Default Author';
const DefaultAuthorSettingSlug = SettingsSlug . DefaultAuthorStub;

const MinimumAccessCapability = 'manage_options';
const AdminMenuHook = 'admin_menu';
const AdminInitHook = 'admin_init';

const installSettingSlug = AppSlug . 'Install';
const AppNameSpace = __NAMESPACE__ . '\\';
}