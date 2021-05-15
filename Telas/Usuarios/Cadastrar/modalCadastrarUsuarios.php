<!-- Titulo do modal -->
<div class="modal-header">
    <h5 class="modal-title">Cadastrar Novo Usuario</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Abre Form do modal -->
<form method="POST" action="" name="formCadastrarUsuario" id="formCadastrarUsuario">

    <!-- Abre form-row -->
    <div class="form-row">

        <!-- Input Nome -->
        <div class="form-group col-md-11">
            <label for="txtNomeUsuario">Nome</label>
            <input type="text" class="form-control" placeholder="Nome do usuário" id="txtNomeUsuario" name="txtNomeUsuario" value="">
        </div>

        <!-- Input Login Usuario -->
        <div class="form-group col-md-11">
            <label for="txtLoginUsuario">Login</label>
            <input type="text" class="form-control" placeholder="Login do Usuario" id="txtLoginUsuario" name="txtLoginUsuario" value="">
        </div>

        <!-- Input E-mail -->
        <div class="form-group col-md-11">
            <label for="txtEmailUsuario">E-mail</label>
            <input type="text" class="form-control" placeholder="exemplo@exemplo.com.br" id="txtEmailUsuario" name="txtEmailUsuario" value="">
        </div>

        <!-- Input Senha -->
        <div class="form-group col-md-5">
            <label for="txtSenhaUsuario">Senha</label>
            <input type="password" class="form-control" placeholder="Senha" id="txtSenhaUsuario" name="txtSenhaUsuario" value="">
        </div>

        <!-- Input confirma senha -->
        <div class="form-group col-md-5">
            <label for="txtConfirmSenhaUsuario">Confirmar senha</label>
            <input type="password" class="form-control" placeholder="Senha" id="txtConfirmSenhaUsuario" name="txtConfirmSenhaUsuario" value="">
        </div>

        <!-- cbx Tipo acesso -->
        <div class="form-group col-md-5">
            <label for="cbxTipoAcesso">Tipo de Aesso</label>
            <select class="custom-select" id="cbxTipoAcesso">
                <option value="FUN">Funcionário</option>
                <option value="ADM" style="color:red;">Administrador</option>
            </select>   
        </div>
    </div><!-- Fecha form-row -->
        <p>
    <!-- Botoes do Modal -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-success" id="btnCadastrar">Salvar mudanças</button>
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
        $("#formCadastrarUsuario").validate({
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

        // Botao de cadastro
        $('#btnCadastrar').on('click', function() {

            // Pegando valores através do jQuery
            var NomeUsuario = $('#txtNomeUsuario').val();
            var LoginUsuario = $('#txtLoginUsuario').val();
            var EmailUsuario = $('#txtEmailUsuario').val();
            var SenhaUsuario = $('#txtSenhaUsuario').val();
            var TipoAcessoUsuario = $('#cbxTipoAcesso').val();

            if ($("#formCadastrarUsuario").valid()) {
                // Requisição para query de inserir
                $.ajax({
                    type: 'POST',
                    url: '../Cadastrar/insertUsuarioQuery.php',
                    success: function() {
                        // fechando modal apos ação
                        $('#modal').modal('hide');

                        // Atualizando datatable quando fechar o modal
                        $("#datatable-usuarios").DataTable().ajax.reload();

                        toastr.success('Usuário cadastrado com sucesso!');
                    },
                    data: {
                        // enviando para a query de insert
                        'NomeUsuarioQuery':       NomeUsuario,
                        'LoginUsuarioQuery':      LoginUsuario,
                        'EmailUsuarioQuery':      EmailUsuario,
                        'SenhaUsuarioQuery':      SenhaUsuario,
                        'TipoAcessoUsuarioQuery': TipoAcessoUsuario
                    }
                });
            }else{
                toastr.warning('Insira informações válidas!');
            }
        });
    });
</script>