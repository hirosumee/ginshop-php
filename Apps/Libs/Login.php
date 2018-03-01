<?php
/**
 * Created by PhpStorm.
 * User: gin
 * Date: 3/1/2018
 * Time: 8:59 AM
 */

session_start();
//before use module login. session must be started!!
 class Apps_Libs_Login
 {
     public $username="";
     public $password="";
     protected $id="";
     public $avatar="";

     public function __construct($username="",$password="")
     {
         $this->username=$username;
         $this->password=$password;
     }

     /**
      * @return string
      */
     public function encryptPassword(){
         return md5($this->password);
     }

     /**
      * @return bool
      */
     public function login()
     {
         $user=new Apps_Models_Users();
         $query=$user->buildParams([
             "where"=>"username =:username AND password =:password",
             "params"=>[
                 ":username"=>$this->username,
                 ":password"=>$this->password
             ]
         ])->selectOne();
         if($query)
         {
             $_SESSION['userId']=$query['id'];
             $_SESSION['username']=$query['username'];
             $_SESSION['avatar']=$query['avatar'];
             return true;
         }
         return false;
     }
     public function logout()
     {
         unset($_SESSION['userId']);
         unset($_SESSION['username']);
         unset($_SESSION['avatar']);
     }
     public function getSession($nameParam)
     {
         if($nameParam!=null)
         {
             return isset($_SESSION[$nameParam])?$_SESSION[$nameParam]:null;
         }
         return false;
     }

     public function isLogin(): bool
     {
         return $this->getSession('userId')?true:false;
     }
     public function getId()
     {
         return $this->getSession('userId');
     }
     public function getUsername()
     {
         return $this->getSession('username');
     }
     public function getAvatar()
     {
         return $this->getSession('avatar');
     }
 }