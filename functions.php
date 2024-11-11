<?php

	function connect(){
        $mysqli = new mysqli('localhost', 'root', '', 'honda');
        if($mysqli->connect_errno != 0){
           return $mysqli->connect_error;
        }else{
           $mysqli->set_charset("utf8mb4");	
        }
        return $mysqli;
     }

     function getAllSpec(){
        $mysqli = connect();
        $res = $mysqli->query("SELECT * FROM specifications ORDER BY ModelType ASC");
        while($row = $res->fetch_assoc()){
            $spec[] = $row;
        }
        return $spec;
    }

    function getSpec($category){
        $mysqli = connect();
        $res = $mysqli->query("SELECT * FROM specifications WHERE Model= '$category'");
        while($row = $res->fetch_assoc()){
            $spec[] = $row;
        }
        return $spec;
    }

?>