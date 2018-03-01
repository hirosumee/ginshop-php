<?php
/**
 * Created by PhpStorm.
 * User: gin
 * Date: 2/28/2018
 * Time: 9:33 AM
 */
class Apps_Libs_Router
{
    const HOME_PAGE="home";
    const PARAM_NAME="r";

    public static $sourcePath;

    /**
     * Apps_Libs_Router constructor.
     * @param string $sourcePath
     */
    public function __construct($sourcePath="")
    {
        if($sourcePath)
        {
            self::$sourcePath=$sourcePath;
        }
    }

    /**
     * @param $name
     * @return null
     */
    public function getGET($name)
    {
        if(trim($name)!=null)
        {
            return isset($_GET[$name])?$_GET[$name]:null;
        }
        return null;
    }

    /**
     * @param $name
     * @return null
     */
    public function getPOST($name)
    {
        if(trim($name)!=null)
        {
            return isset($_POST[$name])?$_POST[$name]:null;
        }
        return null;
    }
    public function router()
    {
        $url=$this->getGET(self::PARAM_NAME);
        if(trim($url)=="")
        {
            $url=self::HOME_PAGE;
        }
        $path=self::$sourcePath.'/'.$url.'.php';
        if(file_exists($path)) {
            return require_once $path;
        }
        echo "page 404 not found";
        return false;

    }

    public function createUrl($url,$param=[]){
        if($url)
        {
            $param[self::PARAM_NAME]=$url;
        }
        return $_SERVER["PHP_SELF"].'?'.http_build_query($param);
    }
    public function redirect($location)
    {
        header('Location:'.$location, true);
    }
    public function homePage()
    {
        $this->redirect("");
    }
}