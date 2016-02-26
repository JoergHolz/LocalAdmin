<?php
/*
| ----------------------------------------------------------------------------------------
|  L o c a l A d m i n   S E T T I N G S
|
|  Documentation: https://github.com/JoergHolz/LocalAdmin
| ----------------------------------------------------------------------------------------
|  MIT License (MIT) Copyright (c) 2016 Joerg Holz | https://www.workflow-management.net
|
|  Permission is hereby granted, free of charge, to any person obtaining a copy
|  of this software and associated documentation files (the "Software"), to deal
|  in the Software without restriction, including without limitation the rights
|  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
|  copies of the Software, and to permit persons to whom the Software is
|  furnished to do so, subject to the following conditions:
|
|  The above copyright notice and this permission notice shall be included in all
|  copies or substantial portions of the Software.
|
|  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
|  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
|  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
|  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
|  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
|  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
|  SOFTWARE.
| ----------------------------------------------------------------------------------------
*/

/*
| -------------------------------------------------------------------
|  LocalAdmin Version:
| -------------------------------------------------------------------
*/

$config["internal"] = [
    "version" => "1.1"  // Don't change!
];

/*
| -------------------------------------------------------------------
|  General behavior of LocalAdmin:
| -------------------------------------------------------------------
*/

$config["general"] = [
    "tld" => "dev",
    "show_tooltips" => TRUE,
    "allow_shell_scripts" => FALSE,
    "button_groups_in_two_rows" => FALSE,
    "button_groups_in_two_rows_at" => 600
];


/*
| -------------------------------------------------------------------
|  Splashscreen
| -------------------------------------------------------------------
*/

$config["splashscreen"] = [
    "show_splashscreen" => TRUE,
    "logo_path" => "images/default/splashscreen_logo.png",
    "text" => "Loading"
];


/*
| -------------------------------------------------------------------
|  Top Navbar General Settings
| -------------------------------------------------------------------
 */

$config["navbar"]["general"] = [
    "title" => "LocalAdmin",
    "logo_path" => "images/default/navbar_logo.png",
    "show_local_ip" => TRUE,
    "show_public_ip" => TRUE
];


/*
| -------------------------------------------------------------------
|  Top Navbar Links
| -------------------------------------------------------------------
 */

$config["navbar"]["links"] = [
    0 => [
        "name" => "System Info",
        "url" => "?c=localadmin&m=systeminfo",
        "target" => "_self",
    ],
    1 => [
        "name" => "DuckDuckGo",
        "url" => "https://duckduckgo.com"
    ],
    2 => [
        "name" => "Developer",
        "dropdown" => [
            0 => [
                "name" => "LocalAdmin on Github",
                "url" => "https://github.com/JoergHolz/LocalAdmin"
            ],
            1 => [
                "name" => "LocalAdmin URL-Scheme-Launcher on Github",
                "url" => "https://github.com/JoergHolz/LocalAdmin-URL-Scheme-Launcher",
                "divider" => TRUE
            ],
            2 => [
                "name" => "Stackoverflow",
                "url" => "https://stackoverflow.com"
            ]
        ]
    ]
];

/*
| -------------------------------------------------------------------
|  All Projects
| -------------------------------------------------------------------
*/

$config["all_projects"] = [
    "hide_if_contains" => ""
];

/*
| -------------------------------------------------------------------
|  Project Group Settings
| -------------------------------------------------------------------
*/

$config["project_group"][0] = [
    "name" => "Projects",
    "directory" => "/absolute/path/to/webroot/",
    "matching_path" => "/",
    "has_subdomains" => FALSE,
    "columns" => 2,
    "icon" => "",
    "button_groups_in_two_rows" => TRUE,
    "hidden_sites" => [],
    "title_button_group" => [
        0 => [
            "type" => "show_path"
        ],
        1 => [
            "type" => "show_hidden_projects"
        ],
        2 => [
            "platform" => "Mac OS X",
            "browser" => "",
            "type" => "url_scheme",
            "script" => "show_in_finder.scpt",
            "add_to_path" => "",
            "label" => "Finder",
            "tooltip" => "Show in Finder",
            "parameters" => ""
        ]
    ],
    "local_button_group" => [
        "title" => "Local:",
        "buttons" => [
            0 => [
                "platform" => "",
                "browser" => "",
                "type" => "show_in_browser",
                "url" => ""
            ],
            1 => [
                "platform" => "",
                "browser" => "",
                "type" => "live_preview",
                "url" => ""
            ],
            2 => [
                "platform" => "Mac OS X",
                "browser" => "",
                "type" => "url_scheme",
                "script" => "show_in_finder.scpt",
                "add_to_path" => "",
                "label" => "Finder",
                "tooltip" => "Show in Finder",
                "parameters" => ""
            ],
            3 => [
                "platform" => "Mac OS X",
                "browser" => "",
                "type" => "url_scheme",
                "script" => "open_in_phpstorm.scpt",
                "add_to_path" => "",
                "label" => "PhpStorm",
                "tooltip" => "Open in PhpStorm",
                "parameters" => ""
            ],
            4 => [
                "platform" => "Mac OS X",
                "browser" => "",
                "type" => "url_scheme",
                "script" => "open_developer_tools_in_cur_browser.scpt",
                "add_to_path" => "",
                "label" => "DeveloperTools",
                "tooltip" => "Open DeveloperTools",
                "parameters" => ""
            ],
            5 => [
                "platform" => "Mac OS X",
                "browser" => "",
                "type" => "dropdown",
                "name" => "Browser",
                "items" => [
                    0 => [
                        "type" => "url_scheme",
                        "script" => "open_in_browser.scpt",
                        "add_to_path" => "",
                        "label" => "Safari",
                        "tooltip" => "Open in Safari",
                        "parameters" => "&browser=Safari"
                    ],
                    1 => [
                        "type" => "url_scheme",
                        "script" => "open_in_browser.scpt",
                        "add_to_path" => "",
                        "label" => "Google Chrome",
                        "tooltip" => "Google Chrome",
                        "parameters" => "&browser=Google Chrome"
                    ],
                    2 => [
                        "type" => "url_scheme",
                        "script" => "open_in_browser.scpt",
                        "add_to_path" => "",
                        "label" => "Firefox",
                        "tooltip" => "Open in Firefox",
                        "parameters" => "&browser=Firefox"
                    ],
                    3 => [
                        "type" => "url_scheme",
                        "script" => "open_in_browser.scpt",
                        "add_to_path" => "",
                        "label" => "Opera",
                        "tooltip" => "Open in Opera",
                        "parameters" => "&browser=Opera"
                    ]

                ]
            ]
        ]
    ],
    "remote_button_group" => [
        "title" => "Remote:",
        "buttons" => [
            0 => [
                "platform" => "",
                "browser" => "",
                "type" => "dropdown",
                "name" => "Searches",
                "items" => [
                    0 => [
                        "type" => "search",
                        "search_for" => "Bootstrap Button",
                    ],
                    1 => [
                        "type" => "search",
                        "search_for" => "htaccess password",
                    ]
                ]
            ]
        ]
    ]
];

/*
| -------------------------------------------------------------------
|  Settings for each Project
| -------------------------------------------------------------------
*/

$config["site_options"]["your_directory_name"] = [
    "name" => "My Project 1",
    "icon" => "",
    "button_groups_in_two_rows" => TRUE,
    "local_button_group" => [
        "buttons" => [
            0 => [
                "platform" => "",
                "browser" => "",
                "type" => "login",
                "path_to_login" => "/wp-login.php"
            ]
        ]
    ],
    "remote_button_group" => [
        "buttons" => [
            0 => [
                "platform" => "",
                "browser" => "",
                "type" => "show_in_browser",
                "url" => ""
            ],
            1 => [
                "platform" => "",
                "browser" => "",
                "type" => "login",
                "path_to_login" => "",
                "url" => ""
            ],
            2 => [
                "platform" => "",
                "browser" => "",
                "type" => "dropdown",
                "name" => "Browser",
                "items" => [
                    0 => [
                        "type" => "url_scheme",
                        "script" => "open_in_browser.scpt",
                        "add_to_path" => "",
                        "label" => "Safari",
                        "tooltip" => "Open in Safari",
                        "parameters" => "&browser=Safari",
                        "url" => "http://www.achimdunker.de"
                    ],
                    1 => [
                        "type" => "url_scheme",
                        "script" => "open_in_browser.scpt",
                        "add_to_path" => "",
                        "label" => "Chrome",
                        "tooltip" => "Open in Chrome",
                        "parameters" => "&browser=Chrome",
                        "url" => "http://www.achimdunker.de"
                    ],
                    2 => [
                        "type" => "url_scheme",
                        "script" => "open_in_browser.scpt",
                        "add_to_path" => "",
                        "label" => "Firefox",
                        "tooltip" => "Open in Firefox",
                        "parameters" => "&browser=Firefox",
                        "url" => "http://www.achimdunker.de"
                    ],
                    3 => [
                        "type" => "url_scheme",
                        "script" => "open_in_browser.scpt",
                        "add_to_path" => "",
                        "label" => "Opera",
                        "tooltip" => "Open in Opera",
                        "parameters" => "&browser=Opera",
                        "url" => "http://www.achimdunker.de"
                    ]
                ]
            ]
        ]
    ]
];

