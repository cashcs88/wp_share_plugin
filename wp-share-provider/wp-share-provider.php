<?php
/*
 * Plugin Name: WP Share Provider
 *
 */

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
        add_action('admin_menu', array($this, 'initShareMenu')); //Add Plugin Setting Page to menu
        add_action('admin_init', array($this, 'initShareSettings')); //Register plugin Settings
        add_action('admin_init', array($this, 'initShareSettingsPage')); //Register plugin Settings
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

    public function initShareSettings()
    {

    }

    public function initShareSettingsPage()
    {
        /*
        add_settings_section(
            'global',
            'Global Share Plugin settings',
            'initGlobalSharePluginSettingsSection',
            'share-provider-plugin' );
        */
    }

    public function initGlobalSharePluginSettingsSection() {

    }
}

ShareProvider::getInstance();  // Getting class object

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