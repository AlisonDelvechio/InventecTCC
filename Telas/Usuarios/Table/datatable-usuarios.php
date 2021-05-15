<?php

//Verificar se a sessão não já está aberta.
if (!isset($_SESSION)) {
	// Iniciando a sessao
	session_start();
}

// Recebendo valores da sessao
$UsuarioTela = $_SESSION['UsuarioTela'];
$UsuarioSenha = $_SESSION['UsuarioSenha'];
$idUsuario = $_SESSION['idUsuario'];
$TipoAcesso = $_SESSION['tipoAcesso'];

//Pegando Links adicionados a raiz
$raiz = '../../../';

//Ativa o buffer de saida
ob_start();
?>

<!-- Html da datatable -->
<table id="datatable-usuarios" class="table table-striped table-bordered" style="width:100%">
	<thead>
	<div class="form-row align-items-center">

		<!-- Filtros -->

			<div class="col-md-2">
				<label for="tipoAcessoFilter">Tipo de Acesso</label>
				<select class="custom-select" id="tipoAcessoFilter">
					<option value="">Todos</option>
					<option value="ADM">Administrador</option>
					<option value="FUN">Funcionário</option>
				</select>
			</div>

			<div class="col-md-2">
				<label for="dtInicialFilter">Data Inicial</label>
				<input type="date" class="form-control" id="dtInicialFilter" name="dtInicialFilter" value=""  blur="filter();">
			</div>

			<div class="col-md-2">
				<label for="dtFinalFilter">Data Final</label>
				<input type="date" class="form-control" id="dtFinalFilter" name="dtFinalFilter" value="" blur="filter();">
			</div>

			<div>
				<button class="btn btn-light" id="btnLimpaFilter" style="margin-top: 30px;">Limpar Filtros</button>
			</div>
		<!-- Fecha Filtros -->
		</div>
		<p>
		<tr>
			<th>Usuário</th>
			<th>Nome</th>
			<th>E-mail</th>
			<th>Data de Inclusão</th>
			<th>Tipo de Acesso</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function() {

		// Variavel para pegar tipo acesso
		TipoAcesso = "<?php echo $TipoAcesso;?>";

		// Mensagem do sistema
        toastr.options = {
            progressBar: true,
            closeButton: true,
            hideDuration: 100,
            tapToDismiss: true,
            positionClass: "toast-bottom-center"
        };

		//Filtros

			//Filtro de Tipo Acesso
			$('#tipoAcessoFilter').on('change', function(e){
				$("#datatable-usuarios").DataTable().ajax.reload();
			});

			//Filtro de data inicial
			$('#dtInicialFilter').on('change', function(e){
				$("#datatable-usuarios").DataTable().ajax.reload();
			});

			//Filtro de data final
			$('#dtFinalFilter').on('change', function(e){
				$("#datatable-usuarios").DataTable().ajax.reload();
			});

			//Botao de limpar 
			$('#btnLimpaFilter').on('click', function(){

				$('#localFilter').val('');
				$('#pertencenteFilter').val('');
				$('#estadoFilter').val('');
				$('#dtInicialFilter').val('');
				$('#dtFinalFilter').val('');

				$("#datatable-usuarios").DataTable().ajax.reload();
			});
		//

		// Botao de DELETE
		$('#datatable-usuarios tbody').on('click', '.btnDelete', function(e) {

			//Pegando ID de cada linha no click
			var idLinha = (e.currentTarget.attributes["data-id"].value);

			// Requisição para o modal
			$.ajax({
				type: 'POST',
				url: '../Deletar/modalDeletarUsuarios.php',
				success: function(data) {
					// Atribuindo Modal
					$('.modal-content').html(data);
				},
				data: {
					// enviando ID para o modal
					idUsuarioTable: idLinha
				}
			});
		});

		// Botao de UPDATE
		$('#datatable-usuarios tbody').on('click', '.btnUpdate', function(e) {

			//Pegando ID de cada linha no click
			var idLinha = (e.currentTarget.attributes["data-id"].value);

			// Requisição para o modal
			$.ajax({
				type: 'POST',
				url: '../Alterar/modalAlterarUsuarios.php',
				success: function(data) {
					// Atribuindo Modal
					$('.modal-content').html(data);
				},
				data: {
					// enviando ID para o modal
					idUsuarioTable: idLinha
				}
			});
		});

		// Executando datatable
		$('#datatable-usuarios').DataTable({

			processing: true,
			serverSide: true,

			// Tradução da datatable
			language: {
				sEmptyTable: "Nenhum registro encontrado",
				sInfo: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
				sInfoEmpty: "Mostrando 0 até 0 de 0 registros",
				sInfoFiltered: "(Filtrados de _MAX_ registros)",
				sInfoPostFix: "",
				sInfoThousands: ".",
				sLengthMenu: "_MENU_ resultados por página",
				sLoadingRecords: "Carregando...",
				sProcessing: "Processando...",
				sZeroRecords: "Nenhum registro encontrado",
				sSearch: "Pesquisar",
				oPaginate: {
					sNext: "Próximo",
					sPrevious: "Anterior",
					sFirst: "Primeiro",
					sLast: "Último"
				},
				oAria: {
					sSortAscending: ": Ordenar colunas de forma ascendente",
					sSortDescending: ": Ordenar colunas de forma descendente"
				},
				select: {
					rows: {
						_: "Selecionado %d linhas",
						0: "Nenhuma linha selecionada",
						1: "Selecionado 1 linha"
					}
				},
				buttons: {
					pageLength: {
						_: "%d resultados ",
						"-1": "Todos Resultados"
					}
				}
			},
			// 

			//Dados da tabela vindo da query em json
			ajax: {
				"url": "query-datatable-usuarios.php",
				"type": "POST",
				"data": {
					tipoAcessoFilter: function(){
						return $('#tipoAcessoFilter').val();
					},
					dtInicialFilter: function(){
						return $('#dtInicialFilter').val();
					},
					dtFinalFilter: function(){
						return $('#dtFinalFilter').val();
					}
				}
			},

			// Colunas da datatable
			columns: [{
					// Login
					data: 0,
					class: "text-left"
				},
				{
					// Nome
					data: 1,
					class: "text-center"
				},
				{
					// E-mail
					data: 2,
					class: "text-center"
				},
				{
					// Data de inclusao
					data: 3,
					class: "text-center"
				},
				{
					// Tipo de acesso
					data: 4,
					class: "text-center"
				},
				{
					// Acoes
					data: 5,
					orderable: false,
					class: "text-center"
				}
			],

			// Quantidade de dados em exibição
			lengthMenu: [
				[10, 25, 50, -1],
				['10', '25', '50', 'All']
			],

			// Botões
			dom: 'Bfrtip',
			buttons: [{
					//Mostrar linhas
					extend: 'pageLength'
				},
				{
					//Copiar
					extend: 'copy',
					text: '<i class="fas fa-copy"></i>',
					className: 'borderStyle',
					exportOptions: {
						columns: [0, 1, 2]
					}
				},
				{
					//Excel
					extend: 'excel',
					text: '<i class="fas fa-file-excel"></i>',
					exportOptions: {
						columns: [0, 1, 2]
					}
				},
				{
					//CSV
					extend: 'csv',
					text: '<i class="fas fa-file-csv"></i>',
					exportOptions: {
						columns: [0, 1, 2]
					}
				},
				{
					//Pdf
					extend: 'pdf',
					text: '<i class="fas fa-file-pdf"></i>',
					exportOptions: {
						columns: [0, 1, 2]
					}
				},
				{
					//Imprimir
					extend: 'print',
					text: '<i class="fas fa-print"></i>',
					exportOptions: {
						columns: [0, 1, 2]
					}
				},
				{
					//Atualizar
					text: '<i class="fas fa-redo"></i>',
					action: function() {
						$("#datatable-usuarios").DataTable().ajax.reload();
					},
				},
				{
					//Adicionar Usuario
					text: 'Novo Usuario',
					className: 'btn btn-success btn-create',
					action: function() {

						if (TipoAcesso != 'FUN') {

							// Atribui data-toggle e data-target via jQuery
							$('.btn-create').attr('data-toggle', 'modal');
							$('.btn-create').attr('data-target', '#modal');

							// Requisição para o modal
							$.ajax({
								type: 'GET',
								url: '../Cadastrar/modalCadastrarUsuarios.php',
								success: function(data) {
									// Atribuindo Modal
									$('.modal-content').html(data);
								},
							});
							
						}else{
							$('.btn-create').attr('disabled', true);
							toastr.warning('Você não tem permissão para criar novos usuários!');
						}

						
					},
				},
			] // Fecha Columns
		}); // Fecha datatable
	});
</script>

<?php

//Atribuindo a pagina
$pagemaincontent = ob_get_contents();

//Fecha buffer e limpa
ob_end_clean();

//Header
$pageheader = "Usuários";

//Titulo
$pagetitle = "Usuários";

//Aplicando o template da master
include("../../../master.php");
?>