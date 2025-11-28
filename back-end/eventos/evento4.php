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
                  <h3 class="font-weight-bold">GEPEA presente no 20º Salão Jovem UFRGS</h3>
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
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" class=""  aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="../imagens/eventos/evt_20251128_183101_5a7126a8.png" class="d-block w-100" alt="Imagem do evento">
                <div class="carousel-caption d-none d-md-block">
                  <p>GEPEA presente no 20º Salão Jovem UFRGS</p>
                </div>
              </div>
              <div class="carousel-item ">
                <img src="../imagens/eventos/evt_20251128_183147_ccd1721d.png" class="d-block w-100" alt="Imagem do evento">
                <div class="carousel-caption d-none d-md-block">
                  <p>GEPEA presente no 20º Salão Jovem UFRGS</p>
                </div>
              </div>
              <div class="carousel-item ">
                <img src="../imagens/eventos/evt_20251128_183201_44618c04.jpg" class="d-block w-100" alt="Imagem do evento">
                <div class="carousel-caption d-none d-md-block">
                  <p>GEPEA presente no 20º Salão Jovem UFRGS</p>
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
              
          <p>As orientandas de Iniciação Cientifica (Ensino Médio) Fernanda Sehn e Brenda Marins, do Grupo de Estudos e Pesquisas em Educação, Antirracismo, Gênero e Juventude (GEPEA) participaram do Salão Jovem da UFRGS, apresentando suas pesquisas desenvolvidas no âmbito do projeto Redes Antirracistas, vinculado ao Ministério da Igualdade Racial. As apresentações foram momentos importantes de socialização dos resultados da pesquisa e de fortalecimento do GEPEA enquanto espaço formativo.</p>
          <p>As pesquisas apresentadas, que discutem educação física escolar e feminismo negro, destacam-se por suas contribuições teóricas e metodológicas para o campo de investigação, reafirmando o papel do GEPEA como espaço de formação, diálogo e produção de conhecimento comprometido com a transformação social e a valorização da diversidade.</p>
          <p>Parabenizamos as estudantes pela dedicação e comprometimento com a pesquisa!</p>
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