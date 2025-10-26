<?php
$paginaAtiva = 'sobre'; 
$fotoPerfil  = "../imagens/user-foto.png"; 
$linkPerfil  = "login.php"; 
require '../include/navbar.php';
require '../include/menu-anonimo.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>

<body>
  
  <div class="container-scroller">

      <!-- CONTEÚDO PRINCIPAL -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <div class="titulo-publicacoes"> 
                    <h3 class="font-weight-bold">Sobre o GEPEA</h3>
                    <h6 class="font-weight-normal mb-0">Conheça nossa história e missão</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="sobre-container">
            <div class="sobre-content">
              <div class="sobre-imagem">
                <img src="../imagens/gepea.png" alt="Equipe do GEPEA" class="img-fluid">
              </div>
              
              <div class="sobre-texto" id="sobreTexto">
                <?php include '../include/carregar_sobre.php'; ?>
              </div>
            </div>
          </div>
        
        <!-- FOOTER -->
        <?php
          include'../include/footer.php';
        ?>
      </div>
      <!-- main-panel ends -->
    </div>   
  </div>
  <script src="../script.js"></script>
</body>

</html>