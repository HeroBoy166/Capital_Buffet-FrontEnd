<?php 
    include("../conexao.php");
    session_start();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email_usuario='$email' AND senha='$senha'";
        $consulta = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($consulta) == 0) {
        $_SESSION['n_encontrada'] = true;
            header('Location: ../../FrontEnd/views/Login.php');

    } else {
        $linha = mysqli_fetch_array($consulta);
            $admin = $linha['admin'];

        if ($admin == 1) {
            $_SESSION['permissoes'] = 1;
                header('Location: /Capital_Buffet/FrontEnd/views/Empresa/Funcionarios.html');
        
        } else {
            $_SESSION['id_usuario'] = $linha['id_usuario'];
                header('Location: /Capital_Buffet/FrontEnd/views/Cliente.php');
        }
    }
?>