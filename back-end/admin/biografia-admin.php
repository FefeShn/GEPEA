<?php
$paginaAtiva = 'nenhum'; 
$fotoPerfil  = "../imagens/computer.jpg"; 
$linkPerfil  = "../anonimo/login.php"; 
require '../include/navbar.php';
require '../include/menu-admin.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>

<body>
  
  <div class="container-scroller">
    
      <!-- CONTEÚDO PRINCIPAL -->
      <main class="biography-container">
      <div class="biography-header">
        <div class="biography-title-wrapper">
          <h1 class="biography-title">Biografia</h1>
          <a href="membros-admin.php" class="back-button">← Voltar aos membros</a>
        </div>
        <button class="edit-button">
          <i class="ti-pencil"></i> Editar biografia
        </button>
      </div>
      
      <div class="biography-content">
        <div class="biography-photo">
          <img src="../imagens/computer.jpg" alt="Foto do Professor Luciano Corsino" class="profile-image">
            <button class="change-photo-button">
                <i class="ti-camera"></i> Alterar foto de perfil
            </button>
        </div>
        
        <div class="biography-info">
          <h2 class="member-name">Fernanda Sehn</h2>
          <p class="member-role bolsista">Bolsista</p>
          
          <div class="member-contacts">
            <a href="http://lattes.cnpq.br/5360280589109309" target="_blank" class="lattes-link">
              <img src="../imagens/lattes-icon.png" alt="Currículo Lattes" class="contact-icon">
              Currículo Lattes
            </a>
            <a href="mailto:fernandasehn6@gmail.com" class="email-link">
              <img src="../imagens/email-icon.png" alt="Email" class="contact-icon">
              fernandasehn6@gmail.com
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
          include"../include/footer.php";
        ?>
      </div>
      <!-- main-panel ends -->
    </div>   
  </div>
  <script src="../script.js"></script>
</body>

</html>