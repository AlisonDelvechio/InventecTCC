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

//Recebendo ID do modal
$idUsuarioTela = $_POST['idUsuarioQuery'];
$idPessoa = $_POST['idPessoaQuery'];

// Select buscando pelas informações do Usuario
$selectUsuarios = mysqli_query($con, "

	SELECT * FROM tb_usuarios 
	where idUsuario = '" . $idUsuarioTela. "'

") or die(mysqli_error($con));

// While percorrendo informações
while ($rowUsuarios = mysqli_fetch_array($selectUsuarios)) {

	$LoginUsuario = $rowUsuarios['loginUsuario'];
}

// Variavel de açao
$Atividade = "O usuário <b>$UsuarioTela</b> excluiu o usuário <b>$LoginUsuario</b>";
$Operacao = 'D';

//Query de exclusao
$deleteQuery = mysqli_query($con, "

	DELETE FROM tb_usuarios
	WHERE idUsuario = '$idUsuarioTela'

") or die(mysqli_error($con));

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
