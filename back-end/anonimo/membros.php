<?php
$paginaAtiva = 'membros'; 
$fotoPerfil  = "../imagens/user-foto.png"; 
$linkPerfil  = "login.php"; 
require '../include/navbar.php';
require '../include/menu-anonimo.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>

<body class="membros-page">
  
  <div class="container-scroller">

      <!-- CONTEÚDO PRINCIPAL -->
      <main class="members-container">
        <h1 class="page-title">Nossos Membros</h1>
        
        <div class="members-grid">
            <!-- Membro 1 -->
            <a href="../biografias/biografia1.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/dino.jpg" alt="Foto do Coordenador">
                </div>
                <h3 class="member-name">Dr. Luciano Corsino</h3>
                <p class="member-role coordenador">Coordenador</p>
            </a>
            
            <!-- Membro 2 -->
            <a href="../biografias/biografia2.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/estrela.jpg" alt="Foto do Vice-Coordenador">
                </div>
                <h3 class="member-name">Dr. Daniel Santana</h3>
                <p class="member-role vice-coordenador">Vice-Coordenador</p>
            </a>
            
            <!-- Membro 3 -->
            <a href="../biografias/biografia3.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/computer.jpg" alt="Foto do Bolsista">
                </div>
                <h3 class="member-name">Fernanda Sehn</h3>
                <p class="member-role bolsista">Bolsista</p>
            </a>
            
            <!-- Membro 4 -->
            <a href="../biografias/biografia4.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/roque.jpg" alt="Foto do Membro">
                </div>
                <h3 class="member-name">Danieri Ribeiro</h3>
                <p class="member-role membro">Membro</p>
            </a>
            
            <!-- Membro 5 -->
            <a href="../biografias/biografia5.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/musga.jpg" alt="Foto do Bolsista">
                </div>
                <h3 class="member-name">Brenda Marins</h3>
                <p class="member-role bolsista">Bolsista</p>
            </a>
            
            <!-- Membro 6 -->
            <a href="../biografias/biografia6.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/abraco.jpg" alt="Foto da Bolsista">
                </div>
                <h3 class="member-name">Deisi Franco</h3>
                <p class="member-role bolsista">Bolsista</p>
            </a>
            
            <!-- Membro 7 -->
            <a href="../biografias/biografia7.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/flori.jpg" alt="Foto do Membro">
                </div>
                <h3 class="member-name">Me. Leandro Mendes</h3>
                <p class="member-role membro">Membro</p>
            </a>
            
            <!-- Membro 8 -->
            <a href="../biografias/biografia8.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/dormino.jpg" alt="Foto da Membro">
                </div>
                <h3 class="member-name">Ma. Myllena Camargo</h3>
                <p class="member-role membro">Membro</p>
            </a>
        </div>
    </main>
        
        <!-- FOOTER -->
        <?php
          include'..\include\footer.php';
        ?>
      </div>
      <!-- main-panel ends -->
    </div>   
  </div>
  <script src="../script.js"></script>
</body>

</html>