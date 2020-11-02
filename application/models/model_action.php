<?php

namespace application\models;
use application\models\Model_CRM;
use application\models\Model_Billing;


class Model_action
{

    public $crm;
    public $billing;

    function __construct()
    {
        require_once('application/models/model_crm.php');
        $this->crm = new Model_CRM(CRM['SERVER'], CRM['DB'], CRM['UID'], CRM['PWD']);
        require_once('application/models/model_billing.php');
        $this->billing = new Model_CRM(BILLING['SERVER'], BILLING['DB'], BILLING['UID'], BILLING['PWD']);
    }

    function getCRMData(){
        return $this->crm->getData();
    }

    function getBillingData(){
        return $this->billing->getData();
    }


}