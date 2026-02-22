<?php
namespace WWAC;

if ( ! defined( 'ABSPATH' ) ) exit;

class Admin {

    public function __construct() {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function menu() {

    add_menu_page(
        'Instant Chat Connect',
        'Instant Chat Connect',
        'manage_options',
        'maaligaiwwac-settings',
        [$this, 'settings_page'],
        'dashicons-whatsapp',
        56
    );
}

    public function register_settings() {
        register_setting(
            'maaligaiwwac_settings_group',
            'maaligaiwwac_settings',
            [
                'sanitize_callback' => [$this, 'sanitize']
            ]
        );
    }

    public function sanitize($input) {

    return [
        'number'      => sanitize_text_field($input['number'] ?? ''),
        'message'     => sanitize_textarea_field($input['message'] ?? ''),
        'position'    => sanitize_text_field($input['position'] ?? 'right'),
        'logo_type'   => sanitize_text_field($input['logo_type'] ?? 'default'),
        'icon_size'   => intval($input['icon_size'] ?? 60),
        'button_text' => sanitize_text_field($input['button_text'] ?? ''),
        'show_text'   => !empty($input['show_text']) ? 1 : 0,
        ];
    }

    public function settings_page() {

        $options = get_option('maaligaiwwac_settings');
        ?>

        <div class="wrap">
            <h1>Instant Chat Connect</h1>

            <form method="post" action="options.php">

                <?php settings_fields('maaligaiwwac_settings_group'); ?>

                <table class="form-table">

                    <tr>
                        <th>WhatsApp Number (with country code)</th>
                        <td>
                            <input type="text"
                                   name="maaligaiwwac_settings[number]"
                                   value="<?php echo esc_attr($options['number'] ?? ''); ?>"
                                   class="regular-text" />
                        </td>
                    </tr>

                    <tr>
                        <th>Default Message</th>
                        <td>
                            <textarea name="maaligaiwwac_settings[message]"
                                      class="large-text"><?php
                                echo esc_textarea($options['message'] ?? '');
                            ?></textarea>
                        </td>
                    </tr>

                    <tr>
    <th>Logo Type</th>
    <td>
        <select name="maaligaiwwac_settings[logo_type]">
            <option value="default" <?php selected($options['logo_type'] ?? '', 'default'); ?>>
                WhatsApp
            </option>
            <option value="business" <?php selected($options['logo_type'] ?? '', 'business'); ?>>
                WhatsApp Business
            </option>
        </select>
    </td>
</tr>

<tr>
    <th>Icon Size (px)</th>
    <td>
        <input type="number"
               name="maaligaiwwac_settings[icon_size]"
               value="<?php echo esc_attr($options['icon_size'] ?? 60); ?>"
               min="40" max="120" />
    </td>
</tr>

<tr>
    <th>Show Text Bubble</th>
    <td>
        <input type="checkbox"
               name="maaligaiwwac_settings[show_text]"
               value="1"
               <?php checked($options['show_text'] ?? 0, 1); ?> />
        Enable text bubble
    </td>
</tr>

<tr>
    <th>Button Text</th>
    <td>
        <input type="text"
               name="maaligaiwwac_settings[button_text]"
               value="<?php echo esc_attr($options['button_text'] ?? 'Need Help? Chat with us'); ?>"
               class="regular-text" />
    </td>
</tr>

                    <tr>
                        <th>Button Position</th>
                        <td>
                            <select name="maaligaiwwac_settings[position]">
                                <option value="right"
                                    <?php selected($options['position'] ?? '', 'right'); ?>>
                                    Right
                                </option>
                                <option value="left"
                                    <?php selected($options['position'] ?? '', 'left'); ?>>
                                    Left
                                </option>
                            </select>
                        </td>
                    </tr>

                </table>

                <?php submit_button(); ?>

            </form>
        </div>

        <?php
    }
}