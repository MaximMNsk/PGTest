<?php

namespace application\models;

class Model_Validate
{
    function email(string $email){
        $success = 1;
        $message = 'Validate success';
        if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
            $success = 0;
            $message = 'Check an email to be correct. As example - mymail@email.com';
        }
        return [
            'success' => $success,
            'message' => $message,
        ];
    }

    function identifier(string $str){
        $success = 1;
        $message = 'Validate success';
        $pattern = '/[a-z\-\s\.]/i';
        $lettersArr = str_split($str);
        foreach($lettersArr as $letter){
            if( !preg_match($pattern, $letter) ){
                $success = 0;
                $message = 'Check an identifier to be correct. As example - My.Login';
                }
        }
        return [
            'success' => $success,
            'message' => $message,
        ];
    }

    function fullName(string $str){
        $success = 1;
        $message = 'Validate success';
        $pattern = '/(\w)(\s){1}(\w)/i';
        if( !filter_var($str, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $pattern]]) ){
            $success = 0;
            $message = 'Check an Full Name to be correct. As example - Иван Иванов.';
        }
        return [
            'success' => $success,
            'message' => $message,
        ];
    }

    function id($id){
        $success = 1;
        $message = 'Validate success';
        if( !$id ){
            $success = 0;
            $message = 'Empty form detected';
        }
        return [
            'success' => $success,
            'message' => $message,
        ];
    }

    function rate(string $str){
        $success = 1;
        $message = 'Validate success';
        if(filter_var($str, FILTER_VALIDATE_FLOAT, ['options' => ['decimal' => '.']])){
            $parts = explode('.', $str);
            if( count($parts)==2 ){
                $decimal = $parts[1];
                if( strlen($decimal) != 2 ){
                    $success = 0;
                    $message = 'Wrong rate format. As example - 1000.00';
                }
            }else{
                $success = 0;
                $message = 'Wrong rate format. As example - 1000.00';
            }
        }else{
            $success = 0;
            $message = 'Wrong rate format. As example - 1000.00';
        }
        return [
            'success' => $success,
            'message' => $message,
        ];
    }

    function auth(){
        if( isset($_SESSION['access']) ){
            if($_SESSION['access']>0){
                return true;
            }
        }
        return false;
    }

}