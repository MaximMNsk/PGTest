<?php

namespace application\controllers;
use application\views\View;

class Controller_Action
{

    function __construct()
    {
//        $this->model = new Model_Main();
        $this->view = new View();
    }

    public function action_index()
    {
        $data = [];
        $this->view->generate('action_view.php', 'template_view.php', $data);
    }

    private function isAuth()
    {
        // if()
    }
}