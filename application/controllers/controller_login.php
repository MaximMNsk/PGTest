<?php

namespace application\controllers;
use application\models\Model_Login;
use application\views\View;

class Controller_Login extends Controller 
{
    function __construct()
    {
        $this->model = new Model_Login();
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate('login_view.php', 'template_view.php');        
    }

    function action_login(){
        $this->model->login = $_POST['login'];
        $this->model->pwd = $_POST['pwd'];
        if ( $this->model->verifyUser() ) {
            $this->model->login();
            return $this->redirectToAction();
        } else {
            $this->model->setWPFlag();
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
        header("HTTP/1.1 301 Moved Permanently");
        header("location: http://".$_SERVER['HTTP_HOST']."/login/");
    }

    private function redirectToAction()
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("location: http://".$_SERVER['HTTP_HOST']."/action/");
    }


}