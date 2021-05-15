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
$idPatrimonio = $_POST['idPatrimonioQuery'];

// Select buscando pelas informações do local 
$selectPatrimonio = mysqli_query($con, "

	SELECT * FROM tb_patrimonios
	where idPatrimonio = '" . $idPatrimonio . "'

") or die(mysqli_error($con));

// While percorrendo informações
while ($rowPatrimonios = mysqli_fetch_array($selectPatrimonio)) {

	$NomePatrimonio = $rowPatrimonios['nomePatrimonio'];
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

// Variavel de açao
$Atividade = "O usuário <b>$UsuarioTela</b> excluiu o patrimônio <b>$NomePatrimonio</b>";
$Operacao = 'D';

//Query de exclusao
$deleteQuery = mysqli_query($con, "
	
	DELETE FROM tb_patrimonios 
	WHERE idPatrimonio = '$idPatrimonio'
	
") or die(mysqli_error($link));

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
