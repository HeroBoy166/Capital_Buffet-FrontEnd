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


    $nome = $_GET['nome'];
    $cpf = $_GET['cpf'];
    $cargo = $_GET['cargo'];
    $salario = str_replace(",", ".", $_GET['salario']);
    $email = $_GET['email'];
    $telefone = $_GET['telefone'];


    $sql = "INSERT INTO funcionarios (cpf_funcionario, nome_funcionario, cargo, salario, email_funcionario, telefone_funcionario) VALUES ('$cpf', '$nome', '$cargo', $salario, '$email', '$telefone')";
        mysqli_query($mysqli, $sql);
        
    echo json_encode(array( "status" => "sucess"));