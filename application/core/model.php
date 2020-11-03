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

    function makeRequest($reqSql, $options=[ 'q' => 'select', 'params' => [] ]){
        if( !$this->db ){
            return false;
        }
        if ( sqlsrv_begin_transaction( $this->db ) === false ) {
            return false;
        }
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
                sqlsrv_commit($this->db);
                return true;
            } else {
                var_dump(sqlsrv_errors());
                sqlsrv_rollback($this->db);
                return false;
            } 
        }
    }




}


