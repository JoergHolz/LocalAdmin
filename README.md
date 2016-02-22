#LocalAdmin - a webbased Admin Tool

Weeks ago I deleted Apples Server.app (I had to much trouble to set up vhosts.). I setup my own server and was looking for a project administration tool to have things in one place?

I found [Localhomepage](http://cmall.github.io/LocalHomePage/), a great idea and nice tool from [Chris Mallinson](https://mallinson.ca). I decided to pick up the idea and bring some automation and developer things into it.

Wouldn't it be nice to have one place, where you have all your project links, starting your IDE/SDK, jump to the project directory, open files, open developer tools, iOS Simulator, …

I did some development and the result is LocalAdmin::

 ![LocalAdmin dialog](doc_images/localadmin.png) 

## Who should use LocalAdmin?
Webdevelopers, Back- and Frontend-People, Cordova- and Phonegap Developers, Automation Developers and every one who wants to use a local webdriven folder and document tool.

## Requirements

– local web server

– local wildcard Domain

– PHP >= 5.6, works great with PHP 7

– For best experience: [LocalAdmin-URL-Scheme-Launcher](https://github.com/JoergHolz/LocalAdmin-URL-Scheme-Launcher) (OS X only)


## Get started

1. If you have not setup a local webserver, PHP and a local wildcard domain, then do so. Here are some links:

     Mac OS X: [The Perfect Web Development Environment for Your New Mac](https://mallinson.ca/osx-web-development/)
   
     Windows: [Apache 2.x on Microsoft Windows](http://php.net/manual/en/install.windows.apache2.php)  
     Windows Wildcard Domain: [Wildcard Subdomains in Apache](http://blog.calcatraz.com/wildcard-subdomains-in-apache-1422)
   
     Linux: [Apache 2.x on Unix systems](http://php.net/manual/en/install.windows.apache2.php)  
     Linux Wildcard Domain: [Dnsmasq](http://www.thekelleys.org.uk/dnsmasq/doc.html)

2. Download and unzip localadmin

3. Move it to the root of your webserver where all your other project are

4. Depending on the settings of your vhost, there may be a need of some changes. The document root of LocalAdmin is /htdocs. If you want to move the folder htdocs somewhere else, read below [Extending LocalAdmin](#extending-localadmin) 

5. Open settings.php in localadmin/application/config and find the following configurations:

    Set your local wildcard domain in "tld":

        $config["general"] = [
               "tld" => "dev",

    Set the absolute path to your web root in "directory":

   
        $config["project_group"][0] = [
                "name" => "My Projects",
                "directory" => "/absolute/path/to/webroot/",

           
    
    Example: "/Users/your_username/Sites/" **(Don't forget the slashes!)**
  
6. Install [LocalAdmin-URL-Scheme-Launcher](https://github.com/JoergHolz/LocalAdmin-URL-Scheme-Launcher) (OS X only)

7. Open LocalAdmin in your browser, e. g.: http://localadmin.dev

8. You are done!

##How it works

LocalAdmin lists all folders (No files!), which are in a given directory **AND** the content of these folders matches your "matching_path". Some examples:

Lists everything in your webroot. This is the default.

```
$config["project_group"][0] = [
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/",     
```
 Lists only folders, which have inside a www folder:
 
```     
$config["project_group"][0] = [
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/www/",     
```
 
Lists only folders, which have inside a htdocs/www folder (This is the standard structure I use in my webprojects):

```
$config["project_group"][0] = [
       "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/htdocs/www/",     
```

###Practical Example

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

Your settings will look like:

```
$config["project_group"][0] = [
        "directory" => "/absolute/path/to/webroot/mobile-apps/",
        "matching_path" => "/",

$config["project_group"][1] = [
        "directory" => "/absolute/path/to/webroot/miller-company/",
        "matching_path" => "/htdocs/",
        
$config["project_group"][2] = [
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/htdocs/",
```

The first setting lists every folder in mobile-apps because of the simple slash.

The second setting lists the folders backend, frontend and shop **but not** the documents folder, because it has no htdocs inside.

The third setting lists my_web1 … my_web4 **but not** the folders mobile-apps and miller-company, because … right, they don't have a htdocs in the first level.


####Advanced Example
Lets take the above example an say we want to have an extra group listed in LocalAdmin which contains all projects having a document folder inside:
 
```
$config["project_group"][0] = [
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/documents/",
``` 

This would list: miller-company and my_web3

##Settings

You find all settings in the file application/config/settings.php. All settings are stored in an array called $config, and grouped into:

###1. General behavior of LocalAdmin:

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

Description:

| Name        | Type          | Description  |
| ------------- |-------------| -----|
| "tld"      | String | Name of your local wildcard TLD, default "dev". If you don't use a wildcard TLD, LocalAdmin will not work properly out of the box.
| "show_tooltips"      | Boolean      | set to TRUE to show tooltips. |
| "allow_shell_scripts" | Boolean      | enables support for shell scripts, default FALSE. **Before enabling, read the sections [Shell Scripts](#shell-scripts) and [Security](#security).** |
| "button_groups_in_two_rows"|Boolean|how the button groups will be shown: FALSE (Default) in one row, TRUE in two rows. This behavior you can also setup in the project group settings and for every single project individual.
|"button_groups_in_two_rows_at"|Integer|the window width in pixel, when the button groups will shown in two rows. Good for small browser windows.


###2. Splashscreen
The splashscreen is the start screen of LocalAdmin. It prevents your to use LocalAdmin until it is fully loaded.

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

Description:

| Name        | Type          | Description  |
|-------------|-------------|-----|
|"show_splashscreen"|Boolean|enables/disables the splashscreen|
|"logo_path"|String|relative path to splashscreen logo, leave blank to hide. default size: 128px x 128px |
|"text"|String|text or html to be displayed, default "Loading"|

###3. Top Navigation

Saved in:

```
$config["navbar"]
```

####3.1 Top Navbar General Settings

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

Description:

| Name        | Type          | Description  |
|-------------|-------------|-----|
|  "title"|String|title of this backend, leave blank to hide|
|  "logo_path"|String|relative path to navbar logo, leave blank to hide. Size: 32px x 32px|
|  "show_local_ip"|Boolean|set to TRUE to show local IP
|  "show_public_ip"|Boolean|set to TRUE to show public IP of your network. Makes request to: https://api.ipify.org


####3.2 Top Navbar Links

The navigation links can be simple links ore dropdowns.

Saved in:

```
$config["navbar"]["links"]
```

Default settings:

```
$config["navbar"]["links"] = [
    0 => [
        "name" => "Systeminfo",
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


Description:

| Name        | Type          | Description  |
|-------------|-------------|-----|
|"name"|String|link name|
|"url"|String|where to jump|
|"target"|String|where to show, if empty "_blank" is used|
|"dropdown"|Array|Indicates a dropdown|
|"divider"|Boolean|set to TRUE to show a divider (separator line) below the link


###All Projects
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


Description:

| Name        | Type          | Description  |
|-------------|-------------|-----|
|"hide_if_contains"|String|If you want to hide projects (directories) which name contains a word or phrase, this is the right place.

###Project Groups

A project group is a collection of directories in specific path (setting: "directory") and a matching structure (setting: "matching_path").

Before you start to make your settings, you should read [How it works](#how-it-works).

Saved in:

```
$config["project_group"]
```

Absolute minimum setup, which lists all directories is:

```
$config["project_group"][0] = [
    "directory" => "/absolute/path/to/webroot/mobile-apps/",
    "matching_path" => "/"
];
```

###Optional Settings for every Project

```
$config["site_options"]
```


##Shell Scripts

##Security

##Advanced Use Cases

## <a name="extending">Extending LocalAdmin</a>
change of htdocs



## History

Version: 1.0

## Credits

Christa

[Localhomepage](http://cmall.github.io/LocalHomePage/)

## Links

[Codeigniter](http://www.codeigniter.com)

[Bootstrap](http://getbootstrap.com)

[Chris Mallinson](https://mallinson.ca)

[ipify](https://www.ipify.org)

## License

MIT License (MIT)

Copyright (c) 2016 Jörg Holz | [https://www.workflow-management.net](https://www.workflow-management.net)