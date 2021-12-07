<?php
require_once 'conexao.php';

$id = isset($_GET['id']) ? addslashes($_GET['id']) : 0;

if($id > 0) {
	$result = $mysqli->query("DELETE FROM clientes WHERE id = $id");
	echo $mysqli->affected_rows;
}
?>