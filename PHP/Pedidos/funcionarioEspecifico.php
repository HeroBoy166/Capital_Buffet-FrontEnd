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

$id_pedido = $_GET['id_pedido'];
$cpf_funcionario = $_GET['cpf_funcionario'];
$acao = $_GET['acao']; //Adicionar ou Remover


$sql = "SELECT * FROM pedidos WHERE id_pedido=$id_pedido";
    $consulta = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($consulta) == 0) {
    echo json_encode(array("status"=>"falha", "causa" => "pedido não encontrado"));

} else {
    $sql = "SELECT * FROM funcionarios WHERE cpf_funcionario='$cpf_funcionario'";
        $consulta = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($consulta) == 0) {
        echo json_encode(array("status"=>"falha", "causa" => "funcionário não encontrado"));

    } else {
        $sql = "SELECT * FROM pedido_funcionarios WHERE pedido_id=$id_pedido AND funcionario_cpf='$cpf_funcionario'";
            $consulta = mysqli_query($mysqli, $sql);

        if (($acao == "Adicionar") && (mysqli_num_rows($consulta) != 0)) {
            echo json_encode(array("status"=>"falha", "causa" => "funcionário já faz parte do pedido"));

        } else if (($acao == "Remover") && (mysqli_num_rows($consulta) == 0)) {
            echo json_encode(array("status"=>"falha", "causa" => "funcionário não encontrado nesse pedido"));

        } else {
            $sql = ($acao == "Adicionar") 
                ? "INSERT INTO pedido_funcionarios (pedido_id, funcionario_cpf) VALUES ($id_pedido, '$cpf_funcionario')" 
                : "DELETE FROM pedido_funcionarios WHERE pedido_id=$id_pedido AND funcionario_cpf='$cpf_funcionario'";

            mysqli_query($mysqli, $sql);

            recalcular_orcamento();

            echo json_encode(array("status"=>"sucesso"));
        }
    }
}

//FUNÇÕES
function recalcular_orcamento() {
    global $mysqli, $id_pedido, $cpf_funcionario, $acao;
    
    $sql = "SELECT orcamento, inicio_evento, fim_evento FROM pedidos WHERE id_pedido=$id_pedido";
        $consulta = mysqli_query($mysqli, $sql);
            $linha = mysqli_fetch_assoc($consulta);
                $orcamento = $linha['orcamento'];
                $inicio_evento = $linha['inicio_evento'];
                $fim_evento = $linha['fim_evento'];

    $duracao = date_diff(date_create($inicio_evento), date_create($fim_evento), true);
        $d = $duracao->format('%h');

    $cargos = array("Chefe de cozinha" => 50 , "Ajudante de cozinha" => 35, "Copeiro" => 15, "Garçom" => 25, "Barman" => 35, "Recepcionista" => 30, "Segurança" => 45, "Faxineiro" => 20);
    
    $sql = "SELECT cargo FROM funcionarios WHERE cpf_funcionario='$cpf_funcionario'";
        $consulta = mysqli_query($mysqli, $sql);  
            $custo_hora = $cargos[mysqli_fetch_row($consulta)[0]];

    ($acao == "Adicionar")
        ? $orcamento+= ($custo_hora*$d)
        : $orcamento-= ($custo_hora*$d);

    $sql = "UPDATE pedidos SET orcamento=$orcamento WHERE id_pedido=$id_pedido";
        mysqli_query($mysqli, $sql);
}
?>