<?php
$paginaAtiva = 'index'; 
$fotoPerfil  = "../imagens/user-foto.png"; 
$linkPerfil  = "../anonimo/login.php"; 
require '../include/navbar.php';
require '../include/menu-dinamico.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  /* Layout empilhado e centralizado para a página de publicação */
  .sobre-container { display: block; }
  .sobre-content { display: flex; flex-direction: column; gap: 24px; align-items: center; }
  .sobre-content .carousel { width: 100%; max-width: 960px; margin: 0 auto; }
  .post-content { width: 100%; max-width: 960px; margin: 0 auto; text-align: justify; }
</style>

<body>
  <div class="container-scroller">
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin">
            <div class="row">
              <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <div class="titulo-publicacoes"> 
                  <h3 class="font-weight-bold">Reunião do dia 04/11/25</h3>
                  <h6 class="font-weight-normal mb-0">Publicado em 2025-11-14</h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="sobre-container">
          <div class="sobre-content">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current=\"true\" aria-label="Slide 1"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="../imagens/publicacoes/pub_20251114_172510_9d9c351b.jpeg" class="d-block w-100" alt="Imagem da publicação">
                <div class="carousel-caption d-none d-md-block">
                  <p>Reunião do dia 04/11/25</p>
                </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Próximo</span>
            </button>
          </div>

            <article class="post-content">
              
          <p>No dia 04/11, Mylena, a nova membra do GEPEA, apresentou para as bolsistas do grupo seu projeto de mestrado. A reunião contou com a presença de quase todas as bolsistas, incluindo também o professor Dr. Luciano Corsino.</p>
            </article>

            <?php include"../include/share.php";?>
          </div>
        </div>
      </div>
      <?php include"../include/footer.php";?>  
    </div>
  </div>
  <script src="../script.js"></script>
</body>
</html>