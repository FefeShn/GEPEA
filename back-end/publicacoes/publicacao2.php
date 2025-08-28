<?php
$paginaAtiva = 'index'; 
$fotoPerfil  = "../imagens/user-foto.png"; 
$linkPerfil  = "../anonimo/login.php"; 
require '../include/navbar.php';
require '../include/menu-anonimo.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                  <h3 class="font-weight-bold">Inauguração de Espaços Afrocentrados</h3>
                  <h6 class="font-weight-normal mb-0">Publicado em 10/03/2025</h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="sobre-container">
          <div class="sobre-content">
                      <!-- Carrossel Bootstrap -->
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>

            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="../imagens/showgepea.jpeg" class="d-block w-100" alt="Artistas no evento de inauguração">
                <div class="carousel-caption d-none d-md-block">
                  <p>Evento contou com a presença dos Poetas Vivos e Lady Black</p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="../imagens/fotogepea.jpeg" class="d-block w-100" alt="Imagem de exemplo do carrossel">
                <div class="carousel-caption d-none d-md-block">
                  <p>Imagem de exemplo do carrossel</p>
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
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam posuere neque dolor, ultricies eleifend nisl ultricies ac. In hac habitasse platea dictumst. Nam lobortis orci egestas enim molestie auctor. Sed vitae justo et arcu lacinia accumsan aliquet nec mauris.</p>
          
          <p>Aenean ante ex, pellentesque nec metus bibendum, pulvinar ultricies massa. Donec dictum ac massa vitae laoreet. Suspendisse placerat dui turpis, eu fermentum augue sodales eu. Sed convallis nisl velit, non auctor lorem ultrices vel.</p>
          
          <h3>Detalhes do Evento</h3>
          <p>Duis luctus dui nunc. Vestibulum mi orci, gravida ac ante at, ullamcorper faucibus enim. Phasellus sit amet mollis massa. Quisque augue lorem, ornare in dapibus quis, iaculis id dui. Donec vel mattis sapien, ac gravida diam.</p>
          
          
          
          <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Cras lacus metus, condimentum id tellus non, sagittis vehicula mi. Sed tristique sem non tincidunt laoreet.</p>
        </article>

        <?php include"../include/share.php";?>
          </div>
        </div>
        
      </div>
      <!-- main-panel ends -->
    </div>   
    <?php include"../include/footer.php";?>
  </div>
  <script src="../script.js"></script>
</body>
</html>