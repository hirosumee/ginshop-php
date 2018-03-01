<?php
/**
 * Created by PhpStorm.
 * User: gin
 * Date: 2/27/2018
 * Time: 1:30 PM
 */
class Apps_Libs_DbConnection{
    static $database=null;
    //host db epiz_20629959_ginshop
    var $dbName="ginshop";
    var $username="root";
    var $tableName="users";
    protected  $password="";
    var $queryParams=[];

    public function __construct()
    {
        $this->connect();
    }
    private function connect()
    {
        if(self::$database==null)
        {
            try{
                self::$database=new PDO("mysql:host=localhost;dbname=$this->dbName",$this->username,$this->password);
                self::$database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }
            catch (Exception $e)
            {
                var_dump($e->getMessage());
                die();
            }
        }
        return self::$database;
    }
    protected function query($sql,$params=[])
    {
        $q=self::$database->prepare($sql);

        if(is_array($params)&&$params)
        {
            $q->execute($params);
        }
        else
        {
            $q->execute();
        }
        return $q;
    }
    public function buildParams($params)
    {
        $default=[
            "select"=>"*",
            "where"=>"",
            "other"=>"",
            "params"=>"",
            "field"=>"",
            "value"=>[]
        ];
        $this->queryParams=array_merge($default,$params);
        return $this;
    }
    protected function buildWhereParam()
    {
        if(trim($this->queryParams['where'])!="")
        {
            return "where ".$this->queryParams['where']." ";
        }
        return " ";
    }
    public function select()
    {
        $sql="select ".$this->queryParams['select']." from ".$this->tableName." "
            .$this->buildWhereParam()." ".$this->queryParams['other'];
        $q=$this->query($sql,$this->queryParams['params']);
        return $q->fetchAll(PDO::FETCH_ASSOC);

    }
    public function selectOne()
    {
        $this->queryParams['other']="limit 1";
        $data=$this->select();
        if($data)
        {
            return $data[0];
        }
        return false;
    }

    public function insert()
    {
        $sql="insert into ".$this->tableName." ".$this->queryParams['field'];
        $result=$this->query($sql,$this->queryParams['value']);
        if($result)
        {
            return self::$database->lastInsertId();
        }
        return [];
    }

    /**
     * @return mixed
     */
    public function update()
    {
        $sql="update ".$this->tableName." set ".$this->queryParams['value']
            ." ".$this->buildWhereParam()." ".$this->queryParams["other"];
        return $this->query($sql);
    }
    public function delete()
    {
        $sql="delete from ".$this->tableName." ".$this->buildWhereParam()." ".$this->queryParams["other"];
        return $this->query($sql);
    }
}