<?php
$paginaAtiva = 'eventos'; 
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
                  <h3 class="font-weight-bold">GEPEA no 10º Salão de Ensino, Pesquisa e Extensão do IFRS</h3>
                  <h6 class="font-weight-normal mb-0">Publicado em 28/11/2025</h6>
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
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class=""  aria-label="Slide 2"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="../imagens/eventos/evt_20251128_184401_f93757a1.png" class="d-block w-100" alt="Imagem do evento">
                <div class="carousel-caption d-none d-md-block">
                  <p>GEPEA no 10º Salão de Ensino, Pesquisa e Extensão do IFRS</p>
                </div>
              </div>
              <div class="carousel-item ">
                <img src="../imagens/eventos/evt_20251128_184411_babd5be7.png" class="d-block w-100" alt="Imagem do evento">
                <div class="carousel-caption d-none d-md-block">
                  <p>GEPEA no 10º Salão de Ensino, Pesquisa e Extensão do IFRS</p>
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
              
          <p>No dia 18 de novembro de 2025, aconteceu a apresentação da nossa colega e orientanda de iniciação científica do GEPEA.</p>
          <p>Fernanda apresentou seu trabalho no 10º Salão de Ensino, Pesquisa e Extensão do IFRS, realizado no @ifrsbgoficial , em um momento especial para o grupo, que conta com a coautoria das orientandas e integrantes do GEPEA: Brenda Marins, Deisi Janine, Eduarda Oliveira, Sarah Oliveira e Danieri Ribeiro .</p>
          <p>O titulo da apresentação foi: “Autoetnografia como possibilidade de reflexão crítica do trabalho pedagógico em Educação Física escolar”, tendo como referencial teórico intelectuais negras do pensamento feminista negro, na perspectiva da justiça social.</p>
          <p>Um registro que nos alegra e fortalece o trabalho que vem sendo desenvolvido de forma coletiva! Parabéns Fernanda!</p>
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