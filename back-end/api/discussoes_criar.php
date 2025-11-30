<?php
session_start();
require_once '../config/auth.php';
require_once '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../anonimo/index.php');
    exit();
}

if (!isLoggedIn()) {
    header('Location: ../anonimo/login.php');
    exit();
}

$contexto = $_POST['contexto'] ?? '';
$redirect = ($contexto === 'admin') ? '../admin/forum-admin.php' : '../membro/forum.php';

$titulo = trim($_POST['titulo'] ?? '');
$participantesInput = $_POST['participantes'] ?? [];
$participantes = array_map('intval', (array)$participantesInput);
$participantes = array_filter($participantes, fn($id) => $id > 0);

if ($titulo === '') {
    $_SESSION['flash_erro'] = 'Informe um título para o chat.';
    header('Location: ' . $redirect);
    exit();
}

$pdo = getConexao();

// Garante tabela de relacionamento 
$pdo->exec("CREATE TABLE IF NOT EXISTS discussao_participante (
    id_discussao INT(11) NOT NULL,
    id_usuario INT(11) NOT NULL,
    data_adicao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_discussao, id_usuario),
    KEY idx_disc_part_usuario (id_usuario),
    CONSTRAINT fk_disc_part_disc FOREIGN KEY (id_discussao) REFERENCES discussao (id_discussao) ON DELETE CASCADE,
    CONSTRAINT fk_disc_part_user FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('INSERT INTO discussao (titulo_discussao, id_usuario) VALUES (?, ?)');
    $stmt->execute([$titulo, $_SESSION['id_usuario']]);
    $idDiscussao = (int)$pdo->lastInsertId();

    $participantes[] = (int)$_SESSION['id_usuario'];
    $participantes = array_values(array_unique($participantes));

    $insertParticipante = $pdo->prepare('INSERT INTO discussao_participante (id_discussao, id_usuario) VALUES (?, ?)');
    foreach ($participantes as $idParticipante) {
        $insertParticipante->execute([$idDiscussao, $idParticipante]);
    }

    $pdo->commit();
    $_SESSION['flash_sucesso'] = 'Chat criado com sucesso!';
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['flash_erro'] = 'Não foi possível criar o chat. Tente novamente.';
}

header('Location: ' . $redirect);
exit();
