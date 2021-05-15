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

	0 => 'loginUsuario',
	1 => 'nomePessoa',
	2 => 'emailUsuario',
	3 => 'dataInclusaoUsuario',
	4 => 'tipoAcesso',
	5 => 'acoes'

);

// Obtendo total de registros do banco
$result_usuario = "

	SELECT idUsuario,
	loginUsuario,
	emailUsuario,
	dataInclusaoUsuario,
	tipoAcesso
	FROM tb_usuarios
	INNER JOIN tb_pessoas ON
	(tb_pessoas.idPessoa = tb_usuarios.idPessoa)
	
";

// Atribuindo as variaveis
$resultado_usuario = mysqli_query($con, $result_usuario);
$qnt_linhas = mysqli_num_rows($resultado_usuario);

// Obter dados a serem apresentados
$result_usuarios = "

	SELECT idUsuario,
	loginUsuario,
	emailUsuario,
	dataInclusaoUsuario,
	tipoAcesso,
	nomePessoa
	FROM tb_usuarios
	INNER JOIN tb_pessoas ON
	(tb_pessoas.idPessoa = tb_usuarios.idPessoa)
	WHERE 1 = 1

";

// Barra de Busca
if(!empty($requestData['search']['value'])){

	$result_usuarios.=" AND (loginUsuario LIKE '".$requestData['search']['value']."%'";
	$result_usuarios.=" OR emailUsuario LIKE '".$requestData['search']['value']."%'";
	$result_usuarios.=" OR dataInclusaoUsuario LIKE '".$requestData['search']['value']."%' )";
}

// Filtros

	//Variaveis recebendo filtros
	$tipoAcessoFilter = $_POST['tipoAcessoFilter'];
	$dtInicialFilter = $_POST['dtInicialFilter'];
	$dtFinalFilter = $_POST['dtFinalFilter'];

	//Filtro de Tipo Acesso
	if ($tipoAcessoFilter != "" && $tipoAcessoFilter != null) {
		$result_usuarios.= " AND (tb_usuarios.tipoAcesso = '".$tipoAcessoFilter."')";
	}

	//Filtro de data inicial
	if ($dtInicialFilter != "" && $dtInicialFilter != null) {
		$result_usuarios.= " AND (tb_usuarios.dataInclusaoUsuario >= '".$dtInicialFilter."')";
	}

	//Filtro de data final
	if ($dtFinalFilter != "" && $dtFinalFilter != null) {
		$result_usuarios.= " AND (tb_usuarios.dataInclusaoUsuario <= '".$dtFinalFilter."')";
	}

//Fecha filtros

// Atribuindo as variaveis
$resultado_usuarios = mysqli_query($con, $result_usuarios);
$totalFiltered = mysqli_num_rows($resultado_usuarios);

// Ordenando resultado
$result_usuarios.=" 
	
	ORDER BY ".$columns[$requestData['order'][0]['column']]."
	".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,
	".$requestData['length']." 

";

// Atribuindo a variavel
$resultado_usuarios = mysqli_query($con, $result_usuarios);

// Ler e criar o array de dados
$dados = array();

// Condiçao para habilitar o botao de deletar o local
if($_SESSION['tipoAcesso'] == 'FUN'){
	
	$disabled = 'disabled';	
}else{
	$disabled = '';
}

while ($row_usuarios = mysqli_fetch_array($resultado_usuarios)) {
	
	$dado = array();
	$idUsuario = $row_usuarios["idUsuario"];
	$dado[] = $row_usuarios["loginUsuario"];
	$dado[] = $row_usuarios["nomePessoa"];
	$dado[] = $row_usuarios["emailUsuario"];

	// Convertendo data e hora
	$dateTime = explode(" ", $row_usuarios["dataInclusaoUsuario"]);
	$dateTime[0] = explode("-", $dateTime[0]);
	$dateTime[0] = array_reverse($dateTime[0]);
	$dateTime[0] = implode("/", $dateTime[0]);
	$dado[] = implode(" ", $dateTime);

	$dado[] = $row_usuarios['tipoAcesso'] == 'ADM' ? 'Administrador' : ( $row_usuarios['tipoAcesso'] == 'FUN' ? 'Funcionário' : "-" );

	$dado[] = '
	<button class="btnUpdate" '.$disabled.' data-id="'.$idUsuario.'" data-toggle="modal" data-target="#modal" ><i class="fas fa-edit"></i></button>
	<button class="btnDelete" '.$disabled.' data-id="'.$idUsuario.'" data-toggle="modal" data-target="#modal"><i class="far fa-trash-alt"></i></button>
	
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