<?php

namespace application\controllers;

use application\models\Model_action;
use application\views\View;

class Controller_Action extends Controller
{

    function __construct()
    {
        $this->model = new Model_action;
        $this->view = new View;
    }

    public function action_index()
    {
        $data = [];
        $this->view->generate('action_view.php', 'template_view.php', $data);
    }

    public function action_get(){
        $userData = $this->model->getCRMUser();
        $data = [
            'success' => (!$userData) ? 0 : 1,
            'message' => $userData,
        ];
        if( !$this->model->validate->auth() ) {
            $data = [
                'success' => 0,
                'message' => 'Unregistered user'
            ];
        }
        $this->view->generate('get_view.php', 'empty_view.php', $data);
    }

    function action_set(){
        $fullValidate = $this->model->fullValidate($_POST);
        $data = $fullValidate;
        if( !$this->model->validate->auth() ) {
            $data = [
                'success' => 0,
                'message' => 'Unregistered user'
            ];
        }
        $this->view->generate('get_view.php', 'empty_view.php', $data);
    }

   
    
}