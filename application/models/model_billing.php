<?php

namespace application\models;


class Model_Billing extends Model
{

    
    function getData(){
        $dataSql = 'SELECT TOP (200) employeeId, email, [primary] FROM email';
        $o['q']='select';
        return parent::makeRequest($dataSql, $o);
    }

}