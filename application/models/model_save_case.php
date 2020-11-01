<?php
/**
 * Created by PhpStorm.
 * User: medyancev
 * Date: 24.11.2017
 * Time: 9:06
 */






class Model_save_case extends Model
{

    public function save_case( $data )
    {
//        print_r($_SESSION);
        $res['res'] = false;
        $user = $_SESSION['user'];
        $connect_data = parent::DBConnData( "FRAUD_BASE" );
        $db = parent::MySQLConnect($connect_data, $charset = 'utf8', '');


        $stmt1 = $db->prepare("INSERT into acq_cases (
                                              UUID,
                                              USER,
                                              CASE_DATE_TIME_LOCAL,
                                              CASE_DATE_TIME_MSK,
                                              TERMINAL_ID,
                                              TERMINAL_NAME,
                                              TERMINAL_ADDR,
                                              OPEN_DATE,
                                              MERCHANT_ID,
                                              MERCHANT_NAME,
                                              MERCHANT_ADDR,
                                              MCC,
                                              OWNER,
                                              PHONE,
                                              CASE_OPERS_COUNT,
                                              CASE_COMMENTS_COUNT,
                                              CASE_FUNDS_COUNT,
                                              CASE_FUNDS_STATUS,
                                              CASE_FRAUD_DECISION,
                                              CASE_STATUS,
                                              OWS,
                                              SAVED_DATE_TIME_LOCAL,
                                              SAVED_DATE_TIME_MSK
                                            ) values (
                                              :UUID,
                                              :USER,
                                              :CASE_DATE_TIME_LOCAL,
                                              :CASE_DATE_TIME_MSK,
                                              :TERMINAL_ID,
                                              :TERMINAL_NAME,
                                              :TERMINAL_ADDR,
                                              :OPEN_DATE,
                                              :MERCHANT_ID,
                                              :MERCHANT_NAME,
                                              :MERCHANT_ADDR,
                                              :MCC,
                                              :OWNER,
                                              :PHONE,
                                              :CASE_OPERS_COUNT,
                                              :CASE_COMMENTS_COUNT,
                                              :CASE_FUNDS_COUNT,
                                              :CASE_FUNDS_STATUS,
                                              :CASE_FRAUD_DECISION,
                                              :CASE_STATUS,
                                              :OWS,
                                              :SAVED_DATE_TIME_LOCAL,
                                              :SAVED_DATE_TIME_MSK
                                            )");
        $stmt1->execute(array(
            ':UUID'=>$data['caseData']['uuid'],
            ':USER'=>$user,
            ':CASE_DATE_TIME_LOCAL'=>$data['fraud']['date_time'],
            ':CASE_DATE_TIME_MSK'=>$data['fraud']['date_time_msk'],
            ':TERMINAL_ID'=>$data['term']['id'],
            ':TERMINAL_NAME'=>$data['term']['name'],
            ':TERMINAL_ADDR'=>$data['term']['addr'],
            ':OPEN_DATE'=>$data['term']['open_date'],
            ':MERCHANT_ID'=>$data['term']['merchant_id'],
            ':MERCHANT_NAME'=>$data['term']['merchant_name'],
            ':MERCHANT_ADDR'=>$data['term']['merchant_addr'],
            ':MCC'=>$data['term']['merchant_mcc'],
            ':OWNER'=>$data['term']['merchant_owner'],
            ':PHONE'=>$data['term']['merchant_phone'],
            ':CASE_OPERS_COUNT'=>$data['caseData']['opers_count'],
            ':CASE_COMMENTS_COUNT'=>$data['caseData']['comments_count'],
            ':CASE_FUNDS_COUNT'=>$data['fraud']['funds_count'],
            ':CASE_FUNDS_STATUS'=>$data['fraud']['funds_status'],
            ':CASE_FRAUD_DECISION'=>$data['fraud']['fraud_decision'],
            ':CASE_STATUS'=>$data['fraud']['case_status'],
            ':OWS'=>$data['caseData']['system'],
            ':SAVED_DATE_TIME_LOCAL'=>$data['caseData']['saved_dt_local'],
            ':SAVED_DATE_TIME_MSK'=>$data['caseData']['saved_dt_msk']
        ));
//var_dump($stmt1);

        @$comments = $data['comments'];
        if(count($comments)>0) {
            $insertQuery1 = array();
            $insertData1 = array();
            foreach ($comments as $row) {
                $insertQuery1[] = '(?, ?, ?, ?, ? )';
                $insertData1[] = null;
                $insertData1[] = $data['caseData']['uuid'];
                $insertData1[] = $row['DATE_TIME'];
                $insertData1[] = $row['COMMENT_TEXT'];
                $insertData1[] = $user;
            }
            if (!empty($insertQuery1)) {
                $add_sql = implode(', ', $insertQuery1);
                $stmt1 = $db->prepare("INSERT INTO acq_case_comments VALUES " . $add_sql);
                $stmt1->execute($insertData1);
            }
        }

        $opers = $data['opers'];
        if(count($opers)>0) {
            $insertQuery2 = array();
            $insertData2 = array();
            foreach ($opers as $row) {
                $insertQuery2[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)';
                $insertData2[] = null;
                $insertData2[] = $data['caseData']['uuid'];
                $insertData2[] = $row['AMND_DATE'];
                $insertData2[] = $row['POSTING_DATE'];
                $insertData2[] = $row['TRANS_DATE'];
                $insertData2[] = $row['RRN'];
                $insertData2[] = $row['AUTH_CODE'];
                $insertData2[] = $row['RETURN_CODE'];
                $insertData2[] = $row['TRANS_TYPE'];
                $insertData2[] = $row['TRANS_CONDITION'];
                $insertData2[] = $row['IS_AUTHORIZATION'];
                $insertData2[] = $row['TARGET_NUMBER'];
                $insertData2[] = $row['TRANS_AMOUNT'];
                $insertData2[] = $row['TRANS_CURR'];
                $insertData2[] = $row['MCC'];
                $insertData2[] = $row['FULL_MCC'];
                $insertData2[] = $row['MEMBER_ID'];
                $insertData2[] = $row['ICA_NUMBER'];
                $insertData2[] = $row['SC_STAT'];
                $insertData2[] = $row['DATE_TIME_LOCAL'];
                $insertData2[] = $row['DATE_TIME_MSK'];
                $insertData2[] = $user;
            }
            if (!empty($insertQuery2)) {
                $add_sql_2 = implode(', ', $insertQuery2);
                $stmt1 = $db->prepare("INSERT INTO acq_case_operations VALUES " . $add_sql_2);
                $stmt1->execute($insertData2);
            }
        }

        $errs = $db->errorInfo();
//        print_r($errs);
        if( $errs[0]!='00000'  ){
            $res['err'] = $db->errorInfo();
        }else{
            $res['res'] = true;
        }
        parent::OraDisconnect( $connect_data );
        return $res;


    }


}

?>