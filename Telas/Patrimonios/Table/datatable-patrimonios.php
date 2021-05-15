<?php

//Pegando Links adicionados a raiz
$raiz = '../../../';

// Incluindo conexao
include('../../../PHP/conexao.php');

// Consulta para o filtro de locais
$consultaLocal = mysqli_query($con, "

    SELECT idLocal, nomeLocal 
    FROM tb_locais 
    ORDER BY nomeLocal ASC

")OR DIE (mysqli_error($con));

//Ativa o buffer de saida
ob_start();
?>

<!-- Html da datatable -->
<table id="datatable-patrimonios" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<div class="form-row align-items-center">

			<!-- Filtros -->

		        <div class="col-md-2">
		        	<label for="localFilter">Local</label>
		            <select class="custom-select" id="localFilter">
		            	<option value="">Todos</option>
		                <?php 
	                	while($prod = mysqli_fetch_assoc($consultaLocal)) { ?>
	                   		<option value="<?php echo $prod['idLocal'] ?>"><?php echo $prod['nomeLocal'] ?></option>
	               		<?php } ?>
		            </select>
		        </div>

		        <div class="col-md-2">
		        	<label for="pertencenteFilter">Pertencente</label>
		            <select class="custom-select" id="pertencenteFilter">
		            	<option value="">Todos</option>
		                <option value="CPS">CPS</option>
		                <option value="APM">APM</option>
		            </select>
		        </div>

		        <div class="col-md-2">
		        	<label for="estadoFilter">Estado</label>
		            <select class="custom-select" id="estadoFilter">
		            	<option value="">Todos</option>
		                <option value="Bom">Bom</option>
		                <option value="Regular">Regular</option>
		                <option value="Ruim">Ruim</option>
		                <option value="ForaDeUso">Fora de Uso</option>
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
			<th>Nome do Patrimonio</th>
			<th>Número do Patrimônio</th>
			<th>Pertencente</th>
			<th>Estado</th>
			<th>Local</th>
			<th>Data de Chegada</th>
			<th>Descrição</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<script>
	$(document).ready(function() {

		//Filtros

			//Filtro de local
			$('#localFilter').on('change', function(e){
				$("#datatable-patrimonios").DataTable().ajax.reload();
			});

			//Filtro de pertencente
			$('#pertencenteFilter').on('change', function(e){
				$("#datatable-patrimonios").DataTable().ajax.reload();
			});

			//Filtro de estado
			$('#estadoFilter').on('change', function(e){
				$("#datatable-patrimonios").DataTable().ajax.reload();
			});

			//Filtro de data inicial
			$('#dtInicialFilter').on('change', function(e){
				$("#datatable-patrimonios").DataTable().ajax.reload();
			});

			//Filtro de data final
			$('#dtFinalFilter').on('change', function(e){
				$("#datatable-patrimonios").DataTable().ajax.reload();
			});

			//Botao de limpar 
			$('#btnLimpaFilter').on('click', function(){

				$('#localFilter').val('');
				$('#pertencenteFilter').val('');
				$('#estadoFilter').val('');
				$('#dtInicialFilter').val('');
				$('#dtFinalFilter').val('');

				$("#datatable-patrimonios").DataTable().ajax.reload();
			});
		//

		// Botao de DELETE
		$('#datatable-patrimonios tbody').on('click', '.btnDelete', function(e) {

			//Pegando ID de cada linha no click
			var idLinha = (e.currentTarget.attributes["data-id"].value);

			// Requisição para o modal
			$.ajax({
				type: 'POST',
				url: '../Deletar/modalDeletarPatrimonios.php',
				success: function(data) {
					// Atribuindo Modal
					$('.modal-content').html(data);
				},
				data: {
					// enviando ID para o modal
					idPatrimonioTable: idLinha
				}
			});
		});

		// Botao de UPDATE
		$('#datatable-patrimonios tbody').on('click', '.btnUpdate', function(e) {

			//Pegando ID de cada linha no click
			var idLinha = (e.currentTarget.attributes["data-id"].value);

			// Requisição para o modal
			$.ajax({
				type: 'POST',
				url: '../Alterar/modalAlterarPatrimonios.php',
				success: function(data) {
					// Atribuindo Modal
					$('.modal-content').html(data);
				},
				data: {
					// enviando ID para o modal
					idPatrimonioTable: idLinha
				}
			});
		});

		// Executando datatable
		$('#datatable-patrimonios').DataTable({

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
				"url": "query-datatable-patrimonios.php",
				"type": "POST",
				"data": {
					localFilter: function(){
						return $('#localFilter').val();
					},
					pertencenteFilter: function(){
						return $('#pertencenteFilter').val();
					},
					estadoFilter: function(){
						return $('#estadoFilter').val();
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
					// Nome do Patrimonio
					data: 0,
					class: "text-left"
				},
				{
					// Numero de Patrimonio
					data: 1,
					class: "text-center"
				},
				{
					// Pertencente
					data: 2,
					class: "text-center"
				},
				{
					// Status
					data: 3,
					class: "text-center"
				},
				{
					// Local
					data: 4,
					class: "text-center"
				},
				{
					// Data de chegada
					data: 5,
					class: "text-center"
				},
				{
					// Descrição
					data: 6,
					class: "text-center"
				},
				{
					// Ações
					data: 7,
					orderable: false,
					class: "text-center"
				}
				],
			// Fecha Columns

			// Quantidade de dados em exibição
				lengthMenu: [
					[10, 25, 50, -1],
					['10', '25', '50', 'All']
				],
			//

			// Botoes
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
						columns: [ 0, 1, 2, 3 , 4 , 5 , 6 ]
					}
				},
				{
					//Excel
					extend: 'excel',
					text: '<i class="fas fa-file-excel"></i>',
					exportOptions: {
						columns: [ 0, 1, 2, 3 , 4 , 5 , 6 ]
					}
				},
				{
					//CSV
					extend: 'csv',
					text: '<i class="fas fa-file-csv"></i>',
					exportOptions: {
						columns: [ 0, 1, 2, 3 , 4 , 5 , 6 ]
					}
				},
				{
					//Pdf
					extend: 'pdf',
					text: '<i class="fas fa-file-pdf"></i>',
					exportOptions: {
						columns: [ 0, 1, 2, 3 , 4 , 5 , 6 ]
					}
				},
				{
					//Imprimir
					extend: 'print',
					text: '<i class="fas fa-print"></i>',
					exportOptions: {
						columns: [ 0, 1, 2, 3 , 4 , 5 , 6 ]
					}
				},
				{
					//Atualizar
					text: '<i class="fas fa-redo"></i>',
					action: function() {
						$("#datatable-patrimonios").DataTable().ajax.reload();
					},
				},
				{
					//Adicionar Patrimonio
					text: 'Novo Patrimônio',
					className: 'btn btn-success btn-create',
					action: function() {

						// Atribui data-toggle e data-target via jQuery
						$('.btn-create').attr('data-toggle', 'modal');
						$('.btn-create').attr('data-target', '#modal');

						// Requisição para o modal
						$.ajax({
							type: 'GET',
							url: '../Cadastrar/modalCadastrarPatrimonios.php',
							success: function(data) {
								// Atribuindo Modal
								$('.modal-content').html(data);
							},
						});
					},
				},
			] 
			// Fecha Botoes

		}); 
		// Fecha datatable
	});
</script>

<?php

//Atribuindo a pagina
$pagemaincontent = ob_get_contents();

//Fecha buffer e limpa
ob_end_clean();

//Header
$pageheader = "Patrimônios";

//Titulo
$pagetitle = "Patrimônios";

//Aplicando master
include("../../../master.php");

?>