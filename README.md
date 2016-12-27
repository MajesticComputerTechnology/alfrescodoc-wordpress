# AlfrescoDoc for Wordpress

[![Latest Stable Version](https://poser.pugx.org/mct/alfrescodoc-wordpress/v/stable)](https://packagist.org/packages/mct/alfrescodoc-wordpress) 
[![Total Downloads](https://poser.pugx.org/mct/alfrescodoc-wordpress/downloads)](https://packagist.org/packages/mct/alfrescodoc-wordpress) 
[![Latest Unstable Version](https://poser.pugx.org/mct/alfrescodoc-wordpress/v/unstable)](https://packagist.org/packages/mct/alfrescodoc-wordpress) 
[![License](https://poser.pugx.org/mct/alfrescodoc-wordpress/license)](https://packagist.org/packages/mct/alfrescodoc-wordpress)


AlfrescoDoc is a [WordPress](https://wordpress.org) module to display document from [Alfresco](https://www.alfresco.com) server powered by [Alfesco PHP CMIS CLIENT](https://github.com/fvettore/php-alf-cmis-api).
 


## Features

- Easy to display document and folder metadata from Alfresco server.
- Using Alfresco CMIS API
- It's possible to control which metadata to display.

## How to use with shortcode

add the below shortcode to display the document list in page and post

```
[alf-doc]
```

## AlfrescoDoc requires

- Alfresco 5.X with cmisatom binding (url like: http://alfresco:8080/alfresco/cmisatom)
- Wordpress at least: 3.0.1
- PHP with CURL and XML enabled

Partial compatibility (browsing and retrieving objects and aspects is OK) with old Alfresco (under development) (url like http://alfresco:8080/alfresco/service/api/cmis)

## Installation

It can be installed from Composer or source cord download.

### Installation using Composer

Please open a command prompt and carry out the next command.

```sh
$ cd <parent-of-an-install-directory>
$ composer create-project alfrescodoc-wordpress <an-install-directory>
```

### Source code is downloaded and installed.

A [Download ZIP](https://github.com/MajesticComputerTechnology/alfrescodoc-wordpress/archive/master.zip) button of our repository of GitHub is pressed and source cord is downloaded.

And ZIP is developed in an optional directory of a local machine.

## Configuration

Go to Setting > Alfresco Document

![alfrescodoc-wordpress Configuration](http://dev.majestic.com.au/alfresco/wp-content/uploads/2016/02/alfresco-wordpress-configuration.png)

## 


## License

Copyright 2016 [Majestic Computer Technology](http://majestic.com.au)

[AlfrescoDoc](https://github.com/MajesticComputerTechnology/alfrescodoc-wordpress) is open-sourced software licensed under the [Apache License v2.0](http://www.apache.org/licenses/LICENSE-2.0)

[Alfresco PHP CMIS CLIENT](https://github.com/fvettore/php-alf-cmis-api) is open-sourced software licensed under the [Apache License v2.0](http://www.apache.org/licenses/LICENSE-2.0)