<?php

// Incluindo conexao
include('../../../PHP/conexao.php');

//Receber requisição da pesquisa
$requestData = $_REQUEST;

//Posição dos dados na tabela, onde os dados se referente ao banco
$columns = array(

	0 => 'nomePessoa',
	1 => 'dataInclusaoHistorico',
	2 => 'atividade'

);

// Obtendo total de registros do banco
$result_historico = "

	SELECT idHistorico,
	usuarioTela,
	dataInclusaoHistorico,
	operacao,
	atividade,
	nomePessoa
	FROM tb_historicos
	LEFT OUTER JOIN tb_pessoas
	ON (tb_pessoas.idPessoa = tb_historicos.idPessoa)

";

// Atribuindo as variaveis
$resultado_historico = mysqli_query($con, $result_historico);
$qnt_linhas = mysqli_num_rows($resultado_historico);

// Obter dados a serem apresentados
$result_historicos = "

	SELECT idHistorico,
	usuarioTela,
	dataInclusaoHistorico,
	operacao,
	atividade,
	nomePessoa
	FROM tb_historicos
	LEFT OUTER JOIN tb_pessoas
	ON (tb_pessoas.idPessoa = tb_historicos.idPessoa)
	WHERE 1 = 1

";

// Barra de Busca
if(!empty($requestData['search']['value'])){

	$result_historicos.=" AND (usuarioTela LIKE '".$requestData['search']['value']."%'";
	$result_historicos.=" OR dataInclusaoHistorico LIKE '".$requestData['search']['value']."%'";
	$result_historicos.=" OR atividade LIKE '".$requestData['search']['value']."%' )";
}

// Filtros

	//Variaveis recebendo filtros
	$pessoasFilter = $_POST['pessoasFilter'];
	$acoesFilter = $_POST['acoesFilter'];
	$dtInicialFilter = $_POST['dtInicialFilter'];
	$dtFinalFilter = $_POST['dtFinalFilter'];

	//Filtro de usuarios
	if ($pessoasFilter != "" && $pessoasFilter != null) {
		$result_historicos.= " AND (tb_historicos.idPessoa = ".$pessoasFilter.")";
	}

	//Filtro de acoes
	if ($acoesFilter != "" && $acoesFilter != null) {
		$result_historicos.= " AND (tb_historicos.operacao = '".$acoesFilter."')";
	}

	//Filtro de data inicial
	if ($dtInicialFilter != "" && $dtInicialFilter != null) {
		$result_historicos.= " AND (tb_historicos.dataInclusaoHistorico >= '".$dtInicialFilter."')";
	}

	//Filtro de data final
	if ($dtFinalFilter != "" && $dtFinalFilter != null) {
		$result_historicos.= " AND (tb_historicos.dataInclusaoHistorico <= '".$dtFinalFilter."')";
	}

//Fecha filtros

// Atribuindo as variaveis
$resultado_historicos = mysqli_query($con, $result_historicos);
$totalFiltered = mysqli_num_rows($resultado_historicos);

// Ordenando resultado
$result_historicos.=" 
	
	ORDER BY ".$columns[$requestData['order'][0]['column']]."
	".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,
	".$requestData['length']." 

";

// Atribuindo a variavel
$resultado_historicos = mysqli_query($con, $result_historicos);

// Ler e criar o array de dados
$dados = array();

while ($row_historicos = mysqli_fetch_array($resultado_historicos)) {
	
	$dado = array();
	$dado[] = $row_historicos["nomePessoa"];

	// Convertendo data e hora
	$dateTime = explode(" ", $row_historicos["dataInclusaoHistorico"]);
	$dateTime[0] = explode("-", $dateTime[0]);
	$dateTime[0] = array_reverse($dateTime[0]);
	$dateTime[0] = implode("/", $dateTime[0]);
	$dado[] = implode(" ", $dateTime);
	$dado[] = $row_historicos["atividade"];

	$dados[] = $dado;
}

// Criando o array que retornara informações para o javascript
$json_data = array(

	//Para cada requisição e enviado um numero como parametro
	"draw" => intval($requestData['draw']), 

	//Quantidade de registros que ha no banco
	"recordsTotal" => intval($qnt_linhas), 

	//Total de registros quando houver pesquisa
	"recordsFiltered" => intval($totalFiltered), 

	//Array de dados retornando a tabela
	"data" => $dados 
);

//Enviar dados com o formato json
echo json_encode($json_data); 

?>