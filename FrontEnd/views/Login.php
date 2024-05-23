<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login_style.css">
    <link rel="icon" type="image/x-icon" href="../imagens/logo.png">
    <title>Login</title>
</head>
<body>
<div class="showcase">
    <div class="login-box">
        <h2>Login</h2>
        <form method="POST" action="../../PHP/Usuarios/acaoLogin.php">
            <div class="user-box">
                <input type="text" name="email" required="" autocomplete="off" value="<?php if (isset($_SESSION['cad_sucesso'])) {echo $_SESSION['cad_sucesso'];}?>">
                <label>E-mail</label>
            </div>
            <div class="user-box">
                <input type="password" name="senha" required="" autocomplete="off">
                <label>Senha</label>
            </div>
            <div class="button-form">
                <input type="submit" value="Entrar" id="submit"> <!--style="background: transparent;-->
            </div>
            <div id="register">

            <?php 
                if (isset($_SESSION['n_encontrada'])) {
                    echo "<b>Conta não encontrada!</b> <br>";
                }

                if (isset($_SESSION['cad_sucesso'])) {
                    echo "<b>Conta criada com sucesso!</b> <br>";
                }

                unset($_SESSION['n_encontrada']);
                unset($_SESSION['cad_sucesso']);
            ?>

                Não tem uma conta?
                <a href="../views/Cadastro.php">Registre</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>