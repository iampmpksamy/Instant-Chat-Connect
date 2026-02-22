<?php
namespace WWAC;

if ( ! defined( 'ABSPATH' ) ) exit;

class Frontend {

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'assets']);
        add_action('wp_footer', [$this, 'render_button']);
    }

    public function assets() {
        wp_enqueue_style(
            'wwac-style',
            WWAC_URL . 'assets/css/style.css',
            [],
            WWAC_VERSION
        );
    }

    public function render_button() {

        $options = get_option('maaligaiwwac_settings');

        if ( empty($options) || empty($options['number']) ) {
            return;
        }

        // Position
        $position = 'right';
        if ( !empty($options['position']) &&
             in_array($options['position'], ['left','right']) ) {
            $position = esc_attr($options['position']);
        }

        // Basic fields
        $number  = esc_attr($options['number']);
        $message = !empty($options['message'])
                   ? urlencode($options['message'])
                   : '';

        // Advanced UI fields
        $logo_type   = $options['logo_type'] ?? 'default';
        $icon_size   = !empty($options['icon_size']) ? intval($options['icon_size']) : 60;
        $button_text = $options['button_text'] ?? '';
        $show_text   = !empty($options['show_text']);

        // Safety limits for size
        if ($icon_size < 40) $icon_size = 40;
        if ($icon_size > 120) $icon_size = 120;

        $url = "https://wa.me/{$number}?text={$message}";
        ?>

        <div class="wwac-wrapper wwac-<?php echo esc_attr($position); ?>">

            <?php if ($show_text && !empty($button_text)) : ?>
                <span class="wwac-text">
                    <?php echo esc_html($button_text); ?>
                </span>
            <?php endif; ?>

            <a href="<?php echo esc_url($url); ?>"
               target="_blank"
               class="wwac-button"
               style="width: <?php echo esc_attr($icon_size); ?>px;
                      height: <?php echo esc_attr($icon_size); ?>px;"
               aria-label="Chat on WhatsApp">

                <?php if ($logo_type === 'business') : ?>

                    <img src="<?php echo esc_url(WWAC_URL . 'assets/images/whatsapp-business.png'); ?>"
                         alt="WhatsApp Business"
                         style="width: <?php echo esc_attr($icon_size - 20); ?>px;
                                height: <?php echo esc_attr($icon_size - 20); ?>px;" />

                <?php else : ?>

                    <img src="<?php echo esc_url(WWAC_URL . 'assets/images/whatsapp.png'); ?>"
                         alt="WhatsApp"
                         style="width: <?php echo esc_attr($icon_size - 20); ?>px;
                                height: <?php echo esc_attr($icon_size - 20); ?>px;" />

                <?php endif; ?>

            </a>

        </div>

        <?php
    }
}