<?php

class Connection2{

    private $con, $lang;

    function __construct($lang)
    {
        $this->lang = strtoupper($lang);
    }

    function connect(){

        include 'Constants.php';

        try{
            $db_name = $this->lang.'_DB_NAME';
            $db_user = $this->lang.'_DB_USER';
            $db_pass = $this->lang.'_DB_PASS';

            $this->con = new PDO('mysql:host='.$connection_data['DB_HOST'].';dbname='.$connection_data[$db_name].';charset=utf8',$connection_data[$db_user],$connection_data[$db_pass]);
            return $this->con;
        }
        catch(exception $e){
            echo "error ".$e->getMessage();
            return null;
        }
    }

    function disconnect(){
        $this->con = null;
    }

}