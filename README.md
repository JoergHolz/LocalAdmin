#LocalAdmin - a webbased Admin Tool

Weeks ago I deleted Apples Server.app (I had to much trouble to set up vhosts.). I setup my own server and was looking for a project administration tool.

I found [Localhomepage](http://cmall.github.io/LocalHomePage/), a great idea and nice tool from [Chris Mallinson](https://mallinson.ca). I decided to pick up the idea and bring some automation and developer things into it.

The result is LocalAdmin, here a real life screenshot:

 ![LocalAdmin dialog](doc_images/localadmin.png) 

## Who should use LocalAdmin?
Webdevelopers, Back- and FrontEnd-People, Cordova- and Phonegap Developers, Automation Developers.

## Requirements

- local web server

- local TLD (see below)

- PHP >= 5.6, works great with PHP 7

- For best experience: [LocalAdmin-URL-Scheme-Launcher](https://github.com/JoergHolz/LocalAdmin-URL-Scheme-Launcher) (OS X only)

## Get started


1. If you have not setup a local webserver, PHP and a local wildcard domain, then do so. Here are some links:

     Mac OS X: [The Perfect Web Development Environment for Your New Mac](https://mallinson.ca/osx-web-development/)
   
     Windows: [Apache 2.x on Microsoft Windows](http://php.net/manual/en/install.windows.apache2.php)  
     Windows Wildcard Domain: [Wildcard Subdomains in Apache](http://blog.calcatraz.com/wildcard-subdomains-in-apache-1422)
   
     Linux: [Apache 2.x on Unix systems](http://php.net/manual/en/install.windows.apache2.php) 
     Linux Wildcard Domain: [Dnsmasq](http://www.thekelleys.org.uk/dnsmasq/doc.html)

2. Download and unzip localadmin

3. Move it to the root of your webserver where all your other project are

4. Depending on the settings of your vhost, there may be a need of some changes. The document root of LocalAdmin is «/htdocs». If you want to move the folder htdocs somewhere else, read below [Extending LocalAdmin](#extending) 

5. Open settings.php in localadmin/application/config:

   Set your local wildcard domain:
   
    ```
   $config["tld"] = "dev";
   ```
   
   Set the absolute path to your web root:
   
       ```
   $config["project_group"][0] = [
       "name" => "workflow-management.net",
       "directory" => "/absolute/path/to/webroot/",
           ```
  Example: "/Users/your_username/Sites/" **(Don't forget the slashes!)**
  
6. Install [LocalAdmin-URL-Scheme-Launcher](https://github.com/JoergHolz/LocalAdmin-URL-Scheme-Launcher) (OS X only)

## <a name="extending">Extending LocalAdmin</a>
change of htdocs

## How it works

## Usage

## Settings


## History

Version: 1.0

## Credits

– Christa

– [Localhomepage](http://cmall.github.io/LocalHomePage/)

## Links

- [Codeigniter](http://www.codeigniter.com)

- [Bootstrap](http://getbootstrap.com)

- [Chris Mallinson](https://mallinson.ca)

## License

MIT License (MIT)

Copyright (c) 2016 Jörg Holz | [https://www.workflow-management.net](https://www.workflow-management.net)