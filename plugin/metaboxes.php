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

class WPApps_Metaboxes {
    var $main;

    function __construct($main) {
        $this->main = $main;

        // Use nice custom meta boxes by HumanMade
        if (!defined('CMB_PATH'))
            require_once WPAPPS_PATH . "/lib/cmb/custom-meta-boxes.php";

//        add_action('add_meta_boxes', [$this, 'add_meta_box']);
//        add_action('post_updated', [$this, 'save']);

        add_filter('cmb_meta_boxes', [$this, 'add_event_metaboxes']);
        add_filter('cmb_meta_boxes', [$this, 'add_idea_metaboxes']);
        add_filter('cmb_meta_boxes', [$this, 'add_app_metaboxes']);
        add_filter('cmb_meta_boxes', [$this, 'add_submission_metaboxes']);
    }

    function add_event_metaboxes($meta_boxes) {
        $meta_boxes[] = [
            'title' => _x('Information', 'event-edit', WPAPPS_TRANS),
            'pages' => 'event',
            'fields' => [
                ['id' => 'logo', 'name' => __('Event Logo', WPAPPS_TRANS), 'type' => 'image'],
				['id' => 'abbreviated_title', 'name' => __('Abbreviated Title', WPAPPS_TRANS), 'type' => 'text'],
                ['id' => 'when_start', 'name' => __('Event Start', WPAPPS_TRANS), 'type' => 'datetime_unix'],
                ['id' => 'when_end', 'name' => __('Event End', WPAPPS_TRANS), 'type' => 'datetime_unix'],
                ['id' => 'location', 'name' => __('Event Location', WPAPPS_TRANS), 'type' => 'textarea'],
                //['id' => 'organizer', 'name' => __('Event Organizer', WPAPPS_TRANS), 'type' => 'textarea'],
                ['id' => 'edition', 'name' => __('Edition', WPAPPS_TRANS), 'type' => 'text'],
                ['id' => 'register_url', 'name' => __('Registration link', WPAPPS_TRANS), 'type' => 'text_url'],
                ['id' => 'datasets_url', 'name' => __('Datasets catalogue link', WPAPPS_TRANS), 'type' => 'text_url'],
                ['id' => 'theme', 'name' => __("Theme", WPAPPS_TRANS), 'type' => 'select', 'options' => [
                    '' => _x('Select theme', 'theme', WPAPPS_TRANS),
                    'Public administration & policy' => _x('Public administration & policy', 'theme', WPAPPS_TRANS),
                    'Population' => _x('Population', 'theme', WPAPPS_TRANS),
                    'Culture/Sport/Leisure time' => _x('Culture/Sport/Leisure time', 'theme', WPAPPS_TRANS),
                    'Territory' => _x('Territory', 'theme', WPAPPS_TRANS),
                    'Health' => _x('Health', 'theme', WPAPPS_TRANS),
                    'Infrastructure' => _x('Infrastructure', 'theme', WPAPPS_TRANS),
                    'Audience (Youth/Adult/Senior)' => _x('Audience (Youth/Adult/Senior)', 'theme', WPAPPS_TRANS),
                    'Environment' => _x('Environment & Nature', 'theme', WPAPPS_TRANS),
                    'Education & Lifelong learning' => _x('Education & Lifelong learning', 'theme', WPAPPS_TRANS),
                    'Tourism' => _x('Tourism', 'theme', WPAPPS_TRANS),
                    'Safety' => _x('Safety', 'theme', WPAPPS_TRANS),
                    'Welfare' => _x('Welfare', 'theme', WPAPPS_TRANS),
                    'Work & Economy' => _x('Work & Economy', 'theme', WPAPPS_TRANS),
                    'Life Home' => _x('Life/Home', 'theme', WPAPPS_TRANS)
                ]],
                
            ],
            'context' => 'side',
            'priority' => 'high'
        ];

        $meta_boxes[] = [
            'title' => _x('Contact Point', 'event-edit', WPAPPS_TRANS),
            'pages' => 'event',
            'fields' => [
                ['id' => 'event-contact-point', 'name' => __("Contact Point", WPAPPS_TRANS), 'type' => 'group', 'repeatable' => true, 'fields' => [
                    ['id' => 'contact-name', 'name' => __('Name', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] ,
                    ['id' => 'contact-surname', 'name' => __('Surname', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] ,
                    ['id' => 'contact-email', 'name' => __('E-mail', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] ,
                    ['id' => 'contact-phone', 'name' => __('Phone Number', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2],
                    ['id' => 'contact-fax', 'name' => __('Fax Number', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2]
                ]],
            ]
        ];


		$meta_boxes[] = [
            'title' => __('Organizer', WPAPPS_TRANS),
            'pages' => 'event',
            'fields' => [
                ['id' => 'organizer', 'name' => __("Organizer", WPAPPS_TRANS), 'type' => 'group', 'repeatable' => true, 'fields' => [
                    ['id' => 'logo', 'name' => __('Organizer Logo', WPAPPS_TRANS), 'type' => 'image'],
                    ['id' => 'organizer-name', 'name' => __('Organizer name', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2],
                    ['id' => 'organizer-website', 'name' => __('Organizer website', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2],
                    ['id' => 'organizer-coordinator', 'name' => __('Coordinator', WPAPPS_TRANS), 'type' => 'checkbox', 'cols' => 2]
                ]]
            ]
        ];
        $meta_boxes[] = [
            'title' => __('Jury', WPAPPS_TRANS),
            'pages' => 'event',
            'fields' => [
                ['id' => 'jury', 'name' => __("Jury", WPAPPS_TRANS), 'type' => 'group', 'repeatable' => true, 'fields' => [
                    ['id' => 'jury-name', 'name' => __('Name', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2],
                    ['id' => 'jury-members', 'name' => __("Jury members", WPAPPS_TRANS), 'type' => 'group', 'repeatable' => true, 'fields' => [
                        ['id' => 'agent-name', 'name' => __('Name', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2],
                        ['id' => 'agent-surname', 'name' => __('Surname', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2]
                    ]]
                ]]
            ]
        ];
        $meta_boxes[] = [
            'title' => __('Awards', WPAPPS_TRANS),
            'pages' => 'event',
            'fields' => [
                ['id' => 'award', 'name' => __("Award", WPAPPS_TRANS), 'type' => 'group', 'repeatable' => true, 'fields' => [
                    ['id' => 'award-prize', 'name' => __("Prize", WPAPPS_TRANS), 'type' => 'text', 'cols' => 2],
                    ['id' => 'award-sponsor-logo', 'name' => __('Award Sponsor Logo', WPAPPS_TRANS), 'type' => 'image', 'cols' => 2],
                    ['id' => 'award-sponsor-name', 'name' => __("Award Sponsor name", WPAPPS_TRANS), 'type' => 'text', 'cols' => 2],
                    ['id' => 'award-sponsor-website', 'name' => __("Award Sponsor website", WPAPPS_TRANS), 'type' => 'text', 'cols' => 2]
                ]]
            ]
        ];
        $meta_boxes[] = [
            'title' => __('Sponsors', WPAPPS_TRANS),
            'pages' => 'event',
            'fields' => [
                ['id' => 'sponsor', 'name' => __("Sponsor", WPAPPS_TRANS), 'type' => 'group', 'fields' => [
                    ['id' => 'sponsor-logo', 'name' => __('Sponsor Logo', WPAPPS_TRANS), 'type' => 'image', 'cols' => 2],
                    ['id' => 'sponsor-name', 'name' => __("Sponsor name", WPAPPS_TRANS), 'type' => 'text', 'cols' => 2],
                    ['id' => 'sponsor-website', 'name' => __("Sponsor website", WPAPPS_TRANS), 'type' => 'text', 'cols' => 2]
                ]]
            ]
        ];
        return $meta_boxes;
    }

    function add_idea_metaboxes($meta_boxes) {
        $meta_boxes[] = [
            'title' => _x('Information', 'idea-edit', WPAPPS_TRANS),
            'pages' => 'idea',
            'fields' => [
                ['id' => 'summary', 'name' => __("Keywords", WPAPPS_TRANS), 'type' => 'textarea'],
                ['id' => 'theme', 'name' => __("Theme", WPAPPS_TRANS), 'type' => 'select', 'options' => [
                    '' => _x('Select theme', 'theme', WPAPPS_TRANS),
                    'Public administration & policy' => _x('Public administration & policy', 'theme', WPAPPS_TRANS),
                    'Population' => _x('Population', 'theme', WPAPPS_TRANS),
                    'Culture/Sport/Leisure time' => _x('Culture/Sport/Leisure time', 'theme', WPAPPS_TRANS),
                    'Territory' => _x('Territory', 'theme', WPAPPS_TRANS),
                    'Health' => _x('Health', 'theme', WPAPPS_TRANS),
                    'Infrastructure' => _x('Infrastructure', 'theme', WPAPPS_TRANS),
                    'Audience (Youth/Adult/Senior)' => _x('Audience (Youth/Adult/Senior)', 'theme', WPAPPS_TRANS),
                    'Environment & Nature' => _x('Environment & Nature', 'theme', WPAPPS_TRANS),
                    'Education & Lifelong learning' => _x('Education & Lifelong learning', 'theme', WPAPPS_TRANS),
                    'Tourism' => _x('Tourism', 'theme', WPAPPS_TRANS),
                    'Safety' => _x('Safety', 'theme', WPAPPS_TRANS),
                    'Welfare' => _x('Welfare', 'theme', WPAPPS_TRANS),
                    'Economy' => _x('Work & Economy', 'theme', WPAPPS_TRANS),
                    'Lifehome' => _x('Life/Home', 'theme', WPAPPS_TRANS)
                ]],
                ['id' => 'homepage', 'name' => __("Homepage", WPAPPS_TRANS), 'type' => 'text_url'],
                ['id' => 'language', 'name' => __("Language", WPAPPS_TRANS), 'type' => 'text', 'desc' => __("The language used to describe the idea.<br />Eg. 'Dutch'", WPAPPS_TRANS)],
                ['id' => 'ori-deri', 'name' => _x("Original Vs Derivative Work", 'original-derivative', WPAPPS_TRANS), 'type' => 'select', 'options' => [
                    '' => _x('Other', 'original-derivative', WPAPPS_TRANS),
                    'Original Work' => _x('Original Work', 'original-derivative', WPAPPS_TRANS),
                    'Derivative Work' => _x('Derivative Work', 'original-derivative', WPAPPS_TRANS)
                ]],
            ],
            'context' => 'side',
            'priority' => 'high'
        ];

        $meta_boxes[] = [
            'title' => __('Conceivers', 'idea-edit', WPAPPS_TRANS),
            'pages' => 'idea',
            'fields' => [
                ['id' => 'conceivers', 'name' => __("Conceivers", WPAPPS_TRANS), 'type' => 'group', 'repeatable' => true, 'fields' => [
                    ['id' => 'conceiver-name', 'name' => __('Conceiver Name', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] ,
                    ['id' => 'conceiver-surname', 'name' => __('Conceiver Surname', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] ,
                    ['id' => 'conceiver-affiliation', 'name' => __('Conceiver affiliation', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] ,
                    ['id' => 'conceiver-email', 'name' => __('Conceiver e-mail', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] ,
                    ['id' => 'contact-point', 'name' => __('Contact Point', WPAPPS_TRANS), 'type' => 'checkbox', 'cols' => 2]
                ]
                ] 
                // ['id' => 'contact', 'name' => __('Contact', WPAPPS_TRANS), 'type' => 'text'] // should have email/phone number? -> make abstract
            ]
        ];

        $meta_boxes[] = [
            'title' => __("Datasets", 'idea-edit', WPAPPS_TRANS),
            'pages' => 'idea',
            'fields' => [
                ['id' => 'datasets', 'name' => __("Datasets", WPAPPS_TRANS), 'type' => 'group', 'repeatable' => true, 'fields' => [
                    ['id' => 'dataset-url', 'name' => __('Dataset URL', WPAPPS_TRANS), 'type' => 'text_url', 'cols' => 2] ,
                    ['id' => 'dataset-description', 'name' => __('Dataset description', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] 
                ]]
            ]
        ];
        /*
        $meta_boxes[] = [
            'title' => _x('People', 'idea-edit', WPAPPS_TRANS),
            'pages' => 'idea',
            'fields' => [
                ['id' => 'conceivers', 'name' => __('Conceivers', WPAPPS_TRANS), 'type' => 'text', 'repeatable' => true],
                ['id' => 'contact', 'name' => __('Contact', WPAPPS_TRANS), 'type' => 'text'] // should have email/phone number? -> make abstract
                // revisions (revises|revised|implements)
            ]
        ];
        */
        return $meta_boxes;
    }

    function add_app_metaboxes($meta_boxes) {
        $meta_boxes[] = [
            'title' => _x("Information", 'app-edit', WPAPPS_TRANS),
            'pages' => 'app',
            'fields' => [
                ['id' => 'keyword', 'name' => __("Keywords", WPAPPS_TRANS), 'type' => 'textarea'],
                ['id' => 'homepage', 'name' => __("Homepage", WPAPPS_TRANS), 'type' => 'text_url'],
                ['id' => 'download_url', 'name' => __("Download URL", WPAPPS_TRANS), 'type' => 'text_url'],
                ['id' => 'demo_url', 'name' => __("Demo", WPAPPS_TRANS), 'type' => 'text_url'],
                ['id' => 'license', 'name' => __("Theme", WPAPPS_TRANS), 'type' => 'select', 'options' => [
                    '' => _x('Select license', 'theme', WPAPPS_TRANS),
                    'Apache v2 License' => _x('Apache v2 License', 'theme', WPAPPS_TRANS),
                    'GPL v2' => _x('GPL v2', WPAPPS_TRANS),
                    'MIT License' => _x('MIT License', 'theme', WPAPPS_TRANS),
                    'Mozilla Public License Version 2.0' => _x('Mozilla Public License Version 2.0', 'theme', WPAPPS_TRANS),
                    'LGPL v2.1' => _x('LGPL v2.1', 'theme', WPAPPS_TRANS),
                    'BSD (3-Clause) License' => _x('BSD (3-Clause) License', 'theme', WPAPPS_TRANS),
                    'Artistic License 2.0e' => _x('Artistic License 2.0', 'theme', WPAPPS_TRANS),
                    'GPL v3' => _x('GPL v3', 'theme', WPAPPS_TRANS),
                    'LGPL v3' => _x('LGPL v3', 'theme', WPAPPS_TRANS),
                    'Affero GPL' => _x('Affero GPL', 'theme', WPAPPS_TRANS),
                    'Public Domain (Unlicense)' => _x('Public Domain (Unlicense)', WPAPPS_TRANS),
                    'No License' => _x('No License', 'theme', WPAPPS_TRANS),
                    'Eclipse Public License v1.0' => _x('Eclipse Public License v1.0', 'theme', WPAPPS_TRANS),
                    'BSD 2-Clause license' => _x('BSD 2-Clause license', 'theme', WPAPPS_TRANS)
                ]],
                ['id' => 'language', 'name' => __("Language", WPAPPS_TRANS), 'type' => 'text', 'desc' => __("The application's language.<br />Eg. 'English', 'Dutch'", WPAPPS_TRANS)],
                ['id' => 'ori-deri', 'name' => _x("Original Vs Derivative Work", 'original-derivative', WPAPPS_TRANS), 'type' => 'select', 'options' => [
                    '' => _x('Other', 'original-derivative', WPAPPS_TRANS),
                    'Original Work' => _x('Original Work', 'original-derivative', WPAPPS_TRANS),
                    'Derivative Work' => _x('Derivative Work', 'original-derivative', WPAPPS_TRANS)
                ]],
            ],
            'context' => 'side',
            'priority' => 'high'
        ];
        $meta_boxes[] = [
            'title' => __("Credits", WPAPPS_TRANS),
            'pages' => 'app',
            'fields' => [
                ['id' => 'creators', 'name' => __("Creators", WPAPPS_TRANS), 'type' => 'group', 'repeatable' => true, 'fields' => [
                    ['id' => 'creator-name', 'name' => __('Creator Name', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] ,
                    ['id' => 'creator-surname', 'name' => __('Creator Surname', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] ,
                    ['id' => 'creator-affiliation', 'name' => __('Creator affiliation', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] ,
                    ['id' => 'creator-email', 'name' => __('Creator e-mail', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] ,
                    ['id' => 'contact-point', 'name' => __('Contact Point', WPAPPS_TRANS), 'type' => 'checkbox', 'cols' => 2]
                ]]
            ]
        ];
        $meta_boxes[] = [
            'title' => __("Datasets", WPAPPS_TRANS),
            'pages' => 'app',
            'fields' => [
                ['id' => 'datasets', 'name' => __("Datasets", WPAPPS_TRANS), 'type' => 'group', 'repeatable' => true, 'fields' => [
                    ['id' => 'dataset-url', 'name' => __('Dataset URL', WPAPPS_TRANS), 'type' => 'text_url', 'cols' => 2] ,
                    ['id' => 'dataset-description', 'name' => __('Dataset description', WPAPPS_TRANS), 'type' => 'text', 'cols' => 2] 
                ]]
            ]
        ];
        $meta_boxes[] = [
            'title' => _x("Platform & Tools", 'app-platform-metabox', WPAPPS_TRANS),
            'pages' => 'app',
            'fields' => [
                ['id' => 'platform-title', 'name' => _x("Platform", 'app-platform-title', WPAPPS_TRANS), 'type' => 'select', 'options' => [
                    '' => _x('Other', 'app-platform', WPAPPS_TRANS),
                    'desktop' => _x('Desktop', 'app-platform', WPAPPS_TRANS),
                    'mobile' => _x('Mobile', 'app-platform', WPAPPS_TRANS)
                ]],
                ['id' => 'platform-system', 'name' => _x("System", "app-platform", WPAPPS_TRANS), 'type' => 'text', 'desc' => __('Eg. Windows XP', WPAPPS_TRANS)],
                ['id' => 'tools', 'name' => __('Tools', WPAPPS_TRANS), 'type' => 'text', 'repeatable' => true],
                ['id' => 'softwareVersion', 'name' => __('software Version', WPAPPS_TRANS), 'type' => 'text'],
                ['id' => 'programmingLanguage', 'name' => __('Programming Language', WPAPPS_TRANS), 'type' => 'text'],
                ['id' => 'requirements', 'name' => __('Requirements', WPAPPS_TRANS), 'type' => 'textarea']
            ]
        ];
        return $meta_boxes;
    }  

    function add_submission_metaboxes($meta_boxes) {
        $meta_boxes[] = [
            'title' => _x("Information", 'app-edit', WPAPPS_TRANS),
            'pages' => 'app',
            'fields' => [
                ['id' => 'keyword', 'name' => __("Keywords", WPAPPS_TRANS), 'type' => 'textarea'],
                ['id' => 'homepage', 'name' => __("Homepage", WPAPPS_TRANS), 'type' => 'text_url'],
                ['id' => 'download_url', 'name' => __("Download URL", WPAPPS_TRANS), 'type' => 'text_url'],
                ['id' => 'license', 'name' => __("Theme", WPAPPS_TRANS), 'type' => 'select', 'options' => [
                    '' => _x('Select license', 'theme', WPAPPS_TRANS),
                    'Apache v2 License' => _x('Apache v2 License', 'theme', WPAPPS_TRANS),
                    'GPL v2' => _x('GPL v2', WPAPPS_TRANS),
                    'MIT License' => _x('MIT License', 'theme', WPAPPS_TRANS),
                    'Mozilla Public License Version 2.0' => _x('Mozilla Public License Version 2.0', 'theme', WPAPPS_TRANS),
                    'LGPL v2.1' => _x('LGPL v2.1', 'theme', WPAPPS_TRANS),
                    'BSD (3-Clause) License' => _x('BSD (3-Clause) License', 'theme', WPAPPS_TRANS),
                    'Artistic License 2.0e' => _x('Artistic License 2.0', 'theme', WPAPPS_TRANS),
                    'GPL v3' => _x('GPL v3', 'theme', WPAPPS_TRANS),
                    'LGPL v3' => _x('LGPL v3', 'theme', WPAPPS_TRANS),
                    'Affero GPL' => _x('Affero GPL', 'theme', WPAPPS_TRANS),
                    'Public Domain (Unlicense)' => _x('Public Domain (Unlicense)', WPAPPS_TRANS),
                    'No License' => _x('No License', 'theme', WPAPPS_TRANS),
                    'Eclipse Public License v1.0' => _x('Eclipse Public License v1.0', 'theme', WPAPPS_TRANS),
                    'BSD 2-Clause license' => _x('BSD 2-Clause license', 'theme', WPAPPS_TRANS)
                ]],
                ['id' => 'language', 'name' => __("Language", WPAPPS_TRANS), 'type' => 'text', 'desc' => __("The application's language.<br />Eg. 'English', 'Dutch'", WPAPPS_TRANS)],
                ['id' => 'ori-deri', 'name' => _x("Original Vs Derivative Work", 'original-derivative', WPAPPS_TRANS), 'type' => 'select', 'options' => [
                    '' => _x('Other', 'original-derivative', WPAPPS_TRANS),
                    'Original Work' => _x('Original Work', 'original-derivative', WPAPPS_TRANS),
                    'Derivative Work' => _x('Derivative Work', 'original-derivative', WPAPPS_TRANS)
                ]],
            ],
            'context' => 'side',
            'priority' => 'high'
        ];
        
        return $meta_boxes;
    }
}
