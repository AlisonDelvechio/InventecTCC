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

//Recebendo valores
$NomeUsuario =  $_POST['NomeUsuarioQuery'];
$LoginUsuario = $_POST['LoginUsuarioQuery'];
$EmailUsuario = $_POST['EmailUsuarioQuery'];
$SenhaUsuario = $_POST['SenhaUsuarioQuery'];
$TipoAcesso = $_POST['TipoAcessoUsuarioQuery'];

//Query de cadastro Pessoa
$insertQueryUsuario = mysqli_query($con, "
	
	INSERT INTO tb_pessoas
	(nomePessoa) 
	VALUES (
	'$NomeUsuario'

)")or die(mysqli_error($con));

// Pega o ultimo idPessoa Inserido
$idPessoa = mysqli_insert_id($con);

//Query de cadastro Usuario
$insertQueryUsuario = mysqli_query($con, "
	
	INSERT INTO tb_usuarios 
	(loginUsuario,
	emailUsuario,
	senhaUsuario,
	idPessoa,
	tipoAcesso) 
	VALUES (
	'$LoginUsuario',
	'$EmailUsuario',
	'$SenhaUsuario',
	'$idPessoa',
	'$TipoAcesso'

)")or die(mysqli_error($con));

// Variavel de açao
$Atividade = "O usuário <b>$UsuarioTela</b> cadastrou o usuário <b>$LoginUsuario</b> com e-mail <b>$EmailUsuario</b>";
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

)")or die(mysqli_error($con));
	 
?>