<?php

// Conexao
include('../../../PHP/conexao.php');

//Receber requisição da pesquisa
$requestData = $_REQUEST;

//Posição dos dados na tabela, onde os dados se referente ao banco
$columns = array(
	
	0 => 'nomePatrimonio',
	1 => 'numeroPatrimonio',
	2 => 'pertencentePatrimonio',
	3 => 'statusPatrimonio',
	4 => 'nomeLocal',
	5 => 'dataPatrimonio',
	6 => 'descricaoPatrimonio',
	7 => 'acoes'

);

// Obtendo total de registros do banco
$result_patrimonio = "

	SELECT idPatrimonio, 
	nomePatrimonio, 
	numeroPatrimonio, 
	pertencentePatrimonio, 
	statusPatrimonio, 
	tb_locais.idLocal,
	nomeLocal, 
	dataPatrimonio, 
	descricaoPatrimonio 
	FROM tb_patrimonios
	INNER JOIN tb_locais ON (tb_locais.idLocal = tb_patrimonios.idLocal)

";

// Atribuindo as variaveis
$resultado_patrimonio = mysqli_query($con, $result_patrimonio);
$qnt_linhas = mysqli_num_rows($resultado_patrimonio);

// Obtendo dados a serem apresentados
$result_patrimonios = "

	SELECT idPatrimonio, 
	nomePatrimonio, 
	numeroPatrimonio, 
	pertencentePatrimonio, 
	statusPatrimonio, 
	tb_locais.idLocal,
	nomeLocal, 
	dataPatrimonio, 
	descricaoPatrimonio 
	FROM tb_patrimonios
	INNER JOIN tb_locais ON (tb_locais.idLocal = tb_patrimonios.idLocal)
	WHERE 1 = 1
	
";

// Barra de Busca
if(!empty($requestData['search']['value'])){
	
	$result_patrimonios.=" AND (nomePatrimonio LIKE '".$requestData['search']['value']."%'";
	$result_patrimonios.=" OR numeroPatrimonio LIKE '".$requestData['search']['value']."%'";
	$result_patrimonios.=" OR pertencentePatrimonio LIKE '".$requestData['search']['value']."%'";
	$result_patrimonios.=" OR statusPatrimonio LIKE '".$requestData['search']['value']."%'";
	$result_patrimonios.=" OR nomeLocal LIKE '".$requestData['search']['value']."%'";
	$result_patrimonios.=" OR dataPatrimonio LIKE '".$requestData['search']['value']."%'";
	$result_patrimonios.=" OR descricaoPatrimonio LIKE '".$requestData['search']['value']."%' )";
}

// Filtros

	//Variaveis recebendo filtros
	$localFilter = $_POST['localFilter'];
	$pertencenteFilter = $_POST['pertencenteFilter'];
	$estadoFilter = $_POST['estadoFilter'];
	$dtInicialFilter = $_POST['dtInicialFilter'];
	$dtFinalFilter = $_POST['dtFinalFilter'];

	//Filtro de local
	if ($localFilter != "" && $localFilter != null) {
		$result_patrimonios.= " AND (tb_locais.idLocal = ".$localFilter.")";
	}

	//Filtro de pertencente
	if ($pertencenteFilter != "" && $pertencenteFilter != null) {
		$result_patrimonios.= " AND (tb_patrimonios.pertencentePatrimonio = '".$pertencenteFilter."')";
	}

	//Filtro de estado
	if ($estadoFilter != "" && $estadoFilter != null) {
		$result_patrimonios.= " AND (tb_patrimonios.statusPatrimonio = '".$estadoFilter."')";
	}

	//Filtro de data inicial
	if ($dtInicialFilter != "" && $dtInicialFilter != null) {
		$result_patrimonios.= " AND (tb_patrimonios.dataPatrimonio >= '".$dtInicialFilter."')";
	}

	//Filtro de data final
	if ($dtFinalFilter != "" && $dtFinalFilter != null) {
		$result_patrimonios.= " AND (tb_patrimonios.dataPatrimonio <= '".$dtFinalFilter."')";
	}

//Fecha filtros

// Atribuindo as variaveis
$resultado_patrimonios = mysqli_query($con, $result_patrimonios);
$totalFiltered = mysqli_num_rows($resultado_patrimonios);

// Ordenando resultado
$result_patrimonios.=" 

	ORDER BY ".$columns[$requestData['order'][0]['column']]."
	".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." 
	,".$requestData['length']." 

";

// Atribuindo a variavel
$resultado_patrimonios = mysqli_query($con, $result_patrimonios);

// Ler e criar o array de dados
$dados = array();

// Array coletando dados para tabela
while ($row_patrimonios = mysqli_fetch_array($resultado_patrimonios)) {
	
	$dado = array();
	$idPatrimonio = $row_patrimonios["idPatrimonio"];
	$dado[] = $row_patrimonios["nomePatrimonio"];
	$dado[] = $row_patrimonios["numeroPatrimonio"];
	$dado[] = $row_patrimonios["pertencentePatrimonio"];
	$dado[] = $row_patrimonios["statusPatrimonio"];
	$dado[] = $row_patrimonios["nomeLocal"];
	// Formatando data
	$dado[] = implode("/", array_reverse(explode("-",$row_patrimonios["dataPatrimonio"])));
	$dado[] = $row_patrimonios["descricaoPatrimonio"];
	$dado[] = '
	<a class="btnUpdate" data-id="'.$idPatrimonio.'" data-toggle="modal" data-target="#modal" ><i class="fas fa-edit"></i></a>
	<a class="btnDelete" data-id="'.$idPatrimonio.'" data-toggle="modal" data-target="#modal"><i class="far fa-trash-alt"></i></a>
	
	';

	// Atribuindo array na variavel
	$dados[] = $dado;
}

// Criando o array que retornara informações para o javascript
$json_data = array(

	//Para cada requisição é enviado um numero como parametro
	"draw" => intval($requestData['draw']), 

	//Quantidade de registros que ha no banco
	"recordsTotal" => intval($qnt_linhas), 

	//Total de registros quando houver pesquisa
	"recordsFiltered" => intval($totalFiltered), 

	//Array de dados retornando a tabela
	"data" => $dados 
);

//Envia os dados com o formato json
echo json_encode($json_data); 

?>