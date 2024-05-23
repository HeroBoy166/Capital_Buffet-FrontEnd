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
            

            $id_comida = $_GET['id'];
            $nome = $_GET['nome'];
            $preco = str_replace(",", ".", $_GET['preco']);
            $estoque = $_GET['estoque'];
            $categoria = $_GET['categoria'];
            $descricao = $_GET['desc'];
            $url_imagem = $_GET['imagem'];
            
            if (empty($_GET['tipo'])) { 
                $tipo = ""; 

            } else { 
                $tipo = $_GET['tipo']; 
            }


            $sql = "SELECT * FROM comidas WHERE id_comida='$id_comida'";
                $consulta = mysqli_query($mysqli, $sql);

            if (mysqli_num_rows($consulta) == 0) {
                echo "Comida não encontrada!";
                
            } else {
                    
                $coluna = mysqli_fetch_array($consulta);
                    if(empty($nome))        { $nome = $coluna["nome_comida"]; }
                    if(empty($preco))       { $preco = $coluna["preco_comida"]; }
                    if(empty($tipo))        { $tipo = $coluna["tipo"]; }
                    if(empty($categoria))   { $categoria = $coluna["categoria"]; }
                    if(empty($descricao))   { $descricao = $coluna["descricao_comida"]; }
                    if(empty($url_imagem))  { $url_imagem = $coluna["url_imagem_c"]; }
                    if(strlen($estoque) == 0)   { $estoque = $coluna["estoque_comida"]; }
                    

                    
                $sql = "UPDATE comidas SET nome_comida='$nome', preco_comida=$preco, estoque_comida=$estoque, tipo='$tipo', categoria='$categoria', descricao_comida='$descricao', url_imagem_c='$url_imagem' WHERE id_comida='$id_comida'";
                    mysqli_query($mysqli, $sql);

                echo "Comida alterada com sucesso!";
            }