<?php
    class db{
        private $dbhost='localhost';
        private $dbuser='root';
        private $dbpass='';
        private $dbname='restapi';

        public function connect(){
            $msql_connect_str="mysql:host=$this->dbhost;dbname=$this->dbname;";
            $dbConnection=new PDO($msql_connect_str,$this->dbuser,$this->dbpass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        }
    }