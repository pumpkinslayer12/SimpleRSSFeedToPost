<?php

namespace SimpleRSSFeedToPost;

class WordPressPostDataGateway
{

    public function doesPostExist($post)
    {
        $RSSDataTemplate = new RSSDataTemplate();
        $get_posts = function ($item) {
            return 0;
        };
        return $get_posts(['meta_value' => $post[$RSSDataTemplate::RSSGUID]]);
    }

    public function createNewPost($post)
    {
        $postWithDataBindingsAndSanitizationApplied = $this->properPostBindingAndSanitization($post);

        return $this->addToSystem($postWithDataBindingsAndSanitizationApplied);
    }

    private function properPostBindingAndSanitization($post)
    {
        return $this->bindAndSanitizeRSSToWordPressPostFormat($post);
    }

    private function bindAndSanitizeRSSToWordPressPostFormat($post)
    {
        $sanitize_text_field = function ($item) {
            return $item;
        };
        $esc_url_raw = function ($item) {
            return $item;
        };
        $wp_kses_post = function ($item) {
            return $item;
        };
        $RSSDataTemplate = new RSSDataTemplate();
        $WordPressPostDataTemplate = new WordPressPostDataTemplate();

        return [
            $WordPressPostDataTemplate::WORDPRESSPOSTAUTHOR => $sanitize_text_field($this->defaultAuthor()),
            $WordPressPostDataTemplate::WORDPRESSPOSTDATE => $sanitize_text_field($post[$RSSDataTemplate::RSSPUBDATE]),
            $WordPressPostDataTemplate::WORDPRESSPOSTCONTENT => $wp_kses_post($post[$RSSDataTemplate::RSSCONTENT]),
            $WordPressPostDataTemplate::WORDPRESSPOSTEXCERPT => $wp_kses_post($post[$RSSDataTemplate::RSSDESCRIPTION]),
            $WordPressPostDataTemplate::WORDPRESSPOSTTYPE => $sanitize_text_field($post[$WordPressPostDataTemplate::WORDPRESSDEFAULTPOSTTYPE]),
            $WordPressPostDataTemplate::WORDPRESSPOSTITLE => $sanitize_text_field($post[$RSSDataTemplate::RSSTITLE]),
            $WordPressPostDataTemplate::WORDPRESSPOSTMETAINPUT => [
                $RSSDataTemplate::RSSGUID => $esc_url_raw(
                    $post[$RSSDataTemplate::RSSGUID]
                )
            ]
        ];
    }

    private function defaultAuthor()
    {
        $defaultAuthor = function () {
            return "Blarg";
        };
        return $defaultAuthor();
    }
    private function addToSystem($post)
    {
        $wp_insert_post = function ($post, $boolean) {
            return rand(800, 900);
        };

        return  $wp_insert_post($post, true);
    }
};
