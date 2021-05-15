<?php

//Verificar se a sessão não já está aberta.
if (!isset($_SESSION)) {
	// Iniciando a sessao
	session_start();
}

// Incluindo conexao
include('../../../PHP/conexao.php');

// Recebendo ID da tabela
$idLocalModal = $_POST['idLocalTable'];

?>

<!-- Conteudo do modal -->
<p>Deseja excluir este local? <h4 style="color: red;"> Todos os patrimônios vinculados ao local serão apagados!</h4></p>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" id="btnDeletar">Deletar</button>
    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
</div>

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

        // Botao de DELETE
        $('#btnDeletar').on('click', function(){

            // Passando variavel do PHP para o Javascript 
            var idLocalModal = "<?php echo $idLocalModal;?>";

            // Chamando requisição para query de exclusao
            $.ajax({
                type: 'POST',
                url: '../Deletar/deleteLocalQuery.php',
                success: function() {
                    // fechando modal apos ação
                    $('#modal').modal('hide');

                    // Atualizando datatable quando fechar o modal
                    $("#datatable-locais").DataTable().ajax.reload();

                    toastr.success('Local excluido com sucesso!');
                },
                data: {
                    // enviando ID para a query de exclusao
                    'idLocalQuery': idLocalModal
                }
            });
        });
    });
</script>