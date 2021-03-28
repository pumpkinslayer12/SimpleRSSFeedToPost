<?php

namespace SimpleRSSFeedToPost;

class WordPressPostingSystem
{
    const WORDPRESSPOSTAUTHOR = 'post_author';
    const WORDPRESSPOSTDATE = 'post_date';
    const WORDPRESSPOSTDATEPATTERN = 'Y-m-d H:i:s';
    const WORDPRESSPOSTCONTENT = 'post_content';
    const WORDPRESSPOSTITLE = 'post_title';
    const WORDPRESSPOSTEXCERPT = 'post_excerpt';
    const WORDPRESSPOSTTYPE = 'post_type';
    const WORDPRESSPOSTMETAINPUT = 'meta_input';
    const WORDPRESSDEFAULTPOSTTYPE = 'post';
    const WORDPRESSPOSTID = 'ID';

    public static function postItems($posts)
    {
        return array_map([self::class, 'postProcessing'], $posts);
    }

    private static function postProcessing($post)
    {
        $postMatchingGUID = get_posts(
            [
                'meta_value' => $post[RSSParser::RSSGuid],
                'numberposts' => 1
            ]
        );

        if (array_key_exists(self::WORDPRESSPOSTID, $postMatchingGUID)) {
            return $postMatchingGUID[self::WORDPRESSPOSTID];
        } else {
            return wp_insert_post(self::bindAndSanitizeRSSToWordPressPostFormat($post), true);
        }
    }
    private static function bindAndSanitizeRSSToWordPressPostFormat($post)
    {
        $baseWordPressFields = [
            self::WORDPRESSPOSTDATE => date(RSSParser::RSSPubDateFormat, strtotime($post[RSSParser::RSSPubDateFormat])),
            self::WORDPRESSPOSTCONTENT => wp_kses_post($post[RSSParser::RSSContent]),
            self::WORDPRESSPOSTEXCERPT => wp_kses_post($post[RSSParser::RSSDescription]),
            self::WORDPRESSPOSTTYPE => sanitize_text_field($post[self::WORDPRESSDEFAULTPOSTTYPE]),
            self::WORDPRESSPOSTITLE => sanitize_text_field($post[RSSParser::RSSTitle]),
            self::WORDPRESSPOSTMETAINPUT => [
                RSSParser::RSSGuid => esc_url_raw($post[RSSParser::RSSGuid])
            ]
        ];

        return array_merge($baseWordPressFields, self::isThereDefaultAuthor());
    }

    private static function isThereDefaultAuthor()
    {
        $options = get_option(AppDefaultValues::SettingsSlug, []);
        if (array_key_exists(AppDefaultValues::DefaultAuthorSettingSlug, $options)) {
            return [self::WORDPRESSPOSTAUTHOR => intval($options[AppDefaultValues::DefaultAuthorSettingSlug])];
        } else {
            return [];
        }
    }
}
