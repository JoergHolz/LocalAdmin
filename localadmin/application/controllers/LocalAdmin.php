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

   function __construct()
    {
        parent::__construct();
        $this->config->load("internal");
        $this->config->load("settings");
        $this->load->library("user_agent");
        $this->load->library("navbar");
        $this->load->library("buttons");
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
                $box_output = "<div class='row group " . $dirname . "' data-group='" . $dirname . "'>";
                foreach (glob($project_group["directory"] . "*") as $file) {
                    if ($i > ($columns - 1)) {
                        $i = 0;
                        $box_output .= "</div><div class='row group " . $dirname . "' data-group='" . $dirname . "'>";
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

                            $box_output = $this->buttons->create_button_group($button_group["local_button_group"], $project_data, $box_output);

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

                            $box_output = $this->buttons->create_button_group($button_group["remote_button_group"], $project_data, $box_output);
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
                                $output["content"] .= $this->buttons->url($button);
                            } elseif ($button["type"] === "shell") {
                                $output["content"] .= $this->buttons->shell($button);
                            } elseif ($button["type"] === "url_scheme") {
                                $output["content"] .= $this->buttons->url_scheme($button);
                            } elseif ($button["type"] === "special") {
                                $output["content"] .= $this->buttons->special($button);
                            }
                        }
                    }
                    $output["content"] .= "</div>";
                }

                $output["content"] .= "<a href='#' class='close-btn pull-right' data-project='" . $dirname . "' data-display='show'><span class='glyphicon glyphicon-remove close-sign'></span></a></div>";
                $output["content"] .= "</div>";

                $output["content"] .= $box_output;
                $output["content"] .= "</div></div>";
            }
        }
        $this->load->view("head", $this->buttons->create_head_data());
        $this->load->view("navbar", $this->navbar->create_navbar_data());

        $this->load->view("content", $output);
        $this->load->view("footer");

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
        $this->load->view("navbar", $this->navbar->create_navbar_data());
        $this->load->view("container", $output);
        $this->load->view("footer");
    }
}
