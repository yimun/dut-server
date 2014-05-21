<?php
defined('YII_DEBUG') or define('YII_DEBUG',true);
 
// including Yii
require_once(dirname(__FILE__).'/../..//../framework/yii.php');
 
// we'll use a separate config file
$configFile=dirname(__FILE__).'/../config/console.php';
 
// creating and running console application
Yii::createConsoleApplication($configFile)->run();