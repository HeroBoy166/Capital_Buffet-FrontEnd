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


//Confere se ambos não foram inicializados
if (empty($_GET['cpf']) && empty($_GET['cnpj'])) {
echo json_encode(array("status"=>"falha","causa"=>"CPF ou CNPJ são obrigatórios"));

//O isset() returna true mesmo quando a variável está vazia, então foi necessário usar o strlen()
} else if (strlen($_GET['cpf']) != 0 && strlen($_GET['cnpj']) != 0) {
    echo json_encode(array("status"=>"falha","causa"=>"CPF e CNPJ não é permitido"));

} else {

$nome = $_GET['nome'];
$senha = $_GET['senha'];
$cpf = $_GET['cpf'];
$cnpj = $_GET['cnpj'];
$cep = $_GET['cep'];
$email = $_GET['email'];
$telefone = $_GET['telefone'];


//Foi usado AND em vez de OR porque se, por exemplo, o cpf for igual a "NULL" sempre irá dar true se o usuário não tiver o cpf registrado
$sql = "SELECT * FROM usuarios WHERE (cpf='$cpf' AND cnpj='$cnpj') OR email_usuario='$email'";
    $consulta = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($consulta) != 0) {
    echo json_encode(array("status"=>"falha", "causa"=>"já registrado"));

} else if (strlen($cpf) != 0) {
            
    $sql = "INSERT INTO usuarios (nome_usuario, senha, cpf, cep, email_usuario, telefone_usuario) VALUES ('$nome', '$senha', '$cpf', '$cep', '$email', '$telefone')";
        mysqli_query($mysqli, $sql);

} else {

    $sql = "INSERT INTO usuarios (nome_usuario, senha, cnpj, cep, email_usuario, telefone_usuario) VALUES ('$nome', '$senha', '$cnpj', '$cep', '$email', '$telefone')";
        mysqli_query($mysqli, $sql);
}
            
echo json_encode(array("status"=>"sucesso"));
}