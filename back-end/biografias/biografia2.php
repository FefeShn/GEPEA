<?php
$paginaAtiva = 'membros'; 
$fotoPerfil  = "../imagens/user-foto.png"; 
$linkPerfil  = "../anonimo/login.php"; 
require '../include/navbar.php';
require '../include/menu-anonimo.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php include"../include/head.php"?>
<body>
  
  <div class="container-scroller">
    <!-- CONTEÚDO PRINCIPAL -->
      <main class="biography-container">
      <div class="biography-header">
        <h1 class="biography-title">Biografia</h1>
        <a href="../anonimo/membros.php" class="back-button">← Voltar aos membros</a>
      </div>
      
      <div class="biography-content">
        <div class="biography-photo">
          <img src="../imagens/estrela.jpg" alt="Foto do Professor Luciano Corsino" class="profile-image">
        </div>
        
        <div class="biography-info">
          <h2 class="member-name">Dr. Daniel Santana</h2>
          <p class="member-role vice-coordenador">Vice-Coordenador do GEPEA</p>
          
          <div class="member-contacts">
            <a href="http://lattes.cnpq.br/0401741443606361" target="_blank" class="lattes-link">
              <img src="../imagens/lattes-icon.png" alt="Currículo Lattes" class="contact-icon">
              Currículo Lattes
            </a>
            <a href="mailto:daniel.santana@gmail.com" class="email-link">
              <img src="../imagens/email-icon.png" alt="Email" class="contact-icon">
              daniel.santana@gmail.com
            </a>
          </div>
          
          <div class="biography-text">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam posuere neque dolor, ultricies eleifend nisl ultricies ac. In hac habitasse platea dictumst. Nam lobortis orci egestas enim molestie auctor. Sed vitae justo et arcu lacinia accumsan aliquet nec mauris. Aenean ante ex, pellentesque nec metus bibendum, pulvinar ultricies massa. Donec dictum ac massa vitae laoreet. Suspendisse placerat dui turpis, eu fermentum augue sodales eu. Sed convallis nisl velit, non auctor lorem ultrices vel. Duis luctus dui nunc. Vestibulum mi orci, gravida ac ante at, ullamcorper faucibus enim. Phasellus sit amet mollis massa. Quisque augue lorem, ornare in dapibus quis, iaculis id dui. Donec vel mattis sapien, ac gravida diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Cras lacus metus, condimentum id tellus non, sagittis vehicula mi. Sed tristique sem non tincidunt laoreet.</p>
            
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam posuere neque dolor, ultricies eleifend nisl ultricies ac. In hac habitasse platea dictumst. Nam lobortis orci egestas enim molestie auctor. Sed vitae justo et arcu lacinia accumsan aliquet nec mauris. Aenean ante ex, pellentesque nec metus bibendum, pulvinar ultricies massa. Donec dictum ac massa vitae laoreet. Suspendisse placerat dui turpis, eu fermentum augue sodales eu. Sed convallis nisl velit, non auctor lorem ultrices vel. Duis luctus dui nunc. Vestibulum mi orci, gravida ac ante at, ullamcorper faucibus enim. Phasellus sit amet mollis massa. Quisque augue lorem, ornare in dapibus quis, iaculis id dui. Donec vel mattis sapien, ac gravida diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Cras lacus metus, condimentum id tellus non, sagittis vehicula mi. Sed tristique sem non tincidunt laoreet.</p>
            
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam posuere neque dolor, ultricies eleifend nisl ultricies ac. In hac habitasse platea dictumst. Nam lobortis orci egestas enim molestie auctor. Sed vitae justo et arcu lacinia accumsan aliquet nec mauris. Aenean ante ex, pellentesque nec metus bibendum, pulvinar ultricies massa. Donec dictum ac massa vitae laoreet. Suspendisse placerat dui turpis, eu fermentum augue sodales eu. Sed convallis nisl velit, non auctor lorem ultrices vel. Duis luctus dui nunc. Vestibulum mi orci, gravida ac ante at, ullamcorper faucibus enim. Phasellus sit amet mollis massa. Quisque augue lorem, ornare in dapibus quis, iaculis id dui. Donec vel mattis sapien, ac gravida diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Cras lacus metus, condimentum id tellus non, sagittis vehicula mi. Sed tristique sem non tincidunt laoreet.</p>
          </div>
        </div>
      </div>
    </main>
        
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