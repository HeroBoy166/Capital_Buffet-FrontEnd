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
$nome = $_GET['nome'];
$senha = $_GET['senha'];
$cep = $_GET['cep'];
$email = $_GET['email'];
$telefone = $_GET['telefone'];


$sql = "SELECT * FROM usuarios WHERE id_usuario=$id_usuario";
    $consulta = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($consulta) == 0) {
    echo json_encode(array("status"=>"falha","causa"=>"não encontrado"));
    
} else {
        
    $coluna = mysqli_fetch_array($consulta);
        if(empty($nome))        { $nome = $coluna["nome_usuario"]; }
        if(empty($senha))       { $senha = $coluna["senha"]; }
        if(empty($cep))         { $cep = $coluna["cep"]; }
        if(empty($email))       { $email = $coluna["email_usuario"]; }
        if(empty($telefone))    { $telefone = $coluna["telefone_usuario"]; }

    $sql = "UPDATE usuarios SET nome_usuario='$nome', senha='$senha', cep='$cep', email_usuario='$email', telefone_usuario='$telefone' WHERE id_usuario=$id_usuario";
        mysqli_query($mysqli, $sql);

    echo json_encode(array("status"=>"sucesso"));
}