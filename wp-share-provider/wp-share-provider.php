<?php
/*
 * Plugin Name: WP Share Provider
 *
 */


defined('ABSPATH') || exit;

if (!defined('SHARE_PROVIDER_PLUGIN_DIR')) {
    define('SHARE_PROVIDER_PLUGIN_DIR', __DIR__);
    define('SHARE_PROVIDER_PLUGIN_VERSION', '1.0.0');
}

class ShareProvider
{
    private static $instance = null;

    /**
     * @return Singleton
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'share_provider_enqueue')); //Enueue assets for front-end

        add_action('admin_menu', array($this, 'initShareMenu')); //Add Plugin Setting Page to menu
        add_action('admin_init', array($this, 'initShareSettingsPage')); //Register plugin Settings

        add_filter('the_content', array($this, 'showShareProvider')); //Show plugin on front
    }

    public function share_provider_enqueue()
    {
        wp_register_style(
            'share-provider-styles',
            SHARE_PROVIDER_PLUGIN_DIR . '/assets/css/styles.css',
            array(),
            SHARE_PROVIDER_PLUGIN_VERSION
        );

        wp_register_script('share-provider-scrips',
            SHARE_PROVIDER_PLUGIN_DIR . '/assets/js/main.css', array('jquery'),
            SHARE_PROVIDER_PLUGIN_VERSION,
            true
        );

        wp_enqueue_style('share-provider-styles');
        wp_enqueue_script('share-provider-scrips');
    }

    public function initShareMenu()
    {
        //To Add as submennu of Settings ( <! Hide one, which you want !> )
        /*
        add_options_page(
            'Share Provider', //The text to be displayed in the title tags of the page when the menu is selected
            'Share', //The text to be used for the menu
            'install_plugins', //The capability required for this menu to be displayed to the user.
            'share-provider-plugin', //The slug name to refer to this menu by (should be unique for this menu).
            array( $this, 'initShareSettingsPage' ) //The function to be called to output the content for this page.
        );
        */

        //To Add as submennu of Settings ( <! Hide one, which you want !> )
        /*
        add_submenu_page(
            'options-general.php', //You can use any Parent from Main Dashboard Menu
            'Share Provider', //The text to be displayed in the title tags of the page when the menu is selected
            'Share', //The text to be used for the menu
            'install_plugins', //The capability required for this menu to be displayed to the user.
            'share-provider-plugin', //The slug name to refer to this menu by (should be unique for this menu).
            array( $this, 'initShareSettingsPage' ) //The function to be called to output the content for this page.
        );
        */

        //To Add as item in Main Dashboard Menu ( <! Hide one, which you want !> )
        add_menu_page(
            'Share Provider', //The text to be displayed in the title tags of the page when the menu is selected
            'Share', //The text to be used for the menu
            'install_plugins', //The capability required for this menu to be displayed to the user.
            'share-provider-plugin', //The slug name to refer to this menu by (should be unique for this menu).
            array($this, 'initShareSettingsPage'), //The function to be called to output the content for this page.
            'dashicons-share' //Dashicons is the official icon font of the WordPress admin as of 3.8.
        );
    }

    public function initShareSettingsPage()
    {
        add_settings_section(
            'enable-disable-share-provider-plugin',
            'Enable plugin',
            array($this, 'general_settings_callback'),
            'general'
        );
        add_settings_field(
            'toggle_share_provider',
            'Share plugin Enabled',
            array($this, 'enable_disable_callback'),
            'general',
            'enable-disable-share-provider-plugin',
            array('Enable this option to Enable Share Provider plugin')
        );
        register_setting(
            'general',
            'toggle_share_provider'
        );
    }

    public function general_settings_callback()
    {
        echo 'This option provide you enable or disable current plugin. Even if plugin is active, you have possibility to disable all plugin functions using this option.';
    }

    public function enable_disable_callback($args)
    {
        $html = '<input type="checkbox" id="toggle_share_provider" name="toggle_share_provider" value="1"' .
            checked(1, get_option('toggle_share_provider'), false) . '/>';
        $html .= '<label for="toggle_share_provider">' . $args[0] . '</label>';
        echo $html;
    }

    public function showShareProvider($content)
    {
        if (get_option('toggle_share_provider') && is_single()) {
            $content .= '<div class="">Share</div>';
        }
        return $content;
    }
}

ShareProvider::getInstance();  // Getting class object

/** start NOTES **/

//All is the same - Getting class object
//
//  $Object = ShareProvider::getInstance();
//  $Object -> test();
//  ShareProvider::getInstance() -> test();


//New tries will fire php error:
//
//  $Object2 = new Singleton();
//  Fatal error: Call to private Singleton::__construct() from invalid context
//
//  $Object3 = clone $Object;
//  Fatal error: Call to private Singleton::__clone() from context ''

/** end NOTES **/