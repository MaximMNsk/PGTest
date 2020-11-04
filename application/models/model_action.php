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

    function updateCRMUser(int $id, string $identifyer, string $email){ // true, false
        if( $this->crm->updateUser($id, $identifyer) != false ){
            return $this->crm->addEmail($id, $email);
        }
        return false;
    }

    function getBillingUser(){
        return $this->billing->getData();
    }
    
    function validate(){
        return $this->validate;
    }

    function fullValidate(array $a){
        $valEmail = $this->validate->email($a['email']);
        $valIdentifyer = $this->validate->identifyer($a['identifyer']);
        $valFullName = $this->validate->fullName($a['fullName']);
        $valRate = $this->validate->rate($a['rate']);
        if( $valEmail['success']==0 ) $res[] = $valEmail;
        if( $valIdentifyer['success']==0 ) $res[] = $valIdentifyer;
        if( $valFullName['success']==0 ) $res[] = $valFullName;
        if( $valRate['success']==0 ) $res[] = $valRate;
        $res[] = [
            'success' => 1,
            'message' => 'Successfully completed',
        ];
        return $res;
    }

}