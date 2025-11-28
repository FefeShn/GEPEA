<?php
require_once __DIR__ . '/../../src/config.php';
require_once __DIR__ . '/../../src/SupportMailer.php';
use Support\SupportMailer;

if (session_status() === PHP_SESSION_NONE) { session_start(); }

$u = envv('SUPPORT_ADMIN_USER', 'admin');
$p = envv('SUPPORT_ADMIN_PASS', 'admin');

$authOk = false;
if (isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    $authOk = hash_equals($u, $_SERVER['PHP_AUTH_USER']) && hash_equals($p, $_SERVER['PHP_AUTH_PW']);
}
if (!$authOk) {
    header('WWW-Authenticate: Basic realm="Tickets"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Auth required';
    exit;
}

$pdo = support_db();

// Retry action
if (($_GET['action'] ?? '') === 'retry' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $t = $pdo->prepare('SELECT * FROM support_tickets WHERE id = ?');
    $t->execute([$id]);
    if ($row = $t->fetch()) {
        $mailer = new SupportMailer();
        $ok = $mailer->send($row);
        $upd = $pdo->prepare('UPDATE support_tickets SET status = ? WHERE id = ?');
        $upd->execute([$ok ? 'sent' : 'failed', $id]);
        header('Location: tickets.php');
        exit;
    }
}

$rows = $pdo->query('SELECT * FROM support_tickets ORDER BY id DESC')->fetchAll();
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tickets de Suporte</title>
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu;max-width:980px;margin:40px auto;padding:0 16px;color:#222}
    table{border-collapse:collapse;width:100%}
    th,td{border:1px solid #ddd;padding:8px}
    th{background:#f6f6f6;text-align:left}
    .badge{padding:2px 6px;border-radius:4px;font-size:12px}
    .sent{background:#d1e7dd;color:#0f5132}
    .failed{background:#f8d7da;color:#842029}
    .new{background:#cff4fc;color:#055160}
    a.btn{padding:4px 8px;background:#0d6efd;color:#fff;border-radius:4px;text-decoration:none}
    a.btn:hover{background:#0b5ed7}
  </style>
</head>
<body>
  <h1>Tickets de Suporte</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Status</th><th>Nome</th><th>E-mail</th><th>Título</th><th>Data</th><th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= (int)$r['id'] ?></td>
        <td><span class="badge <?= htmlspecialchars($r['status']) ?>"><?= htmlspecialchars($r['status']) ?></span></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= htmlspecialchars($r['email']) ?></td>
        <td><?= htmlspecialchars($r['title']) ?></td>
        <td><?= htmlspecialchars($r['created_at']) ?></td>
        <td>
          <?php if ($r['status'] === 'failed'): ?>
            <a class="btn" href="?action=retry&id=<?= (int)$r['id'] ?>">Re-tentar envio</a>
          <?php else: ?>
            —
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>