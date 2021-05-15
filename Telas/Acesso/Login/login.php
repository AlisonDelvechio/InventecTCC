<?php

//Verificar se a sessão não já está aberta.
if (!isset($_SESSION)) {
	// Iniciando a sessao
	session_start();
}

//Pegando Links adicionados a raiz
$raiz = '../../../';

// Incluindo conexao
include($raiz.'PHP/conexao.php');

$error = false;

if (!empty($_POST)) {

  //Recebendo ID do modal
  $UsuarioTela = $_POST['txtLoginUsuario'];
  $UsuarioSenha = $_POST['txtSenhaUsuario'];

  // Atribuindo valores na sessao
  $_SESSION['UsuarioTela'] = $UsuarioTela;
  $_SESSION['UsuarioSenha'] = $UsuarioSenha;

  //Query para verificar se existe o usuario
  $verifyQuery = mysqli_query($con, "

    SELECT * FROM tb_usuarios
    WHERE loginUsuario = '$UsuarioTela'
    AND senhaUsuario = '$UsuarioSenha'

  ") or die(mysqli_error($con));

  $arrayData = mysqli_fetch_array($verifyQuery);

  if($arrayData != null && $arrayData != '' && $arrayData != []){
    
    $_SESSION['idUsuario'] = $arrayData['idUsuario'];
    $_SESSION['tipoAcesso'] = $arrayData['tipoAcesso'];
    
    header('location: '.$raiz.'Telas/Home/homePage.php');
  }else{
    $error = true;
  }

}

?>


<!-- Imagens -->
<link href="<?= $raiz ?>Imagens/logo.png" rel="stylesheet" type="text/css" />

<!-- Login CSS -->
<link href="<?= $raiz ?>CSS/login.css" rel="stylesheet" type="text/css" />

<!-- Logo CSS -->
<link href="<?= $raiz ?>CSS/logo.css" rel="stylesheet" type="text/css" />

<!-- Bootstrap -->
<link href="<?= $raiz ?>Bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?= $raiz ?>Bootstrap/js/bootstrap.min.js"></script>

<!-- Font awesome -->
<link href="<?= $raiz ?>fontawesome/css/all.css" rel="stylesheet">

<!-- jQuery -->
<script type="text/javascript" src="<?= $raiz ?>jQuery/jquery.js"></script>

<!-- jQuery Toastr -->
<link href="<?= $raiz ?>jQuery/Toastr/toastr.css" rel="stylesheet"/>
<link href="<?= $raiz ?>jQuery/Toastr/toastr.min.css" rel="stylesheet"/>
<script type="text/javascript" src="<?= $raiz ?>jQuery/Toastr/toastr.min.js"></script>
<script type="text/javascript" src="<?= $raiz ?>jQuery/Toastr/toastr.js.map"></script>

<div class="loginMain">

  <div class="container">

      <div class="middle">

        <div id="login">

          <form action="" method="POST" id="frmLogin">

            <fieldset class="clearfix">

              <!-- Input Usuario -->
              <p ><span class="fa fa-user"></span>
              <input type="text"  Placeholder="Usuário" id="txtLoginUsuario" name="txtLoginUsuario" required></p> 

              <!-- Input Senha -->
              <p><span class="fa fa-lock"></span>
              <input type="password"  Placeholder="Senha" id="txtSenhaUsuario" name="txtSenhaUsuario" required></p> 

              <div>
                <span style="width:48%; text-align:left;  display: inline-block;"><a class="small-text" href="#">Recuperar senha</a></span>

                <span style="width:50%; text-align:right;  display: inline-block;">

                <!-- Input Botao Login -->
                <input type="submit" value="Login" id="btnlogin" name="btnlogin">

                </span>

                <?php if($error) : ?>
                  <script>
                    $(document).ready(function(){

                      // Mensagem do sistema
                      toastr.options = {
                        progressBar: true,
                        closeButton: true,
                        hideDuration: 100,
                        tapToDismiss: true,
                        positionClass: "toast-bottom-center"
                      };

                      toastr.warning('Login Incorreto!');
                    });
                  </script>
                <?php endif; ?>

              </div>
            </fieldset>

            <div class="clearfix"></div>
          </form>

          <div class="clearfix"></div>
        </div> <!-- end login -->

        <div class="logo">

        <img class="logologin" src="<?= $raiz ?>Imagens/logo.png"> 

          <div class="clearfix"></div>
        </div>
      </div>
  </div>
</div>