<?php
$paginaAtiva = 'membros-admin'; 
$fotoPerfil  = "../imagens/computer.jpg"; 
$linkPerfil  = "../admin/biografia-admin.php"; 
require '../include/navbar.php';
require '../include/menu-admin.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<body>
  
  <div class="container-scroller">
    

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="members-container">
        <div class="members-header">
            <h1 class="page-title">Nossos Membros</h1>
            <div class="members-actions">
                <a href="#" class="add-member-button">
                    <i class="ti-plus"></i> Cadastrar novo membro
                </a>
                <button class="delete-member-button" id="deleteMemberButton">
                  <i class="ti-trash"></i> Excluir membro
                </button>
            </div>
        </div>
        
        <div class="members-grid">
            <!-- Membro 1 -->
            <div class="member-card-wrapper">
              <a href="../biografias/biografia1.php" class="member-card">
                  <div class="member-photo">
                      <img src="../imagens/dino.jpg" alt="Foto do Coordenador">
                  </div>
                  <h3 class="member-name">Dr. Luciano Corsino</h3>
                  <p class="member-role coordenador">Coordenador</p>
              </a>
              <input type="checkbox" class="member-checkbox">
            </div>
            
            <!-- Membro 2 -->
            <div class="member-card-wrapper">
              <a href="../biografias/biografia2.php" class="member-card">
                  <div class="member-photo">
                      <img src="../imagens/estrela.jpg" alt="Foto do Vice-Coordenador">
                  </div>
                  <h3 class="member-name">Dr. Daniel Santana</h3>
                  <p class="member-role vice-coordenador">Vice-Coordenador</p>
              </a>
              <input type="checkbox" class="member-checkbox">
            </div>
            
            <!-- Membro 3 -->
            <div class="member-card-wrapper">
              <a href="../biografias/biografia3.php" class="member-card">
                  <div class="member-photo">
                      <img src="../imagens/computer.jpg" alt="Foto do Bolsista">
                  </div>
                  <h3 class="member-name">Fernanda Sehn</h3>
                  <p class="member-role bolsista">Bolsista</p>
              </a>
              <input type="checkbox" class="member-checkbox">
            </div>
            
            <!-- Membro 4 -->
            <div class="member-card-wrapper">
              <a href="../biografias/biografia4.php" class="member-card">
                  <div class="member-photo">
                      <img src="../imagens/roque.jpg" alt="Foto do Membro">
                  </div>
                  <h3 class="member-name">Danieri Ribeiro</h3>
                  <p class="member-role membro">Membro</p>
              </a>
              <input type="checkbox" class="member-checkbox">
            </div>
            
            <!-- Membro 5 -->
            <div class="member-card-wrapper">
              <a href="../biografias/biografia5.php" class="member-card">
                  <div class="member-photo">
                      <img src="../imagens/musga.jpg" alt="Foto do Bolsista">
                  </div>
                  <h3 class="member-name">Brenda Marins</h3>
                  <p class="member-role bolsista">Bolsista</p>
              </a>
              <input type="checkbox" class="member-checkbox">
            </div>
            
            <!-- Membro 6 -->
            <div class="member-card-wrapper">
              <a href="../biografias/biografia6.php" class="member-card">
                  <div class="member-photo">
                      <img src="../imagens/abraco.jpg" alt="Foto da Bolsista">
                  </div>
                  <h3 class="member-name">Deisi Franco</h3>
                  <p class="member-role bolsista">Bolsista</p>
              </a>
              <input type="checkbox" class="member-checkbox">
            </div>
            
            <!-- Membro 7 -->
            <div class="member-card-wrapper">
              <a href="../biografias/biografia7.php" class="member-card">
                  <div class="member-photo">
                      <img src="../imagens/flori.jpg" alt="Foto do Membro">
                  </div>
                  <h3 class="member-name">Me. Leandro Mendes</h3>
                  <p class="member-role membro">Membro</p>
              </a>
              <input type="checkbox" class="member-checkbox">
            </div>
            
            <!-- Membro 8 -->
            <div class="member-card-wrapper">
              <a href="../biografias/biografia8.php" class="member-card">
                  <div class="member-photo">
                      <img src="../imagens/dormino.jpg" alt="Foto da Membro">
                  </div>
                  <h3 class="member-name">Ma. Myllena Camargo</h3>
                  <p class="member-role membro">Membro</p>
              </a>
              <input type="checkbox" class="member-checkbox">
            </div>
        </div>
    </main>
        
    <!-- Modal de Cadastro -->
    <div class="modal-overlay" id="modalCadastro">
      <div class="modal-container">
        <div class="modal-header">
          <h3>Cadastrar Novo Membro</h3>
        </div>
        <div class="modal-body">
          <form id="formCadastroMembro">
  <div class="form-group">
    <label for="nomeMembro">Nome Completo</label>
    <input type="text" id="nomeMembro" placeholder="Digite o nome completo" required>
  </div>
  
  <div class="form-group">
    <label for="emailMembro">Email</label>
    <input type="email" id="emailMembro" placeholder="exemplo@universidade.edu.br" required>
  </div>

  <div class="form-group">
    <label for="lattesMembro">Curriculo Lattes</label>
    <input type="text" id="lattesMembro" placeholder="exemplo: http://lattes.cnpq.br/5951306735617460">
  </div>
  
  <div class="form-group">
    <label for="cargoMembro">Cargo no Grupo</label>
    <select id="cargoMembro" required>
      <option value="" disabled selected>Selecione o cargo...</option>
      <option value="coordenador">Coordenador</option>
      <option value="vice-coordenador">Vice-Coordenador</option>
      <option value="bolsista">Bolsista</option>
      <option value="membro">Membro</option>
      <option value="membro">Outro</option>
    </select>
  </div>
  
  <div class="form-group">
    <label for="senhaMembro">Senha Inicial</label>
    <input type="password" id="senhaMembro" placeholder="Crie uma senha segura" required>
  </div>
  
  <div class="form-group">
    <label for="fotoMembro">Foto do Perfil</label>
    <input type="file" id="fotoMembro" accept="image/*">
    <label for="fotoMembro">Selecionar arquivo (JPEG ou PNG)</label>
  </div>
  
  <div class="modal-actions">
    <button type="button" class="cancel-button">Cancelar</button>
    <button type="submit" class="submit-button">Cadastrar Membro</button>
  </div>
</form>
        </div>
      </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal-overlay" id="modalExcluirMembro">
      <div class="modal-container confirm-modal">
        <div class="modal-header">
          <h3>Confirmar Exclusão</h3>
        </div>
        <div class="modal-body">
          <p>Tem certeza que deseja excluir o(s) membro(s) selecionado(s)? Esta ação não pode ser desfeita.</p>
        </div>
        <div class="modal-actions">
          <button class="cancel-button" id="cancelarExclusao">Não, cancelar</button>
          <button class="submit-button delete-button" id="confirmarExclusao">Sim, excluir</button>
        </div>
      </div>
    </div>

    <!-- FOOTER -->
    <?php
      include"../include/footer.php";
    ?>
  </div>
  <script src="../script.js"></script>
</body>
</html>