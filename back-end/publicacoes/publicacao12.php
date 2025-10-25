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
                  <h3 class="font-weight-bold">teste 8</h3>
                  <h6 class="font-weight-normal mb-0">Publicado em 2025-10-25</h6>
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
                <img src="../imagens/publicacoes/pub_20251025_234643_3db046a0.png" class="d-block w-100" alt="Imagem da publicação">
                <div class="carousel-caption d-none d-md-block">
                  <p>teste 8</p>
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
              
          <p>Você sempre fez os meus sonhos</p>
          <p>Sempre soube do meu segredo</p>
          <p>Isso já faz muito tempo</p>
          <p>Eu nem me lembro quanto tempo faz</p>
          <p>O meu coração não sabe contar os dias</p>
          <p>E a minha cabeça já está tão vazia</p>
          <p>Mas a primeira vez</p>
          <p>Ainda me lembro bem</p>
          <p>Talvez eu seja no seu passado mais uma página</p>
          <p>Que foi do seu diário arrancada</p>
          <p>Sonho, choro e sinto</p>
          <p>Que resta alguma esperança</p>
          <p>Saudade, quero arrancar esta página</p>
          <p>Da minha vida</p>
          <p>Sonho, choro e sinto</p>
          <p>Que resta alguma esperança</p>
          <p>Saudade, quero arrancar esta página</p>
          <p>Sonho, choro e sinto</p>
          <p>Que resta alguma esperança</p>
          <p>Saudade, quero arrancar esTa página</p>
          <p>Da minha vida, da minha vida</p>
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