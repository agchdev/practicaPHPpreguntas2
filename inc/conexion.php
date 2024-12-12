<?php
    // $host = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "practica2";

    try{
        $conexion = new mysqli('localhost','root','','practica2');
    }catch(PDOException $e){
        echo "Ha ocurrido el error: ".$e->getMessage();
    }
?>