<?php
require_once 'conexao.php';

$order    = isset($_GET['order']) ? addslashes($_GET['order']) : 'nome';
$result   = $mysqli->query("SELECT * FROM clientes order by $order");

if($order == 'nome') {
	$setaID   = '';
	$setaNome = "<i class=\"bi bi-arrow-down\"></i>";
} else {
	$setaID   = "<i class=\"bi bi-arrow-down\"></i>";
	$setaNome = '';
}	

?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>Cadastro Kevyn</title>
  </head>
  <body>
	<br><br>
	<div class="container">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Clientes</li>
		  </ol>
		</nav>

		<a class="btn btn-dark" href="cadastro.php" role="button" aria-label="Mute">
			<i class="bi bi-plus-lg"></i>
			Novo
		</a><br><hr>
		
		<table class="table table-striped table-hover table-bordered table-sm">
		  <thead class="table-dark">
			<tr>
			  <th scope="col"><a class="text-light" href="clientes.php?order=id">ID</a> <?php echo $setaID;?></th>
			  <th scope="col"><a class="text-light" href="clientes.php?order=nome">Nome</a> <?php echo $setaNome;?></th>
			  <th scope="col">Email</th>
			  <th scope="col">Data Nascimento</th>
			  <th scope="col">Sexo</th>			  
			  <th scope="col">Necessidades</th>
			  <th scope="col">Opções</th>
			</tr>
		  </thead>
		  <tbody>
		  
<?php

if($result->num_rows == 0) {
	echo 'Sem registros';
} else {

	while ($obj = $result->fetch_object()) {
		$id           = $obj->id;
		$nome         = $obj->nome;
		$email        = $obj->email;
		$sexo         = $obj->sexo == 'm' ? "Masculino <i class=\"fas fa-mars\"></i>" : "Feminino <i class=\"fas fa-venus\">";
		$data         = implode('/', array_reverse(explode('-', $obj->data_nascimento)));
		$necessidades = $obj->necessidades;
		
		$data_nasc    = explode('-', $obj->data_nascimento);
		$idade        = date('Y') - $data_nasc[0];
		if(date('m') < $data_nasc[1]) {
			$idade = $idade - 1;
		} elseif(date('m') == $data_nasc[1] && date('d') <= $data_nasc[2]) {
			$idade = $idade - 1;
		}		
		
		$sexoM = $sexo == 'm' ? 'checked' : '';
		$sexoF = $sexo == 'f' ? 'checked' : '';

		$necessidadeV    = '';
		$necessidadeA    = '';
		$necessidadeF    = '';

		if(strpos($necessidades, 'V') !== false) {
			$necessidadeV = "<i class=\"bi bi-eye\" data-bs-toggle=\"tooltip\" data-bs-html=\"true\" data-bs-placement=\"bottom\" title=\"<b>Deficiente visual</b>\"></i>";
		}
		
		if(strpos($necessidades, 'A') !== false) {
			$necessidadeA = "<i class=\"bi bi-ear\" data-bs-toggle=\"tooltip\" data-bs-html=\"true\" data-bs-placement=\"bottom\" title=\"<b>Deficiente auditivo</b>\"></i>";
		}

		if(strpos($necessidades, 'F') !== false) {
			$necessidadeF = "<i class=\"fa-solid fa-wheelchair\" data-bs-toggle=\"tooltip\" data-bs-html=\"true\" data-bs-placement=\"bottom\" title=\"<b>Deficiente fisico</b>\"></i>";
		}
		
		echo "
			<tr>
				<th scope=\"row\">$id</th>
				<td>$nome</td>
				<td>$email</td>
				<td>$data ($idade anos)</td>
				<td>$sexo</td>
				<td>
					$necessidadeV
					$necessidadeA
					$necessidadeF					
				</td>			  
				<td>
					<a class=\"btn btn btn-outline-success btn-sm\" href=\"cadastro.php?id=$id\" role=\"button\" aria-label=\"Mute\">
						<i class=\"bi bi-pencil\"></i>
					</a> 
					<a class=\"btn btn btn-outline-danger btn-sm\" href=\"#\" role=\"button\" aria-label=\"Mute\" onclick=\"deletar($id)\">
						<i class=\"bi bi-trash\"></i>
					</a>
				</td>
			</tr>";
	}
}
?>		  

		  </tbody>
		</table>
	</div>
	
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script>
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
			return new bootstrap.Tooltip(tooltipTriggerEl)
		})
	</script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
	
	function deletar(id) {
		Swal.fire({
			title: 'Você deseja deletar?',
			text: "Essa ação não poderá ser revertida!",
			icon: 'question',
			showCancelButton: true,
			cancelButtonText: 'Não!',
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sim!'
			}).then((result) => {
			if (result.isConfirmed) {
				fetch('deletar.php?id=' + id)
				.then(data => {
					Swal.fire({
					  icon: 'success',
					  title: 'Deletado com sucesso!',
					  showConfirmButton: false					  
					})
					
					setInterval(function() { 
						location.reload(true); 
					}, 1000);
				});				
			}
		})
	}
	</script>
  </body>
</html>