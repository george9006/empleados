<?php

$servidor= "mysql:dbname=empresa;host=127.0.0.1";
$usuario="root";
$password="";

try{

	$pdo= new PDO($servidor,$usuario,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));

	//echo "Conectado...";

} catch(PDOExeption $e){

echo "conexion mala".$e->getMessage();

}

?>