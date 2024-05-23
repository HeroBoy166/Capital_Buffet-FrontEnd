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


if(isset($_GET)){

    $sql = 'SELECT * FROM utilitarios';
    
    if(isset($_GET["nome"]) && $_GET["nome"] != ""){
        $sql .= ' nome_utilitario LIKE "%'.$_GET["nome"].'%"';
    }
    if(isset($_GET["ordem"])){
        if($_GET["ordem"] == "+"){
            $sql .= " ORDER BY preco_utilitario DESC";
        } else if($_GET["ordem"] == "-"){   
            $sql .= " ORDER BY preco_utilitario ASC";
        }
    }
}else{
    $sql = 'SELECT * FROM utilitarios';
}

$consulta = mysqli_query($mysqli, $sql);
$reuturn = array();
$x=0;

while ($linha = mysqli_fetch_array($consulta)) {
    $i= $linha["id_utilitario"];
    $n= $linha["nome_utilitario"];
    $p= $linha["preco_utilitario"];
    $q= $linha["estoque_utilitario"];
    $d= $linha["descricao_utilitario"];
    $u= $linha["url_imagem_u"];

        $return[$x] = array(
            "id" => $i,
            "nome" => $n,
            "preco" => $p,
            "estoque" => $q,
            "descricao" => $d,
            "img" => $u
        );
    $x++;
    }
echo json_encode($return);