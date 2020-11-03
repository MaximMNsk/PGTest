<?php

namespace application\models;


class Model_CRM extends Model
{

    function getUser(){
        $dataSql = 'SELECT  TOP(1) employee.employeeId, employee.firstName, employee.lastName, employee.timekeeperIdentifier, email.employeeId AS Expr1, email.email, email.[primary]
                    FROM    employee LEFT OUTER JOIN
                            email ON employee.employeeId = email.employeeId
                    WHERE   (employee.timekeeperIdentifier IS NULL)
                    ORDER BY email.[primary] DESC';
        $o['q']='select';
        return parent::makeRequest($dataSql, $o);
    }

    function updateUser(int $id, string $identifyer){
        $dataSql = 'UPDATE employee 
                    SET timekeeperIdentifier = ?
                    WHERE employeeId = ?';
        $o['q']='update';
        $o['params'] = [
            0 => $identifyer,
            1 => $id,
        ];
        return parent::makeRequest($dataSql, $o);
    }

    function addEmail(int $id, string $email){
        $dataSql = 'INSERT INTO email (employeeId, email, [primary]) 
                    SELECT ? AS employeeId, ? AS email, ? AS [primary]
                    WHERE NOT EXISTS
                    (SELECT employeeId, email, [primary] FROM email where employeeId=?)';
        $o['q']='insert';
        $o['params'] = [
            0 => $id,
            1 => $email,
            2 => 'True',
            3 => $id,
        ];
        return parent::makeRequest($dataSql, $o);
    }

}