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


$data_registro = $_GET['data'];
$valor = str_replace(",", ".", $_GET['valor']);
$descricao = $_GET['desc'];


$sql = "INSERT INTO registros_financeiros (data_registro, valor, descricao) VALUES ('$data_registro', $valor, '$descricao')";
    mysqli_query($mysqli, $sql);

echo json_encode(array("status"=>"sucesso"));