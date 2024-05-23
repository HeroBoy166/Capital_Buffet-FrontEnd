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

if(isset($_GET["id"]) && $_GET["id"] != "" ){

    $id= $_GET["id"];
    $sql="SELECT * FROM comidas WHERE id_comida = '$id'";

}elseif( (isset($_GET["querry"]) && $_GET["querry"] != "" ) || ( isset($_GET["categoria"]) && $_GET["categoria"] != "")){
    if(isset($_GET["querry"]) && $_GET["querry"] != ""){
    $querry = $_GET["querry"] ;
    $sql = "SELECT * FROM comidas WHERE
        nome_comida LIKE '%$querry%'
    ";
    } if($_GET["querry"] != "" && isset($_GET["categoria"]) && $_GET["categoria"] != ""){
        $cat = $_GET["categoria"];
        $sql .= " OR categoria LIKE '%$cat%'";
    } else if (isset($_GET["categoria"]) && $_GET["categoria"] != ""){
        $cat = $_GET["categoria"];
        $sql = "SELECT * FROM comidas WHERE categoria LIKE '%$cat%'";
    }

    if(isset($_GET["ordem"])){
        if($_GET["ordem"] == "+"){
            $sql .= " ORDER BY preco_comida DESC";
        }else if($_GET["ordem"] == "-"){   
            $sql .= " ORDER BY preco_comida ASC";
        }
    }
}else{
    $sql = 'SELECT * FROM comidas';
}
$consulta = mysqli_query($mysqli, $sql);
$return = array();
$x = 0;
    while ($linha  = mysqli_fetch_array($consulta)) {
            $return[$x] = array(
                "id" => $linha ['id_comida'],
                "nome" => $linha["nome_comida"],
                "preco" => $linha['preco_comida'],
                "estoque" => $linha ['estoque_comida'],
                "tipo" => $linha['tipo'],
                "categoria" => $linha [ 'categoria'],
                "descricao" => $linha ['descricao_comida'],
                "img" => $linha ['url_imagem_c']
            );
            $x++;
    }
echo json_encode($return);