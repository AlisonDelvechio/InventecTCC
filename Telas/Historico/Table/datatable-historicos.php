<?php

//Pegando Links adicionados a raiz
$raiz = '../../../';

// Incluindo conexao
include('../../../PHP/conexao.php');

//Ativa o buffer de saida
ob_start();

// Consulta para o filtro de usuarios
$consultaPessoas = mysqli_query($con, "

    SELECT idPessoa, nomePessoa
    FROM tb_pessoas
    ORDER BY nomePessoa ASC

")OR DIE (mysqli_error($con));

?>

<!-- Html da datatable -->
<table id="datatable-historicos" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<div class="form-row align-items-center">

			<!-- Filtros -->

				<div class="col-md-2">
		        	<label for="pessoasFilter">Pessoas</label>
		            <select class="custom-select" id="pessoasFilter">
		            	<option value="">Todos</option>
		                <?php 
	                	while($prod = mysqli_fetch_assoc($consultaPessoas)) { ?>
	                   		<option value="<?php echo $prod['idPessoa'] ?>"><?php echo $prod['nomePessoa'] ?></option>
	               		<?php } ?>
		            </select>
		        </div>

				<div class="col-md-2">
					<label for="acoesFilter">Ações</label>
					<select class="custom-select" id="acoesFilter">
						<option value="">Todos</option>
						<option value="I">Cadastro</option>
						<option value="D">Exclusão</option>
						<option value="U">Alteração</option>
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
			<th>Nome</th>
			<th>Data e Hora</th>
			<th>Atividade</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function() {

		//Filtros

			//Filtro pessoas
			$('#pessoasFilter').on('change', function(e){
				$("#datatable-historicos").DataTable().ajax.reload();
			});

			//Filtro de acoes
			$('#acoesFilter').on('change', function(e){
				$("#datatable-historicos").DataTable().ajax.reload();
			});

			//Filtro de data inicial
			$('#dtInicialFilter').on('change', function(e){
				$("#datatable-historicos").DataTable().ajax.reload();
			});

			//Filtro de data final
			$('#dtFinalFilter').on('change', function(e){
				$("#datatable-historicos").DataTable().ajax.reload();
			});

			//Botao de limpar 
			$('#btnLimpaFilter').on('click', function(){

				$('#pessoasFilter').val('');
				$('#acoesFilter').val('');
				$('#dtInicialFilter').val('');
				$('#dtFinalFilter').val('');

				$("#datatable-historicos").DataTable().ajax.reload();
			});
		//

		// Executando datatable
		$('#datatable-historicos').DataTable({

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
				"url": "query-datatable-historicos.php",
				"type": "POST",
				"data": {
					pessoasFilter: function(){
						return $('#pessoasFilter').val();
					},
					acoesFilter: function(){
						return $('#acoesFilter').val();
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
					// Nome
					data: 0,
					class: "text-left"
				},
				{
					// Data e hora
					data: 1,
					class: "text-center"
				},
				{
					// Atividade
					data: 2,
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
						$("#datatable-historicos").DataTable().ajax.reload();
					},
				}
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
$pageheader = "Históricos de ação";

//Titulo
$pagetitle = "Históricos de ação";

//Aplicando o template da master
include("../../../master.php");
?>