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


defined('BASEPATH') OR exit('No direct script access allowed');

class Systeminfo extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->config->load("internal");
        $this->load->library("navbar");
    }

    function index()
    {
        $this->systeminfo();
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
