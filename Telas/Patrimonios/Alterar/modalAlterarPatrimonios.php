<?php

include('../../../PHP/conexao.php');

// Recebendo ID da tabela
$idPatrimonioModal = $_POST['idPatrimonioTable'];

// Query para consultar dados 
$consultaPatrimonios = mysqli_query($con, "

    SELECT * FROM tb_patrimonios 
    where idPatrimonio = '".$idPatrimonioModal."'

    ")OR DIE (mysqli_error($con));

// Query para consultar os locais
$consultaLocais = mysqli_query($con, "

    SELECT * FROM tb_locais 
    ORDER BY nomeLocal ASC

    ")OR DIE (mysqli_error($con));

// Query pegando dados do banco
while($rowPatrimonios = mysqli_fetch_array($consultaPatrimonios))
{
    $NomePatrimonio = $rowPatrimonios['nomePatrimonio'];
    $NumeroPatrimonio = $rowPatrimonios['numeroPatrimonio'];
    $PertencentePatrimonio = $rowPatrimonios['pertencentePatrimonio'];
    $StatusPatrimonio = $rowPatrimonios['statusPatrimonio'];
    $LocalPatrimonio = $rowPatrimonios['idLocal'];
    $DataPatrimonio = $rowPatrimonios['dataPatrimonio'];
    $DescricaoPatrimonio = $rowPatrimonios['descricaoPatrimonio'];
}

?>

<!-- Titulo do modal -->
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Alterar Patrimonio</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Abre Form do modal -->
<form method="POST" action="" name="formAlterarPatrimonio" id="formAlterarPatrimonio">

    <!-- Abre form-row -->
    <div class="form-row">

        <!-- Input txtNomePatrimonio -->
        <div class="form-group col-md-5">
            <label for="txtNomePatrimonio">Nome do Patrimônio</label>
            <input type="text" class="form-control" placeholder="Nome" id="txtNomePatrimonio" name="txtNomePatrimonio" value="<?php echo $NomePatrimonio ?>">
        </div>

        <!-- Input txtNumeroPatrimonio -->
        <div class="form-group col-md-5">
            <label for="txtNumeroPatrimonio">Número do Patrimônio</label>
            <input type="number" class="form-control" placeholder="Número" id="txtNumeroPatrimonio" name="txtNumeroPatrimonio" value="<?php echo $NumeroPatrimonio ?>">
        </div>

        <!-- Input cbxPertencentePatrimonio -->
        <div class="form-group col-md-5">
            <label for="cbxPertencentePatrimonio">Pertencente</label>
            <select class="custom-select" id="cbxPertencentePatrimonio">
                <!-- Condição que compara com o registro no banco, ao ser igual, sera selecionado -->
                <option value="CPS" <?=($PertencentePatrimonio == 'CPS')?'selected':''?> >CPS</option>
                <option value="APM" <?=($PertencentePatrimonio == 'APM')?'selected':''?> >APM</option>
            </select>
        </div>

        <!-- Input cbxStatusPatrimonio -->
        <div class="form-group col-md-5">
            <label for="cbxStatusPatrimonio">Status</label>
            <select class="custom-select" id="cbxStatusPatrimonio">
                <!-- Condição que compara com o registro no banco, ao ser igual, sera selecionado -->
                <option value="Bom" <?=($StatusPatrimonio == 'Bom')?'selected':''?> >Bom</option>
                <option value="Regular" <?=($StatusPatrimonio == 'Regular')?'selected':''?> >Regular</option>
                <option value="Ruim" <?=($StatusPatrimonio == 'Ruim')?'selected':''?> >Ruim</option>
                <option value="ForaDeUso" <?=($StatusPatrimonio == 'ForaDeUso')?'selected':''?>>Fora de Uso</option> 
            </select>
        </div>

        <!-- Input cbxlLocalPatrimonio -->
        <div class="form-group col-md-5">
            <label for="cbxlLocalPatrimonio">Local</label>
            <select class="custom-select" id="cbxlLocalPatrimonio">
                <!-- Condição para exibir os locais, quando o local for igual nas duas tabelas, ele sera selecionado -->
                <?php while($consLocais = mysqli_fetch_assoc($consultaLocais)):?>
                    <option value="<?php echo $consLocais['idLocal']; ?>"
                        <?php if($consLocais['idLocal'] == $LocalPatrimonio) 
                            echo "selected";
                        ?>   
                    >
                <?php echo $consLocais['nomeLocal'] ?>
                </option><!-- Fecha Option -->
                <?php endwhile; ?>
           </select>
       </div>

        <!-- Input dtDataPatrimonio -->
       <div class="form-group col-md-5">
         <label for="dtDataPatrimonio">Data de Chegada</label>
         <input type="date" class="form-control" id="dtDataPatrimonio" name="dtDataPatrimonio" value="<?php echo $DataPatrimonio ?>">
       </div>
    </div><!-- Fecha form-row -->

    <!-- Textarea txtDescricaoPatrimonio -->
    <div class="form-group">
        <label for="txtDescricaoPatrimonio">Descrição</label>
        <textarea class="form-control" id="txtDescricaoPatrimonio" rows="3" placeholder="Descrição do item"><?php echo $DescricaoPatrimonio ?></textarea>
    </div>

    <!-- Botoes do Modal -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-success" id="btnUpdate">Salvar mudanças</button>
    </div>
</form><!-- Fecha Form do modal -->

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

        // Validaçao Form
        $("#formAlterarPatrimonio").validate({
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

        // Botao de update
        $('#btnUpdate').on('click', function(){

            // Pegando valores através do jQuery
            var idPatrimonioModal = "<?php echo $idPatrimonioModal;?>";
            var NomePatrimonio = $('#txtNomePatrimonio').val();
            var NumeroPatrimonio = $('#txtNumeroPatrimonio').val();
            var PertencentePatrimonio = $('#cbxPertencentePatrimonio').val();
            var StatusPatrimonio = $('#cbxStatusPatrimonio').val();
            var LocalPatrimonio = $('#cbxlLocalPatrimonio').val();
            var DataPatrimonio = $('#dtDataPatrimonio').val();
            var DescricaoPatrimonio = $('#txtDescricaoPatrimonio').val();

            if ($("#formAlterarPatrimonio").valid()) {
                // Requisição para query de update
                $.ajax({
                    type: 'POST',
                    url: '../Alterar/updatePatrimonioQuery.php',
                    success: function() {
                        // fechando modal após ação
                        $('#modal').modal('hide');

                        // Atualizando datatable quando fechar o modal
                        $("#datatable-patrimonios").DataTable().ajax.reload();

                        toastr.success('Patrimônio alterado com sucesso!');
                    },
                    data: {
                        // enviando para a query de update
                        'NomePatrimonioQuery':        NomePatrimonio,
                        'NumeroPatrimonioQuery':      NumeroPatrimonio,
                        'PertencentePatrimonioQuery': PertencentePatrimonio,
                        'StatusPatrimonioQuery':      StatusPatrimonio,
                        'LocalPatrimonioQuery':       LocalPatrimonio,
                        'DataPatrimonioQuery':        DataPatrimonio,
                        'DescricaoPatrimonioQuery':   DescricaoPatrimonio,
                        'idPatrimonioQuery':          idPatrimonioModal
                    }
                });// Fecha Ajax
            }else{
                toastr.warning('Insira informações válidas!');
            }
        });
    });
</script>