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

// Incluindo conexao
include('../../../PHP/conexao.php');

// Recebendo ID
$idPatrimonio = $_POST['idPatrimonioQuery'];

//Recebendo valores
$NomePatrimonio = $_POST['NomePatrimonioQuery'];
$NumeroPatrimonio = $_POST['NumeroPatrimonioQuery'];
$PertencentePatrimonio = $_POST['PertencentePatrimonioQuery'];
$StatusPatrimonio = $_POST['StatusPatrimonioQuery'];
$LocalPatrimonio = $_POST['LocalPatrimonioQuery'];
$DataPatrimonio = $_POST['DataPatrimonioQuery'];
// Convertendo data
$dateTime = implode("/", array_reverse(explode("-",$DataPatrimonio)));
$DataPatrimonioConvert = $dateTime;
$DescricaoPatrimonio = $_POST['DescricaoPatrimonioQuery'];

// Select buscando pelas informações dos locais
$selectLocais = mysqli_query($con, "

	SELECT * FROM tb_locais 
	WHERE idLocal = '" . $LocalPatrimonio. "'

") or die(mysqli_error($con));

// While buscando informaçoes dos locais
while($rowLocais = mysqli_fetch_array($selectLocais))
{
    $NomeLocal = $rowLocais['nomeLocal'];
}

// Select buscando pelas informações dos patrimonios antes do update
$selectPatrimoniosAntes = mysqli_query($con, "

	SELECT * FROM tb_patrimonios 
	WHERE idPatrimonio = '" . $idPatrimonio . "'

") or die(mysqli_error($con));

// While buscando informaçoes dos patrimonios antes do update
while($rowPatrimoniosAntes = mysqli_fetch_array($selectPatrimoniosAntes))
{
    $NomePatrimonioAntes = $rowPatrimoniosAntes['nomePatrimonio'];
	$NumeroPatrimonioAntes = $rowPatrimoniosAntes['numeroPatrimonio'];
	$PertencentePatrimonioAntes = $rowPatrimoniosAntes['pertencentePatrimonio'];
	$StatusPatrimonioAntes = $rowPatrimoniosAntes['statusPatrimonio'];
	$LocalPatrimonioAntes = $rowPatrimoniosAntes['idLocal'];
	$DataPatrimonioAntes = $rowPatrimoniosAntes['dataPatrimonio'];
	// Convertendo data
	$dateTimeAntes = implode("/", array_reverse(explode("-",$rowPatrimoniosAntes['dataPatrimonio'])));
	$DataPatrimonioAntesConvert = $dateTimeAntes;
	$DescricaoPatrimonioAntes = $rowPatrimoniosAntes['descricaoPatrimonio'];

}

// Select buscando pelas informações dos locais antes do update
$selectLocaisAntes = mysqli_query($con, "

	SELECT * FROM tb_locais 
	WHERE idLocal = '" . $LocalPatrimonioAntes . "'

") or die(mysqli_error($con));

// While buscando informaçoes dos locais antes do update
while($rowLocaisAntes = mysqli_fetch_array($selectLocaisAntes))
{
    $NomeLocalAntes = $rowLocaisAntes['nomeLocal'];
}

// Select buscando pelas informações do usuario
$selectUsuarios = mysqli_query($con, "

    SELECT * FROM tb_usuarios 
    where idUsuario = '" . $idUsuario . "'

") or die(mysqli_error($con));

// While buscando pelas informações do usuario
while($rowUsuarios = mysqli_fetch_array($selectUsuarios))
{
    $idPessoa = $rowUsuarios['idPessoa'];
}

// Váriavel de açao
$Atividade = "O usuário <b>$UsuarioTela</b> alterou o patrimônio <b>$NomePatrimonio</b>";

// Condiçoes concatenando as açoes
	if($LocalPatrimonio != $LocalPatrimonioAntes){
		$Atividade .= ", local <b>$NomeLocalAntes</b> para <b>$NomeLocal</b>";
	}
	if($NomePatrimonio != $NomePatrimonioAntes){
		$Atividade .= ", nome <b>$NomePatrimonioAntes</b> para <b>$NomePatrimonio</b>";
	}
	if($NumeroPatrimonio != $NumeroPatrimonioAntes){
		$Atividade .= ", número <b>$NumeroPatrimonioAntes</b> para <b>$NumeroPatrimonio</b>";
	}
	if($PertencentePatrimonio != $PertencentePatrimonioAntes){
		$Atividade .= " , pertencente <b>$PertencentePatrimonioAntes</b> para <b>$PertencentePatrimonio</b>";
	}
	if($StatusPatrimonio != $StatusPatrimonioAntes){
		$Atividade .= " , status <b>$StatusPatrimonioAntes</b> para <b>$StatusPatrimonio</b>";
	}
	if($DataPatrimonio != $DataPatrimonioAntes){
		$Atividade .= ", data de inclusão <b>$DataPatrimonioAntesConvert</b> para <b>$DataPatrimonioConvert</b>";
	}
	if($DescricaoPatrimonio != $DescricaoPatrimonioAntes){
		$Atividade .= " , descrição <b>$DescricaoPatrimonioAntes</b> para <b>$DescricaoPatrimonio</b>";
	}

	$Atividade .= ".";

// 

// Variavel para designar a operaçao
$Operacao = 'U';

//Query de alterar
$updateQuery = mysqli_query($con, "

	UPDATE tb_patrimonios SET 
	nomePatrimonio = 		'$NomePatrimonio', 
	numeroPatrimonio = 		'$NumeroPatrimonio', 
	pertencentePatrimonio = '$PertencentePatrimonio', 
	statusPatrimonio = 		'$StatusPatrimonio',
	idLocal = 				'$LocalPatrimonio', 
	dataPatrimonio = 		'$DataPatrimonio',
	descricaoPatrimonio = 	'$DescricaoPatrimonio'
	WHERE idPatrimonio = 	'$idPatrimonio'

")or die(mysqli_error($con));

// Grava Historico
$addHistorico = mysqli_query($con, "
	
	INSERT INTO tb_historicos
	(usuarioTela,
	operacao,
	atividade,
	idPessoa) 
	VALUES (
	'$UsuarioTela',
	'$Operacao',
	'$Atividade',
	'$idPessoa'

)")or die(mysqli_error($link));
	
?>