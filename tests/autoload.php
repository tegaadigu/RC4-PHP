<?php
/**
 * Created by PhpStorm.
 * User: tegaadigu
 * Date: 03/06/2018
 * Time: 12:00 PM
 */
include_once __DIR__.'/../vendor/autoload.php';
$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4("App\\", __DIR__, true);
$classLoader->register();
