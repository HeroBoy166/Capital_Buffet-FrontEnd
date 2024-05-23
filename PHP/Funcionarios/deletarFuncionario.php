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

$cpf = $_GET['cpf'];
$sql = "SELECT * FROM funcionarios WHERE cpf_funcionario='$cpf'";
    $consulta = mysqli_query($mysqli, $sql);
if (mysqli_num_rows($consulta) == 0) {
    echo json_encode(array( "status" => "falha", "causa" => "não encontrado"));
} else {
    $sql = "SELECT * FROM pedido_funcionarios WHERE funcionario_cpf='$cpf'";
        $consulta = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($consulta) != 0) {
        echo json_encode(array("status"=>"falha", "causa"=>"faz parte de pedido"));
    } else {
        $sql = "DELETE FROM funcionarios WHERE cpf_funcionario='$cpf'";
            mysqli_query($mysqli, $sql);
        echo json_encode(array( "status" => "sucesso"));
    }
}