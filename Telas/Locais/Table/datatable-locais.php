<?php

//Pegando Links adicionados a raiz
$raiz = '../../../';

// Incluindo conexao
include('../../../PHP/conexao.php');

// Consulta para o filtro de locais
$consultaBloco = mysqli_query($con, "

    SELECT idLocal, blocoLocal 
    FROM tb_locais 
    ORDER BY blocoLocal ASC

")OR DIE (mysqli_error($con));

//Ativa o buffer de saida
ob_start();


?>

<!-- Html da datatable -->
<table id="datatable-locais" class="table table-striped table-bordered" style="width:100%">
	<thead>
	<div class="form-row align-items-center">

			<!-- Filtros -->

		        <div class="col-md-2">
		        	<label for="blocosFilter">Bloco</label>
		            <select class="custom-select" id="blocosFilter">
		            	<option value="">Todos</option>
		                <?php 
	                	while($prod = mysqli_fetch_assoc($consultaBloco)) { ?>
	                   		<option value="<?php echo $prod['blocoLocal'] ?>"><?php echo $prod['blocoLocal'] ?></option>
	               		<?php } ?>
		            </select>
		        </div>

		        <div>
	             	<button class="btn btn-light" id="btnLimpaFilter" style="margin-top: 30px;">Limpar Filtros</button>
		        </div>
		    <!-- Fecha Filtros -->
        </div>
		<p>
		<tr>
			<th>Local</th>
			<th>Bloco</th>
			<th>Descrição</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function() {

		//Filtros

			//Filtro blocos
			$('#blocosFilter').on('change', function(e){
				$("#datatable-locais").DataTable().ajax.reload();
			});

			//Botao de limpar 
			$('#btnLimpaFilter').on('click', function(){

				$('#blocosFilter').val('');
				$("#datatable-locais").DataTable().ajax.reload();
			});
		//

		// Botao de DELETE
		$('#datatable-locais tbody').on('click', '.btnDelete', function(e) {

			//Pegando ID de cada linha no click
			var idLinha = (e.currentTarget.attributes["data-id"].value);

			// Requisição para o modal
			$.ajax({
				type: 'POST',
				url: '../Deletar/modalDeletarLocais.php',
				success: function(data) {
					// Atribuindo Modal
					$('.modal-content').html(data);
				},
				data: {
					// enviando ID para o modal
					idLocalTable: idLinha
				}
			});
		});

		// Botao de UPDATE
		$('#datatable-locais tbody').on('click', '.btnUpdate', function(e) {

			//Pegando ID de cada linha no click
			var idLinha = (e.currentTarget.attributes["data-id"].value);

			// Requisição para o modal
			$.ajax({
				type: 'POST',
				url: '../Alterar/modalAlterarLocais.php',
				success: function(data) {
					// Atribuindo Modal
					$('.modal-content').html(data);
				},
				data: {
					// enviando ID para o modal
					idLocalTable: idLinha
				}
			});
		});

		// Executando datatable
		$('#datatable-locais').DataTable({

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
				"url": "query-datatable-locais.php",
				"type": "POST",
				"data": {
					blocosFilter: function(){
						return $('#blocosFilter').val();
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
					// Bloco
					data: 1,
					class: "text-center"
				},
				{
					// Descricao
					data: 2,
					class: "text-center"
				},
				{
					// Acoes
					data: 3,
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
						$("#datatable-locais").DataTable().ajax.reload();
					},
				},
				{
					//Adicionar Local
					text: 'Novo Local',
					className: 'btn btn-success btn-create',
					action: function() {

						// Atribui data-toggle e data-target via jQuery
						$('.btn-create').attr('data-toggle', 'modal');
						$('.btn-create').attr('data-target', '#modal');

						// Requisição para o modal
						$.ajax({
							type: 'GET',
							url: '../Cadastrar/modalCadastrarLocais.php',
							success: function(data) {
								// Atribuindo Modal
								$('.modal-content').html(data);
							},
						});
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
$pageheader = "Locais";

//Titulo
$pagetitle = "Locais";

//Aplicando o template da master
include("../../../master.php");
?>