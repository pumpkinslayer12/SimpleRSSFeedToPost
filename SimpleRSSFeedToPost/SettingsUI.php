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
        do_settings_sections(AppDefaultValues::SettingsSlug);
        submit_button('Save Changes', 'primary');
        echo '</form>' .
            '<h2>Results of The Last Run</h2>' .
            '<pre>';
        var_dump(get_option(AppDefaultValues::LastJobRanStatusSlug));
        echo '</pre>' .
            '</div>';
    }
    public static function inputFieldURL()
    {
        $options = get_option(AppDefaultValues::SettingsSlug, [AppDefaultValues::UrlSettingSlug => '']);
        if (array_key_exists(AppDefaultValues::UrlSettingSlug, $options)) {
            $fieldInitialValue = $options[AppDefaultValues::UrlSettingSlug];
        } else {
            $fieldInitialValue = '';
        }

        $htmlField = '<input ' .
            'id="' . esc_attr(AppDefaultValues::UrlSettingSlug) . '" ' .
            'name="' . esc_attr(AppDefaultValues::SettingsSlug) . '[' . esc_attr(AppDefaultValues::UrlSettingSlug) . ']" ' .
            'type="text" ' .
            'value="' . esc_attr($fieldInitialValue) . '"/>';
        echo $htmlField;
    }

    public static function defaultUserListing()
    {
        $options = get_option(AppDefaultValues::SettingsSlug, []);

        if (array_key_exists(AppDefaultValues::DefaultAuthorSettingSlug, $options)) {
            $fieldInitialValue = $options[AppDefaultValues::DefaultAuthorSettingSlug];
        } else {
            $fieldInitialValue = 0;
        }

        wp_dropdown_users(
            [
                'name' => esc_attr(AppDefaultValues::SettingsSlug . '[' . AppDefaultValues::DefaultAuthorSettingSlug . ']'),
                'id' => esc_attr(AppDefaultValues::DefaultAuthorSettingSlug),
                'selected' => esc_attr($fieldInitialValue)
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

        if (is_user_member_of_blog($settings[AppDefaultValues::DefaultAuthorSettingSlug])) {

            $validFields[AppDefaultValues::DefaultAuthorSettingSlug] = $settings[AppDefaultValues::DefaultAuthorSettingSlug];
        } else {
            add_settings_error(
                AppDefaultValues::SettingsSlug,
                AppDefaultValues::DefaultAuthorSettingSlug . 'Error',
                'Please select a valid default user.'
            );
            $validFields[AppDefaultValues::DefaultAuthorSettingSlug] = -1;
        }

        return $validFields;
    }
}
