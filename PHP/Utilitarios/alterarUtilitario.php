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
$nome = $_GET['nome'];
$preco = str_replace(",", ".", $_GET['preco']);
$estoque = $_GET['estoque'];
$descricao = $_GET['desc'];
$url_imagem = $_GET['imagem'];


$sql = "SELECT * FROM utilitarios WHERE id_utilitario=$id_utilitario";
    $consulta = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($consulta) == 0) {
    echo "Utilitário não encontrado!";
    
} else {
        
    $coluna = mysqli_fetch_array($consulta);
        if(empty($nome))      { $nome = $coluna["nome_utilitario"]; }
        if(empty($preco))     { $preco = $coluna["preco_utilitario"]; }
        if(empty($descricao)) { $descricao = $coluna["descricao_utilitario"]; }
        if(empty($url_imagem))  { $url_imagem = $coluna["url_imagem_u"]; }
        if(strlen($estoque) == 0)   { $estoque = $coluna["estoque_utilitario"]; }

        
    $sql = "UPDATE utilitarios SET nome_utilitario='$nome', preco_utilitario=$preco, estoque_utilitario=$estoque, descricao_utilitario='$descricao', url_imagem_u='$url_imagem' WHERE id_utilitario=$id_utilitario";
        mysqli_query($mysqli, $sql);

    echo "Utilitário alterado com sucesso!";
}
        