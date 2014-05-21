<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Duthelper Console',
        
    'defaultController'=>'Debug',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(   
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'linwei',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		/* // 此处路由已更改  参考http://phprookie.diandian.com/post/yii/1603
		    'urlManager'=>array(          
			'urlFormat'=>'path',
			'showScriptName'=>false,//注意false不要用引号括上
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		), */
		
		/* 'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		), */
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=duthelper',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'linwei',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
		
		/* 'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		), */
		 'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				
				/* array(
					'class'=>'CWebLogRoute',
				), */
				
			),
		),
		

		'session'=>array(
		        'autoStart'=>false,
		     //   'sessionName'=>'Site Access',
		    //    'cookieMode'=>'only',
		    //    'savePath'=>'/path/to/new/directory',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
	    'version' => '1.0',
		// this is used in contact page
		'adminEmail'=>'755213779@qq.com',
		
		'collectMode'=>true,
		// datamap
        'datamap' => require('datamap.php'), 
		// 教务系统url
		'baseUrl' => 'http://202.118.65.21:8080/',
		// 百度云推送
		'apiKey'    => 'n2IFfPCX127KSFkaHLrO1Hdf',
		'secretKey' => 'nMY8FYzoT8GynPbGOi3GI9DSHohl0SXe',
	),
);