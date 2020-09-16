<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Directories to format.
	|--------------------------------------------------------------------------
	|
	| List of directories to be scanned. By default, the directories to be
	| scanned belong to the Laravel directory structure. Here you can add
	| or remove the directories as you see fit.
	|
	*/

	'laravel' => [
		'app',
		'config',
		'database',
		'routes',
		'tests',
		'vendor/laravel',
	],

	/*
	|--------------------------------------------------------------------------
	| File name.
	|--------------------------------------------------------------------------
	|
	| The types of files to evaluate. For more information, visit the Symfony.
	| Finder documentation. https://symfony.com/doc/current/components/finder.html#file-name
	|
	*/

	'file-name' => [
		'*.php',
		'*.stub',
	],

];
