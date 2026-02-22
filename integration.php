<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Instant Chat Connect by Maalig
 * Plugin URI:        https://www.pmpksamy.com/Instant-chat-connect
 * Description:       Smart floating chat plugin with automation-ready architecture for modern WordPress websites.
 * Version:           1.0.0
 * Author:            IAMPMPKSAMY(Call Sign: Maalig)
 * Author URI:        https://www.pmpksamy.com
 * Text Domain:       Instant Chat Connect
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WWAC_PATH', plugin_dir_path( __FILE__ ) );
define( 'WWAC_URL', plugin_dir_url( __FILE__ ) );
define( 'WWAC_VERSION', '1.0.0' );

require_once WWAC_PATH . 'includes/class-plugin.php';

function wwac_init() {
    return \WWAC\Plugin::instance();
}

wwac_init();



// Add Settings link in Plugins page
add_filter(
    'plugin_action_links_' . plugin_basename(__FILE__),
    function($links) {

        $settings_link = '<a href="' . admin_url('admin.php?page=maaligaiwwac-settings') . '">Settings</a>';

        array_unshift($links, $settings_link);

        return $links;
    }
);

