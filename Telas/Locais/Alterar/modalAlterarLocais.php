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

// Select buscando pelas informações do local 
$selectLocais = mysqli_query($con, "

    SELECT * FROM tb_locais 
    where idLocal = '" . $idLocalModal . "'

    ") or die(mysqli_error($con));

// While percorrendo informações
while ($rowLocais = mysqli_fetch_array($selectLocais)) {

    $NomeLocal = $rowLocais['nomeLocal'];
    $BlocoLocal = $rowLocais['blocoLocal'];
    $DescricaoLocal = $rowLocais['descricaoLocal'];

}

?>

<!-- Titulo do modal -->
<div class="modal-header">
    <h5 class="modal-title">Editar Local</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="POST" action="" name="formAlterarLocal" id="formAlterarLocal">
    <div class="form-row">
        <!-- Input Local -->
        <div class="form-group col-md-6">
            <label for="txtNomeLocal">Local</label>
            <input type="text" class="form-control" placeholder="Nome do Local" id="txtNomeLocal" name="txtNomeLocal" value="<?php echo $NomeLocal ?>">
        </div>
        <!-- Input Bloco -->
        <div class="form-group col-md-6">
            <label for="txtBlocoLocal">Bloco</label>
            <input type="text" class="form-control" placeholder="Bloco" id="txtBlocoLocal" name="txtBlocoLocal" value="<?php echo $BlocoLocal ?>">
        </div>
    </div>
    <div class="form-group">
        <!-- Text areae Descrição -->
        <label for="txtDescricaoLocal">Descrição</label>
        <textarea class="form-control" id="txtDescricaoLocal" Locaiss="3"><?php echo $DescricaoLocal ?></textarea>
    </div>
    </div>
    <div class="modal-footer">
        <!-- Botões Modal -->
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
        $("#formAlterarLocal").validate({
           rules : {
                 txtNomeLocal:{
                        required: true
                 }, 
                 txtBlocoLocal:{
                        required: true
                 }          
           },
           messages:{
                 txtNomeLocal:{
                        required:"Por favor, informe um local!"
                 },
                 txtBlocoLocal:{
                        required:"Por favor, informe um bloco!"
                 }
           }
        });

        $('#btnAlterar').on('click', function() {

            var idLocalModal = "<?php echo $idLocalModal; ?>";
            var NomeLocal = $('#txtNomeLocal').val();
            var BlocoLocal = $('#txtBlocoLocal').val();
            var DescricaoLocal = $('#txtDescricaoLocal').val();

            if ($("#formAlterarLocal").valid()) {

                $.ajax({
                    type: 'POST',
                    url: '../Alterar/updateLocalQuery.php',
                    success: function() {
                        // fechando modal ao clicar
                        $('#modal').modal('hide');

                        // Atualizando datatable quando fechar o modal
                        $("#datatable-locais").DataTable().ajax.reload();

                        toastr.success('Local alterado com sucesso!');
                    },
                    data: {
                        // enviando para a query de alteração
                        'NomeLocalQuery':      NomeLocal,
                        'BlocoLocalQuery':     BlocoLocal,
                        'DescricaoLocalQuery': DescricaoLocal,
                        'idLocalQuery':        idLocalModal
                    }
                });
            }else{
                toastr.warning('Insira informações válidas!');
            }
        });
    });
</script>