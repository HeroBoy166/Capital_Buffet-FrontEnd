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


if(isset($_GET["querry"]) && $_GET["querry"] != ""){

    $querry = $_GET["querry"];
    $sql = "SELECT * FROM registros_financeiros WHERE
        data_registro LIKE '%$querry%' OR
        valor LIKE '%$querry%' OR
        descricao LIKE '%$querry%'
    ";

}else{
    $sql = "SELECT * FROM registros_financeiros";
}
    $consulta = mysqli_query($mysqli, $sql);
$x = 0;
$return = $valores = $dates =array();

while ($linha = mysqli_fetch_array($consulta)) {
    $i= $linha["id_registro"];
    $p= $linha["data_registro"];
    $v= $linha["valor"];
    $d= $linha["descricao"];

    $valores[$x] = $v; 
    $dates[$x] = $p; 

    $return[$x]=array(
        "id" => $i,
        "data" => $p,
        "valor" => $v,
        "desc" => $d
    );
    
    $x++;
}

echo json_encode(array("data" => $return, "valores" => $valores, "dates" => $dates));