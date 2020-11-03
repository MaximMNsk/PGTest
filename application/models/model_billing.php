<?php

namespace application\models;


class Model_Billing extends Model
{

    
    function getData(){
        $dataSql = 'SELECT * FROM timekeeper';
        $o['q']='select';
        return parent::makeRequest($dataSql, $o);
    }

}