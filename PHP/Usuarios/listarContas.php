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
        
        if(isset($_GET["querry"]) && $_GET["query"] != ""){
            $query = $_GET["query"];
            $sql = "SELECT * FROM usuarios WHERE 
                nome_usuario LIKE '%$query%' OR
                cpf LIKE '%$query%' OR
                cnpj LIKE '%$query%' OR
                cep LIKE '%$query%' OR
                email_usuario LIKE '%$query%' OR
                telefone_usuario LIKE '%$query%'
                ";
        }else{
            $sql = "SELECT * FROM usuarios";
        }
            $consulta = mysqli_query($mysqli, $sql);
            $return = array();
            $x = 0;
            
            while ($linha = mysqli_fetch_array($consulta)) {
                $i= $linha["id_usuario"];
                $n= $linha["nome_usuario"];
                $s= $linha["senha"];
                $cpf= $linha["cpf"];
                $cnpj= $linha["cnpj"];
                $cep= $linha["cep"];
                $e= $linha["email_usuario"];
                $t= $linha["telefone_usuario"];

                $return[$x] = array(
                    "id" => $i,
                    "nome" => $n,
                    "senha" => $s,
                    "cpf"  => $cpf,
                    "cnpj" => $cnpj,
                    "cep" => $cep,
                    "email" => $e,
                    "telefone" => $t
                );

                $x++;
            }
echo json_encode($return);