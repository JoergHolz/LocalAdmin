#LocalAdmin

####A fully customizable admin tool for web based projects, Cordova apps and automation tasks####

Open your project in different browsers, open developer tools, jump to the projects directory, open the project in your IDE/SDK, have a live preview, call external scripts, have predefined searches, … or create your own buttons and tasks.

LocalAdmin works in all modern browsers.

---
![LocalAdmin dialog](doc_images/localadmin.png) 

---
##Table of Contents

[1. Requirements](#1-requirements)   
[2. Get started](#2-get-started)   
[3. How it works](#3-how-it-works)   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[3.1 Practical Example](#31-practical-example)   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[3.2 Advanced Example](#32-advanced-example)   
[4. Settings](#4-settings)   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[4.1 General Behavior of LocalAdmin](#41-general-behavior-of-localadmin)  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[4.2 Splashscreen](#42-splashscreen)  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[4.3 Top Navigation](#43-top-navigation)  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[4.3.1 Top Navbar General Settings](#431-top-navbar-general-settings)  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[4.3.2 Top Navbar Links](#432-top-navbar-links)  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[4.4 All Projects](#44-all-projects)  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[4.5 Project Groups](#45-project-groups)   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[4.6 Settings for each Project](#46-settings-for-each-project)   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[4.7 Buttons](#47-buttons)    
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[4.8 Button Types](#48-button-types)   
[5. Security](#7-security)   
[6. Extending LocalAdmin](#7-extending-localadmin)   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[6.1 Moving htdocs](#61-moving-htdocs)   
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[6.2 Creating your own Buttons](#62-creating-your-own-buttons)   
[7. About](#7-about)   
[8. Credits](#8-credits)   
[9. Links](#9-links)   
[10. License](#10-license)   

##1. Requirements

– Local Web Server     
– Local Wildcard Domain (tld)     
– PHP >= 5.6, works great with PHP 7     
– For best experience: [LocalAdmin-URL-Scheme-Launcher](https://github.com/JoergHolz/LocalAdmin-URL-Scheme-Launcher) (OS X 

##2. Get started

1. If you have not setup a local webserver, PHP and a local wildcard domain, then start now. Here are some links:

     Mac OS X: [The Perfect Web Development Environment for Your New Mac](https://mallinson.ca/osx-web-development/)
   
     Windows: [Apache 2.x on Microsoft Windows](http://php.net/manual/en/install.windows.apache2.php)  
     Windows Wildcard Domain: [Wildcard Subdomains in Apache](http://blog.calcatraz.com/wildcard-subdomains-in-apache-1422)
   
     Linux: [Apache 2.x on Unix systems](http://php.net/manual/en/install.windows.apache2.php)  
     Linux Wildcard Domain: [Dnsmasq](http://www.thekelleys.org.uk/dnsmasq/doc.html)

2. Download and unzip LocalAdmin

3. Move it to the root of your webserver where all your other project are

4. Depending on your vhost settings, there may be a need of some changes. The document root of LocalAdmin is /htdocs. If you want to move the folder htdocs somewhere else, read below [Extending LocalAdmin](#11-extending-localadmin) 

5. Open settings.php in localadmin/application/config and find the following configurations:

    Set your local wildcard domain in "tld":

        $config["general"] = [
               "tld" => "dev",
               ...

    Set the absolute path to your web root in "directory":

   
        $config["project_group"][0] = [
                "name" => "My Projects",
                "directory" => "/absolute/path/to/webroot/",
                ...

           
    
    Example: "/Users/your_username/Sites/" **(Don't forget the slashes!)**
  
6. Install [LocalAdmin-URL-Scheme-Launcher](https://github.com/JoergHolz/LocalAdmin-URL-Scheme-Launcher) (OS X only)

7. Open LocalAdmin in your browser, e. g.: http://localadmin.dev

8. You are done!

##3. How it works

LocalAdmin lists all folders (No files!), which are in a given directory **AND** the content of these folders matches your "matching_path". Some examples:

**Lists everything in your webroot:**

```
$config["project_group"][0] = [
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/",
        ...
```
**Lists only folders, which have inside a www folder:**
 
```     
$config["project_group"][0] = [
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/www/",
        ...
```
 
**Lists only folders, which have inside a www/htdocs folder:**

```
$config["project_group"][0] = [
       "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/www/htdocs/",
        ...
```

###3.1 Practical Example

Let's say you have the following folder structure in your webserver root:

```
mobile-apps
    app1
        platforms
    app2
        platforms
    app3
        platforms
       
miller-company
    backend
        htdocs
    frontend
        htdocs
    shop
        htdocs
    documents
        logos
         
my_web1
    htdocs
my_web2
    htdocs
my_web3
    htdocs
    documents
        redame.txt
my_web4
    htdocs
```

Your settings could look like:

```
$config["project_group"][0] = [
        "directory" => "/absolute/path/to/webroot/mobile-apps/",
        "matching_path" => "/",
        ...

$config["project_group"][1] = [
        "directory" => "/absolute/path/to/webroot/miller-company/",
        "matching_path" => "/htdocs/",
        ...
        
$config["project_group"][2] = [
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/htdocs/",
        ...
```

The first setting lists every folder in mobile-apps because of the simple slash.

The second setting lists the folders backend, frontend and shop **but not** the documents folder, because it has no htdocs inside.

The third setting lists my_web1 … my_web4 **but not** the folders mobile-apps and miller-company, because … right, they don't have a htdocs in the first level.


####3.2 Advanced Example
Lets take the above example an say we want to have an extra group listed in LocalAdmin which contains all projects having a document folder inside:
 
```
$config["project_group"][0] = [
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/documents/",
        ...
``` 

This would list: miller-company and my_web3

##4 Settings

You find all settings in application/config/settings.php. All settings are stored in an array called $config and grouped into:

###4.1 General Behavior of LocalAdmin

Saved in:

```
$config["general"]
```

Default settings:

```
$config["general"] = [
    "tld" => "dev",
    "show_tooltips" => TRUE,
    "allow_shell_scripts" => FALSE,
    "button_groups_in_two_rows" => FALSE,
    "button_groups_in_two_rows_at" => 600
];
```

| Key        | Type          | Description  |
| ------------- |-------------| -----|
| "tld"      | String | name of your local wildcard TLD, default "dev". **If you don't use a wildcard TLD, LocalAdmin will not work properly out of the box.**
| "show_tooltips"      | Boolean      | set to TRUE to show tooltips |
| "allow_shell_scripts" | Boolean      | enables support for shell scripts, default FALSE. **Before careful what you are doing!** |
| "button_groups_in_two_rows"|Boolean|how the button groups will be shown: FALSE in one row, TRUE in two rows. This setting overrides the same called settings in project groups and settings for each project.
|"button_groups_in_two_rows_at"|Integer|the window width in pixel, when the button groups will shown in two rows. Good for small browser windows.


###4.2 Splashscreen
The splashscreen is the start screen of LocalAdmin. It prevents you to use LocalAdmin until it is fully loaded.

Saved in:

```
$config["splashscreen"]
```

Default settings:

```
$config["splashscreen"] = [
    "show_splashscreen" => TRUE,
    "logo_path" => "images/default/splashscreen_logo.png",
    "text" => "Loading"
];
```

| Key        | Type          | Description  |
|-------------|-------------|-----|
|"show_splashscreen"|Boolean|enables/disables the splashscreen|
|"logo_path"|String|relative path to splashscreen logo, leave blank to hide, default size: 128px x 128px |
|"text"|String|text or html to be displayed, default "Loading"|

###4.3 Top Navigation

Saved in:

```
$config["navbar"]
```

####4.3.1 Top Navbar General Settings

Saved in:

```
$config["navbar"]["general"]
```

Default settings:

```
$config["navbar"]["general"] = [
    "title" => "LocalAdmin",
    "logo_path" => "images/default/navbar_logo.png",
    "show_local_ip" => TRUE,
    "show_public_ip" => TRUE
];
```

| Key        | Type          | Description  |
|-------------|-------------|-----|
|  "title"|String|title of this backend, leave blank to hide|
|  "logo_path"|String|relative path to navbar logo, leave blank to hide, size: 32px x 32px|
|  "show_local_ip"|Boolean|set to TRUE to show local IP
|  "show_public_ip"|Boolean|set to TRUE to show public IP of your network, makes request to: https://api.ipify.org


####4.3.2 Top Navbar Links

Navigation links can be simple links or dropdowns.

Saved in:

```
$config["navbar"]["links"]
```

Default settings:

```
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
```


| Key        | Type          | Description  |
|-------------|-------------|-----|
|"name"|String|link name|
|"url"|String|where to jump|
|"target"|String|where to show, if empty "_blank" is used|
|"dropdown"|Array|indicates a dropdown|
|"divider"|Boolean|set to TRUE to show a divider (separator line) below a link in dropdown


###4.4 All Projects
Saved in:

```
$config["all_projects"]
```

Default settings:

```
$config["all_projects"] = [
    "hide_if_contains" => ""
];
```


| Key       | Type          | Description  |
|-------------|-------------|-----|
|"hide_if_contains"|String| If you want to hide projects (directories) which name contains a word or phrase, this is the right place to do it.  

###4.5 Project Groups

A project group is a collection of directories in a specific path (setting: "directory") and a matching structure (setting: "matching_path").

Before you start to make your settings, you should read [How it works](#5-how-it-works).

Saved in:

```
$config["project_group"]
```

Basic setup, which lists all directories. Use this one as a template and extend it to your needs:

```
$config["project_group"][0] = [
    "name" => "",
    "directory" => "/absolute/path/to/webroot/",
    "matching_path" => "/",
    "has_subdomains" => FALSE,
    "columns" => 2,
    "button_groups_in_two_rows" => FALSE,
    "hidden_sites" => [],
    "title_buttons" => [],
    "local_button_group" => [],
    "remote_button_group" => []
];
```

Showing two project groups:

```
$config["project_group"][0] = [
    "directory" => "/absolute/path/to/webroot/",
    "matching_path" => "/", 
    ...
];

$config["project_group"][1] = [
    "directory" => "/absolute/path/to/webroot/another_path/",
    "matching_path" => "/", 
    ...
];
```

| Key       | Type          | Description  |
|-------------|-------------|-----|
| "name" | String | display name of project group, if empty directory name will used  |
| "directory" | String | absolute path to your webroot/projectfolder, read [How it works](#5-how-it-works)   |
| "matching_path" | String | the path matching condition for showing folders/projects, read [How it works](#5-how-it-works)  |
| "has_subdomains| Boolean | set to true, if you have setup your vhost to use subdomains in the path of your project group  |
| "columns" | Integer | number of projects to be shown in one row, can be 1, 2, 3 or 4  |
| "icon" | String | path to icon, remarks see below  |
| "button_groups_in_two_rows" | Boolean | set to true, if you want to show the local-/remote-button-group in two rows.  |
| "hidden_sites" | Array | list here all sites by their directory names, which you don't want to see in your project group  |
| "title_buttons" | Array | setup for buttons, shown right of the project group name, see [4.7 Buttons](#47-buttons)  |
| "local_button_group" | Array | see [4.7 Buttons](#47-buttons)   |
| "remote_button_group" | Array | see [4.7 Buttons](#47-buttons)  |


Default project group setup in settings.php, read [2. Get started](#2-get-started):

Icons: LocalAdmin tries to fetch a favicon.ico in the web root of your projects. If this fails, it tries to fetch an icon path from your site options, if this also fails, it tries to fetch a path from your project group settings.
###4.6 Settings for each Project

For every single project you can setup a name, an icon and you can add buttons.

Saved in:

```
$config["site_options"]
```

Basic setup, which lists all directories. Use this one as a template and extend it to your needs:

```
$config["site_options"]["your_directory_name"] = [
    "name" => "My Project 1",
    "icon" => ",
    "button_groups_in_two_rows" => TRUE,
    "local_button_group" => [],
    "remote_button_group" => []
    ];
```


| Key       | Type          | Description  |
|-------------|-------------|-----|
| "name" | String | display name of project, if empty directory name will used  |
| "icon" | String | path to icon, remarks see below  |
| "button_groups_in_two_rows" | Boolean | set to true, if you want to show the local-/remote-button-group in two rows.  |
| "local_button_group" | Array | see [4.7 Buttons](#47-buttons)   |
| "remote_button_group" | Array | see [4.7 Buttons](#47-buttons)  |

**Attention:**   
"your_directory_name" has to be changed to the real name of your project. If you use subdomains in a folder the name has to be like:
```
subdomain.domain e.g. blog.example
```


Icons: LocalAdmin tries to fetch a favicon.ico in the web root of your projects. If this fails, it tries to fetch an icon path from your site options, if this also fails, it tries to fetch a path from your project group settings.

###4.7 Buttons
Buttons are grouped in button groups and could be placed right of the project group title (setting: "title_button_group"), as a local button group (setting: "local_button_group") or remote button group (setting: "remote_button_group") in the project panel.

You can define buttons in the project group settings:

```
$config["project_group"][0] = [
    "title_button_group" => [],
    "local_button_group" => [
        "title" => "Local:",
        "buttons" => []

    ],
    "remote_button_group" => [
        "title" => "Remote:",
        "buttons" => []
    ]
]
```

For each project you can append local or remote buttons:

```
$config["site_options"]["your_directory_name"] = [
   "local_button_group" => [
        "buttons" => [
        ]
    ],
    "remote_button_group" => [
        "buttons" => [
        ]
    ]
];
```


###4.8 Button Types

Properties you can use in every button type and in dropdowns too:

| Key       | Type          | Description  |
|-------------|-------------|-----|
| "platform" |String| button will be displayed only on this platform, leave blank for all platforms
| "browser" | String | button will be displayed only in this browser, leave blank for all browsers

To get the values, which LocalAdmin uses to detect the agent, click on the info button right of the top navbar.

**"show_path"**

Shows path of project group, number of projects and number of hidden projects.

Usable: title_button_group
```
0 => [
             "platform" => "",
             "browser" => "",
             "type" => "show_path"
        ]
```

---

**"show_hidden_projects"**

Dropdown which lists hidden projects. Only visible when there are hidden projects.

Usable: title_button_group
```
0 => [
           "platform" => "",
           "browser" => "",
           "type" => "show_hidden_projects"
        ]
```

---

**"dropdown"**

Shows the buttons defined in «items» as a dropdown list.

Usable: title_button_group, local_button_group, remote_button_group
```
0 => [
                "platform" => "",
                "browser" => "",
                "type" => "dropdown",
                "name" => "Button Name",
                "items" => []
            ]

```

| Key       | Type          | Description  |
|-------------|-------------|-----|
| "name" |String| display name of dropdown
| "items" | Array | buttons to be displayed in dropdown 

---

**"show_in_browser"**

Shows project or URL in new tab.

Usable: title_button_group, local_button_group, remote_button_group
```
0 => [
                "platform" => "",
                "browser" => "",
                "type" => "show_in_browser",
                "url" => ""
           ]
```

| Key       | Type          | Description  |
|-------------|-------------|-----|
| "url" |String| href link, leave blank to show local project

---


**"url"**

Shows project or URL in new tab.

The difference to "show_in_browser" is, that you can here provide a label and tooltip.

Usable: title_button_group, local_button_group, remote_button_group
```
0 => [
                "platform" => "",
                "browser" => "",
                "type" => "url",
                "label" => "",
                "url" => "",
                "tooltip" => ""
           ]
```


| Key       | Type          | Description  |
|-------------|-------------|-----|
| "label" |String| button label |
| "url" |String| href link |
| "tooltip" |String| tooltip to display |

---

**"live_preview"**

Shows project or URL as live preview in popup.

**Live preview uses an iframe, so the site you want to see has to provide this function.**

Usable: title_button_group, local_button_group, remote_button_group
```
0 => [
                "platform" => "",
                "browser" => "",
                "type" => "live_preview",
                "url" => ""
           ]
```

| Key       | Type          | Description  |
|-------------|-------------|-----|
| "url" |String| href link, leave blank to show local project

---


**"login"**

Shows login in new tab.

Usable: title_button_group, local_button_group, remote_button_group
```
0 => [
                "platform" => "",
                "browser" => "",
                "type" => "login",
                "url" => "",
                "path_to_login" => ""
           ]
```

| Key       | Type          | Description  |
|-------------|-------------|-----|
| "url" |String| href link, leave blank to show local project
| "path_to_login" | String| path from url or project to login page
---


**"search"**

Predefined Google search.

Usable: title_button_group, local_button_group, remote_button_group
```
0 => [
                "platform" => "",
                "browser" => "",
                "type" => "search",
                "search_for" => ""
           ]
```

| Key       | Type          | Description  |
|-------------|-------------|-----|
| "search_for" |String| term to search
---


**"special"**

Predefined Google search.

Usable: title_button_group, local_button_group, remote_button_group
```
0 => [
                "platform" => "",
                "browser" => "",
                "type" => "special",
                "item" => ""
           ]
```

| Key       | Type          | Description  |
|-------------|-------------|-----|
| "item" |String| button html

Typical Bootstrap button: 
```
<a href='#' target='_blank' type='button' class='btn btn-default'>Button</a>
```
---

**"url_scheme"**

Creates a URL scheme link. OS X user can use my [LocalAdmin-URL-Scheme-Launcher](https://github.com/JoergHolz/LocalAdmin-URL-Scheme-Launcher) (OS X only)

On other platforms you have to right your own launcher.

Ready to use examples for all build in scripts are here: [LocalAdmin-URL-Scheme-Launcher](https://github.com/JoergHolz/LocalAdmin-URL-Scheme-Launcher)

Usable: title_button_group, local_button_group, remote_button_group
```
 0 => [
                "platform" => "",
                "browser" => "",
                "type" => "url_scheme",
                "script" => "",
                "add_to_path" => "",
                "label" => "",
                "tooltip" => "",
                "parameters" => ""
           ]
```

| Key       | Type          | Description  |
|-------------|-------------|-----|
| "script" |String| script to execute |
| "add_to_path" |String| for addressing files/folders deeper in your project |
| "label" |String| button label |
| "tooltip" |String| tooltip to display |
| "parameters" |String| optional parameters like "&key=value"|

A typical URL scheme link looks like (For better reading the example is urldecoded.):

```
localadmin://the_script_name.scpt?siteroot=http://your_website.com&agent_platform=Mac+OS+X&agent_browser=Safari&path=/path/to/project/add_to_path&key=value
```

The path is created from your project path + add_to path. You need the add_to_path to address files or folders which are deeper located in your project.

LocalAdmin urlencodes all parameters.

---


**"shell"**

Executes a shell script by using the PHP exec-function and opens a popup for showing the results, if your script returns some values.

On default the execution of shell scripts is forbidden for security reasons. To enable the execution you have to set "allow_shell_scripts" in the general settings to TRUE.

This function is only for people who know what they are doing, be aware and read the PHP docs and the docs associated with your server!

Usable: title_button_group, local_button_group, remote_button_group
```
0 => [
                "platform" => "",
                "browser" => "",
                "type" => "shell",
                "label" => "",
                "script" => "",
                "tooltip" => ""
           ]
```

| Key       | Type          | Description  |
|-------------|-------------|-----|
| "script" |String| script to execute |
| "label" |String| button label |
| "tooltip" |String| tooltip to display |
---


##5. Security
You can do some powerful task with LocalAdmin - therefore harden your enviroment. On default LocalAdmin has a .htaccess in htdocs, which limits the permission only to the local machine.

##6. Extending LocalAdmin

LocalAdmin is based on [Codeigniter](https://www.codeigniter.com).

###6.1 Moving htdocs
If you need or want to change the location of htdocs, then you have to change these two setting in index.php:

```
$system_path = '../system';
```

```
$application_folder = '../application';
```

###6.2 Creating your own Buttons
Every button type has a corresponding private function, which is located in application/controllers/LocalAdmin.php.

If you define a new type «my_button»:
 
```
 "local_button_group" => [
         "title" => "Local:",
         "buttons" => [
             0 => [
                 "type" => "my_button",
                 "key1" => "value1",
                 "key2" => "value2"
             ]
         ]
     ]
```

You need the private function «_my_button» in application/controllers/LocalAdmin.php

```
  function _my_button($button){
        // create your button as <a href='…>label</a> and return it
    }
```
The function has to return HTML, see the other button functions in application/controllers/LocalAdmin.php.

$button contains:
```
[type] => my_button
[key1] => value1
[key2] => value2
[file] => /path/to…/example
[domain] => example
[siteroot] => http://example.dev
[project] => example
[target] => _blank
[tooltip] => 
```

How to create Bootstrap Buttons: [Buttons](http://getbootstrap.com/css/#buttons). Remember to return \<a> buttons otherwise you have to write same CSS and urlencode your links.

##7. About
Weeks ago I found this great tool: [Localhomepage](http://cmall.github.io/LocalHomePage/) from [Chris Mallinson](https://mallinson.ca). I used it for several days and thought it would be a nice idea to have some more functions.

##8. Credits

Christa  
[Chris Mallinson](https://mallinson.ca)


##9. Links

[Codeigniter](http://www.codeigniter.com)  
[Bootstrap](http://getbootstrap.com)  
[Localhomepage](http://cmall.github.io/LocalHomePage/)  
[ipify](https://www.ipify.org)  

##10. License

MIT License (MIT)

Copyright (c) 2016 Jörg Holz | [https://www.workflow-management.net](https://www.workflow-management.net)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.