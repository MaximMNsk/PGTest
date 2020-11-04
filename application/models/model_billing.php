<?php

namespace application\models;


class Model_Billing extends Model
{

    
    function getData(){
        $dataSql = 'SELECT * FROM timekeeper';
        $o['q']='select';
        return parent::makeRequest($dataSql, $o);
    }


    function addItem($a){
        $dataSql = 'INSERT INTO timekeeper (identifier, fullName, email, rate) 
                    VALUES (?, ?, ?, ?)';
        $o['q']='insert';
        $o['params'] = [
            0 => $a['identifier'],
            1 => $a['fullName'],
            2 => $a['email'],
            3 => $a['rate'],
        ];
        return parent::makeRequest($dataSql, $o);
    }

}