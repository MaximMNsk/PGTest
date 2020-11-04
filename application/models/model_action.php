<?php

namespace application\models;
use application\models\Model_CRM;
use application\models\Model_Billing;
use application\models\Model_Validate;


class Model_action
{

    public $crm;
    public $billing;
    public $validate;

    function __construct()
    {
        require_once('application/models/model_crm.php');
        $this->crm = new Model_CRM(CRM['SERVER'], CRM['DB'], CRM['UID'], CRM['PWD']);
        require_once('application/models/model_billing.php');
        $this->billing = new Model_Billing(BILLING['SERVER'], BILLING['DB'], BILLING['UID'], BILLING['PWD']);
        require_once('application/models/model_validate.php');
        $this->validate = new Model_Validate;
    }

    function getCRMUser(){
        return $this->crm->getUser(); // false, [], [data]
    }


    function updateUser($a){
        $res = true;
        if( $this->crm->prepareRequests() ){
            if( !$this->crm->updateUser($a['id'], $a['identifier']) ){
                $res = false;
            }
            if( !$this->crm->addEmail($a['id'], $a['email']) ){
                $res = false;
            }
        }else{
            $res = false;
        }
        if( $this->billing->prepareRequests() ){
            if( !$this->billing->addItem($a) ){
                $res = false;
            }
        }else{
            $res = false;
        }
        if( !$res ){
            $this->crm->rollbackRequest();
            $this->billing->rollbackRequest();
            return false;
        }else{
            $this->crm->commitRequest();
            $this->billing->commitRequest();
            return true;
        }
    }


    function validate(){
        return $this->validate;
    }

    function fullValidate(array $a){
        $res = [];
        $valEmail = $this->validate->email($a['email']);
        $valIdentifier = $this->validate->identifier($a['identifier']);
        $valFullName = $this->validate->fullName($a['fullName']);
        $valRate = $this->validate->rate($a['rate']);
        if( $valEmail['success']==0 ) $res[] = $valEmail;
        if( $valIdentifier['success']==0 ) $res[] = $valIdentifier;
        if( $valRate['success']==0 ) $res[] = $valRate;
        return $res;
    }

    function arrToUtf8(array $a){
        $r = [];
        foreach($a as $k=>$v){
            $r[$k] = mb_convert_encoding($v, 'utf8', 'cp1251');
        }
        return $r;
    }

    function arrToCp1251(array $a){
        $r = [];
        foreach($a as $k=>$v){
            $r[$k] = mb_convert_encoding($v, 'cp1251', 'utf8');
        }
        return $r;
    }

}