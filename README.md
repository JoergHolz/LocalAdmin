#LocalAdmin - a webbased Admin Tool

Weeks ago I deleted Apples Server.app (I had to much trouble to set up vhosts.). I setup my own server and was looking for a project administration tool.

I found [Localhomepage](http://cmall.github.io/LocalHomePage/), a great idea and nice tool from [Chris Mallinson](https://mallinson.ca). I decided to pick up the idea and bring some automation and developer things into it.

The result is LocalAdmin, here a real life screenshot:

 ![LocalAdmin dialog](doc_images/localadmin.png) 

## Who should use LocalAdmin?
Webdevelopers, Back- and FrontEnd-People, Cordova- and Phonegap Developers, Automation Developers.

## Requirements

– local web server

– local TLD (see below)

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

4. Depending on the settings of your vhost, there may be a need of some changes. The document root of LocalAdmin is /htdocs. If you want to move the folder htdocs somewhere else, read below [Extending LocalAdmin](#extending) 

5. Open settings.php in localadmin/application/config and find the following configurations:


Set your local wildcard domain in:
   
```
   $config["tld"] = "dev";
```
   

    Set the absolute path to your web root:

   
```
   $config["project_group"][0] = [
           "name" => "My Projects",
          "directory" => "/absolute/path/to/webroot/",
```
           
    
    Example: "/Users/your_username/Sites/" **(Don't forget the slashes!)**
  
6. Install [LocalAdmin-URL-Scheme-Launcher](https://github.com/JoergHolz/LocalAdmin-URL-Scheme-Launcher) (OS X only)

7. Open LocalAdmin in your browser, e. g.: http://localadmin.dev

8. You are done!


## How it works

LocalAdmin lists all folders (No files!), which are in a given directory **AND** the content of these folders matches your "matching_path". Some examples:

Lists everything in your webroot. This is the default.

```
$config["project_group"][0] = [
        "name" => "My Projects",
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/",     
```
 Lists only folders, which have inside a www folder:
 
```     
$config["project_group"][0] = [
        "name" => "My Projects",
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/www/",     
```
 
Lists only folders, which have inside a htdocs/www folder (This is the standard structure I use in my webprojects):

```
$config["project_group"][0] = [
        "name" => "My Projects",
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/htdocs/www/",     
```

### Practical Example

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
        "name" => "Mobile Apps",
        "directory" => "/absolute/path/to/webroot/mobile-apps/",
        "matching_path" => "/",

$config["project_group"][1] = [
        "name" => "Miller Company",
        "directory" => "/absolute/path/to/webroot/miller-company/",
        "matching_path" => "/htdocs/",
        
$config["project_group"][2] = [
        "name" => "My Webs",
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/htdocs/",
```

The first setting lists every folder in mobile-apps because of the simple slash.

The second setting lists the folders backend, frontend and shop **but not** the documents folder, because it has no htdocs inside.

The third setting lists my_web1 … my_web4 **but not** the folders mobile-apps and miller-company, because … right, they don't have a htdocs in the first level.


####Advanced Example
Lets take the above example an say we want to have a extra group listed in LocalAdmin which contains all project having a document folder in it:
 
```
$config["project_group"][0] = [
        "name" => "Document Folders",
        "directory" => "/absolute/path/to/webroot/",
        "matching_path" => "/documents/",
``` 

This would lists: miller-company and my_web3.

## Settings




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

## License

MIT License (MIT)

Copyright (c) 2016 Jörg Holz | [https://www.workflow-management.net](https://www.workflow-management.net)