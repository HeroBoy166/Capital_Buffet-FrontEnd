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

$id_usuario = $_GET['id'];
$sql = "SELECT * FROM usuarios WHERE id_usuario='$id_usuario'";
    $consulta = mysqli_query($mysqli, $sql);
if (mysqli_num_rows($consulta) == 0) {
    echo json_encode(array("status"=>"falha","causa"=>"não encontrado"));
} else {
    $sql = "SELECT * FROM pedidos WHERE usuario_id='$id_usuario'";
        $consulta = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($consulta) != 0) {
        echo json_encode(array("status"=>"falha","causa"=>"pedidos ainda ativos"));
    } else {
        $sql = "DELETE FROM usuarios WHERE id_usuario='$id_usuario'";
            mysqli_query($mysqli, $sql);
        echo json_encode(array("status"=>"sucesso"));
    }
}