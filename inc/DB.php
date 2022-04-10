<?php

class DB
{
private $servername = "localhost";
private $username = "root";
private $password = "";
private $dbname = "myapp";
public $cnx;
    public function __construct()
    {
        $this->cnx = new PDO("mysql:host=$this->servername;dbname=$this->dbname; charset=utf8",$this->username, $this->password);
    }

}