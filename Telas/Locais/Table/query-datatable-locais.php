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

// Incluindo conexao
include('../../../PHP/conexao.php');

//Receber requisição da pesquisa
$requestData = $_REQUEST;

//Posição dos dados na tabela, onde os dados se referente ao banco
$columns = array(

	0 => 'nomeLocal',
	1 => 'blocoLocal',
	2 => 'descricaoLocal',
	3 => 'acoes'

);

// Obtendo total de registros do banco
$result_local = "

	SELECT idLocal,
	nomeLocal,
	blocoLocal,
	descricaoLocal
	FROM tb_locais

";

// Atribuindo as variaveis
$resultado_local = mysqli_query($con, $result_local);
$qnt_linhas = mysqli_num_rows($resultado_local);

// Obter dados a serem apresentados
$result_locais = "

	SELECT idLocal, 
	nomeLocal, 
	blocoLocal, 
	descricaoLocal 
	FROM tb_locais WHERE 1 = 1

";

// Barra de Busca
if(!empty($requestData['search']['value'])){

	$result_locais.=" AND (nomeLocal LIKE '".$requestData['search']['value']."%'";
	$result_locais.=" OR blocoLocal LIKE '".$requestData['search']['value']."%'";
	$result_locais.=" OR descricaoLocal LIKE '".$requestData['search']['value']."%' )";
}

// Filtros

	//Variaveis recebendo filtros
	$blocosFilter = $_POST['blocosFilter'];

	//Filtro de usuarios
	if ($blocosFilter != "" && $blocosFilter != null) {
		$result_locais.= " AND (tb_locais.blocoLocal = '".$blocosFilter."')";
	}

//Fecha filtros

// Atribuindo as variaveis
$resultado_locais = mysqli_query($con, $result_locais);
$totalFiltered = mysqli_num_rows($resultado_locais);

// Ordenando resultado
$result_locais.=" 
	
	ORDER BY ".$columns[$requestData['order'][0]['column']]."
	".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,
	".$requestData['length']." 

";

// Atribuindo a variavel
$resultado_locais = mysqli_query($con, $result_locais);

// Ler e criar o array de dados
$dados = array();

// Condiçao para habilitar o botao de deletar o local
if($_SESSION['tipoAcesso'] == 'FUN'){
	
	$disabled = 'disabled';	
}else{
	$disabled = '';
}
 

while ($row_locais = mysqli_fetch_array($resultado_locais)) {
	
	$dado = array();
	$idLocal = $row_locais["idLocal"];
	$dado[] = $row_locais["nomeLocal"];
	$dado[] = $row_locais["blocoLocal"];
	$dado[] = $row_locais["descricaoLocal"];
	$dado[] = '
	<button class="btnUpdate" data-id="'.$idLocal.'" data-toggle="modal" data-target="#modal" ><i class="fas fa-edit"></i></button>
	<button class="btnDelete" '.$disabled.' data-id="'.$idLocal.'" data-toggle="modal" data-target="#modal"><i class="far fa-trash-alt"></i></button>
	
	';

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