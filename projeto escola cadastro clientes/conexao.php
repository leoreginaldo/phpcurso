<?php
$servidor = 'localhost';
$usuario  = 'root';
$senha    = '';
$db       = 'evento';

$mysqli = new mysqli($servidor, $usuario, $senha, $db);

if($mysqli->connect_errno){
	die($mysqli->connect_error);
}

?>
