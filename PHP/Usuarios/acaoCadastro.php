<?php
    include("../conexao.php");
    session_start();

    //Dados inválidos!
    if ((strlen($_POST['cpfcnpj']) != 14 && strlen($_POST['cpfcnpj']) != 18) || strlen($_POST['cep']) != 9 || strlen($_POST['telefone']) != 15) {
        $_SESSION['error_mens'] = "Algum dado é inválido!";
            header('Location: ../../FrontEnd/views/Cadastro.php');
        
    } else {
        
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];
        $cpfcnpj = formatarCnpjCpf($_POST['cpfcnpj']);
        $cep = $_POST['cep'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];

        $sql = "SELECT * FROM usuarios WHERE cpf='$cpfcnpj' OR cnpj='$cpfcnpj' OR email_usuario='$email'";
            $consulta = mysqli_query($mysqli, $sql);

        if (mysqli_num_rows($consulta) != 0) {
            $_SESSION['error_mens'] = "CNPJ/CPF/E-mail já cadastrado!";
                header('Location: ../../FrontEnd/views/Cadastro.php');

        } else {
            $sql = (strlen($cpfcnpj) == 14) 
                ? "INSERT INTO usuarios (nome_usuario, senha, cpf, cep, email_usuario, telefone_usuario) VALUES ('$nome', '$senha', '$cpfcnpj', '$cep', '$email', '$telefone')"
                : "INSERT INTO usuarios (nome_usuario, senha, cnpj, cep, email_usuario, telefone_usuario) VALUES ('$nome', '$senha', '$cpfcnpj', '$cep', '$email', '$telefone')";
                
            mysqli_query($mysqli, $sql);

            $_SESSION['cad_sucesso'] = $email;
                header('Location: ../../FrontEnd/views/Login.php');
        }
    }

function formatarCnpjCpf($valor){
    $cnpj_cpf = preg_replace("/\D/", '', $valor);
    
    if (strlen($cnpj_cpf) == 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
    } 
    
    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}
?>