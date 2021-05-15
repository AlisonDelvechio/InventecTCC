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

//Recebendo valores do modal
$NomeLocal = $_POST['NomeLocalQuery'];
$BlocoLocal = $_POST['BlocoLocalQuery'];
$DescricaoLocal = $_POST['DescricaoLocalQuery'];

//Query de cadastro de locais
$cadastro = mysqli_query($con, "
	
	INSERT INTO tb_locais 
	(nomeLocal,
	blocoLocal,
	descricaoLocal) 
	VALUES (
	'$NomeLocal',
	'$BlocoLocal',
	'$DescricaoLocal'

)")or die(mysqli_error($link));

// Variavel de açao
$Atividade = "O usuário <b>$UsuarioTela</b> cadastrou o local <b>$NomeLocal</b> no bloco <b>$BlocoLocal</b>";
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