<?php

namespace SimpleRSSFeedToPost;

class SettingsUI
{

    public static function settingsPageMarkup()
    {
        echo '<div class="wrap"><h2>' .
            esc_html(AppDefaultValues::AppTitle) .
            '</h2><form action="options.php" method="post">';

        settings_fields(AppDefaultValues::SettingsSlug);
        do_settings_sections(AppDefaultValues::SectionSlug);
        submit_button('Save Changes', 'primary');
        echo '</form></div>';
    }
    public static function inputFieldURL($option, $optionValue)
    {
        $htmlField = '<input id="' . $optionValue . '" name="' . $option . '["' . $optionValue . '"] type="text" value="';

        if (array_key_exists($optionValue, get_option($option))) {
            esc_html($htmlField . $option . '["' . $optionValue . '"]/>');
        } else {
            esc_html($htmlField . '"/>');
        }
    }

    public static function defaultUserListing($option, $optionValue)
    {
        $options = get_option($option);
        wp_dropdown_users(
            [
                'name' => esc_attr($option . '[' . $optionValue . ']'),
                'id' => esc_attr($optionValue),
                'selected' => esc_attr(array_key_exists($optionValue, $options) ? $options[$optionValue] : 0)
            ]
        );
    }

    public static function sectionDescription()
    {
        echo '<p>Please enter a valid RSS url and select a default user for imported posts.</p>';
    }

    public static function sanitizeSettings($settings)
    {
        $validFields = [];
        $validFields[AppDefaultValues::UrlSettingSlug] = esc_url_raw($settings[AppDefaultValues::UrlSettingSlug]);
        $validFields[AppDefaultValues::DefaultAuthorSettingSlug] = intval($settings[AppDefaultValues::DefaultAuthorSettingSlug]);

        if ($validFields[UrlSettingSlug] !== $settings[AppDefaultValues::UrlSettingSlug]) {
            add_settings_error(
                AppDefaultValues::SettingsSlug,
                AppDefaultValues::UrlSettingSlug . 'Error',
                'Please enter a valid RSS feed url'
            );
            return $settings;
        }

        if (!is_user_member_of_blog($validFields[AppDefaultValues::DefaultAuthorSettingSlug])) {
            add_settings_error(
                AppDefaultValues::SettingsSlug,
                AppDefaultValues::DefaultAuthorSettingSlug . 'Error',
                'Please select a valid default user'
            );
            return $settings;
        }
        return $validFields;
    }
}
