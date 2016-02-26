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

class Navbar
{

    protected $CI;


    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library("user_agent");
        $this->CI->config->load("internal");
        $this->CI->config->load("settings");
    }

    function create_navbar_data()
    {
        $output = array();

        if (!empty($this->CI->config->item("general", "navbar")["logo_path"])) {
            $output["logo"] = "<img src='" . $this->CI->config->item("general", "navbar")["logo_path"] . "' class='logo pull-left'>";
        } else {
            $output["logo"] = "";
        }
        if (!empty($this->CI->config->item("general", "navbar")["title"])) {
            $output["title"] = $this->CI->config->item("general", "navbar")["title"];
        } else {
            $output["title"] = "";
        }
        if ($this->CI->config->item("general", "navbar")["show_local_ip"] === TRUE) {
            $output["local_ip"] = "<li><p>Local: " . getHostByName(getHostName()) . "</a></li>";
        } else {
            $output["local_ip"] = "";
        }
        if ($this->CI->config->item("general", "navbar")["show_public_ip"] === TRUE) {
            $output["public_ip"] = "<li><p>Public: <span id='public_ip'>tba.</span></p></li>";
        } else {
            $output["public_ip"] = "";
        }
        if (!empty($this->CI->config->item("links", "navbar"))) {
            $output["links"] = $this->CI->config->item("links", "navbar");
        } else {
            $output["links"] = "";
        }

        return $output;
    }
}