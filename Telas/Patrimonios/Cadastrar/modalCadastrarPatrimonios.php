<?php

//Verificar se a sessão não já está aberta.
if (!isset($_SESSION)) {
	// Iniciando a sessao
	session_start();
}

//Pegando Links adicionados a raiz
$raiz = '../../../';

// Incluindo conexao
include('../../../PHP/conexao.php');

$consultaLocal = mysqli_query($con, "

    SELECT idLocal, nomeLocal 
    FROM tb_locais 
    ORDER BY nomeLocal ASC

")OR DIE (mysqli_error($con));

?>

<!-- Titulo do modal -->
<div class="modal-header">
    <h5 class="modal-title">Cadastrar Novo Patrimonio</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Abre Form do modal -->
<form method="POST" action="" name="formCadastrarPatrimonio" id="formCadastrarPatrimonio">

    <!-- Abre form-row -->
    <div class="form-row">

        <!-- Input txtNomePatrimonio -->
        <div class="form-group col-md-5">
            <label for="txtNomePatrimonio">Nome do Patrimônio</label>
            <input type="text" class="form-control" placeholder="Nome" id="txtNomePatrimonio" name="txtNomePatrimonio" value="">
        </div>

        <!-- Input txtNumeroPatrimonio -->
        <div class="form-group col-md-5">
            <label for="txtNumeroPatrimonio">Número do Patrimônio</label>
            <input type="number" class="form-control" placeholder="Número" id="txtNumeroPatrimonio" name="txtNumeroPatrimonio" value="">
        </div>

        <!-- Input cbxPertencentePatrimonio -->
        <div class="form-group col-md-5">
            <label for="cbxPertencentePatrimonio">Pertencente</label>
            <select class="custom-select" id="cbxPertencentePatrimonio">
                <!-- Condição que compara com o registro no banco, ao ser igual, sera selecionado -->
                <option value="CPS">CPS</option>
                <option value="APM">APM</option>
            </select>
        </div>

        <!-- Input cbxStatusPatrimonio -->
        <div class="form-group col-md-5">
            <label for="cbxStatusPatrimonio">Status</label>
            <select class="custom-select" id="cbxStatusPatrimonio">
                <option value="Bom">Bom</option>
                <option value="Regular">Regular</option>
                <option value="Ruim">Ruim</option>
                <option value="ForaDeUso">Fora de Uso</option>
            </select>
        </div>

        <!-- Input cbxlLocalPatrimonio -->
        <div class="form-group col-md-5">
            <label for="cbxlLocalPatrimonio">Local</label>
            <select class="custom-select" id="cbxlLocalPatrimonio">
                <?php 
                while($prod = mysqli_fetch_assoc($consultaLocal)) { ?>
                    <?php if($prod != '' && $prod != null && $prod != [] && $prod != 'undefined') : ?>
                        <option value="<?php echo $prod['idLocal'] ?>"><?php echo $prod['nomeLocal'] ?></option>
                            <?php else : ?>
                                <option value="">Sem Local</option>
                    <?php endif; ?>
                <?php } ?>
           </select>
       </div>

        <!-- Input dtDataPatrimonio -->
        <div class="form-group col-md-5">
             <label for="dtDataPatrimonio">Data de Chegada</label>
             <input type="date" class="form-control" id="dtDataPatrimonio" name="dtDataPatrimonio" value="">
        </div>
    </div><!-- Fecha form-row -->

    <!-- Textarea txtDescricaoPatrimonio -->
    <div class="form-group">
        <label for="txtDescricaoPatrimonio">Descrição</label>
        <textarea class="form-control" id="txtDescricaoPatrimonio" rows="3" placeholder="Descrição do item"></textarea>
    </div>

    <!-- Botoes do Modal -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-success" id="btnCadastrar">Salvar mudanças</button>
    </div>
</form><!-- Fecha Form do modal -->

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
        $("#formCadastrarPatrimonio").validate({
           rules : {
                 txtNomePatrimonio:{
                        required: true,
                        minlength: 6
                 }, 
                 txtNumeroPatrimonio:{
                        required: true,
                        number: true,
                        minlength: 11,
                        maxlength: 11
                 },
                 cbxPertencentePatrimonio:{
                        required: true
                 },
                 cbxStatusPatrimonio:{
                        required: true
                 },
                 cbxlLocalPatrimonio:{
                        required: true
                 },
                 dtDataPatrimonio:{
                        required: true
                 }          
           },
           messages:{
                 txtNomePatrimonio:{
                        required:"Por favor, informe o nome do patrimônio!",
                        minlength: "mínimo 6 caracteres!"
                 },
                 txtNumeroPatrimonio:{
                        required:"Por favor, informe um numero de patrimônio!",
                        number: "Insira um número válido!",
                        minlength: "mínimo 11 caracteres!",
                        maxlength: "máximo 11 caracteres!"
                 },
                 cbxPertencentePatrimonio:{
                        required: "Por favor, selecione um pertencente!"
                 },
                 cbxStatusPatrimonio:{
                        required: "Por favor, selecione um status!"
                 },
                 cbxlLocalPatrimonio:{
                        required: "Por favor, selecione um local!"
                 },
                 dtDataPatrimonio:{
                        required: "Por favor, selecione a data de chegada !"
                 }  
           }
        });

        // Botao de cadastro
        $('#btnCadastrar').on('click', function() {

            // Pegando valores através do jQuery
            var NomePatrimonio = $('#txtNomePatrimonio').val();
            var NumeroPatrimonio = $('#txtNumeroPatrimonio').val();
            var PertencentePatrimonio = $('#cbxPertencentePatrimonio').val();
            var StatusPatrimonio = $('#cbxStatusPatrimonio').val();
            var LocalPatrimonio = $('#cbxlLocalPatrimonio').val();
            var DataPatrimonio = $('#dtDataPatrimonio').val();
            var DescricaoPatrimonio = $('#txtDescricaoPatrimonio').val();

            if ($("#formCadastrarPatrimonio").valid()) {
                console.log('entrou');
                // Requisição para query de inserir
                $.ajax({
                    type: 'POST',
                    url: '../Cadastrar/insertPatrimonioQuery.php',
                    success: function() {
                        // fechando modal após ação
                        $('#modal').modal('hide');

                        // Atualizando datatable quando fechar o modal
                        $("#datatable-patrimonios").DataTable().ajax.reload();

                        toastr.success('Patrimônio cadastrado com sucesso!');
                    },
                    data: {
                        // enviando para a query de insert
                        'NomePatrimonioQuery':        NomePatrimonio,
                        'NumeroPatrimonioQuery':      NumeroPatrimonio,
                        'PertencentePatrimonioQuery': PertencentePatrimonio,
                        'StatusPatrimonioQuery':      StatusPatrimonio,
                        'LocalPatrimonioQuery':       LocalPatrimonio,
                        'DataPatrimonioQuery':        DataPatrimonio,
                        'DescricaoPatrimonioQuery':   DescricaoPatrimonio
                    }
                });// Fecha Ajax
            }else{
                toastr.warning('Insira informações válidas!');
            }
        });
    });
</script>