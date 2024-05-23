<?php
$abs_path = explode("/",str_replace("\\", "/",__DIR__));
$max = sizeof($abs_path);
$max--;
$include = "";
for($i = 0; $i < $max; $i++)
{
$include .= $abs_path[$i] . "/";
}
include($include . "conexao.php");
include($include . "mail.php");
include($include . "CORS.php");
cors();

$tipo = $_GET['tipo'];
$orcamento = $_GET['orcamento'];
$inicio = $_GET['inicio'];
$fim = $_GET['fim'];
$qtd_convidados = $_GET['qtd_convidados'];
$endereco = $_GET['endereco'];
$observacoes = $_GET['observacoes'];

$qtd_comidas = $_GET['qtd_comidas'];
$qtd_utilitarios = $_GET['qtd_utilitarios'];
$qtd_cargos = $_GET['qtd_cargos'];

$usuario_id = $_GET["id_usuario"];


//PEDIDOS
$sql = "INSERT INTO pedidos (tipo_evento, orcamento, inicio_evento, fim_evento , qtd_convidados, endereco, observacoes, usuario_id) VALUES 
    ('$tipo', $orcamento, '$inicio', '$fim', $qtd_convidados, '$endereco', '$observacoes', $usuario_id)";
        mysqli_query($mysqli, $sql);

            $ultimo_id = mysqli_insert_id($mysqli);


//PEDIDOS_COMIDAS
foreach($qtd_comidas as $id_comida => $qtd_comida) {
    $sql = "INSERT INTO pedido_comidas (pedido_id, comida_id, qtd_comida) VALUES ($ultimo_id, $id_comida, $qtd_comida)";
        mysqli_query($mysqli, $sql);
}


//PEDIDOS_UTILITÁRIOS
foreach($qtd_utilitarios as $id_utilitario => $qtd_utilitario) {
    $sql = "INSERT INTO pedido_utilitarios (pedido_id, utilitario_id, qtd_utilitario) VALUES ($ultimo_id, $id_utilitario, $qtd_utilitario)";
        mysqli_query($mysqli, $sql);
}


//PEDIDOS_FUNCIONARIOS
$sql = "INSERT INTO pedido_funcionarios (pedido_id, funcionario_cpf) SELECT $ultimo_id, cpf_funcionario FROM funcionarios WHERE cargo=? ORDER BY rand() LIMIT ?";
    $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "si", $cargo, $qtd_cargo);
        
foreach($qtd_cargos as $cargo => $qtd_cargo) {
    mysqli_stmt_execute($stmt);
}

echo json_encode(array("status"=>"sucesso"));
?>