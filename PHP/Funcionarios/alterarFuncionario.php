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
$nome = $_GET['nome'];
$cargo = $_GET['cargo'];
$salario = str_replace(",", ".", $_GET['salario']);
$email = $_GET['email'];
$telefone = $_GET['telefone'];
$sql = "SELECT * FROM funcionarios WHERE cpf_funcionario='$cpf'";
    $consulta = mysqli_query($mysqli, $sql);
if (mysqli_num_rows($consulta) == 0) {
    echo json_encode(array("status" => "falha", "causa" => "não encontrado", $cpf));
} else {
    $coluna = mysqli_fetch_array($consulta);
        if(empty($nome))      { $nome = $coluna["nome_funcionario"]; }
        if(empty($cargo))     { $cargo = $coluna["cargo"]; }
        if(empty($salario))   { $salario = $coluna["salario"]; }
        if(empty($email))     { $email = $coluna["email_funcionario"]; }
        if(empty($telefone))  { $telefone = $coluna["telefone_funcionario"]; }
    $sql = "UPDATE funcionarios SET nome_funcionario='$nome', cargo='$cargo', salario=$salario, email_funcionario='$email', telefone_funcionario='$telefone' WHERE cpf_funcionario='$cpf'";
        mysqli_query($mysqli, $sql);
    echo json_encode(array("status" => "sucesso"));
}