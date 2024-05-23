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

$id_registro = $_GET['id'];
$data_registro = $_GET['data'];
$valor = str_replace(",", ".", $_GET['valor']);
$descricao = $_GET['desc'];


$sql = "SELECT * FROM registros_financeiros WHERE id_registro=$id_registro";
    $consulta = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($consulta) == 0) {
    echo json_encode(array("status"=>"falha","causa"=>"não encontrado"));

} else {

    $coluna = mysqli_fetch_array($consulta);
        if(empty($data_registro))   { $data_registro = $coluna["data_registro"]; }
        if(empty($valor))     { $valor = $coluna["valor"]; }
        if(empty($descricao)) { $descricao = $coluna["descricao"]; }


    $sql = "UPDATE registros_financeiros SET data_registro='$data_registro', valor=$valor, descricao='$descricao' WHERE id_registro=$id_registro";
        mysqli_query($mysqli, $sql);

    echo json_encode(array("status"=>"sucesso"));
}