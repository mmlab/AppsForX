<?php

/*
 * Author: Cedric Van Bockhaven
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
*/

class WPApps_Posttypes {
    var $main;

    function __construct($main) {
        $this->main = $main;

        add_action('init', array($this, "register_event"));
        add_action('init', array($this, "register_idea"));
        add_action('init', array($this, "register_app"));
        add_action('init', array($this, "register_submission"));

        add_action("manage_event_posts_custom_column", array($this, 'custom_event_column'), 10, 2);
        add_filter('manage_event_posts_columns' , array($this, 'custom_event_columns'));
    }

    ### Events

    function register_event() {
        register_post_type("event", array(
            'labels' => array(
                'name' => __('Events', WPAPPS_TRANS),
                'singular_name' => __('Event', WPAPPS_TRANS),
                'add_new' => __('Add New', WPAPPS_TRANS),
                'add_new_item' => __('Add New Event', WPAPPS_TRANS),
                'edit_item' => __('Edit Event', WPAPPS_TRANS),
                'new_item' => __('New Event', WPAPPS_TRANS),
                'all_items' => __('Events', WPAPPS_TRANS),
                'view_item' => __('View Event', WPAPPS_TRANS),
                'search_items' => __('Search Events', WPAPPS_TRANS),
                'not_found' =>  __('No events found', WPAPPS_TRANS),
                'not_found_in_trash' => __('No events found in Trash', WPAPPS_TRANS),
                'parent_item_colon' => '',
                'menu_name' => __('Events', WPAPPS_TRANS)
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'event' ),
            'capability_type' => 'event',
            'has_archive' => true,
            'hierarchical' => false,
            'supports' => array( 'title', 'editor', 'comments' ),
            'map_meta_cap' => true,
            'capabilities' => array('read' => 'read_events')
        ));
    }

    // set browsable event fields, handle display
    function custom_event_columns($columns) {
        unset($columns["date"]);
        $columns['when'] = "When";
        return $columns;
    }

    function custom_event_column($column, $post_id) {
        switch ($column) {
            case "when":
                echo date('d M Y - H:i', get_post_meta($post_id, 'when_start', true));
                break;
        }
    }

    ### Apps(+Concepts)

    function register_idea() {
        register_post_type("idea", array(
            'labels' => array(
                'name' => __('Ideas', WPAPPS_TRANS),
                'singular_name' => __('Idea', WPAPPS_TRANS),
                'add_new' => __('Add New', WPAPPS_TRANS),
                'add_new_item' => __('Add New Idea', WPAPPS_TRANS),
                'edit_item' => __('Edit Idea', WPAPPS_TRANS),
                'new_item' => __('New Idea', WPAPPS_TRANS),
                'all_items' => __('Ideas', WPAPPS_TRANS),
                'view_item' => __('View Idea', WPAPPS_TRANS),
                'search_items' => __('Search Ideas', WPAPPS_TRANS),
                'not_found' =>  __('No ideas found', WPAPPS_TRANS),
                'not_found_in_trash' => __('No ideas found in Trash', WPAPPS_TRANS),
                'parent_item_colon' => '',
                'menu_name' => __('Ideas', WPAPPS_TRANS)
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'idea' ),
            'capability_type' => 'idea',
            'has_archive' => true,
            'hierarchical' => false,
            'supports' => array( 'title', 'editor', 'comments' ),
            'map_meta_cap' => true,
            'capabilities' => array('read' => 'read_events')
        ));
    }

    function register_app() {
        register_post_type("app", array(
            'labels' => array(
                'name' => __('Apps', WPAPPS_TRANS),
                'singular_name' => __('App', WPAPPS_TRANS),
                'add_new' => __('Add New', WPAPPS_TRANS),
                'add_new_item' => __('Add New App', WPAPPS_TRANS),
                'edit_item' => __('Edit App', WPAPPS_TRANS),
                'new_item' => __('New App', WPAPPS_TRANS),
                'all_items' => __('Apps', WPAPPS_TRANS),
                'view_item' => __('View App', WPAPPS_TRANS),
                'search_items' => __('Search Apps', WPAPPS_TRANS),
                'not_found' =>  __('No apps found', WPAPPS_TRANS),
                'not_found_in_trash' => __('No apps found in Trash', WPAPPS_TRANS),
                'parent_item_colon' => '',
                'menu_name' => __('Apps', WPAPPS_TRANS)
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'app' ),
            'capability_type' => 'app',
            'has_archive' => true,
            'hierarchical' => false,
            'supports' => array( 'title', 'editor', 'comments' ),
            'map_meta_cap' => true,
            'capabilities' => array('read' => 'read_events' /*NOT read_event*/)
        ));
    }

    function register_submission() {
        register_post_type("submission", array(
            'labels' => array(
                'name' => __('Submissions', WPAPPS_TRANS),
                'singular_name' => __('Submission', WPAPPS_TRANS),
                'add_new' => __('Add New', WPAPPS_TRANS),
                'add_new_item' => __('Add New submission', WPAPPS_TRANS),
                'edit_item' => __('Edit submission', WPAPPS_TRANS),
                'new_item' => __('New submission', WPAPPS_TRANS),
                'all_items' => __('Submissions', WPAPPS_TRANS),
                'view_item' => __('View submission', WPAPPS_TRANS),
                'search_items' => __('Search Submissions', WPAPPS_TRANS),
                'not_found' =>  __('No submissions found', WPAPPS_TRANS),
                'not_found_in_trash' => __('No submissions found in Trash', WPAPPS_TRANS),
                'parent_item_colon' => '',
                'menu_name' => __('Submissions', WPAPPS_TRANS)
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'submission' ),
            'capability_type' => 'submission',
            'has_archive' => true,
            'hierarchical' => false,
            'supports' => array( 'title', 'editor', 'comments' ),
            'map_meta_cap' => true,
            'capabilities' => array('read' => 'read_events' /*NOT read_event*/)
        ));
    }

}