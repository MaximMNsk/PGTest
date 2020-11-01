<?php

namespace application\models;

class Model
{

    protected $db;

    public $serverName;
    public $dbName;
    public $username;
    public $password;

    function __construct(){
        $options = array( "Database"=>$this->dbName, "UID"=>$this->username, "PWD"=>$this->password);
        $conn = sqlsrv_connect( $this->serverName, $options);
    }

    




}


