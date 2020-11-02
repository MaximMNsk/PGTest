<?php

namespace application\models;


class Model_Login
{
    public $login=null;
    public $pwd=null;

    function verifyUser(){
        if($this->login && $this->pwd){
            if($this->login==USER['LOGIN'] && $this->pwd==USER['PWD']){
                return true;
            }
        }
        return false;
    }

    function login(){
        $_SESSION = [
            'user' => $this->login,
            'access' => 1,
        ];
    }

    function logout(){
        $_SESSION = ['access' => 3] ;
        session_destroy();
    }

    function setWPFlag(){
        $flag = (isset($_POST['login'])) ? 0 : 3 ;
        $_SESSION = [
            'access' => $flag
        ];
    }

}