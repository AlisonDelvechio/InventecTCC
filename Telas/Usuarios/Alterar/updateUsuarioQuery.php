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
$idUsuarioModal = $_POST['idUsuarioQuery'];
$idPessoa = $_POST['idPessoaQuery'];

//Recebendo valores
$NomeUsuario =  $_POST['NomeUsuarioQuery'];
$LoginUsuario = $_POST['LoginUsuarioQuery'];
$EmailUsuario = $_POST['EmailUsuarioQuery'];
$SenhaUsuario = $_POST['SenhaUsuarioQuery'];
$TipoAcesso = $_POST['TipoAcessoUsuarioQuery'];

// Select buscando pelas informações antes do update
$selectUsuariosAntes = mysqli_query($con, "

	SELECT * FROM tb_usuarios 
	where idUsuario = '" . $idUsuarioModal . "'

") or die(mysqli_error($con));

// While buscando pelas informações antes do update
while($rowUsuariosAntes = mysqli_fetch_array($selectUsuariosAntes))
{
    $LoginUsuarioAntes = $rowUsuariosAntes['loginUsuario'];
    $EmailUsuarioAntes = $rowUsuariosAntes['emailUsuario'];
}

//Query de alterar Pessoa
$updateQueryPessoa = mysqli_query($con, "

	UPDATE tb_pessoas
	SET nomePessoa = '$NomeUsuario'
	WHERE idPessoa = '$idPessoa'

")or die(mysqli_error($con));

// Váriavel de açao
$Atividade = "O usuário <b>$UsuarioTela</b> alterou o usuário <b>$LoginUsuario</b>";

// Condiçoes concatenando as açoes
	if($LoginUsuario != $LoginUsuarioAntes){
		$Atividade .= ", nome <b>$LoginUsuarioAntes</b> para <b>$LoginUsuario</b>";
	}
	if($EmailUsuario != $EmailUsuarioAntes){
		$Atividade .= ", e-mail <b>$EmailUsuarioAntes</b> para <b>$EmailUsuario</b>";
	}

	$Atividade .= ".";
// 

$Operacao = 'U';

//Query de alterar
$updateQueryUsuario = mysqli_query($con, "

	UPDATE tb_usuarios
	SET loginUsuario = '$LoginUsuario',
	emailUsuario = '$EmailUsuario',
	senhaUsuario = '$SenhaUsuario',
	tipoAcesso = '$TipoAcesso'
	WHERE idUsuario = '$idUsuarioModal'

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