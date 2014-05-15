# Laravel Bootstrap Package

## Introduction

This will make you easier to install Bootstrap Assets on your Laravel apps. This repository require [Asset Pipeline](https://github.com/CodeSleeve/asset-pipeline). We love simple, so i hope this package can get you an easy method to install bootstrap assets.

## How to install 

Install this package is pretty simple, on your laravel apps. Update your composer.json by adding this code
	
	"require":{
		"gufy/bootstrap":"dev-master"
	}

Once you've done updating your composer.json, Add this script to your `app/config/app.php` on service providers section

	'Gufy\Bootstrap\BootstrapServiceProvider',

Then, you need to run this command, so it will be automatically register bootstrap assets on javascript and css files. Make sure you only run this once. 

## Registering Assets

Before registering assets, you have to run this command first

	php artisan assets:setup // from codesleeve/asset-pipeline command

I have already provided this assets to the structure directories

- Bootstrap
- Angular JS
- Font Awesome
- Fancybox
- Datatables

Or type this to know what have been provided by this package.

	php artisan bootstrap:list

In some case, maybe you want to install bootstrap. It's simple, type this command to install bootstrap asset.

	php artisan bootstrap:install bootstrap

To make sure bootstrap is installed, check `app/assets/javascripts/application.js` and the content is containing `//= require bootstrap` and `app/assets/stylesheets/application.css` containing `*= require bootstrap`. 

That's it. Simple, isn't it?

## Changelog

See [Changelog](Changelog.md)

## Contributing

I love contribution and collaboration. Just fork and make some patch, then make a pull request to this repository. 

Thanks. :-)