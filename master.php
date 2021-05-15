<?php

//Verificar se a sessão não já está aberta.
if (!isset($_SESSION)) {
	// Iniciando a sessao
	session_start();
}

// Recebendo valores da sessao
$UsuarioTela = $_SESSION['UsuarioTela'];
$UsuarioSenha = $_SESSION['UsuarioSenha'];
$idUsuario = $_SESSION['idUsuario'];
$TipoAcesso = $_SESSION['tipoAcesso'];

// Incluindo conexao
include('PHP/conexao.php');

// Select buscando pelas informações do Usuario 
    $selectUsuarios = mysqli_query($con, "

        SELECT * FROM tb_usuarios
        where idUsuario = '" . $idUsuario . "'

    ") or die(mysqli_error($con));

    // While percorrendo informações
    while ($rowUsuarios = mysqli_fetch_array($selectUsuarios)) {

        $LoginUsuario = $rowUsuarios['loginUsuario'];
        $EmailUsuario = $rowUsuarios['emailUsuario'];
        $SenhaUsuario = $rowUsuarios['senhaUsuario'];
        $TipoAcesso = $rowUsuarios['tipoAcesso'];
        $idPessoa = $rowUsuarios['idPessoa'];
	}

// 

// Select buscando pelas informações da pessoa
    $selectPessoas = mysqli_query($con, "

        SELECT * FROM tb_pessoas
        where idPessoa = '" . $idPessoa . "'

    ") or die(mysqli_error($con));

    // While percorrendo informações
    while ($rowPessoas = mysqli_fetch_array($selectPessoas)) {

        $NomeUsuario = $rowPessoas['nomePessoa'];

    }
// 

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- Icone favIcon -->
	<link rel="shortcut icon" href="<?= $raiz ?>Imagens/logo.png" type="image/x-icon" />

	<!-- Imagens -->
	<link href="<?= $raiz ?>Imagens/logo.png" rel="stylesheet" type="text/css" />
	
	<!-- Logo CSS -->
	<link href="<?= $raiz ?>CSS/logo.css" rel="stylesheet" type="text/css" />

	<!-- Loader CSS -->
	<link href="<?= $raiz ?>CSS/loader.css" rel="stylesheet" type="text/css" />

	<!-- Menu CSS -->
	<link href="<?= $raiz ?>CSS/menu.css" rel="stylesheet" type="text/css" />

	<!-- DataTable CSS -->
	<link href="<?= $raiz ?>CSS/datatable.css" rel="stylesheet" type="text/css" />

	<!-- Login CSS -->
	<link href="<?= $raiz ?>CSS/login.css" rel="stylesheet" type="text/css" />

	<!-- Modal CSS -->
	<link href="<?= $raiz ?>CSS/modal.css" rel="stylesheet" type="text/css" />

	<!-- jQuery -->
	<script type="text/javascript" src="<?= $raiz ?>jQuery/jquery.js"></script>

	<!-- JQuery Validation -->
	<script type="text/javascript" src="<?= $raiz ?>jQuery/Validate/jquery.validate.js"></script>
	<script type="text/javascript" src="<?= $raiz ?>jQuery/Validate/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?= $raiz ?>jQuery/Validate/additional-methods.js"></script>
	<script type="text/javascript" src="<?= $raiz ?>jQuery/Validate/additional-methods.min.js"></script>

	<!-- jQuery Toastr -->
	<link href="<?= $raiz ?>jQuery/Toastr/toastr.css" rel="stylesheet"/>
	<link href="<?= $raiz ?>jQuery/Toastr/toastr.min.css" rel="stylesheet"/>
	<script type="text/javascript" src="<?= $raiz ?>jQuery/Toastr/toastr.min.js"></script>
	<script type="text/javascript" src="<?= $raiz ?>jQuery/Toastr/toastr.js.map"></script>

	<!-- Chart -->
	<script type="text/javascript" src="<?= $raiz ?>Chart/Chart.js"></script>
	<script type="text/javascript" src="<?= $raiz ?>Chart/Chart.min.js"></script>
	<script type="text/javascript" src="<?= $raiz ?>Chart/Chart.bundle.js"></script>
	<script type="text/javascript" src="<?= $raiz ?>Chart/Chart.bundle.min.js"></script>

	<!-- DataTable -->
	<link rel="stylesheet" type="text/css" href="<?= $raiz ?>DataTables/datatables.min.css" />
	<script type="text/javascript" src="<?= $raiz ?>DataTables/datatables.min.js"></script>

	<!-- Bootstrap -->
	<link href="<?= $raiz ?>Bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?= $raiz ?>Bootstrap/js/bootstrap.min.js"></script>

	<!-- Font awesome -->
	<link href="<?= $raiz ?>fontawesome/css/all.css" rel="stylesheet">
	<script defer src="<?= $raiz ?>fontawesome/js/all.js"></script>

	<!-- Titulo -->
	<title><?php echo $pagetitle; ?></title>
</head>

<body onload="myFunction()" style="margin:0;">
	<div class="wrapper">

		<!-- Sidebar Header -->
		<nav id="sidebar">
			<div class="sidebar-header">
				<img class="logoMenu" src="<?= $raiz ?>Imagens/logo.png"> 
			</div>

			<!-- Header dentro da variavel -->
			<ul class="list-unstyled components">
				<p><?php echo $pageheader; ?></p>
				<li class="homePage">
					<a href="<?= $raiz ?>Telas/Home/homePage.php" ><i class="fas fa-home"></i> Home</a>
				</li>
				<li class="datatable-patrimonios">
					<!-- Patrimônios -->
					<a href="<?= $raiz ?>Telas/Patrimonios/Table/datatable-patrimonios.php"><i class="fas fa-align-left"></i> Patrimônios</a>
				</li>
				<li class="datatable-locais">
					<!-- Locais -->
					<a href="<?= $raiz ?>Telas/Locais/Table/datatable-locais.php"><i class="fas fa-warehouse"></i> Locais</a>
				</li>
				<li class="datatable-usuarios">
					<a href="<?= $raiz ?>Telas/Usuarios/Table/datatable-usuarios.php"><i class="fas fa-users"></i> Usuários</a>
				</li>
				<li class="datatable-historicos">
					<a href="<?= $raiz ?>Telas/Historico/Table/datatable-historicos.php"><i class="fas fa-clock"></i> Histórico</a>
				</li>
			</ul>

			<!-- Botoes inferiores da sidebar -->
			<ul class="list-unstyled CTAs">
				<li>
					<a href="" class="download" data-toggle="modal" data-target="#modalUser" id="profile"><i class="far fa-user"></i> Perfil</a>
				</li>
				<li>
					<a href="<?= $raiz ?>Telas/Acesso/Login/login.php" class="article"><i class="far fa-arrow-alt-circle-left"></i> Sair</a>
				</li>
			</ul>
		</nav>

		<!-- Page Content Holder -->
		<div id="content">

			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="container-fluid">

					<!-- Botao para esconder a sidebar -->
					<button type="button" id="sidebarCollapse" class="navbar-btn">
						<span></span>
						<span></span>
						<span></span>
					</button>
					<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fas fa-align-justify"></i>
					</button>					
				</div>
			</nav>

			<div id="loader"></div>

			<div class="main animate-bottom" style="display:none;" id="DivLoader">

				<?php echo $pagemaincontent; ?>

			</div>

		</div><!-- Fecha content -->
	</div> <!-- Fecha wrapper -->

	<!-- Modal -->
	<div class="modal fade" id="modal" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-body">
				</div>
			</div>
		</div>
	</div>

	<!-- Modal User -->
	<div class="modal fade" id="modalUser" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-body">

					<form method="POST" action="" name="formAlterarUsuario" id="formAlterarUsuario">

				    <!-- Abre form-row -->
				    <div class="form-row">

				        <!-- Input Nome -->
				        <div class="form-group col-md-11">
				            <label for="txtNomeUsuario">Nome</label>
				            <input type="text" class="form-control" placeholder="Nome do usuário" id="txtNomeUsuario" name="txtNomeUsuario" value="<?php echo $NomeUsuario; ?>" disabled>
				        </div>

				        <!-- Input Login Usuario -->
				        <div class="form-group col-md-11">
				            <label for="txtLoginUsuario">Login</label>
				            <input type="text" class="form-control" placeholder="Login do Usuario" id="txtLoginUsuario" name="txtLoginUsuario" value="<?php echo $LoginUsuario; ?>" disabled>
				        </div>

				        <!-- Input E-mail -->
				        <div class="form-group col-md-11">
				            <label for="txtEmailUsuario">E-mail</label>
				            <input type="text" class="form-control" placeholder="exemplo@exemplo.com.br" id="txtEmailUsuario" name="txtEmailUsuario" value="<?php echo $EmailUsuario; ?>" disabled>
				        </div>

				        <!-- Input senha -->
				        <div class="form-group col-md-5">
				            <label for="txtSenhaUsuario">Senha</label>
				            <input type="password" class="form-control" placeholder="Senha" id="txtSenhaUsuario" name="txtSenhaUsuario" value="<?php echo $SenhaUsuario; ?>" disabled>
				        </div>

				          <!-- Input confirma senha -->
				        <div class="form-group col-md-5">
				            <label for="txtConfirmSenhaUsuario">Confirmar senha</label>
				            <input type="password" class="form-control" placeholder="Senha" id="txtConfirmSenhaUsuario" name="txtConfirmSenhaUsuario" value="<?php echo $SenhaUsuario; ?>" disabled>
				        </div>

				        <!-- cbx Tipo acesso -->
				        <div class="form-group col-md-5">
				            <label for="cbxTipoAcesso">Tipo de Aesso</label>
				            <select class="custom-select" id="cbxTipoAcesso" disabled>
				                <option value="FUN" <?=($TipoAcesso == 'FUN')?'selected':''?> >Funcionário</option>
				                <option value="ADM" style="color:red;" <?=($TipoAcesso == 'ADM')?'selected':''?>>Administrador</option>
				            </select>   
				        </div>
				    </div><!-- Fecha form-row -->
				    <p>

				    <!-- Botoes do Modal -->
				    <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				    </div>
				</form>

				</div>
			</div>
		</div>
	</div>

	<!-- Scripts Gerais -->
	<script>


		// Funçao para o loader em js
		var myVar;

		function showPage() {
			document.getElementById("loader").style.display = "none";
			document.getElementById("DivLoader").style.display = "block";
		}

		function myFunction() {
			myVar = setTimeout(showPage, 2500);
		}

		$(document).ready(function() {

			// Botao de profile
			$('#profile').on('click', function(){
				$('#modalUser').show();
			});
				
			// Função para esconder a sidebar
			$('#sidebarCollapse').on('click', function() {
				$('#sidebar').toggleClass('active');
				$(this).toggleClass('active');
			});

			// Funçao para ativar links de navegaçao
			$(function() {

			  $('ul.components li').removeClass('active');
			  $('ul.components li.'+ location.pathname.split("/")[location.pathname.split("/").length - 1].split(".")[0]).addClass("active");
			});

		});
	</script>
</body>
</html>