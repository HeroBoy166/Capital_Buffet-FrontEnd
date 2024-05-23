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
;

            $id_comida = $_GET['id'];


            $sql = "SELECT * FROM comidas WHERE id_comida=$id_comida";
                $consulta = mysqli_query($mysqli, $sql);

            if (mysqli_num_rows($consulta) == 0) {
                echo "Comida não encontrada!";
                
            } else {

                $sql = "SELECT * FROM pedido_comidas WHERE comida_id=$id_comida";
                    $consulta = mysqli_query($mysqli, $sql);

                if (mysqli_num_rows($consulta) != 0) {
                    echo "Não é possível deletar a comida, porque ela faz parte de um pedido!";

                } else {

                    $sql = "DELETE FROM comidas WHERE id_comida=$id_comida";
                        mysqli_query($mysqli, $sql);

                    echo "Comida deletada com sucesso!";
                }
            }