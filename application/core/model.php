<?php

namespace application\models;

class Model
{

    public $db;

    function __construct($serverName, $dbName, $username, $password){
        $options = array( "Database"=>$dbName, "UID"=>$username, "PWD"=>$password);
        $conn = sqlsrv_connect( $serverName, $options);
        $this->db = (!$conn) ? false : $conn ;
    }


    function prepareRequests(){
        if( !$this->db ){
            return false;
        }
        if ( sqlsrv_begin_transaction( $this->db ) === false ) {
            return false;
        }
        return true;
    }

    function makeRequest($reqSql, $options=[ 'q' => 'select', 'params' => [] ]){
        $statement = @sqlsrv_query( $this->db, $reqSql, $options['params'] );
        if($options['q'] == 'select'){
            $res = [];
            if($statement){
                while( $row = sqlsrv_fetch_array( $statement, SQLSRV_FETCH_ASSOC) ) {
                    $res[] = $row;
                }
                sqlsrv_free_stmt($statement);
                return $res;
            }else{
                return false;
            }
        }else{
            if ($statement) {
                return true;
            } else {
                return false;
            } 
        }
    }

    function commitRequest(){
        sqlsrv_commit($this->db);
    }

    function rollbackRequest(){
        sqlsrv_rollback($this->db);
    }


}


