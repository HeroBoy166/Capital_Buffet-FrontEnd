<?php
  include("../../PHP/conexao.php");
  session_start();
  
  $_SESSION['tipo_evento'] = $_POST['tipo_evento'];
  $_SESSION['inicio_evento'] = $_POST['inicio_evento'];
  $_SESSION['duracao'] = $_POST['duracao'];
  $_SESSION['qtd_convidados'] = $_POST['qtd_convidados'];
  $_SESSION['endereco'] = $_POST['endereco'];
  $_SESSION['observacoes'] = $_POST['observacoes'];

  $fim_e = strtotime($_POST['inicio_evento']) + 3600*(2+$_POST['duracao']);
      $_SESSION['fim_evento'] = gmdate("Y-m-d\TH:i", $fim_e);


  $sql = "SELECT * FROM comidas";
    $consultaC = mysqli_query($mysqli, $sql);

  $sql = "SELECT * FROM utilitarios";
    $consultaU = mysqli_query($mysqli, $sql);

  $cargos = array(
    "Chefe de cozinha" => 50, 
    "Ajudante de cozinha" => 35, 
    "Copeiro" => 15, 
    "Garçom" => 25, 
    "Barman" => 35, 
    "Recepcionista" => 30, 
    "Segurança" => 45, 
    "Faxineiro" => 20
  );
    $_SESSION['cargos'] = $cargos;

?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pedido</title>
  <link rel="stylesheet" href="../css/style_comidas.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="icon" type="image/x-icon" href="../imagens/logo.png">
</head>

<body>
  
  <div class="container" id="food-menu">
    <h1 class="h1">Continuar Pedido</h1>

    <form method="POST" action="../../PHP/Pedidos/acaoPedido.php">
      <section class="content-menu">
      <!--
      <nav class="nav-side">
        <a href="#plates"><img src="https://i.postimg.cc/65MPq3bs/cutlery.png" alt="Pratos">Pratos</a>
        <a href="#drinks"><img src="https://i.postimg.cc/mg6KXD73/juice.png" alt="Sucos"> Bebidas</a>
        <a href="#dessert"><img src="https://i.postimg.cc/0NMFLsCT/piece-of-cake.png" alt="Sobremesa" style="padding-left: 15px"> Sobremesa</a>
        <a href="#food-menu"><img src="https://i.postimg.cc/nrDLzgZg/arrow-up.png" alt="Voltar ao Topo" style="padding: 0"> Topo</a>
      </nav>
      -->

      <!-- COMIDAS -->

        <section class="content-side">
          <section class="items" id="items">
            <article class="plates" id="plates">
              <div class="header1">
                <h1>Comidas</h1>
              </div>

              <ul class="menu-items">
                
                <input type="hidden" value ="0" name="qtd_comidas[0]">

                <?php 
                  while ($linhaC = mysqli_fetch_array($consultaC)) {
                ?>

                  <li class="item">
                    <input type="number" class="item-checkbox" value ="0" min="0" max="<?php echo $linhaC['estoque_comida']; ?>" 
                      name="qtd_comidas[<?php $linhaC['id_comida'] ?>]">

                    <span class="food" onclick="showPopup(<?php echo $linhaC['id_comida'];?>)"><?php echo $linhaC['nome_comida'];?></span>
                    <span class="price">R$ <?php echo $linhaC['preco_comida'];?></span>
                  </li>
                
                  
                <?php 
                  }
                  
                ?>
                <!-- POP-UP
                  <div id="popupOverlay" class="popup-overlay" style="display: none;">
                    <div class="container" id="container">
                      <div class="form-container sign-up-container">
                        <form>
                            <span class="material-icons close-icon" onclick="hidePopup()">close</span>
                              <div class="result" for="create_nome">
                                <label>Nome:</label>
                                <a id="result_nome"><?php echo $linhaC['nome_comida'];?></a>
                              </div>
                              <div class="result" for="create_nome">
                                <label>Preço:</label>
                                <a id="result_nome">R$ <?php echo $linhaC['preco_comida'];?></a>
                              </div>
                              <div class="result" for="create_nome">
                                <label>Tipo:</label>
                                <a id="result_nome"><?php echo $linhaC['tipo'];?></a>
                              </div>
                              <div class="result" for="create_nome">
                                <label>Categoria:</label>
                                <a id="result_nome"><?php echo $linhaC['categoria'];?></a>
                              </div>
                              <div class="result" for="create_nome">
                                <label>Quantidade máxima a ser pedida:</label>
                                <a id="result_nome"><?php echo $linhaC['estoque_comida'];?></a>
                              </div>
                              <div class="result" for="create_nome">
                                <label>Descrição:</label>
                                <a id="result_nome"><?php echo $linhaC['descricao_comida'];?></a>
                              </div>
                        </form>
                      </div>
                      <div class="overlay-container">
                        <div class="overlay">
                          <div class="overlay-panel overlay-left">
                    
                    </div>
                  </div> -->

              </ul>
            </article>
          </section>


      <!-- UTILITÁRIOS -->
          <section class="items" id="items">
            <article class="drinks" id="drinks">
              <div class="header2">
                <h1>Utilitários</h1>
              </div>

              <ul class="menu-items">
              
                <input type="hidden" value ="0" name="qtd_utilitarios[0]">

                <?php 
                  while ($linhaU = mysqli_fetch_array($consultaU)) {
                ?>

                  <li class="item">
                    <input type="number" class="item-checkbox" value ="0" min="0" max="<?php echo $linhaU['estoque_utilitario']; ?>" 
                        name="qtd_utilitarios[<?php $linhaU['id_utilitario'] ?>]">

                    <span class="food" onclick="showPopup(<?php echo $linhaU['id_utilitario'];?>)"><?php echo $linhaU['nome_utilitario'];?></span>
                    <span class="price">R$ <?php echo $linhaU['preco_utilitario'];?></span>
                  </li>
                  
                <?php 
                  }
                ?>

              </ul>
            </article>
          </section>


      <!-- FUNCIONÁRIOS -->
          <section class="items" id="items">
            <article class="drinks" id="dessert">
              <div class="header3">
                <h1>Funcionários</h1>
              </div>
              
              <ul class="menu-items">
              
                <?php 
                  $sql = "SELECT * FROM funcionarios WHERE cargo=?";
                    $stmt = mysqli_prepare($mysqli, $sql);
                      mysqli_stmt_bind_param($stmt, "s", $cargo);

                  foreach ($cargos as $cargo => $custo_hora) {
                    $consulta = mysqli_stmt_execute($stmt); //Essa consulta foi utilizada para evitar um erro de sincronização
                      $resultado = mysqli_stmt_get_result($stmt);
                        $max_cargo = mysqli_num_rows($resultado);
                ?>

                  <li class="item">
                    <input type='number' class="item-checkbox" value ='0' min='0' max='<?php echo $max_cargo;?>'
                      name='qtd_cargos[<?php echo $cargo;?>]'>

                    <span class="food"><?php echo $cargo; ?></span>
                    <span class="price">R$ <?php echo $custo_hora;?>.00 (por hora)</span>
                  </li>
                                
                <?php 
                  }
                ?>

              </ul>
            </article>
          </section>

        <input type="submit" id="button" value="Finalizar Pedido"> <!--style="background: transparent;-->

        </section>
      </section>
    </form>
  </div>

  <script src="../dependencias/axios.min.js" type="text/javascript"></script>
  <script src="./Empresa/javascript/functions.js"></script>
  <script src="../javascript/pedido.js"></script>
</body>
</html>