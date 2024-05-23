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

$count = 0;
if(isset($_GET["querry"]) && $_GET["querry"] != ""){

    $querry = $_GET["querry"];
    $sql = "SELECT * FROM funcionarios WHERE
        nome_funcionario LIKE '%$querry%'OR
        cpf_funcionario LIKE '%$querry%'OR
        email_funcionario LIKE '%$querry%'OR
        telefone_funcionario LIKE '%$querry%'OR
        salario LIKE '%$querry%'OR
        cargo LIKE '%$querry%'
    ";
   
    if(isset($_GET["ordem"])){
        if($_GET["ordem"] == "+"){
            $sql .= " ORDER BY salario DESC";
        }else if($_GET["ordem"] == "-"){   
            $sql .= " ORDER BY salario ASC";
        }
    }
}else{
    $sql = 'SELECT * FROM funcionarios';
}
$consulta = mysqli_query($mysqli, $sql);
$return = array();
$x = 0;
while ($linha = mysqli_fetch_array($consulta)) {
    $cpf= $linha["cpf_funcionario"];
    $n= $linha["nome_funcionario"];
    $car= $linha["cargo"];
    $s= $linha["salario"];
    $e= $linha["email_funcionario"];
    $t= $linha["telefone_funcionario"];
        $return[$x] = array(
            "cpf" => $cpf,
            "nome" => $n,
            "cargo" => $car,
            "salario" => $s,
            "email" => $e,
            "telefone" => $t
        );
    $x++;
}
echo json_encode($return);