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
        session_destroy();
    }

}