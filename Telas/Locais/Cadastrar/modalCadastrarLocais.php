<?php

//Verificar se a sessão não já está aberta.
if (!isset($_SESSION)) {
	// Iniciando a sessao
	session_start();
}

//Pegando Links adicionados a raiz
$raiz = '../../../';

?>

<!-- Titulo do modal -->
<div class="modal-header">
    <h5 class="modal-title">Cadastrar Novo Local</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Abre Form do modal -->
<form method="POST" action="" name="formCadastrarLocal" id="formCadastrarLocal">

    <!-- Abre form-row -->
    <div class="form-row">

        <!-- Input Local -->
        <div class="form-group col-md-6">
            <label for="txtNomeLocal">Local</label>
            <input type="text" class="form-control" placeholder="Nome do Local" id="txtNomeLocal" name="txtNomeLocal" value="">
        </div>

        <!-- Input Bloco -->
        <div class="form-group col-md-6">
            <label for="txtBlocoLocal">Bloco</label>
            <input type="text" class="form-control" placeholder="Bloco" id="txtBlocoLocal" name="txtBlocoLocal" value="">
        </div>

    </div><!-- Fecha form-row -->

    <!-- Abre form-group -->
    <div class="form-group">

        <!-- Text area Descrição -->
        <label for="txtDescricaoLocal">Descrição</label>
        <textarea class="form-control" id="txtDescricaoLocal" rows="3"></textarea>

    </div><!-- Fechaform-group -->

    <!-- Botoes do Modal -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-success" id="btnCadastrarLocais">Salvar mudanças</button>
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
        $("#formCadastrarLocal").validate({
           rules : {
                 txtNomeLocal:{
                        required: true,
                        minlength: 6
                 }, 
                 txtBlocoLocal:{
                        required: true,
                        minlength: 6
                 }          
           },
           messages:{
                 txtNomeLocal:{
                        required:"Por favor, informe um local!",
                        minlength: "mínimo 6 caracteres!"
                 },
                 txtBlocoLocal:{
                        required:"Por favor, informe um bloco!",
                        minlength: "mínimo 6 caracteres!"
                 }
           }
        });

        // Botao de cadastro
        $('#btnCadastrarLocais').on('click', function() {

            // Pegando valores através do jQuery
            var NomeLocal = $('#txtNomeLocal').val();
            var BlocoLocal = $('#txtBlocoLocal').val();
            var DescricaoLocal = $('#txtDescricaoLocal').val();

            if ($("#formCadastrarLocal").valid()) {

             // Requisição para query de inserir
                $.ajax({
                    type: 'POST',
                    url: '<?=$raiz ?>Telas/Locais/Cadastrar/insertLocalQuery.php',
                    success: function() {
                        // fechando modal apos ação
                        $('#modal').modal('hide');

                        // Atualizando datatable quando fechar o modal
                        $("#datatable-locais").DataTable().ajax.reload();

                        toastr.success('Local cadastrado com sucesso!');
                    },
                    data: {
                        // enviando para a query de insert
                        'NomeLocalQuery':      NomeLocal,
                        'BlocoLocalQuery':     BlocoLocal,
                        'DescricaoLocalQuery': DescricaoLocal
                    }
                });
            }else{
                toastr.warning('Insira informações válidas!');
            }
        });
    });
</script>