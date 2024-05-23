<?php
    include('../conexao.php');
            
    session_start();
        $tipo = $_SESSION['tipo_evento'];
        $inicio_evento = $_SESSION['inicio_evento'];
        $fim_evento = $_SESSION['fim_evento'];
        $qtd_convidados = $_SESSION['qtd_convidados'];
        $endereco = $_SESSION['endereco'];
        $observacoes = $_SESSION['observacoes'];

        $qtd_comidas = $_POST['qtd_comidas'];
        $qtd_utilitarios = $_POST['qtd_utilitarios'];
        $qtd_cargos = $_POST['qtd_cargos'];

        $id_usuario = $_SESSION['id_usuario'];
        $cargos = $_SESSION['cargos'];

    $custo_total = 500;

        $sql = "SELECT * FROM comidas WHERE estoque_comida>0";
            $consulta = mysqli_query($mysqli, $sql);
                        
        while ($linha = mysqli_fetch_array($consulta)) {
            $qtd_comida = $qtd_comidas[$linha['id_comida']];
            
            if ($qtd_comida > 0) {
                $custo_total+= ($qtd_comida*$linha['preco_comida']);
            }
        }

        $sql = "SELECT * FROM utilitarios WHERE estoque_utilitario>0";
            $consulta = mysqli_query($mysqli, $sql);
    
        while ($linha = mysqli_fetch_array($consulta)) {
            $qtd_utilitario = $qtd_utilitarios[$linha['id_utilitario']];

            if ($qtd_utilitario > 0) {
                $custo_total+= ($qtd_utilitario*$linha['preco_utilitario']);
            }
        }

        $d = $_SESSION['duracao']; 
        foreach($cargos as $cargo => $custo_hora) {
            $custo_total+= ($qtd_cargos[$cargo]*$custo_hora*$d);
        }


    //PEDIDOS
    $sql = "INSERT INTO pedidos (tipo_evento, orcamento, inicio_evento, fim_evento , qtd_convidados, endereco, observacoes, usuario_id) VALUES 
        ('$tipo', $custo_total, '$inicio_evento', '$fim_evento', $qtd_convidados, '$endereco', '$observacoes', $id_usuario)";
            mysqli_query($mysqli, $sql);

                $ultimo_id = mysqli_insert_id($mysqli);


    //PEDIDOS_COMIDAS
    foreach($qtd_comidas as $id_comida => $qtd_comida) {
        if ($qtd_comida>0) {
            $sql = "INSERT INTO pedido_comidas (pedido_id, comida_id, qtd_comida) VALUES ($ultimo_id, $id_comida, $qtd_comida)";
                mysqli_query($mysqli, $sql);
        }
    }


    //PEDIDOS_UTILITÁRIOS
    foreach($qtd_utilitarios as $id_utilitario => $qtd_utilitario) {
        if ($qtd_utilitario>0) {
            $sql = "INSERT INTO pedido_utilitarios (pedido_id, utilitario_id, qtd_utilitario) VALUES ($ultimo_id, $id_utilitario, $qtd_utilitario)";
                mysqli_query($mysqli, $sql);
        }
    }


    //PEDIDOS_FUNCIONARIOS
    $sql = "INSERT INTO pedido_funcionarios (pedido_id, funcionario_cpf) SELECT $ultimo_id, cpf_funcionario FROM funcionarios WHERE cargo=? ORDER BY rand() LIMIT ?";
        $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, "si", $cargo, $qtd_cargo);
          
    foreach($qtd_cargos as $cargo => $qtd_cargo) {
        if ($qtd_cargo>0) {
            mysqli_stmt_execute($stmt);
        }
    }

    $_SESSION['pedido_feito'] = true;
        header('Location: ../../FrontEnd/views/Cliente.php');
?>