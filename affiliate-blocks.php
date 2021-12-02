<?php
/**
 * Plugin Name: Affiliate Blocks
 * Plugin URI: https://github.com/wpyork/affiliate-blocks
 * Description: affiliate-blocks — is a Gutenberg block plugin
 * Author: wpyork
 * Author URI: https://profiles.wordpress.org/wpyork/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('AFB_DOMAIN', 'affiliate-blocks');
define('AFB_DIR', plugin_dir_path(__FILE__));
define('AFB_URL', plugins_url('/', __FILE__));

/**
 * Initialize the blocks
 */ 
function affiliate_blocks_gutenberg_loader() {
    /**
     * Load the blocks functionality
     */
    require_once ( AFB_DIR . 'dist/init.php');
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

add_action('plugins_loaded', 'affiliate_blocks_gutenberg_loader');

/**
 * Load the plugin text-domain
 */
function affiliate_blocks_gutenberg_init() {
    load_plugin_textdomain('affiliate-blocks', false, basename(dirname(__FILE__)) . '/languages');
}

add_action('init', 'affiliate_blocks_gutenberg_init');

/**
 * Load the plugin welcome page css
 */
function affiliate_blocks_load_admin_scripts( $hook ) {
    wp_enqueue_style( 'affiliate-blocks', AFB_URL.'/assets/css/affiliateblocks.css', false, '' );
}
add_action( 'admin_enqueue_scripts', 'affiliate_blocks_load_admin_scripts' );

/**
 * Create Affiliate Block Categories
 */
if ( version_compare( $GLOBALS['wp_version'], '5.8', '<' ) ) {
    add_filter( 'block_categories', 'affiliate_blocks_block_category', 10, 2 );
} else {
    add_filter( 'block_categories_all', 'affiliate_blocks_block_category', 10, 2 );
}

function affiliate_blocks_block_category( $categories, $post ) 
{
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'affiliate-blocks',
                'title' => __( 'Affiliate Block', 'affiliate-blocks' ),
            ),
        )
    );
   
}


/**
 * Add plugin action links.
 *
 * Add a link to the settings page on the plugins.php page.
 *
 * @since 1.0.0
 *
 * @param  array  $links List of existing plugin action links.
 * @return array         List of modified plugin action links.
 */
function ab_plugin_action_links( $links ) {

    $links = array_merge($links, array(
        '<a target="_blank" href="' . esc_url( 'https://profiles.wordpress.org/wpyork/' ) . '">' . __( 'Support', 'affiliate-blocks' ) . '</a>',        
    ) );
    return $links;

}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ab_plugin_action_links' );





