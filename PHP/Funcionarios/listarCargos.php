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

$return = array();
$cargos = array("Chefe de cozinha", "Ajudante de cozinha", "Copeiro", "Garçom", "Barman", "Recepcionista", "Segurança", "Faxineiro");

$sql = "SELECT * FROM funcionarios WHERE cargo=?";
    $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "s", $cargo);

        
for($x = 0; $x < count($cargos); $x++) {
    $cargo = $cargos[$x];
    
    $consulta = mysqli_stmt_execute($stmt); //Essa consulta foi utilizada para evitar um erro de sincronização
    $resultado = mysqli_stmt_get_result($stmt);
        $max_cargo[$x] = mysqli_num_rows($resultado);

    $return[$x] = $max_cargo[$x];
}

echo json_encode(array("quantidade"=>$return, "cargos"=>$cargos));