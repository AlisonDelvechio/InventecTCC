<?php

// Incluindo conexao
include('../../../PHP/conexao.php');

// Recebendo ID da tabela
$idPatrimonioModal = $_POST['idPatrimonioTable'];

?>

<!-- Conteudo do modal -->
<p>Deseja excluir este patrimônio?</p>
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
            var idPatrimonioModal = "<?php echo $idPatrimonioModal;?>";

            // Chamando requisição para query de exclusao
            $.ajax({
                type: 'POST',
                url: '../Deletar/deletePatrimonioQuery.php',
                success: function() {
                    // fechando modal apos ação
                    $('#modal').modal('hide');

                    // Atualizando datatable quando fechar o modal
                    $("#datatable-patrimonios").DataTable().ajax.reload();

                    toastr.success('Patrimônio excluido com sucesso!');
                },
                data: {
                    // enviando ID para a query de exclusao
                    'idPatrimonioQuery': idPatrimonioModal
                }
            });
        });
    });
</script>