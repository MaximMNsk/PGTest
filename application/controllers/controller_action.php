<?php

namespace application\controllers;

use application\models\Model_action;
use application\views\View;

class Controller_Action extends Controller
{

    function __construct()
    {
        // $this->modelCRM = new Model_CRM;
        $this->model = new Model_action;
        $this->view = new View;
    }

    public function action_index()
    {
        // $data = $this->model->getCRMUser();
        $data = $this->model->updateCRMUser(7, 'Test', 'e@ma.il');
        $this->view->generate('action_view.php', 'template_view.php', $data);
    }

    private function isAuth()
    {
        // if()
    }
}