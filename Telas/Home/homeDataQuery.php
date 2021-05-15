<?php

// Incluindo conexao
include('../../PHP/conexao.php');

//Receber requisição da pesquisa
$requestData = $_REQUEST;

//Posição dos dados na tabela, onde os dados se referente ao banco
$columns = array(

	0 => 'atividade'

);

// Obtendo total de registros do banco
$result_historico = "

	SELECT atividade
	FROM tb_historicos
";

// Atribuindo as variaveis
$resultado_historico = mysqli_query($con, $result_historico);
$qnt_linhas = mysqli_num_rows($resultado_historico);

// Obter dados a serem apresentados
$result_historicos = "

	SELECT atividade
	FROM tb_historicos
	WHERE 1 = 1
	ORDER BY idHistorico DESC
	LIMIT 3
";

// Atribuindo as variaveis
$resultado_historicos = mysqli_query($con, $result_historicos);

// Atribuindo a variavel
$resultado_historicos = mysqli_query($con, $result_historicos);

// Ler e criar o array de dados
$dados = array();

while ($row_historicos = mysqli_fetch_array($resultado_historicos)) {
	
	$dado = array();
	$dado[] = $row_historicos["atividade"];

	$dados[] = $dado;
}

// Criando o array que retornara informações para o javascript
$json_data = array(

	//Para cada requisição e enviado um numero como parametro
	"draw" => intval($requestData['draw']), 

	//Array de dados retornando a tabela
	"data" => $dados 
);

//Enviar dados com o formato json
echo json_encode($json_data); 

?>