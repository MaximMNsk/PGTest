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
        if( !$this->model->validate->auth() ){
            header("location: http://".$_SERVER['HTTP_HOST']."/login/");
        }
        $data = [];
        $this->view->generate('action_view.php', 'template_view.php', $data);
    }

    public function action_get(){
        if( !$this->model->validate->auth() ) {
            $data = [
                'success' => 0,
                'message' => 'Unregistered user'
            ];
        }else{
            $userData = $this->model->getCRMUser();
            if(is_array($userData)){
                $message = ( count($userData)>0 ) ? $this->model->arrToUtf8($userData) : 'No more users in CRM-database' ;
            }elseif(!$userData){
                $message = false;
            }
            $data = [
                'success' => (!$userData) ? 0 : 1,
                'message' => $message,
            ];
        }
        $this->view->generate('get_view.php', 'empty_view.php', $data);
    }

    function action_set(){
        if( !$this->model->validate->auth() ) {
            $data = [
                'success' => 0,
                'message' => 'Unregistered user'
            ];
        }else{
            $incoming = $this->model->arrToCp1251($_POST);
            $fullValidate = $this->model->fullValidate($incoming);
            $data = $fullValidate;
            if( count($data) == 0 ){
                if( $this->model->updateUser($incoming) ){
                    $data = [
                        'success' => 1,
                        'message' => 'User saved in both systems!'
                    ];
                }else{
                    $data = [
                        'success' => 0,
                        'message' => 'Can not save user'
                    ];
                }
            }
        }
        $this->view->generate('set_view.php', 'empty_view.php', $data);
    }

   
    
}