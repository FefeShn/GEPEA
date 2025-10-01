<?php
$paginaAtiva = 'eventos'; 
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
                  <h3 class="font-weight-bold">Artigo Publicado: Não basta não ser racista, é preciso ser antirracista: uma revisão sistemática sobre educação física escolar</h3>
                  <h6 class="font-weight-normal mb-0">Publicado em 22/04/2025</h6>
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
              
            </div>

            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="../imagens/artigo1.jpeg" class="d-block w-100" alt="Capa do artigo publicado">
                <div class="carousel-caption d-none d-md-block">
                  <p>Artigo Publicado</p>
                </div>
              </div>
              
            </div>

            
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
    <?php
      include"../include/footer.php";
    ?>  
  </div>
  <script src="../script.js"></script>
</body>
</html>