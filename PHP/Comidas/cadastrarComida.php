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
            

            $nome = $_GET['nome'];
            $preco = str_replace(",", ".", $_GET['preco']);
            $estoque = $_GET['estoque'];
            $tipo = $_GET['tipo'];
            $categoria = $_GET['categoria'];
            $descricao = $_GET['desc'];
            $url_imagem = $_GET['imagem'];


            $sql = "INSERT INTO comidas (nome_comida, preco_comida, estoque_comida, tipo, categoria, descricao_comida, url_imagem_c) VALUES ('$nome', $preco, $estoque, '$tipo', '$categoria', '$descricao', '$url_imagem')";
                mysqli_query($mysqli, $sql);
                
            echo "Comida cadastrada com sucesso!";
        ?>
