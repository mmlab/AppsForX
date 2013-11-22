<?php

/*
 * Plugin Name: Apps4X
 * Plugin URI: https://github.com/oSoc13/AppsForX
 * Description: Adding events, apps and ideas to a WordPress blog
 * Version: 1.0
 * Author: Cedric Van Bockhaven
 * Author URI: http://ce3c.be
 * Text Domain: wpapps

 * Copyright: OKFN Belgium (some rights reserved)
 * License: GPL2

 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * Attributions: See README or GitHub page for the full attributions list
*/

defined('ABSPATH') || exit;

/**
 * Are you a developer?
 * Make sure to check out the developer notes on the AppsForX GitHub Wiki!
 */
class WPApps {
    const WPAPPS_VERSION = '1.0';

    // setvars
    var $options;
    // classvars
    var $posttypes, $metaboxes;

    /**
     * Initializes constants and calls setup functions
     */
    function __construct() {
        define('IN_WPAPPS', 1);
        define('WPAPPS_DEBUG', false);
        define('WPAPPS_URL', plugin_dir_url(__FILE__));
        define('WPAPPS_PATH', plugin_dir_path(__FILE__));
        define('WPAPPS_TRANS', 'wpapps');

        $this->setup_debug();
        $this->setup_options(); // not used atm
        $this->setup_translations();
        $this->setup_roles();
        $this->setup_relationships();
        $this->setup_template();
        $this->setup_hooks();
        $this->setup_shortcodes();

        require_once WPAPPS_PATH . '/posttypes.php';
        require_once WPAPPS_PATH . '/metaboxes.php';

        $this->posttypes = new WPApps_Posttypes($this);
        $this->metaboxes = new WPApps_Metaboxes($this);
    }

    /**
     * These hooks make sure that an admin menu is displayed
     * Also takes care of the necessary CSS includes
     */
    function setup_hooks() {
        if (is_admin()) {
            // When editing an idea/event/app, the menu loses its highlighting
            // By resetting the $parent_file and $submenu_file variable, we can maintain the menu highlight
            add_action('admin_head', function() {
                global $submenu_file, $parent_file;
                $types = array("event", "idea", "app", "submission");
                $ptype = @($_REQUEST["post_type"] ?: get_post_type(get_the_ID()));

                if (in_array($ptype, $types)) {
                    $parent_file = "wpapps";
                    $submenu_file = "edit.php?post_type=$ptype";
                }
            });

            // Add the menu/submenu items: Apps4X > Overview|Events|Ideas|Apps
            add_action('admin_menu', function() {
                add_menu_page(__("Apps4X", WPAPPS_TRANS), __("Apps4X", WPAPPS_TRANS), "edit_ideas", "wpapps",array($this, "page_overview"), WPAPPS_URL . "/style/calendar16.png", (string)(27+M_PI)); // rule of pi

                add_submenu_page("wpapps", __("Overview", WPAPPS_TRANS), __("Overview", WPAPPS_TRANS), "edit_ideas", "wpapps", array($this, "page_overview")); // overwrite menu title
                add_submenu_page("wpapps", __("Events", WPAPPS_TRANS), __("Events", WPAPPS_TRANS), "edit_events", "edit.php?post_type=event");
                add_submenu_page("wpapps", __("Ideas", WPAPPS_TRANS), __("Ideas", WPAPPS_TRANS), "edit_ideas", "edit.php?post_type=idea");
                add_submenu_page("wpapps", __("Apps", WPAPPS_TRANS), __("Apps", WPAPPS_TRANS), "edit_apps", "edit.php?post_type=app");
                add_submenu_page("wpapps", __("Submissions", WPAPPS_TRANS), __("Submissions", WPAPPS_TRANS), "edit_submissions", "edit.php?post_type=submission");
            });

            // Add admin css
            add_action('admin_init', function() {
                wp_register_style('wpapps-admin', WPAPPS_URL . '/style/wpapps-admin.css', array(),  WPAPPS_VERSION);
                wp_enqueue_style('wpapps-admin');
            });
        }
        else {
            // Add frontend css
            add_action('wp_print_styles', function() {
                wp_register_style('wpapps', WPAPPS_URL.'/style/wpapps.css');
                wp_enqueue_style('wpapps');
            });
        }
    }

    /**
     * This function can display the overview page, could also be a require()
     */
    public function page_overview() { // ToDo

            // Find connected pages (for all posts)
       $posts = get_posts(
         array(
          'numberposts' => -1,
          'post_status' => 'pending',
          'post_type' => get_post_types('', 'names'),
         )
        );

        echo "<h2>List of pending submissions.</h2>";
        
        echo "<h3>Applications</h3>";
        echo "<ul>" ;
        foreach ($posts as $post) { 
         // echo $post->post_title . PHP_EOL; //...
            if ($post->post_type == "app")
                echo "<li><a href=" . get_permalink( $post->ID ) . "> " . $post->post_title . "</a></li>" ;
        }
        echo "</ul>" ;

        echo "<h3>Ideas</h3>";
        echo "<ul>" ;
        foreach ($posts as $post) { 
         // echo $post->post_title . PHP_EOL; //...
            if ($post->post_type == "idea")
                echo "<li><a href=" . get_permalink( $post->ID ) . "> " . $post->post_title . "</a></li>" ;
        }
        echo "</ul>" ;

    }
    /**
     * We can save user options to the database, but it isn't used at the moment
     */
    private function setup_options() {
        $defaults = array(
            "plugin_version" => 0
        );

        $this->options = get_option("wpapps_options", $defaults);
    }

    /**
     * Loads translations from the /lang/ directory
     * There aren't any translations yet, but the functionality is there
     */
    private function setup_translations() {
        add_action('plugins_loaded', function() {
            load_plugin_textdomain("wpapps", false, dirname(plugin_basename(__FILE__)) . "/lang/");
        });
    }

    /**
     * Include template files for the event|idea|app archive and single page views
     * Also adds a metabox to Appearance > Menus to display an archive link in the menu
     */
    private function setup_template() {
        require_once WPAPPS_PATH . '/lib/cpt-archive-menu/cpt-in-navmenu.php';

        add_filter('template_include', function($template_path) {
            $post_type = get_post_type();
            if (in_array($post_type, array('event', 'idea', 'app', 'submission'))) {
                $type = is_single() ? "single" : (is_archive() ? "archive" : false);
                if ($type) {
                    $tplfile = "$type-$post_type.php";
                    if ($theme_file = locate_template(array($tplfile))) {
                        $template_path = $theme_file;
                    } else {
                        $template_path = WPAPPS_PATH . '/tpls/' . $tplfile;
                    }
                }
            }
            return $template_path;
        }, 1);
    }

    /**
     * Adds a metabox to event|ideas|apps to link them together
     */
    private function setup_relationships()
    {
        // Only include P2P if it isn't being used by the site owner yet
        // Also check if git was properly cloned
		$p2p = WPAPPS_PATH . '/lib/posts-to-posts/posts-to-posts.php';

        register_activation_hook(__FILE__, function() use ($p2p) {
            if (!file_exists($p2p))
                $this->wpapps_error(__("Some files appear to be missing. Git has to be cloned recursively!", WPAPPS_TRANS));

            $pfile = WPAPPS_PATH . '/lib/posts-to-posts/core/side-post.php';
            if (!is_writable($pfile))
                $this->wpapp_error(sprintf(__("Can't write to %s which has to be patched. Apply patch manually or make the file writable.", WPAPPS_TRANS), $pfile));
            else
                file_put_contents($pfile, str_replace("->edit_posts", "->read", file_get_contents($pfile)));
        });

        if (!defined("P2P_TEXTDOMAIN"))
            require $p2p;

        add_action('p2p_init', function () {
            p2p_register_connection_type(array(
                'name' => 'events_to_ideas',
                'from' => 'event',
                'to' => 'idea',
                'can_create_post' => current_user_can("edit_others_ideas") // edit_events?
            ));

            p2p_register_connection_type(array(
                'name' => 'ideas_to_apps',
                'from' => 'idea',
                'to' => 'app',
                'can_create_post' => current_user_can("edit_apps")
            ));

            p2p_register_connection_type(array(
                'name' => 'apps_to_events',
                'from' => 'app',
                'to' => 'event',
                'can_create_post' => current_user_can("link_apps")
            ));
        });
    }

    /**
     * Sets up roles and capabilities
     * We have a special role (Submitter) that can do nothing except make submissions
     */
    private function setup_roles()
    {
        // WP3.5+ only
        // http://stackoverflow.com/a/16656057
        // http://wordpress.stackexchange.com/a/88397
        register_activation_hook(__FILE__, function () {
            add_role('wpapps_submitter', 'Submitter', array("read" => true));

            $allcaps = array();
            $roles = array(
                "subscriber" => array(),
                "contributor" => array(
                    'read_idea' => true,
                    'read_ideas' => true,
                    'edit_ideas' => true,
                    'delete_ideas' => true,
                    'edit_idea' => true,
                    'delete_idea' => true,
                    'edit_published_ideas' => true,
                    'delete_published_ideas' => true,

                    'read_app' => true,
                    'read_apps' => true, // magic
                    'edit_apps' => true,
                    'link_apps' => true,
                    'delete_apps' => true,
                    'edit_app' => true,
                    'delete_app' => true,
                    'edit_published_apps' => true,
                    'delete_published_apps' => true,

                    'read_event' => true,
                    'read_events' => true,
                ),
                "author" => array(),
                "wpapps_submitter" =>array(),
                "editor" => array(
                    'edit_others_ideas' => true,
                    'delete_private_ideas' => true,
                    'delete_others_ideas' => true,
                    'edit_private_ideas' => true,
                    'publish_ideas' => true,

                    'edit_others_apps' => true,
                    'delete_private_apps' => true,
                    'delete_others_apps' => true,
                    'edit_private_apps' => true,
                    'publish_apps' => true,

                    'edit_events' => true,
                    'delete_events' => true,
                    'edit_event' => true,
                    'delete_event' => true,
                    'edit_published_events' => true,
                    'delete_published_events' => true,
                    'edit_others_events' => true,
                    'delete_private_events' => true,
                    'delete_others_events' => true,
                    'edit_private_events' => true,
                    'publish_events' => true,
                ),
                "administrator" => array()
            );

            foreach($roles as $role => $caps) {
                $allcaps = array_merge($allcaps, $caps);

                foreach ($allcaps as $cap => $val) {
                    get_role($role)->add_cap($cap, $val);
                }
            }
        });

        register_deactivation_hook(__FILE__, function() {
            remove_role('wpapps_submitter');
        });

        // Dirty hack to work around the edit_posts capability (issue #16)
        // When we're on post-new.php, we manually reset the edit.php permissions
        // that way, edit.php won't show up in the menu, but we'll be able to access it with Submitter permissions
        add_filter('user_has_cap', function ($allcaps, $cap, $args) {
            global $_wp_menu_nopriv, $_wp_submenu_nopriv;
            //print_r(debug_backtrace());
            if (@$cap[0] == "edit_posts" && (@$allcaps["edit_ideas"] || @$allcaps["edit_apps"]))
                unset($_wp_menu_nopriv["edit.php"], $_wp_submenu_nopriv["edit.php"]);

            return $allcaps;
        }, 10, 3);
    }

    /**
     * Setup debugging
     */
    private function setup_debug() {
        if (WPAPPS_DEBUG) {
            restore_error_handler();
            error_reporting(E_ALL);
            ini_set('error_reporting', E_ALL);
            ini_set('html_errors',TRUE);
            ini_set('display_errors',TRUE);
        }
    }

    /**
     * Fail nicely
     */
    public function wpapps_error($err) {
        set_error_handler(function($a,$b) { die($b); });
        trigger_error($err, E_USER_ERROR);
        restore_error_handler();
    }

    /**
     * Stub to show evenlist using shortcode (for widgets)
     */
    private function setup_shortcodes()
    {
        add_shortcode('eventlist', function() { echo "returns nothing yet."; });
    }
}

new WPApps; // 300 lines!
