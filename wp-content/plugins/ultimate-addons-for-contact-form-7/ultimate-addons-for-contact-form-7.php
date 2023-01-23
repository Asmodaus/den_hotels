<?php
/**
 * Plugin Name: Ultimate Addons for Contact Form 7
 * Plugin URI: https://cf7addons.com/
 * Description: 20+ Essential Addons for Contact form 7 including Conditional Fields, Multi Step Form, Thank you page Redirection, Columns Layout, WooCommerce Integration, Star Rating Fields, Range Slider and many more stunning Addons, all in one.
 * Version: 3.1.11
 * Author: Themefic
 * Author URI: https://themefic.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: ultimate-addons-cf7
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Class Ultimate_Addon_CF7
*/
class Ultimate_Addons_CF7 {
    
    /*
    * Construct function
    */
    public function __construct() {
        define( 'UACF7_URL', plugin_dir_url( __FILE__ ) );
        define( 'UACF7_ADDONS', UACF7_URL.'addons' );
        define( 'UACF7_PATH', plugin_dir_path( __FILE__ ) );
        
        //Plugin loaded
        add_action( 'plugins_loaded', array( $this, 'uacf7_plugin_loaded' ) );
        
        if(defined('WPCF7_VERSION') && WPCF7_VERSION >= 5.7){ 
            add_filter( 'wpcf7_autop_or_not', '__return_false' );
        }
        
        // Initialize the appsero
        $this->appsero_init_tracker_ultimate_addons_for_contact_form_7();
    }
	
    /*
    * Ultimate addons loaded
    */
    public function uacf7_plugin_loaded() {
        //Register text domain
        load_plugin_textdomain( 'ultimate-addons-cf7', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
        
        if(class_exists('WPCF7')){
            //Init ultimate addons
            $this->uacf7_init();
        
        }else{
            //Admin notice
            add_action( 'admin_notices', array( $this, 'uacf7_admin_notice' ) );
        }
    }
    
    /*
    * Admin notice- To check the Contact form 7 plugin is installed
    */
     public function uacf7_admin_notice(){
        ?>
        <div class="notice notice-error">
            <p>
               <?php printf(
                __('%s requires %s to be installed and active. You can install and activate it from %s', 'ultimate-addons-cf7'), '<strong>Ultimate Addons for Contact Form 7</strong>', '<strong>Contact form 7</strong>', '<a href="'.admin_url('plugin-install.php?tab=search&s=contact+form+7').'">here</a>.'
            ); ?></p>
        </div>
        <?php
    }
    
    /*
    * Init ultimate addons
    */
    public function uacf7_init() {
        
        //Require ultimate functions
        require_once( 'inc/functions.php' );
        
        //Enqueue admin scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'uacf7_frontend_scripts' ) );
        
        //Require admin menu
        require_once( 'admin/admin-menu.php' );
        
        //Require ultimate addons
        require_once( 'addons/addons.php' );
    }
    
    //Enquene admin scripts
    public function enqueue_admin_scripts(){
        
        wp_enqueue_style( 'uacf7-admin-style', UACF7_URL . 'assets/css/admin-style.css', 'sadf' );
        
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'uacf7-admin-script', UACF7_URL . 'assets/js/admin-script.js', array('jquery'), null, true );
    }

    //Enquene admin scripts
    public function uacf7_frontend_scripts(){ 
        wp_enqueue_style( 'uacf7-frontend-style', UACF7_URL . 'assets/css/uacf7-frontend.css', '' ); 
    }

    
    /**
     * Initialize the plugin tracker
     *
     * @return void
     */
    public function appsero_init_tracker_ultimate_addons_for_contact_form_7() {

        if ( ! class_exists( 'Appsero\Client' ) ) {
            require_once ( __DIR__ . '/inc/app/src/Client.php');
        }

        $client = new Appsero\Client( '7d0e21bd-f697-4c80-8235-07b65893e0dd', 'ultimate-addons-for-contact-form-7', __FILE__ );

        // Active insights
        $client->insights()->init();

    }

   
    
    
}

/*
* Object - Ultimate_Addons_CF7
*/
$ultimate_addons_cf7 = new Ultimate_Addons_CF7();
