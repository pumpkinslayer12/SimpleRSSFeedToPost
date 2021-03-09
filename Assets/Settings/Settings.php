<?php
function appTitle()
{
    return 'Simple RSS Feed to Post';
}

function appSlug()
{
    return 'SimpleRSSFeedToPost';
}

function settingsTitle()
{
    return appTitle() . ' Settings';
}

function settingsSlug()
{
    return appSlug() . 'Settings';
}

function sectionTitle()
{
    return appTitle() . ' Section';
}

function sectionSlug()
{
    return appSlug() . 'Section';
}

function minimumAccessCapability()
{
    return 'manage_options';
}

function registerSettingsUI()
{
    addSettingsPage();
    registerSettingsSection();
}

function addSettingsPage()
{
    add_options_page(
        appTitle(),
        appTitle(),
        minimumAccessCapability(),
        settingsSlug(),
        'settingsPageMarkup'
    );
}
function settingsPageMarkup()
{

    echo '<div class="wrap">' .
        '<h2>' . settingsTitle() . '</h2>' .
        '<form action="options.php" method="post">';
    settings_fields(settingsSlug());
    do_settings_sections(sectionSlug());
    submit_button('Save Changes', 'primary');
    echo '</form></div>';
}

function urlSettingSlug()
{
    return settingsSlug() . 'URL';
}
function defaultUserSettingSlug()
{
    return settingsSlug() . 'DefaultAuthor';
}

function registerSettingsSection()
{
    register_setting(
        settingsSlug(),
        settingsSlug(),
        ['sanitize_callback' => 'sanitizeSettings']
    );

    add_settings_section(
        sectionSlug(),
        sectionTitle(),
        function () {
            echo '<p>Please enter a valid RSS url and select a default user for imported posts.</p>';
        },
        settingsSlug()
    );
    $urlTitle = 'RSS Feed URL';
    add_settings_field(
        urlSettingSlug(),
        $urlTitle,
        'inputFieldURL',
        settingsSlug(),
        sectionSlug(),
        [settingsSlug(), urlSettingSlug()]
    );
    $authorTitle = 'Default Author';
    add_settings_field(
        defaultUserSettingSlug(),
        $authorTitle,
        'defaultUserListing',
        settingsSlug(),
        sectionSlug(),
        [settingsSlug(), defaultUserSettingSlug()]
    );
}
function inputFieldURL($option, $optionValue)
{
    $options = get_option($option);

    echo '<input id="' . esc_attr($optionValue) . '" name="' . esc_attr($option) . '["' . esc_attr($optionValue) . '] type="text" value="' .
        esc_url(array_key_exists($optionValue, $options) ? $options[$optionValue] : '') .
        '"/>';
}

function defaultUserListing($option, $optionValue)
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

function sanitizeSettings($settings)
{
    $validFields = [];
    $validFields[urlSettingSlug()] = esc_url_raw($settings[urlSettingSlug()]);
    $validFields[defaultUserSettingSlug()] = intval($settings[defaultUserSettingSlug()]);

    if ($validFields[urlSettingSlug()] !== $settings[urlSettingSlug()]) {
        add_settings_error(
            settingsSlug(),
            urlSettingSlug() . 'Error',
            'Please enter a valid RSS feed url'
        );
        return $settings;
    }

    if (!is_user_member_of_blog($validFields[defaultUserSettingSlug()])) {
        add_settings_error(
            settingsSlug(),
            defaultUserSettingSlug() . 'Error',
            'Please select a valid default user'
        );
        return $settings;
    }
    return $validFields;
}
