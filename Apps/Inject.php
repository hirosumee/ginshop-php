<?php
/**
 * Created by PhpStorm.
 * User: gin
 * Date: 2/27/2018
 * Time: 1:23 PM
 */
spl_autoload_register(function($className){
    $exp=str_replace('_','/',$className);
    $path=str_replace("Apps","",$exp);
    $fullPath=__DIR__.$path.'.php';
    include_once $fullPath;
});