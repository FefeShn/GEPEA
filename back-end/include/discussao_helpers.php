<?php
require_once __DIR__ . '/../config/conexao.php';

function gepea_listar_discussoes_usuario(int $usuarioId, ?PDO $pdo = null): array {
    $pdo = $pdo ?: getConexao();
    $sql = "
        SELECT
            d.id_discussao,
            d.titulo_discussao,
            d.data_criacao,
            u.nome_user AS criador_nome,
            COUNT(DISTINCT dp_all.id_usuario) AS total_participantes
        FROM discussao d
        JOIN discussao_participante dp_self
            ON dp_self.id_discussao = d.id_discussao AND dp_self.id_usuario = :usuario
        LEFT JOIN discussao_participante dp_all
            ON dp_all.id_discussao = d.id_discussao
        JOIN usuarios u ON u.id_usuario = d.id_usuario
        GROUP BY d.id_discussao, d.titulo_discussao, d.data_criacao, u.nome_user
        ORDER BY d.data_criacao DESC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['usuario' => $usuarioId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

function gepea_buscar_discussao_para_usuario(int $discussaoId, int $usuarioId, ?PDO $pdo = null): array {
    $pdo = $pdo ?: getConexao();
    $sql = "
        SELECT d.id_discussao, d.titulo_discussao, d.data_criacao, u.nome_user AS criador_nome
        FROM discussao d
        JOIN discussao_participante dp ON dp.id_discussao = d.id_discussao AND dp.id_usuario = :usuario
        JOIN usuarios u ON u.id_usuario = d.id_usuario
        WHERE d.id_discussao = :discussao
        LIMIT 1
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['discussao' => $discussaoId, 'usuario' => $usuarioId]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dados) {
        return [null, []];
    }

    $stmtPart = $pdo->prepare("SELECT u.id_usuario, u.nome_user, u.cargo_user FROM discussao_participante dp JOIN usuarios u ON u.id_usuario = dp.id_usuario WHERE dp.id_discussao = ? ORDER BY u.nome_user");
    $stmtPart->execute([$discussaoId]);
    $participantes = $stmtPart->fetchAll(PDO::FETCH_ASSOC) ?: [];

    return [$dados, $participantes];
}
