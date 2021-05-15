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

// Incluindo Conexao
include('../../../PHP/conexao.php');

//Recebendo valores do modal
$NomePatrimonio = $_POST['NomePatrimonioQuery'];
$NumeroPatrimonio = $_POST['NumeroPatrimonioQuery'];
$PertencentePatrimonio = $_POST['PertencentePatrimonioQuery'];
$StatusPatrimonio = $_POST['StatusPatrimonioQuery'];
$LocalPatrimonio = $_POST['LocalPatrimonioQuery'];
$DataPatrimonio = $_POST['DataPatrimonioQuery'];
$DescricaoPatrimonio = $_POST['DescricaoPatrimonioQuery'];
$NomeLocal = $_POST['NomeLocalQuery'];

// Select buscando local
$selectLocais = mysqli_query($con, "

	SELECT * FROM tb_locais 
	where idLocal = '" . $LocalPatrimonio . "'

") or die(mysqli_error($con));

while($rowLocais = mysqli_fetch_array($selectLocais))
{
    $NomeLocal= $rowLocais['nomeLocal'];
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

//Query de cadastro
$cadastro = mysqli_query($con, "

	INSERT INTO tb_patrimonios 
	(nomePatrimonio, 
	numeroPatrimonio, 
	pertencentePatrimonio, 
	statusPatrimonio, 
	idLocal, 
	dataPatrimonio, 
	descricaoPatrimonio) 
	VALUES (
	'$NomePatrimonio',
	'$NumeroPatrimonio',
	'$PertencentePatrimonio',
	'$StatusPatrimonio',
	'$LocalPatrimonio',
	'$DataPatrimonio',
	'$DescricaoPatrimonio')
	
") 	or die(mysqli_error($link));

// Variavel de açao
$Atividade = "O usuário <b>$UsuarioTela</b> cadastrou o patrimônio <b>$NomePatrimonio</b> no local <b>$NomeLocal</b>";
$Operacao = 'I';

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