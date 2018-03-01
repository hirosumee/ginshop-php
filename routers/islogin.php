<?php
/**
 * Created by PhpStorm.
 * User: gin
 * Date: 3/1/2018
 * Time: 11:57 AM
 */

require_once "../Apps/Inject.php";
$userIndentify=new Apps_Libs_Login();
if($userIndentify->isLogin())
{
    echo json_encode([
        "login"=>true,
        "username"=>$userIndentify->getUsername(),
        "avatar"=>$userIndentify->getAvatar()
    ]);
    return ;
}
else
{
    echo json_encode([
        "login"=>false
    ]);
}
