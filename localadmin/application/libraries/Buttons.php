<?php
/*
| ----------------------------------------------------------------------------------------
|  L o c a l A d m i n   C O N T R O L L E R
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

defined('BASEPATH') OR exit('No direct script access allowed');

class Buttons
{

    protected $CI;
    protected $shell_warning = FALSE;



    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library("user_agent");
        $this->CI->config->load("internal");
        $this->CI->config->load("settings");
    }

    function show_in_browser($button)
    {
        if (empty($button["url"])) {
            $link = $button["siteroot"];
        } else {
            $link = $button["url"];
        }
        if (!empty($button["dropdown"]) AND $button["dropdown"] === TRUE) {
            return "<a href='" . $link . "' target='_blank'>Open in new Tab</a>";
        } else {
            return "<a data-toggle='tooltip' data-title='Open in new Tab' href='" . $link . "' target='_blank' type='button' class='btn btn-default'><span class='glyphicon glyphicon-link' aria-hidden='true'></span></a>";
        }
    }

    function live_preview($button)
    {
        if (empty($button["url"])) {
            $link = $button["siteroot"];
        } else {
            $link = $button["url"];
        }
        if (!empty($button["dropdown"]) AND $button["dropdown"] === TRUE) {
            return "<a data-placement='bottom' data-toggle='popover' title='Live Preview' data-content='
                    <iframe src=\"" . $link . "\" class=\"iframe loading\" width=\"100%\" height=\"100%\"></iframe>'>Live Preview</a>";
        } else {
            return "<a data-title='Live Preview'  data-placement='bottom' type='button' class='btn btn-default livepreview' data-toggle='popover' title='Live Preview' data-content='
                    <iframe src=\"" . $link . "\" class=\"iframe loading\" width=\"100%\" height=\"100%\"></iframe>'><span class='glyphicon glyphicon-eye-open'></span></a>";
        }
    }

    function url($button)
    {
        if (!empty($button["dropdown"]) AND $button["dropdown"] === TRUE) {
            return "<a href='" . $button["url"] . "' type='button' target='" . $button["target"] . "'>" . $button["label"] . "</a>";
        } else {
            return "<a data-toggle='tooltip' data-title='" . $button["tooltip"] . "' href='" . $button["url"] . "' type='button' target='" . $button["target"] . "' class='btn btn-default'>" . $button["label"] . "</a>";
        }
    }

    function shell($button)
    {

        $uuid = uniqid();
        $session_data = [
            "script" => $button["script"],
        ];

        $_SESSION[$uuid] = $session_data;

        if ($this->CI->config->item("allow_shell_scripts", "general") === TRUE) {
            $this->shell_warning = FALSE;
            if (!empty($button["dropdown"]) AND $button["dropdown"] === TRUE) {
                return "<a data-placement='bottom' data-toggle='popover' title='Shell output' data-content='<div class=\"shelloutput\"></div>' data-title='" . $button["tooltip"] . "' href='#' type='button' class='btn btn-default shell' data-uuid='" . $uuid . "'>" . $button["label"] . "</a>";
            } else {
                return "<a data-placement='bottom' data-toggle='popover' title='Shell output' data-content='<div class=\"shelloutput\"></div>' data-title='" . $button["tooltip"] . "' href='#' type='button' class='btn btn-default shell livepreview'                             data-uuid='" . $uuid . "'>" . $button["label"] . "</a>";
            }
        } else {
            $this->shell_warning = TRUE;
            return;
        }
    }

    function url_scheme($button)
    {
        if (!empty($button["url"])) {
            $button["siteroot"] = $button["url"];
        }
        if (!empty($button["dropdown"]) AND $button["dropdown"] === TRUE) {
            return "<a href='localadmin://" . $button["script"] . "?siteroot=" . urlencode($button["siteroot"]) . "&agent_platform=" . urlencode($this->CI->agent->platform()) . "&agent_browser=" . urlencode($this->CI->agent->browser()) . "&path=" . urlencode($button["file"] . $button["add_to_path"] . $button["parameters"]) . "' target='_blank' class='localadmin'>" . $button["label"] . "</a>";
        } else {
            return "<a data-toggle='tooltip' data-title='" . $button["tooltip"] . "' href='localadmin://" . $button["script"] . "?siteroot=" . urlencode($button["siteroot"]) . "&agent_platform=" . urlencode($this->CI->agent->platform()) . "&agent_browser=" . urlencode($this->CI->agent->browser()) . "&path=" . urlencode($button["file"] . $button["add_to_path"] . $button["parameters"]) . "' target='_blank' type='button' class='btn btn-default localadmin'>" . $button["label"] . "</a>";
        }
    }

    function login($button)
    {
        if (!empty($button["url"])) {
            $button["siteroot"] = $button["url"];
        }
        if (!empty($button["dropdown"]) AND $button["dropdown"] === TRUE) {
            return "<a href='" . $button["siteroot"] . $button["path_to_login"] . "' target='_blank'>Login</a>";
        } else {
            return "<a data-toggle='tooltip' data-title='Login' href='" . $button["siteroot"] . $button["path_to_login"] . "' target='_blank' type='button' class='btn btn-default'><span class='glyphicon glyphicon-user' aria-hidden='true'></span></a>";
        }
    }

    function search($button)
    {
        if (!empty($button["dropdown"]) AND $button["dropdown"] === TRUE) {
            return "<a href='http://www.google.com/search?q=" . urlencode($button["search_for"]) . "'>" . $button["search_for"] . "</a>";
        } else {
            return "<a data-toggle='tooltip' data-title='Google search: " . $button["search_for"] . "' href='http://www.google.com/search?q=" . urlencode($button["search_for"]) . "' target='_blank' type='button' class='btn btn-default'><span class='glyphicon glyphicon-search' aria-hidden='true'></span></a>";
        }
    }

    function special($button)
    {
        return $button["item"];
    }

    function create_button_group($button_group, $project_data, $box_output)
    {
        $box_output .= "<div class='btn-group responsive-btn-group'>";
        foreach ($button_group["buttons"] as $button) {
            $button["file"] = $project_data["file"];
            $button["domain"] = $project_data["domain"];
            $button["siteroot"] = $project_data["siteroot"];
            $button["project"] = $project_data["project"];

            if (empty($button["target"])) {
                $button["target"] = "_blank";
            }
            if (empty($button["tooltip"])) {
                $button["tooltip"] = "";
            }

            if ((empty($button["platform"]) OR $button["platform"] === $this->CI->agent->platform()) AND (empty($button["browser"]) OR $button["browser"] === $this->CI->agent->browser())) {
                if ($button["type"] === "dropdown") {

                    $box_output .= "<div class='btn-group'><a href='#' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
                                      " . $button["name"] . "
                                      <span class='caret'></span>
                                    </a>
                                    <ul class='dropdown-menu'>";

                    foreach ($button["items"] AS $button) {
                        if ((empty($button["platform"]) OR $button["platform"] === $this->CI->agent->platform()) AND (empty($button["browser"]) OR $button["browser"] === $this->CI->agent->browser())) {
                            $button["dropdown"] = TRUE;
                            $button["file"] = $project_data["file"];
                            $button["domain"] = $project_data["domain"];
                            $button["siteroot"] = $project_data["siteroot"];
                            $button["project"] = $project_data["project"];
                            $method = $button["type"];
                            $box_output .= "<li><a href='#'>" . $this->$method ($button) . "</a></li>";
                        }
                    }
                    $box_output .= "</ul></div>";

                } else {
                    $method = $button["type"];
                    $box_output .= $this->$method ($button);
                }
            }
        }
        $box_output .= "</div>";
        return $box_output;
    }

    function create_head_data()
    {
        $output = array();

        if ($this->CI->config->item("show_splashscreen", "splashscreen") === TRUE) {
            $output["show_splashscreen"] = TRUE;
        } else {
            $output["show_splashscreen"] = FALSE;
        }
        if (!empty($this->CI->config->item("logo_path", "splashscreen"))) {
            $output["splashscreen_logo"] = "<img src='" . $this->CI->config->item("logo_path", "splashscreen") . "' alt='Logo' class='logo'>";
        } else {
            $output["splashscreen_logo"] = "";
        }
        if (!empty($this->CI->config->item("text", "splashscreen"))) {
            $output["splashscreen_text"] = "<h2>" . $this->CI->config->item("text", "splashscreen") . "</h2>";
        } else {
            $output["splashscreen_text"] = "";
        }

        if ($this->shell_warning === TRUE) {
            $output["shell_warning"] = TRUE;
        } else {
            $output["shell_warning"] = FALSE;
        }

        return $output;

    }

}