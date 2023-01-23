<?php
/*
 * SOFTWARE LICENSE INFORMATION
 *
 * Copyright (c) 2017 Buttonizer, all rights reserved.
 *
 * This file is part of Buttonizer
 *
 * For detailed information regarding to the licensing of
 * this software, please review the license.txt or visit:
 * https://buttonizer.pro/license/
 */

namespace Buttonizer\Admin;

use Buttonizer\Api\Settings\MigrateToStandalone;
use Buttonizer\Utils\ButtonizerAccount;
use Buttonizer\Utils\ManifestParser;
use Buttonizer\Utils\Editor;
use Buttonizer\Utils\PermissionCheck;
use Buttonizer\Utils\Settings;

# No script kiddies
defined('ABSPATH') or die('No script kiddies please!');

class Admin
{
    private static $adminStyles = ["dashicons", "common", "admin-menu", "dashboard", "nav-menus", "site-icon", "l10n"];

    /**
     * Admin constructor.
     */
    public function __construct()
    {
        // Add to admin menu
        add_action('admin_menu', [$this, 'pluginAdminMenu']);

        // Lets do some admin stuff for Buttonizer
        add_action('admin_enqueue_scripts', [$this, 'adminAssets']);

        // Enable modules
        add_filter('script_loader_tag', [$this, 'addModuleToScriptTag'], 10, 3);

        // Plugin information, add links
        add_filter("plugin_action_links_" . BUTTONIZER_BASE_NAME, function ($actions) {
            $links = [
                '<a href="' . admin_url('admin.php?page=Buttonizer#/support') . '">' . __('Support', 'buttonizer-multifunctional-button') . '</a>',
                '<a href="' . admin_url('admin.php?page=Buttonizer#/editor') . '">' . __('Manage buttons', 'buttonizer-multifunctional-button') . '</a>',
                '<a href="' . admin_url('admin.php?page=Buttonizer#/settings') . '">' . __('Settings', 'buttonizer-multifunctional-button') . '</a>',
            ];

            return array_merge($actions, $links);
        });
    }

    /**
     * Create Admin menu
     */
    public function pluginAdminMenu()
    {

        if (!PermissionCheck::hasPermission()) return;

        // Admin menu
        add_menu_page('Buttonizer Buttons', 'Buttonizer', 'read', 'Buttonizer', [$this, 'page'], plugins_url('/assets/images/wp-icon.png', BUTTONIZER_PLUGIN_DIR), 81);

        // Add submenu
        add_submenu_page('Buttonizer', 'Manage buttons',  __('Manage buttons', 'buttonizer-multifunctional-button'), 'read', 'admin.php?page=Buttonizer#/editor');

        // Add support link
        add_submenu_page('Buttonizer', __('I need support', 'buttonizer-multifunctional-button'),  __('I need support', 'buttonizer-multifunctional-button'), 'read', 'admin.php?page=Buttonizer#/support');

        // Add community link
        add_submenu_page('Buttonizer', __('Community', 'buttonizer-multifunctional-button'),  __('Community', 'buttonizer-multifunctional-button'), 'read', 'https://community.buttonizer.pro/?referral=buttonizer-plugin-menu');

        // Add knowledge base link
        add_submenu_page('Buttonizer', __('Knowledge base', 'buttonizer-multifunctional-button'),  __('Knowledge base', 'buttonizer-multifunctional-button'), 'read', 'https://community.buttonizer.pro/knowledgebase?referral=buttonizer-plugin-menu');
    }

    public function adminAssets()
    {
        // Only add our assets to our own admin
        if (!isset($_GET['page']) || $_GET['page'] !== "Buttonizer") return;

        // Get latest files
        $manifest = new ManifestParser(BUTTONIZER_DIR . "/assets/app/manifest.json", plugins_url('assets/app', BUTTONIZER_PLUGIN_DIR));

        // Get dashboard scripts
        $script = $manifest->getEntrypoint("index.html", false);

        // Get dashboard style
        $styles = $manifest->getStyles("index.html", false);

        // Get imports
        $imports = $manifest->getImports("index.html", false);

        // Add script
        wp_register_script('buttonizer_admin_js', $script['url'], [], md5(BUTTONIZER_VERSION), true);

        // From script
        wp_deregister_style('forms');

        // Current user
        $current_user = wp_get_current_user();
        $current_user = $current_user->data;

        // Localize script
        wp_localize_script('buttonizer_admin_js', 'buttonizer_admin', [
            'admin' => admin_url('admin.php'),
            'isAdmin' => \is_user_logged_in() && current_user_can(is_multisite() ? 'manage_options' : 'activate_plugins'),
            'baseUrl' => get_site_url('/'),
            'adminBase' => substr(admin_url(), 0, -1),
            'assetsPath' => plugins_url('/assets', BUTTONIZER_PLUGIN_DIR),
            'api' => get_rest_url(),
            'nonce' => wp_create_nonce('wp_rest'),
            'isPlain' => get_option('permalink_structure') === "",
            'version' => BUTTONIZER_VERSION,
            'locale' => Editor::getEditorLanguage(),
            'actionLock' => $this->getActionLock(),
            'requestReview' => $this->requestForReview(),
            'beforeMigrate' => $this->getBeforeMigrate(),
            'hasMigrated' => Settings::getSetting("has_migrated", false),
            'hasLicense' => ButtonizerAccount::getSetting("site_licensed", false),
            'account' => ButtonizerAccount::getData(),
            'security' => wp_create_nonce("save_buttonizer"),
            'settings' => [
                'adminTopBarButtonEnabled' => Settings::getSetting("admin_top_bar_show_button", true),
                'canSendErrors' => Settings::getSetting("can_send_errors", false),
                'accessRoles' => Settings::getSetting("additional_permissions", []),
                'googleAnalytics' => Settings::getSetting("google_analytics", null),
                'waitUntilConsent' => Settings::getSetting("wait_until_consent", false)
            ],
            'available_roles' => $this->getRoles(),
            'site' => [
                'domain' => parse_url(get_site_url(), PHP_URL_HOST),
                'name' => get_bloginfo('name'),
                'user' => [
                    "email" => $current_user->user_email,
                    'firstName' => $current_user->first_name ?? $current_user->display_name ?? $current_user->user_nicename ?? "",
                    'lastName' => $current_user->last_name ?? ""
                ]
            ]
        ]);

        wp_enqueue_script('buttonizer_admin_js');

        // Register all script imports
        foreach ($imports as $key => $importSscript) {
            wp_register_script('buttonizer_admin_js_' . $key, $importSscript['url'], ["buttonizer_admin_js"], md5(BUTTONIZER_VERSION), true);
            wp_enqueue_script('buttonizer_admin_js_' . $key);
        }

        // Register all styles
        foreach ($styles as $key => $style) {
            wp_register_style('buttonizer_admin_css_' . $key, $style['url'], self::$adminStyles, md5(BUTTONIZER_VERSION));
            wp_enqueue_style('buttonizer_admin_css_' . $key);
        }
    }

    /**
     * @param string $tag
     * @param string $handle
     * @param string $src
     */
    public function addModuleToScriptTag($tag, $handle, $src)
    {
        // Add module to script tag
        if (strpos($handle, 'buttonizer_admin_js') === 0) {
            $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        }

        return $tag;
    }


    public function page()
    {
        require_once __DIR__ . "/AdminTemplate.php";
    }

    /**
     * Lock the screen to a specific action
     *
     * @return string lock
     */
    public function getActionLock(): string
    {
        // Needs migration
        if (defined("BUTTONIZER_LEGACY_REQUESTED_MIGRATION") && !BUTTONIZER_LEGACY_REQUESTED_MIGRATION) {
            return "migration";
        }

        // Set up Buttonizer
        if (Settings::getSetting("finished_setup", false) === false) {
            return "setup";
        }

        return "no-lock";
    }

    /**
     * Migration status
     *
     * @return string lock
     */
    public function getBeforeMigrate()
    {
        // Needs migration
        if (!defined("BUTTONIZER_LEGACY_REQUESTED_MIGRATION")) {
            return null;
        }

        return MigrateToStandalone::getReadyForMigration();
    }

    public static function wordpressAdminBar($admin_bar)
    {
        // Only show to admins and when enabled
        if (
            // Check permission
            !PermissionCheck::hasPermission() ||

            // Admin bar disabled
            filter_var(Settings::getSetting('admin_top_bar_show_button', true), FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]) === false
        ) {
            return;
        }

        $admin_bar->add_menu(array(
            'id' => 'buttonizer',
            'title' => '<img src="' . plugins_url('/assets/images/wp-icon.png', BUTTONIZER_PLUGIN_DIR) . '" style="vertical-align: text-bottom; opacity: 0.7; display: inline-block;" />',
            'href' => admin_url() . 'admin.php?page=Buttonizer#/', // (!is_admin() ? '#' . urlencode($_SERVER["REQUEST_URI"]) : '')
            'meta' => [],
        ));

        // Buttonizer buttons
        $admin_bar->add_menu(array(
            'id' => 'buttonizer_buttons',
            'parent' => 'buttonizer',
            'title' => __('Manage buttons', 'buttonizer-multifunctional-button'),
            'href' => admin_url() . 'admin.php?page=Buttonizer#/editor', // (!is_admin() ? '#' . urlencode($_SERVER["REQUEST_URI"]) : '')
            'meta' => array(),
        ));

        // Settings
        $admin_bar->add_menu(array(
            'id' => 'buttonizer_settings',
            'parent' => 'buttonizer',
            'title' => __('Settings', 'buttonizer-multifunctional-button'),
            'href' => admin_url() . 'admin.php?page=Buttonizer#/settings',
            'meta' => array(),
        ));

        // Add support link
        $admin_bar->add_menu(array(
            'id' => 'buttonizer_support',
            'parent' => 'buttonizer',
            'title' => __('I need support', 'buttonizer-multifunctional-button'),
            'href' => admin_url() . 'admin.php?page=Buttonizer#/support',
            'meta' => array(),
        ));

        // Settings
        $admin_bar->add_menu(array(
            'id' => 'buttonizer_knowledgebase',
            'parent' => 'buttonizer',
            'title' => __('Knowledge base', 'buttonizer-multifunctional-button'),
            'href' => "https://community.buttonizer.pro/knowledgebase",
            'meta' => [
                "target" => "_blank",
                "title" => __('Find out everything you need to know about Buttonizer', 'buttonizer-multifunctional-button')
            ],
        ));
    }

    /**
     * Get roles for Buttonizer permission setting
     */
    private function getRoles()
    {
        $roles = [];

        foreach (wp_roles()->get_names() as $id => $role) {
            $roles[] = [
                'id'    => $id,
                'name' => $role
            ];
        }

        return $roles;
    }

    /**
     * Decide if we want to ask this user for a review
     *
     * We have so many ideas to work on...
     *
     * Hope you'd like to support us, but we don't want to bother you too much either :)
     */
    public function requestForReview()
    {
        try {
            // We already have asked for a review and they have clicked
            // We're happy humans, so we won't ask again
            if (Settings::getSetting("review_marked_as_done", false) === true) {
                return false;
            }

            // Get current time
            $currentTime = new \DateTime();

            // User requested to remind them later
            if (Settings::getSetting("review_reminding_since", null) !== null) {
                $remindFrom = Settings::getSetting("review_reminding_since", $currentTime);

                // Get the difference between today and the installed at
                $difference = ($currentTime)->diff($remindFrom);

                // Don't show yet, borrow them some time
                if ($difference->days <= 31) {
                    return false;
                }
            }

            /**
             * @var DateTime
             */
            $installDate = Settings::getSetting("installed_at", $currentTime);

            // Get the difference between today and the installed at
            $difference = ($currentTime)->diff($installDate);

            // Show after 9 days
            return $difference->days >= 9;
        } catch (\Error $e) {
            return false;
        }
    }
}
