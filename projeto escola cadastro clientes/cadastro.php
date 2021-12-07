<?php
require_once 'conexao.php';

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$titulo          = 'Cadastro de Cliente';
$titulo2         = 'Cadastro de Cliente';
$nome            = '';
$sexo            = '';
$data_nascimento = '';
$email           = '';
$necessidades    = '';
$sexoM           = 'checked';
$sexoF           = '';
$necessidadeV    = '';
$necessidadeA    = '';
$necessidadeF    = '';
$campoHidden     = '';

if($id > 0) {
	$stmt = $mysqli->prepare("SELECT nome, sexo, data_nascimento, email, necessidades FROM clientes WHERE id=?");
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$stmt->bind_result($nome, $sexo, $data_nascimento, $email, $necessidades);
	$stmt->fetch();
	$stmt->close();
	
	$sexoM = $sexo == 'm' ? 'checked' : '';
	$sexoF = $sexo == 'f' ? 'checked' : '';
	
	if(strpos($necessidades, 'V') !== false) {
		$necessidadeV = 'checked';
	}
	
	if(strpos($necessidades, 'A') !== false) {
		$necessidadeA = 'checked';
	}

	if(strpos($necessidades, 'F') !== false) {
		$necessidadeF = 'checked';
	}
	
	$titulo      = "Edição de Cliente id = $id";
	$titulo2     = 'Edição de Cliente';
	$campoHidden = "<input type=\"hidden\" name=\"id\" value=\"$id\" />";
}
?>
<!doctype html>
<html lang="pt-br">
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
			<li class="breadcrumb-item"><a href="clientes.php">Clientes</a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php echo $titulo2;?></li>
		  </ol>
		</nav><hr>
		
		<div class="card">
			<form action="salvar.php" method="post">
			  <?php echo $campoHidden ;?>
			  <h5 class="card-header"><?php echo $titulo;?></h5>
			  <div class="card-body">
				<div class="mb-3">
					<label for="nome" class="form-label">Nome</label>
					<input type="text" class="form-control" name="nome" id="nome" value="<?php echo $nome;?>" autofocus required>
				</div>
				<div class="mb-3">
					<label for="email" class="form-label">Email</label>
					<input type="email" class="form-control" name="email" id="email" value="<?php echo $email;?>" required>
				</div>
				<div class="mb-3">
					<label for="data_nascimento" class="form-label">Data Nascimento</label>
					<input type="date" class="form-control" id="data_nascimento" name="data_nascimento" min="1931-01-01" max="2005-12-31" value="<?php echo $data_nascimento;?>" required>
				</div>
				
				<label for="radio" class="form-label">Sexo</label>				
				<div class="form-check" style="cursor:pointer">
				  <input class="form-check-input" type="radio" name="sexo" value="m" id="flexRadioDefault1" <?php echo $sexoM;?>>
				  <label class="form-check-label" for="flexRadioDefault1" style="cursor:pointer">
					Masculino
				  </label>
				</div>
				<div class="form-check" >
				  <input class="form-check-input" type="radio" name="sexo" value="f" id="flexRadioDefault2" <?php echo $sexoF;?>>
				  <label class="form-check-label" for="flexRadioDefault2" style="cursor:pointer">
					Feminino
				  </label>
				</div>
				<br>
				
				<label for="radio" class="form-label">Necessidades especiais</label>
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" name="visual" value="V" id="visual" <?php echo $necessidadeV;?>>
				  <label class="form-check-label" for="visual" style="cursor:pointer">
					<i class="bi bi-eye"></i>
					<b>Deficiente visual</b>
				  </label>
				</div>
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" name="auditivo" value="A" id="auditivo" <?php echo $necessidadeA;?>>
				  <label class="form-check-label" for="auditivo" style="cursor:pointer">
					<i class="bi bi-ear"></i>
					<b>Deficiente auditivo</b>
				  </label>
				</div>
				<div class="form-check">
				  <input class="form-check-input" type="checkbox" name="fisico" value="F" id="fisico" <?php echo $necessidadeF;?>>
				  <label class="form-check-label" for="fisico" style="cursor:pointer">
					<i class="fa-solid fa-wheelchair"></i>
					<b>Deficiente fisico</b>
				  </label>
				</div><br>
				
				<button type="submit" class="btn btn-primary">
					<i class="bi bi-check-lg"></i>
					Salvar
				</button>				
			  </div>
			 </form>
		</div>
		<img src="img/imagem.jpg">
	</div>
	
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>