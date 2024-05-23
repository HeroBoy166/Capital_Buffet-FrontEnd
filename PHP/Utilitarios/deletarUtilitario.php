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


$id_utilitario = $_GET['id'];


$sql = "SELECT * FROM utilitarios WHERE id_utilitario=$id_utilitario";
    $consulta = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($consulta) == 0) {
    echo "Utilitário não encontrado!";
    
} else {

    $sql = "SELECT * FROM pedido_utilitarios WHERE utilitario_id=$id_utilitario";
        $consulta = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($consulta) != 0) {
        echo "Não é possível deletar o utilitario, porque ele faz parte de um pedido!";

    } else {

        $sql = "DELETE FROM utilitarios WHERE id_utilitario=$id_utilitario";
            mysqli_query($mysqli, $sql);

        echo "Utilitário deletado com sucesso!";
    }
}