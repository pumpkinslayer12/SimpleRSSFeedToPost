<?php

class SettingsUI
{
    private static function echoContent($content){
        echo esc_html($content);
    }
    public static function settingsPageMarkup()
    {
        self::echoContent(
            '<div class="wrap">' .
            '<h2>' . Defaults::AppTitle . '</h2>' .
            '<form action="options.php" method="post">'
        );

        settings_fields(Defaults::SettingsSlug);
        do_settings_sections(Defaults::SectionSlug);
        submit_button('Save Changes', 'primary');
        self::echoContent('</form></div>');
    }
    public static function inputFieldURL($option, $optionValue)
    {
        $htmlField = '<input id="'.$optionValue.'" name="'.$option.'["'.$optionValue.'"] type="text" value="';

        if (array_key_exists($optionValue, get_option($option))){
            self::echoContent($htmlField . $option . '["'.$optionValue.'"]/>');
        }
        else{
            self::echoContent($htmlField.'"/>');

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
        self::echoContent('<p>Please enter a valid RSS url and select a default user for imported posts.</p>');
    }

    public static function sanitizeSettings($settings)
    {
        $validFields = [];
        $validFields[Defaults::UrlSettingSlug] = esc_url_raw($settings[Defaults::UrlSettingSlug]);
        $validFields[Defaults::DefaultAuthorSettingSlug] = intval($settings[Defaults::DefaultAuthorSettingSlug]);

        if ($validFields[Defaults::UrlSettingSlug] !== $settings[Defaults::UrlSettingSlug]) {
            add_settings_error(
                Defaults::SettingsSlug,
                Defaults::UrlSettingSlug . 'Error',
                'Please enter a valid RSS feed url'
            );
            return $settings;
        }

        if (!is_user_member_of_blog($validFields[Defaults::DefaultAuthorSettingSlug])) {
            add_settings_error(
                Defaults::SettingsSlug,
                Defaults::DefaultAuthorSettingSlug . 'Error',
                'Please select a valid default user'
            );
            return $settings;
        }
        return $validFields;
    }
}
