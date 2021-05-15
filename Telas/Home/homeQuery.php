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
include('../../PHP/conexao.php');

// Registros dos patrimonios
    $QueryPatrimonios = "

        SELECT * FROM tb_patrimonios 
    ";

    $RegistroPatrimonios = $con->query($QueryPatrimonios);

    $totalPatrimonios = mysqli_num_rows($RegistroPatrimonios);
// 

// Registros dos Usuarios
    $QueryUsuarios = "

        SELECT * FROM tb_usuarios 
    ";

    $RegistroUsuarios = $con->query($QueryUsuarios);

    $totalUsuarios = mysqli_num_rows($RegistroUsuarios);

// 

// Registros dos Locais
    $QueryLocais = "

        SELECT * FROM tb_locais 
    ";

    $RegistroLocais = $con->query($QueryLocais);

    $totalLocais = mysqli_num_rows($RegistroLocais);

// 

// Todos registros para enviar aos graficos
$registros = [$totalUsuarios, $totalPatrimonios, $totalLocais];

echo json_encode($registros);

?>