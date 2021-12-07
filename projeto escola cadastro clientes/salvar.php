<?php
require_once 'conexao.php';
require_once 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id  = isset($_POST['id']) ? $_POST['id'] : '';
	
	if($id > 0) {
		$sql = "UPDATE `clientes` SET `nome` = ?, `sexo` = ?, `data_nascimento` = ?, `email` = ?, `necessidades` = ? WHERE id = ?;";	
	} else {
		$sql = "INSERT INTO clientes VALUES (NULL, ?, ?, ?, ?, ?)";
	}
	
	
	$nome  = isset($_POST['nome']) ? str_ucwords($_POST['nome']) : '';
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$sexo  = isset($_POST['sexo']) ? $_POST['sexo'] : '';
	$data  = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : '';	
	
	$necessidades = [];
	
	$visual   = isset($_POST['visual']) ? $_POST['visual'] : '';
	$auditivo = isset($_POST['auditivo']) ? $_POST['auditivo'] : '';
	$fisico   = isset($_POST['fisico']) ? $_POST['fisico'] : '';
	
	if($visual != '') {
		$necessidades[] = 'V';	
	}
	if($auditivo != '') {
		$necessidades[] = 'A';	
	}
	if($fisico != '') {
		$necessidades[] = 'F';	
	}	
	$necessidades = implode(',', $necessidades);	
	
	$stmt = $mysqli->prepare($sql);
	if($id > 0) {
		$stmt->bind_param('sssssd', $nome, $sexo, $data, $email, $necessidades, $id);
	} else {
		$stmt->bind_param('sssss', $nome, $sexo, $data, $email, $necessidades);
	}	
	
	$stmt->execute();	
	$stmt->close();
	
	header('Location: clientes.php');
}

?>