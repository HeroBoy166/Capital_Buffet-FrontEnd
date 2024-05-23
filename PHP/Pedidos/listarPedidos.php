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
            include($include . "CORS.php");
//cors();

$sql = "SELECT * FROM pedidos";
    $consulta = mysqli_query($mysqli, $sql);
$x = 0;
$return = array();

while ($linha = mysqli_fetch_array($consulta)) {
    $id_p=$linha["id_pedido"];
    $t=$linha["tipo_evento"];
    $o=$linha["orcamento"];
    $s=$linha["status_pedido"];
    $d=$linha["data_pedido"];
    $i_e=$linha["inicio_evento"];
    $f=$linha["fim_evento"];
    $c=$linha["qtd_convidados"];
    $e=$linha["endereco"];
    $obs=$linha["observacoes"];
    $id_u=$linha["usuario_id"];

    $sql = "SELECT * FROM usuarios WHERE id_usuario='$id_u'";
        $consulta2 = mysqli_query($mysqli, $sql);
        while ($linha2 = mysqli_fetch_array($consulta)) {
            $username =$linha2["nome_usuario"];
        }

    $return[$x] = array(
        "id" => $id_p,
        "tipo" => $t,
        "orcamento" => $o,
        "status" => $s,
        "data" => $d,
        "inicio" => $i_e,
        "fim" => $f,
        "convidados" => $c,
        "endereco" => $e,
        "observacoes" => $obs,
        "usuario" => $id_u,
        "username" => $username
    );
    
    $x++;
}

echo json_encode($return);
