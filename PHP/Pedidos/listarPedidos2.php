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
cors();
        
            $id_pedido = $_GET['id'];
            $return = array();
            $comidas = array();
            $utilitarios = array();
            $funcionarios = array();

        //COMIDAS
               
                $sql = "SELECT * FROM pedido_comidas WHERE pedido_id=$id_pedido";
                    $consulta = mysqli_query($mysqli, $sql);
                $x = 0;
            
                while ($linha = mysqli_fetch_array($consulta)) {
                    $c=$linha["comida_id"];
                    $q=$linha["qtd_comida"];
                    
                    $comidas[$x] = array(
                        "id" => $c,
                        "qtd" => $q
                    );
                
                    $x++;
                }


        //UTILITÁRIOS
               
                $sql = "SELECT * FROM pedido_utilitarios WHERE pedido_id=$id_pedido";
                    $consulta = mysqli_query($mysqli, $sql);
                $x = 0;
            
                while ($linha = mysqli_fetch_array($consulta)) {
                    $u=$linha["utilitario_id"];
                    $q=$linha["qtd_utilitario"];

                    $utilitarios[$x] = array(
                        "id" => $u,
                        "qtd" => $q
                    );

                    $x++;
                }
                

        //FUNCIONÁRIOS
               
                $sql = "SELECT * FROM pedido_funcionarios WHERE pedido_id=$id_pedido";
                    $consulta = mysqli_query($mysqli, $sql);
                $x = 0;
            
                while ($linha = mysqli_fetch_array($consulta)) {
                    $c=$linha["funcionario_cpf"];
 
                    $funcionarios[$x] = $c;
                    
                    $x++;
                }
        
echo json_encode(array(
    "comidas" => $comidas,
    "utilitarios" => $utilitarios,
    "funcionarios" => $funcionarios
));