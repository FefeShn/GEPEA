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
                  <h3 class="font-weight-bold">Artigo publicado!</h3>
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
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="../imagens/eventos/evt_20251128_185116_ba99f5d2.png" class="d-block w-100" alt="Imagem do evento">
                <div class="carousel-caption d-none d-md-block">
                  <p>Artigo publicado!</p>
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
              
          <p>É com muita satisfação que anunciamos a publicação do nosso artigo intitulado &quot;Implementação da Lei nº 10.639/03 na Educação Básica: contribuições do campo da educação física escolar&quot; na Revista Caderno Pedagógico.</p>
          <p>Este artigo é fruto de um projeto desenvolvido no âmbito do GEPEA (Grupo de Estudos e Pesquisa sobre Educação, Juventude, Gênero e Antirracismo) no IFRS - Campus Rolante e contribui para a reflexão crítica sobre a implementação da Lei nº 10.639/03 na educação básica, com ênfase na promoção das relações étnico-raciais por meio das práticas e saberes do campo da educação física escolar.</p>
          <p>Convidamos todas e todos a lerem, compartilharem e aprofundarem o debate proposto por este artigo, reafirmando nosso compromisso com uma pesquisa crítica e rigorosa.</p>
          <p>O artigo está disponível para acesso e leitura no link:</p>
          <p>https://ojs.studiespublicacoes.com.br/ojs/index.php/cadped/article/view/17492</p>
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