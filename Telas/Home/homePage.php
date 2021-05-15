<?php

//Ativa o buffer de saida
ob_start();

//Pegando Links adicionados a raiz
$raiz = '../../';

// Incluindo conexao
include('../../PHP/conexao.php');

// Select buscando pelas informações dos patrimonios
$selectPatrimonios = mysqli_query($con, "

 SELECT * FROM tb_patrimonios 

") or die(mysqli_error($con));

// While percorrendo informações
while ($rowPatrimonios = mysqli_fetch_array($selectPatrimonios)) {

 $NomePatrimonio = $rowPatrimonios['nomePatrimonio'];
}

// Informaçoes de ultimo cadastro

    // Select buscando pelas informações dos locais
    $selectLocais = mysqli_query($con, "

     SELECT * FROM tb_locais 

    ") or die(mysqli_error($con));

    // While percorrendo informações
    while ($rowLocais = mysqli_fetch_array($selectLocais)) {

     $NomeLocal = $rowLocais['nomeLocal'];
    }

    // While percorrendo informações
    while ($rowPatrimonios = mysqli_fetch_array($selectPatrimonios)) {

     $NomePatrimonio = $rowPatrimonios['nomePatrimonio'];
    }

    // Select buscando pelas informações dos locais
    $selectUsuarios = mysqli_query($con, "

     SELECT * FROM tb_usuarios 

    ") or die(mysqli_error($con));

    // While percorrendo informações
    while ($rowUsuarios = mysqli_fetch_array($selectUsuarios)) {

     $LoginUsuario = $rowUsuarios['loginUsuario'];
    }

// 

?>

<!-- Grafico -->
<canvas id="homeGraph" width="1900" height="550"></canvas>

    
<!-- Html da datatable -->
<table id="datatable-historicos" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <div class="form-row align-items-center">
        <tr>
            <th>Ultimas atividades</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<p>

<!-- Cards -->
<div class="row">

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Patrimônios</h5>
                <p class="card-text">Último patrimônio cadastrado: <h3><?php echo $NomePatrimonio ?></h3></p>
                <a href="<?= $raiz ?>Telas/Patrimonios/Table/datatable-patrimonios.php" class="btn btn-success">Visitar</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Locais</h5>
                <p class="card-text">Último local cadastrado: <h3><?php echo $NomeLocal ?></h3></p>
                <a href="<?= $raiz ?>Telas/Locais/Table/datatable-locais.php" class="btn btn-success">Visitar</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Usuários</h5>
                <p class="card-text">Último usuário cadastrado: <h3><?php echo $LoginUsuario ?></h3></p>
                <a href="<?= $raiz ?>Telas/Usuarios/Table/datatable-usuarios.php" class="btn btn-success">Visitar</a>
            </div>
        </div>
    </div>
</div>



<script>
    $('document').ready(function(){

        // Ajax com dados do grafico
        $.ajax({
            type: 'POST',
            url: '../Home/homeQuery.php',
            dataType: 'json',
            success: function(data) {

                var totalUsuarios = [data[0]];
                var totalPatrimonios = [data[1]];
                var totalLocais = [data[2]];

                grafico(totalPatrimonios, totalUsuarios, totalLocais);
            }
        });


        // Executando datatable
        $('#datatable-historicos').DataTable({

            processing: true,
            serverSide: true,
            searching: false,
            bFilter: false,
            bInfo: false,
            bLengthChange: false,
            bSort: false,
            paging: false,
            lengthMenu: false,
            pageLength: 5,

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
                }
            },
            // 

            //Dados da tabela vindo da query em json
            ajax: {
                "url": "homeDataQuery.php",
                "type": "POST"
            },

            // Colunas da datatable
            columns: [
                {
                    // Atividade
                    data: 0,
                    class: "text-center"
                }
            ],

        }); // Fecha datatable
    });


    //Funçao para montar o grafico 
    function grafico(totalPatrimonios, totalUsuarios, totalLocais){

        new Chart(document.getElementById("homeGraph"), {
            type: 'bar',
            data: {
                labels: [""],
                datasets: [
                    {
                        label: "Patrimônios",
                        barPercentage: 0.5,
                        backgroundColor: "#3A3A3A",
                        data: totalPatrimonios
                    }, 
                    {
                        label: "Locais",
                        barPercentage: 0.5,
                        backgroundColor: "gray",
                        data: totalLocais
                    },
                    {
                        label: "Usuários",
                        barPercentage: 0.5,
                        backgroundColor: "green",
                        data: totalUsuarios
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    fontSize: 32,
                    text: 'Informações do sistema'
                },
                legend:{
                    labels:{
                        fontSize: 18
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            offsetGridLines: true
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });  
    }
</script>

<?php

//Atribuindo a pagina
$pagemaincontent = ob_get_contents();

//Fecha buffer e limpa
ob_end_clean();

//Header
$pageheader = "Home";

//Titulo
$pagetitle = "Home";

//Aplicando o template da master
include("../../master.php");

?>