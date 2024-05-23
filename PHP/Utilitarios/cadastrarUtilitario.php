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
            $descricao = $_GET['descricao'];
            $url_imagem = $_GET['imagem'];


            $sql = "INSERT INTO utilitarios (nome_utilitario, preco_utilitario, estoque_utilitario, descricao_utilitario, url_imagem_u) VALUES ('$nome', $preco, $estoque, '$descricao', '$url_imagem')";
                mysqli_query($mysqli, $sql);
                
            echo "Utilitário cadastrado com sucesso!";