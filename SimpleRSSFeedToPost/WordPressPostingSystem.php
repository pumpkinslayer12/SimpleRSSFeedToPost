<?php

namespace SimpleRSSFeedToPost;

class WordPressPostingSystem
{
    const Author = 'post_author';
    const Date = 'post_date';
    const DatePattern = 'Y-m-d H:i:s';
    const Content = 'post_content';
    const Title = 'post_title';
    const Excerpt = 'post_excerpt';
    const Type = 'post_type';
    const MetaInput = 'meta_input';
    const DefaultType = 'post';
    const ID = 'ID';
    const Status = 'post_status';
    const DefaultStatus = 'publish';

    public static function RSSPostsToWordPress($posts)
    {
        return array_map([self::class, 'rssPostProcessing'], $posts);
    }

    private static function rssPostProcessing($post)
    {
        $rssPostProcessedToWordPressFormat = self::bindAndSanitizeRSSToWordPressPostFormat($post);

        $PostExists = post_exists($rssPostProcessedToWordPressFormat[self::Title], '', $rssPostProcessedToWordPressFormat[self::Date]);
        if ($PostExists >  0) {
            return $PostExists;
        } else {
            return wp_insert_post($rssPostProcessedToWordPressFormat, true);
        }
    }
    private static function bindAndSanitizeRSSToWordPressPostFormat($post)
    {
        $baseWordPressFields = [
            self::Date => date(self::DatePattern, strtotime($post[RSSParser::PubDate])),
            self::Content => wp_kses_post($post[RSSParser::Content]),
            self::Excerpt => wp_kses_post($post[RSSParser::Description]),
            self::Type => self::DefaultType,
            self::Title => sanitize_text_field($post[RSSParser::Title]),
            self::Status => self::DefaultStatus
        ];
        return array_merge($baseWordPressFields, self::isThereDefaultAuthor());
    }

    private static function isThereDefaultAuthor()
    {
        $options = get_option(AppDefaultValues::SettingsSlug, []);
        if (array_key_exists(AppDefaultValues::DefaultAuthorSettingSlug, $options)) {
            return [self::Author => intval($options[AppDefaultValues::DefaultAuthorSettingSlug])];
        } else {
            return [];
        }
    }
}
