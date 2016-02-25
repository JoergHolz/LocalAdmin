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

class LocalAdmin extends CI_Controller
{

    var $shell_warning = FALSE;

    function __construct()
    {
        parent::__construct();
        $this->config->load("settings");
        $this->load->library('user_agent');
        session_start();
    }

    function index()
    {

        $output = array();
        $output["content"] = "";

        foreach ($this->config->item("project_group") AS $group_number => $project_group) {

            if (!file_exists($project_group["directory"])) {
                $output["content"] = "<div class='container error-container'>
                                            <div class='row'>
                                                <div class='col-lg-3'></div><div class='col-lg-6 alert alert-danger'>
                                                    <h4>Error</h4>
                                                    <p>The directory in your project group setting does not exist:</p><br><strong>" . $project_group["directory"] . "</strong>
                                       </div></div></div>";
            } else {

                $dirsplit = explode('/', $project_group["directory"]);
                $dirname = $dirsplit[count($dirsplit) - 2];

                if (empty($project_group["matching_path"])) {
                    $project_group["matching_path"] = "/";
                }

                if (empty($project_group["columns"]) OR $project_group["columns"] < 1 OR $project_group["columns"] > 4) {
                    $columns = 3;
                } else {
                    $columns = $project_group["columns"];
                }

                $visible_projects = 0;
                $all_projects = 0;
                $hidden_projects = array();
                $i = 0;
                $box_output = "<div class='row'>";
                foreach (glob($project_group["directory"] . "*") as $file) {
                    if ($i > ($columns - 1)) {
                        $i = 0;
                        $box_output .= "</div><div class='row'>";
                    }
                    $all_projects++;
                    $project = basename($file);
                    if ((empty($project_group["hidden_sites"]) OR !in_array($project, $project_group["hidden_sites"])) AND file_exists($file . $project_group["matching_path"]) AND (empty($this->config->item("hide_if_contains", "all_projects")) OR !preg_match("/" . $this->config->item("hide_if_contains", "all_projects") . "/", $project))) {
                        $visible_projects++;
                        $i++;

                        if (array_key_exists("has_subdomains", $project_group) AND $project_group["has_subdomains"] === TRUE) {
                            $domain = sprintf('%1$s.%2$s', $project, $dirname);
                            $siteroot = sprintf('http://%1$s.%2$s.%3$s', $project, $dirname, $this->config->item("tld", "general"));
                        } else {
                            $domain = sprintf('%1$s', $project);
                            $siteroot = sprintf('http://%1$s.%2$s', $project, $this->config->item("tld", "general"));
                        }

                       $icon = "";
                        if (!empty($this->config->item("site_options")[$domain]["icon"])) {
                            $icon = "<img src='" . $this->config->item("site_options")[$domain]["icon"] . "' class='icon pull-left'>";
                        } elseif (file_exists($file . $project_group["matching_path"] . "favicon.ico")) {
                            $icon = "<img src='" . $siteroot . "/favicon.ico' class='icon pull-left'>";
                        } elseif (!empty($project_group["icon"])) {
                            $icon = "<img src='" . $project_group["icon"] . "' class='icon pull-left'>";
                        }

                        if (!empty($this->config->item("site_options")[$domain]["name"])) {
                            $title = $this->config->item("site_options")[$domain]["name"];
                        } else {
                            $title = $project;
                        }

                        $box_output .= "<div class='col-lg-" . (12 / $columns) . "'>
                                            <div class='panel panel-default'>
                                                <div class='panel-heading'>
                                                    " . $icon . "<h3 class='panel-title pull-left'>" . $title . "</h3>
                                                    <a  data-placement='left' style=\"white-space: nowrap;\" class='pull-right' data-toggle='popover' title='' data-content='<small><strong>URL: </strong></small>"
                            . $siteroot . "<br/><small><strong>Path: </strong></small>" . $file . "'>
                                                    <span class='glyphicon glyphicon-info-sign'></span></a>
                                                </div>
                                                <div class='panel-body'>";

                        $project_data = array();
                        $project_data["file"] = $file;
                        $project_data["domain"] = $domain;
                        $project_data["siteroot"] = $siteroot;
                        $project_data["project"] = $project;

                        $button_group = $project_group;

                        if (!empty($button_group["local_button_group"])) {
                            if (!empty($this->config->item("site_options")[$domain]["local_button_group"]["buttons"])) {
                                $button_group["local_button_group"]["buttons"] = array_merge(array_values($button_group["local_button_group"]["buttons"]), array_values($this->config->item("site_options")[$domain]["local_button_group"]["buttons"]));
                            }

                            if ((!empty($this->config->item("site_options")[$domain]["button_groups_in_two_rows"]) AND $this->config->item("site_options")[$domain]["button_groups_in_two_rows"] === TRUE) OR $this->config->item("general")
                                ["button_groups_in_two_rows"] === TRUE OR (!empty($button_group["button_groups_in_two_rows"]) AND $button_group["button_groups_in_two_rows"] === TRUE)
                            ) {
                                $box_output .= "<div class='local'>";
                            } else {
                                $box_output .= "<div class='local pull-left'>";
                            }
                            if (!empty($button_group["local_button_group"]["title"]) AND !empty($button_group["local_button_group"]["buttons"])) {
                                $box_output .= "<p class='btn-desc'><small>" . $button_group["local_button_group"]["title"] . "</small></p>";
                            }

                            $box_output = $this->_create_button_group($button_group["local_button_group"], $project_data, $box_output);

                            $box_output .= "</div>";
                        }
                        if (!empty($button_group["remote_button_group"])) {
                            if (!empty($this->config->item("site_options")[$domain]["remote_button_group"]["buttons"])) {
                                $button_group["remote_button_group"]["buttons"] = array_merge(array_values($button_group["remote_button_group"]["buttons"]), array_values($this->config->item("site_options")[$domain]["remote_button_group"]["buttons"]));
                            }
                            if ((!empty($this->config->item("site_options")[$domain]["button_groups_in_two_rows"]) AND $this->config->item("site_options")[$domain]["button_groups_in_two_rows"] === TRUE) OR $this->config->item("general")                                                        ["button_groups_in_two_rows"] === TRUE OR (!empty($button_group["button_groups_in_two_rows"]) AND $button_group["button_groups_in_two_rows"] === TRUE)) {
                                $box_output .= "<div class='remote no-right'>";
                            } else {
                                $box_output .= "<div class='remote pull-right'>";
                            }
                            if (!empty($button_group["remote_button_group"]["title"]) AND !empty($button_group["remote_button_group"]["buttons"])) {
                                $box_output .= "<p class='btn-desc'><small>" . $button_group["remote_button_group"]["title"] . "</small></p>";
                            }

                            $box_output = $this->_create_button_group($button_group["remote_button_group"], $project_data, $box_output);
                            $box_output .= "</div>";
                        }

                        $box_output .= "</div></div></div>";
                    } else {
                        array_push($hidden_projects, $project);
                    }
                }

                if (empty($project_group["name"])) {
                    $title = "/";
                } else {
                    $title = $project_group["name"];
                }
                $output["content"] .= "<div class='container'>
                                            <div class='row'>
                                                <div class='col-lg-12'>
                                                    <h2 class='pull-left text-overflow group-title'>" . $title . "</h2>";

                if (!empty($project_group["title_button_group"])) {
                    $output["content"] .= "<div class='btn-group dir'>";

                    foreach ($project_group["title_button_group"] AS $button) {
                        $button["file"] = $project_group["directory"];
                        $button["project"] = $project_data["project"];

                        $button["domain"] = $project_data["domain"];
                        $button["siteroot"] = $project_data["siteroot"];


                        if ((empty($button["platform"]) OR $button["platform"] === $this->agent->platform()) AND (empty($button["browser"]) OR $button["browser"] === $this->agent->browser())) {
                            if ($button["type"] === "show_path") {
                                $output["content"] .= "<a  data-placement='bottom' type='button' class='btn btn-default pull-rightx' data-toggle='popover' title='' data-content='
                                                <small><strong>Path: </strong></small>" . $project_group["directory"] . "<br>" .
                                    "<small><strong>Number of Projects: </strong></small>" . $all_projects . "<br>" .
                                    "<small><strong>Visible Projects: </strong></small>" . $visible_projects . "<br>" .
                                    "'><span class='glyphicon glyphicon-info-sign'></span></a>";
                            } elseif ($button["type"] === "show_hidden_projects" AND $all_projects > $visible_projects) {
                                $output["content"] .= "<div class='btn-group'><a href='#' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
                                      Hidden Projects
                                      <span class='caret'></span>
                                    </a>
                                    <ul class='dropdown-menu'>";

                                foreach ($hidden_projects AS $hidden) {
                                    $output["content"] .= "<li><a href='#'>" . $hidden . "</a></li>";
                                }
                                $output["content"] .= "</ul></div>";
                            } elseif ($button["type"] === "url") {
                                $output["content"] .= $this->_url($button);
                            } elseif ($button["type"] === "shell") {
                                $output["content"] .= $this->_shell($button);
                            } elseif ($button["type"] === "url_scheme") {
                                $output["content"] .= $this->_url_scheme($button);
                            } elseif ($button["type"] === "special") {
                                $output["content"] .= $this->_special($button);
                            }
                        }
                    }
                    $output["content"] .= "</div>";
                }
                $output["content"] .= "</div></div>";

                $output["content"] .= $box_output;
                $output["content"] .= "</div></div>";
            }
        }
        $this->load->view("head", $this->_create_head_data());
        $this->load->view("navbar", $this->_create_navbar_data());

        $this->load->view("content", $output);
        $this->load->view("footer");

    }

    function _show_in_browser($button)
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

    function _live_preview($button)
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

    function _url($button)
    {
        if (!empty($button["dropdown"]) AND $button["dropdown"] === TRUE) {
            return "<a href='" . $button["url"] . "' type='button' target='" . $button["target"] . "'>" . $button["label"] . "</a>";
        } else {
            return "<a data-toggle='tooltip' data-title='" . $button["tooltip"] . "' href='" . $button["url"] . "' type='button' target='" . $button["target"] . "' class='btn btn-default'>" . $button["label"] . "</a>";
        }
    }

    function _shell($button)
    {

        $uuid = uniqid();
        $session_data = [
            "script" => $button["script"],
        ];

        $_SESSION[$uuid] = $session_data;

        if ($this->config->item("allow_shell_scripts", "general") === TRUE) {
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

    function _url_scheme($button)
    {
        if (!empty($button["url"])) {
            $button["siteroot"] = $button["url"];
        }
        if (!empty($button["dropdown"]) AND $button["dropdown"] === TRUE) {
            return "<a href='localadmin://" . $button["script"] . "?siteroot=" . urlencode($button["siteroot"]) . "&agent_platform=" . urlencode($this->agent->platform()) . "&agent_browser=" . urlencode($this->agent->browser()) . "&path=" . urlencode($button["file"] . $button["add_to_path"] . $button["parameters"]) . "' target='_blank' class='localadmin'>" . $button["label"] . "</a>";
        } else {
            return "<a data-toggle='tooltip' data-title='" . $button["tooltip"] . "' href='localadmin://" . $button["script"] . "?siteroot=" . urlencode($button["siteroot"]) . "&agent_platform=" . urlencode($this->agent->platform()) . "&agent_browser=" . urlencode($this->agent->browser()) . "&path=" . urlencode($button["file"] . $button["add_to_path"] . $button["parameters"]) . "' target='_blank' type='button' class='btn btn-default localadmin'>" . $button["label"] . "</a>";
        }
    }

    function _login($button)
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

    function _search($button)
    {
        if (!empty($button["dropdown"]) AND $button["dropdown"] === TRUE) {
            return "<a href='http://www.google.com/search?q=" . urlencode($button["search_for"]) . "'>" . $button["search_for"] . "</a>";
        } else {
            return "<a data-toggle='tooltip' data-title='Google search: " . $button["search_for"] . "' href='http://www.google.com/search?q=" . urlencode($button["search_for"]) . "' target='_blank' type='button' class='btn btn-default'><span class='glyphicon glyphicon-search' aria-hidden='true'></span></a>";
        }
    }

    function _special($button)
    {
        return $button["item"];
    }

    function _create_button_group($button_group, $project_data, $box_output)
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

            if ((empty($button["platform"]) OR $button["platform"] === $this->agent->platform()) AND (empty($button["browser"]) OR $button["browser"] === $this->agent->browser())) {
                if ($button["type"] === "dropdown") {

                    $box_output .= "<div class='btn-group'><a href='#' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
                                      " . $button["name"] . "
                                      <span class='caret'></span>
                                    </a>
                                    <ul class='dropdown-menu'>";

                    foreach ($button["items"] AS $button) {
                        if ((empty($button["platform"]) OR $button["platform"] === $this->agent->platform()) AND (empty($button["browser"]) OR $button["browser"] === $this->agent->browser())) {
                            $button["dropdown"] = TRUE;
                            $button["file"] = $project_data["file"];
                            $button["domain"] = $project_data["domain"];
                            $button["siteroot"] = $project_data["siteroot"];
                            $button["project"] = $project_data["project"];
                            $method = "_" . $button["type"];
                            $box_output .= "<li><a href='#'>" . $this->$method ($button) . "</a></li>";
                        }
                    }
                    $box_output .= "</ul></div>";

                } else {
                    $method = "_" . $button["type"];
                    $box_output .= $this->$method ($button);
                }
            }
        }
        $box_output .= "</div>";
        return $box_output;
    }

    function _create_head_data()
    {
        $output = array();

        if ($this->config->item("show_splashscreen", "splashscreen") === TRUE) {
            $output["show_splashscreen"] = TRUE;
        } else {
            $output["show_splashscreen"] = FALSE;
        }
        if (!empty($this->config->item("logo_path", "splashscreen"))) {
            $output["splashscreen_logo"] = "<img src='" . $this->config->item("logo_path", "splashscreen") . "' alt='Logo' class='logo'>";
        } else {
            $output["splashscreen_logo"] = "";
        }
        if (!empty($this->config->item("text", "splashscreen"))) {
            $output["splashscreen_text"] = "<h2>" . $this->config->item("text", "splashscreen") . "</h2>";
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

    function _create_navbar_data()
    {
        $output = array();

        if (!empty($this->config->item("general", "navbar")["logo_path"])) {
            $output["logo"] = "<img src='" . $this->config->item("general", "navbar")["logo_path"] . "' class='logo pull-left'>";
        } else {
            $output["logo"] = "";
        }
        if (!empty($this->config->item("general", "navbar")["title"])) {
            $output["title"] = $this->config->item("general", "navbar")["title"];
        } else {
            $output["title"] = "";
        }

        if ($this->config->item("general", "navbar")["show_local_ip"] === TRUE) {
            $output["local_ip"] = "<li><p>Local: " . getHostByName(getHostName()) . "</a></li>";
        } else {
            $output["local_ip"] = "";
        }
        if ($this->config->item("general", "navbar")["show_public_ip"] === TRUE) {
            $output["public_ip"] = "<li><p>Public: <span id='public_ip'>tba.</span></p></li>";
        } else {
            $output["public_ip"] = "";
        }

        if (!empty($this->config->item("links", "navbar"))) {
            $output["links"] = $this->config->item("links", "navbar");
        } else {
            $output["links"] = "";
        }

        return $output;

    }

    function exec_shell()
    {

        if ($this->config->item("allow_shell_scripts", "general") === TRUE) {
            $uuid = $this->input->get("uuid", TRUE);


            echo exec($_SESSION[$uuid]["script"]);
        }

    }

    function systeminfo()
    {

        $output = array();
        $output["content"] = "<div class='systeminfo'><p>LocalAdmin: " . $this->config->item("version", "internal") . "</p>";
        $output["content"] .= "<p>Codeigniter: " . CI_VERSION . "</p>";
        $output["content"] .= "<p>PHP: " . phpversion() . "</p></div>";

        $output["title"] = "System Info";

        $this->load->view("head");
        $this->load->view("navbar", $this->_create_navbar_data());
        $this->load->view("container", $output);
        $this->load->view("footer");
    }
}
