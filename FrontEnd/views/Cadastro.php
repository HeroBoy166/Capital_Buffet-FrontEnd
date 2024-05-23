<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/logo.png">
    <link rel="stylesheet" href="../css/login_style.css">
    <title>Cadastro</title>

    <script src="../dependencias/jquery-1.2.6.pack.js" type="text/javascript"></script>
    <script src="../dependencias/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
    <script src="../dependencias/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="../dependencias/jquery.mask.min.js" type="text/javascript"></script>


        <script type="text/javascript">
            $(document).ready(function(){	
                $("#cep").mask("99999-999");
                $("#telefone").mask("(99) 99999-9999");
            });
        </script>

</head>
<body>
<div class="showcase">
    <div class ="login-box">
        <h2>Cadastro</h2>
        <form method="POST" action="../../PHP/Usuarios/acaoCadastro.php">
            <div class="user-box">
                <input type="text" name="nome" required autocomplete="off"/>
                <label>Nome</label>
            </div>
            <div class="user-box">
                <input type="text" name="cpfcnpj" id="cpfcnpj" required autocomplete="off"/>
                <label>CPF ou CPNJ</label>
            </div>
            <div class="user-box">
                <input type="text" name="cep" id="cep" required autocomplete="off"/>
                <label>CEP</label>
            </div>
            <div class="user-box">
                <input type="text" name="telefone" id="telefone" required autocomplete="off"/>
                <label>Telefone</label>
            </div>
            <div class="user-box">
                <input type="text" name="email" required autocomplete="off"/>
                <label>E-mail</label>
            </div>
            <div class="user-box">
                <input type="password" name="senha" required autocomplete="off"/>
                <label>Senha</label>
            </div>
                <div class="button-form">
                    <input type="submit" value="Criar" id="submit"> <!--style="background: transparent;-->
                </div>
                <div id="register">
                    
                    <?php 
                        if (isset($_SESSION['error_mens'])) {
                            $mens= $_SESSION['error_mens'];
                            echo "<b>$mens</b> <br>";
                        }
                        unset($_SESSION['error_mens']);
                    ?>   

                    Já tem uma conta?
                    <a href="../views/Login.php">Entre</a>
                </div>
        </form>
</div>

<script type="text/javascript">
    $("#cpfcnpj").keydown(function(){
        try {
            $("#cpfcnpj").unmask();
        } catch (e) {}

        var tamanho = $("#cpfcnpj").val().length;

        if(tamanho < 11){
            $("#cpfcnpj").mask("999.999.999-99");
        } else {
            $("#cpfcnpj").mask("99.999.999/9999-99");
        }

        var elem = this;
        setTimeout(function(){
            elem.selectionStart = elem.selectionEnd = 10000;
        }, 0);

        var currentValue = $(this).val();
        $(this).val('');
        $(this).val(currentValue);
    });
</script>

</body>
</html>
