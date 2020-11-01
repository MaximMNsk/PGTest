<?php


trait OraDB
{
    function OraConnect($connect_data, $charset=null, $user=null ){
        if( $charset ) {
            $chset = ';charset='.$charset;
        } else {
            $chset = $charset ;
        }
        $final_connect_data = array();
        if( count( $connect_data ) > 0 ){
            if($user){
                foreach( $connect_data as $v ){
                    if( $user = $v['user'] ){
                        $final_connect_data = $v;
                    }
                }
            }else{
                $final_connect_data = $connect_data[0];
            }
//            var_dump($final_connect_data);
            $dbc = new PDO('oci:dbname='.$final_connect_data['db_name'].$chset,
                $final_connect_data['user'],
                $final_connect_data['pwd']);
            return $dbc;
        }else{
            return false;
        }
    }

    function OraStatement( $dbconnection, $query ){

    }

    function OraDisconnect( $dbconnection ){
        $dbconnection=null;
    }
}

trait MysqlDB
{
    function MySQLConnect( $connect_data, $charset=null, $user=null){
//        $connection = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'root', 'root');
        if( $charset ) {
            $chset = ';charset='.$charset;
        } else {
            $chset = $charset ;
        }
        $final_connect_data = array();
        if( count( $connect_data ) > 0 ){
            if($user){
                foreach( $connect_data as $v ){
                    if( $user = $v['user'] ){
                        $final_connect_data = $v;
                    }
                }
            }else{
                $final_connect_data = $connect_data[0];
            }
//            print_r( $final_connect_data );
            $dbc = new PDO('mysql:dbname='.$final_connect_data['db_name']
                .';host='.$final_connect_data['db_host']
                .$chset
                ,$final_connect_data['user']
                ,$final_connect_data['pwd']
            );
            return $dbc;
        }else{
            return false;
        }

    }

    function MakeInsertToMysql($ins_sql,$c){
        $stmt = $c->prepare($ins_sql);
        $result = $stmt->execute();
        $errs = $c->errorInfo();
        $res = implode(', ', $errs);
        return $res;
    }

    function MakeSelectToMysql($sel_sql,$c){
        $stmt = $c->prepare($sel_sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function MySQLDisconnect( $connect ){
        $connect=null;
    }
}

trait FillConst
{

    private function FileConnData( $sys1 ){
        $db_all = fopen($this->db_conf_file,"r");
        while(!feof($db_all)){
            $vd = fgets($db_all,1024);
            if(substr($vd,0,strpos($vd,'|')) == $sys1){
                $db_conn_data[] = trim(str_replace($sys1.'|','',$vd));
            }
        }
        fclose($db_all);
        return $db_conn_data;
    }


    function DBConnData( $sys1 ){
        $db_data = null;
        $c = $this->ConnToSelf();
        $sql = "SELECT * FROM connections where IS_ACTIVE='Y' and OLD_NAME='$sys1'";
        $data = $this->MakeSelectToMysql($sql,$c);
        // var_dump($c);
        foreach( $data as $k=>$v )
        {
            // OWS|medyancevdev:Maxdev_1234567890@OWS.PROD
//            $trailer = ($v['TYPE']=='mysql') ? $v['HOST'].'.'.$v['DB'] : $v['DB'] ;
//            $db_conn_data[] = $v['LOGIN'].':'.$v['PWD'].'@'.$trailer;
            $db_data[$k]['user'] = $v['LOGIN'];
            $db_data[$k]['pwd'] = $v['PWD'];
            $db_data[$k]['db_host'] = $v['HOST'];
            $db_data[$k]['db_name'] = $v['DB'];
        }
//         var_dump($db_conn_data);
        return $db_data;
    }





}

class Model
{
    use OraDB, MysqlDB, FillConst;

    function __construct(){
        $this->db_conf_file = '../conf/db.conf';
        $this->DBSelf = 'MAIN_BASE';
    }

    function ConnToSelf()
    {
        $connect_data = $this->FileConnData($this->DBSelf);
        foreach($connect_data as $k=>$d){
            $dbuser = substr($d, 0, strpos($d, ':'));
            $dbpwd = substr(str_replace($dbuser.':','',$d),0,strpos(str_replace($dbuser.':','',$d),'@'));
            $dbname = trim(  substr( strstr(  str_replace($dbuser.':'.$dbpwd.'@','',$d), '.') ,1)  );
            $dbhost = trim(str_replace(array($dbuser.':'.$dbpwd.'@', '.'.$dbname),'',$d));
        }

        $charset = 'utf8';

        $dbc = new PDO("mysql:dbname=$dbname;host=$dbhost;charset=$charset"
            ,$dbuser
            ,$dbpwd
        );

        return $dbc;
    }


    /*
        Модель обычно включает методы выборки данных, это могут быть:
            > методы нативных библиотек pgsql или mysql;
            > методы библиотек, реализующих абстракицю данных. Например, методы библиотеки PEAR MDB2;
            > методы ORM;
            > методы для работы с NoSQL;
            > и др.
    */

    // метод выборки данных
    public function get_data()
    {
        // todo
    }


    public function get_excel_file( $filename=null, $data_arr=null )
    {
        if( $filename && $data_arr )
        {

        }
    }



}

?>

