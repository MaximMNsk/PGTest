<?php

namespace application\controllers;
use application\models\Model_Login;

class Controller_Login extends Controller 
{
    function __construct()
    {
        $this->model = new Model_Login();
    }

    function action_index()
    {
        $this->model->login = $_POST['login'];
        $this->model->pwd = $_POST['pwd'];
        if ( $this->model->verifyUser() ) {
            $this->model->login();
            return $this->redirectToAction();
        } else {
            return $this->redirectToLogin();
        } 
    }

    function action_logout()
    {
        $this->model->logout();
        $this->redirectToLogin();
    }

    private function redirectToLogin()
    {
        header("location: ../");
    }

    private function redirectToAction()
    {
        header("location: ../action/");
    }


}