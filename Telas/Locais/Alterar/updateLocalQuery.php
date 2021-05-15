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
$idLocal = $_POST['idLocalQuery'];

//Recebendo valores
$NomeLocal = $_POST['NomeLocalQuery'];
$BlocoLocal = $_POST['BlocoLocalQuery'];
$DescricaoLocal = $_POST['DescricaoLocalQuery'];

// Select buscando pelas informações antes do update
$selectLocaisAntes = mysqli_query($con, "

	SELECT * FROM tb_locais 
	where idLocal = '" . $idLocal . "'

") or die(mysqli_error($con));

// While buscando pelas informações antes do update
while($rowLocaisAntes = mysqli_fetch_array($selectLocaisAntes))
{
    $NomeLocalAntes = $rowLocaisAntes['nomeLocal'];
    $BlocoLocalAntes = $rowLocaisAntes['blocoLocal'];
    $DescricaoLocalAntes = $rowLocaisAntes['descricaoLocal'];

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
$Atividade = "O usuário <b>$UsuarioTela</b> alterou o local <b>$NomeLocal</b>";

// Condiçoes concatenando as açoes
	if($NomeLocal != $NomeLocalAntes){
		$Atividade .= ", nome <b>$NomeLocalAntes</b> para <b>$NomeLocal</b>";
	}
	if($BlocoLocal != $BlocoLocalAntes){
		$Atividade .= ", bloco <b>$BlocoLocalAntes</b> para <b>$BlocoLocal</b>";
	}
	if($DescricaoLocal != $DescricaoLocalAntes){
		$Atividade .= ", descrição <b>$DescricaoLocalAntes</b> para <b>$DescricaoLocal</b>";
	}

	$Atividade .= ".";
// 
$Operacao = 'U';

//Query de alterar
$editar = mysqli_query($con, "

	UPDATE tb_locais
	SET nomeLocal = '$NomeLocal',
	blocoLocal = '$BlocoLocal',
	DescricaoLocal = '$DescricaoLocal'
	WHERE idLocal = '$idLocal'")

OR DIE (mysqli_error($con));

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