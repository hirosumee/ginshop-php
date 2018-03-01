<?php
/**
 * Created by PhpStorm.
 * User: gin
 * Date: 3/1/2018
 * Time: 9:51 AM
 */
header('Content-type: application/json');
require_once "../Apps/Inject.php";
$route=new Apps_Libs_Router();

$username=trim($route->getPOST('username'));
$password=trim($route->getPOST('password'));

$userIndentify=new Apps_Libs_Login();
if($userIndentify->isLogin())
{
    echo json_encode([
        "login"=>true,
        "username"=>$userIndentify->getUsername(),
        "avatar"=>$userIndentify->getAvatar()
    ]);
}
else
{
    $userIndentify->username=$username;
    $userIndentify->password=$password;
    if($userIndentify->login())
    {
        echo json_encode([
            "login"=>true,
            "username"=>$userIndentify->getUsername(),
            "avatar"=>$userIndentify->getAvatar()
        ]);
    }
    else
    {
        echo json_encode([
            "login"=>false
        ]);
    }
}