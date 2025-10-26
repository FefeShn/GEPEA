<?php
$paginaAtiva = 'membros'; 
$fotoPerfil  = "../imagens/user-foto.png"; 
$linkPerfil  = "login.php"; 
require '../include/navbar.php';
require '../include/menu-anonimo.php';
require_once '../config/conexao.php';

$pdo = getConexao();
$stmt = $pdo->prepare("SELECT id_usuario, nome_user, foto_user, cargo_user FROM usuarios");
$stmt->execute();
$membros = $stmt->fetchAll(PDO::FETCH_ASSOC);

$prioridade = [
    'coordenador' => 1,
    'vice-coordenador' => 2,
    'bolsista' => 3,
    'membro' => 4,
    'outro' => 5,
    'outros' => 5,
];
usort($membros, function($a, $b) use ($prioridade){
    $ca = strtolower(trim($a['cargo_user'] ?? ''));
    $cb = strtolower(trim($b['cargo_user'] ?? ''));
    $pa = $prioridade[$ca] ?? 999; $pb = $prioridade[$cb] ?? 999;
    return $pa === $pb ? strcoll($a['nome_user'] ?? '', $b['nome_user'] ?? '') : ($pa <=> $pb);
});

function cargoClass($cargo){
    $c = strtolower(trim($cargo ?? ''));
    if (strpos($c,'vice')!==false && strpos($c,'coorden')!==false) return 'vice-coordenador';
    if (strpos($c,'coordenador')!==false) return 'coordenador';
    if (strpos($c,'bolsista')!==false) return 'bolsista';
    if (strpos($c,'membro')!==false) return 'membro';
    return 'outro';
}
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
          <?php foreach($membros as $m): 
            $cargoClass = cargoClass($m['cargo_user'] ?? '');
            $foto = (!empty($m['foto_user'])) ? htmlspecialchars($m['foto_user']) : '../imagens/user-foto.png';
          ?>
            <a href="../perfil.php?id=<?= (int)$m['id_usuario'] ?>" class="member-card <?= htmlspecialchars($cargoClass) ?>">
              <div class="member-photo">
                <img src="<?= $foto ?>" alt="Foto de <?= htmlspecialchars($m['nome_user']) ?>">
              </div>
              <h3 class="member-name"><?= htmlspecialchars($m['nome_user']) ?></h3>
              <p class="member-role <?= htmlspecialchars($cargoClass) ?>"><?= htmlspecialchars($m['cargo_user'] ?? '') ?></p>
            </a>
          <?php endforeach; ?>
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