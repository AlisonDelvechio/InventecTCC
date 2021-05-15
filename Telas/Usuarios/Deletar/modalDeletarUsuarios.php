<?php

//Verificar se a sessão não já está aberta.
if (!isset($_SESSION)) {
    // Iniciando a sessao
    session_start();
}

// Recebendo valores da sessao
$UsuarioTela = $_SESSION['idUsuario'];

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

        $idPessoa = $rowUsuarios['idPessoa'];
    }
// 

// Select buscando pelas informações
$selectPessoas = mysqli_query($con, "

    SELECT * FROM tb_pessoas 
    where idPessoa = '" . $idPessoa . "'

") or die(mysqli_error($con));

// While buscando pelas informações
while($rowPessoas = mysqli_fetch_array($selectPessoas))
{
    $idPessoa = $rowPessoas['idPessoa'];
}

?>

<!-- Conteudo do modal -->
<p>Deseja excluir este usuário?</p>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" id="btnDeletar">Deletar</button>
    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
</div>

<script>
    $(document).ready(function(){

        // Botao de DELETE
        $('#btnDeletar').on('click', function(){

            // Mensagem do sistema
            toastr.options = {
                progressBar: true,
                closeButton: true,
                hideDuration: 100,
                tapToDismiss: true,
                positionClass: "toast-bottom-center"
            };

            // Passando variavel do PHP para o Javascript 
            var idUsuarioModal = "<?php echo $idUsuarioModal;?>";
            var idUsuarioSessao = "<?php echo $UsuarioTela;?>";
            var idPessoaModal = "<?php echo $idPessoa; ?>";

            console.log(idUsuarioModal);
            console.log(idUsuarioSessao);

            if(idUsuarioModal == idUsuarioSessao){
                $('#modal').modal('hide');
                toastr.warning('Não é possivel excluir um usuário logado!');
            }else{
                // Chamando requisição para query de exclusao
                $.ajax({
                    type: 'POST',
                    url: '../Deletar/deleteUsuarioQuery.php',
                    success: function() {
                        // fechando modal apos ação
                        $('#modal').modal('hide');

                        // Atualizando datatable quando fechar o modal
                        $("#datatable-usuarios").DataTable().ajax.reload();

                        toastr.success('Usuário excluido com sucesso!');
                    },
                    data: {
                        // enviando ID para a query de exclusao
                        'idUsuarioQuery': idUsuarioModal,
                        'idPessoaQuery':  idPessoaModal
                    }
                });
            }
        });
    });
</script>