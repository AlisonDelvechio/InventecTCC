<?php

// Incluindo conexao
include('../../../PHP/conexao.php');

// Recebendo ID da tabela
$idUsuarioModal = $_POST['idUsuarioTable'];

// Select buscando pelas informações do Usuario 
    $selectUsuarios = mysqli_query($con, "

        SELECT * FROM tb_usuarios
        where idUsuario = '" . $idUsuarioModal . "'

    ") or die(mysqli_error($con));

    // While percorrendo informações
    while ($rowUsuarios = mysqli_fetch_array($selectUsuarios)) {

        $LoginUsuario = $rowUsuarios['loginUsuario'];
        $EmailUsuario = $rowUsuarios['emailUsuario'];
        $SenhaUsuario = $rowUsuarios['senhaUsuario'];
        $TipoAcesso = $rowUsuarios['tipoAcesso'];
        $idPessoa = $rowUsuarios['idPessoa'];
    }
// 

// Select buscando pelas informações antes do update
$selectPessoas = mysqli_query($con, "

    SELECT * FROM tb_pessoas 
    where idPessoa = '" . $idPessoa . "'

") or die(mysqli_error($con));

// While buscando pelas informações antes do update
while($rowPessoas = mysqli_fetch_array($selectPessoas))
{
    $NomeUsuario = $rowPessoas['nomePessoa'];
    $idPessoa = $rowPessoas['idPessoa'];
}

?>

<!-- Titulo do modal -->
<div class="modal-header">
    <h5 class="modal-title">Editar Usuario</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="POST" action="" name="formAlterarUsuario" id="formAlterarUsuario">

    <!-- Abre form-row -->
    <div class="form-row">

        <!-- Input Nome -->
        <div class="form-group col-md-11">
            <label for="txtNomeUsuario">Nome</label>
            <input type="text" class="form-control" placeholder="Nome do usuário" id="txtNomeUsuario" name="txtNomeUsuario" value="<?php echo $NomeUsuario; ?>">
        </div>

        <!-- Input Login Usuario -->
        <div class="form-group col-md-11">
            <label for="txtLoginUsuario">Login</label>
            <input type="text" class="form-control" placeholder="Login do Usuario" id="txtLoginUsuario" name="txtLoginUsuario" value="<?php echo $LoginUsuario; ?>">
        </div>

        <!-- Input E-mail -->
        <div class="form-group col-md-11">
            <label for="txtEmailUsuario">E-mail</label>
            <input type="text" class="form-control" placeholder="exemplo@exemplo.com.br" id="txtEmailUsuario" name="txtEmailUsuario" value="<?php echo $EmailUsuario; ?>">
        </div>

        <!-- Input senha -->
        <div class="form-group col-md-5">
            <label for="txtSenhaUsuario">Senha</label>
            <input type="password" class="form-control" placeholder="Senha" id="txtSenhaUsuario" name="txtSenhaUsuario" value="<?php echo $SenhaUsuario; ?>">
        </div>

          <!-- Input confirma senha -->
        <div class="form-group col-md-5">
            <label for="txtConfirmSenhaUsuario">Confirmar senha</label>
            <input type="password" class="form-control" placeholder="Senha" id="txtConfirmSenhaUsuario" name="txtConfirmSenhaUsuario" value="<?php echo $SenhaUsuario; ?>">
        </div>

        <!-- cbx Tipo acesso -->
        <div class="form-group col-md-5">
            <label for="cbxTipoAcesso">Tipo de Aesso</label>
            <select class="custom-select" id="cbxTipoAcesso">
                <option value="FUN" <?=($TipoAcesso == 'FUN')?'selected':''?> >Funcionário</option>
                <option value="ADM" style="color:red;" <?=($TipoAcesso == 'ADM')?'selected':''?>>Administrador</option>
            </select>   
        </div>
    </div><!-- Fecha form-row -->
    <p>

    <!-- Botoes do Modal -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-success" id="btnAlterar">Salvar mudanças</button>
    </div>
</form>

<script>
    $(document).ready(function() {

       // Mensagem do sistema
        toastr.options = {
            progressBar: true,
            closeButton: true,
            hideDuration: 100,
            tapToDismiss: true,
            positionClass: "toast-bottom-center"
        };

        // Validaçao Form
        $("#formAlterarUsuario").validate({
           rules : {
                txtNomeUsuario:{
                    required: true,
                    minlength: 5
                },
                txtLoginUsuario:{
                    required: true,
                    minlength: 5,
                    nowhitespace: true
                }, 
                txtEmailUsuario:{
                    required: true,
                    minlength: 12,
                    email: true,
                    nowhitespace: true
                },
                txtSenhaUsuario:{
                    required: true,
                    minlength: 6
                },
                txtConfirmSenhaUsuario:{
                    required: true,
                    minlength: 6,
                    equalTo: "#txtSenhaUsuario"
                }      
           },
           messages:{
                txtNomeUsuario:{
                    required:"Por favor, informe um nome!",
                    minlength: "Mínimo 5 caracteres!"
                },
                txtLoginUsuario:{
                    required:"Por favor, informe um local!",
                    minlength: "Mínimo 5 caracteres!",
                    nowhitespace: "Sem espaços no login!"
                },
                txtEmailUsuario:{
                    required:"Por favor, informe um e-mail válido!",
                    minlength: "Mínimo 12 caracteres!",
                    email: "Insira um e-mail válido!",
                    nowhitespace: "Sem espaços no email!"
                },
                txtSenhaUsuario:{
                    required: "Por favor, informe uma senha válida!",
                    minlength: "Mínimo 6 caracteres!"
                },
                txtConfirmSenhaUsuario:{
                    required: "Por favor, informe uma senha válida!",
                    minlength: "Mínimo 6 caracteres!",
                    equalTo: "Senhas divergentes!"
                }
           }
        });


        $('#btnAlterar').on('click', function() {

            var idUsuarioModal = "<?php echo $idUsuarioModal; ?>";
            var idPessoaModal = "<?php echo $idPessoa; ?>";
            var NomeUsuario = $('#txtNomeUsuario').val();
            var LoginUsuario = $('#txtLoginUsuario').val();
            var EmailUsuario = $('#txtEmailUsuario').val();
            var SenhaUsuario = $('#txtSenhaUsuario').val();
            var TipoAcessoUsuario = $('#cbxTipoAcesso').val();
            
            if ($("#formAlterarUsuario").valid()) {
                $.ajax({
                    type: 'POST',
                    url: '../Alterar/updateUsuarioQuery.php',
                    success: function() {
                        // fechando modal ao clicar
                        $('#modal').modal('hide');

                        // Atualizando datatable quando fechar o modal
                        $("#datatable-usuarios").DataTable().ajax.reload();

                        toastr.success('Usuário alterado com sucesso!');
                    },
                    data: {
                        // enviando para a query de alteração
                        'NomeUsuarioQuery':       NomeUsuario,
                        'LoginUsuarioQuery':      LoginUsuario,
                        'EmailUsuarioQuery':      EmailUsuario,
                        'SenhaUsuarioQuery':      SenhaUsuario,
                        'TipoAcessoUsuarioQuery': TipoAcessoUsuario,
                        'idUsuarioQuery':         idUsuarioModal,
                        'idPessoaQuery':         idPessoaModal
                    }
                });
            }else{
                toastr.warning('Insira informações válidas!');
            }
        });
    });
</script>