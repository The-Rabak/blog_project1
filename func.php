<?php
require_once "consts.php";
if(!function_exists("db_connect")){
    function db_connect(){
        if($link = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PWD,MYSQL_DB)){
            return $link;
        }
        else{
            die("DB connection has failed");
        }
    }
}