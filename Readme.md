# Laravel Bootstrap Package

## Introduction

Easy install of installing Bootstrap Assets on your Laravel apps. This repository require [https://github.com/CodeSleeve/asset-pipeline](Asset Pipeline). We love simple, so i hope this package can get you an easy method to install bootstrap assets.

## How to install 

Install this package is pretty simple, on your laravel apps. Update your composer.json by adding this code
	
	"require":{
		"gufy/bootstrap":"dev-master"
	}

Once you've done updating your composer.json, Add this script to your `app/config/app.php` on service providers section

	'Gufy\Bootstrap\BootstrapServiceProvider',

Then, you need to run this command, so it will be automatically register bootstrap assets on javascript and css files. Make sure you only run this once. 

	php artisan assets:setup // from codesleeve/asset-pipeline command
	php artisan bootstrap:install 

To make sure bootstrap is installed, check `app/assets/javascripts/application.js` and the content is containing `//require bootstrap` and `app/assets/stylesheets/application.css` containing `*= require bootstrap`.

## Contributing

I love contribution and collaboration. Just fork and make some patch, then make a pull request to this repository. 

Thanks. :-)