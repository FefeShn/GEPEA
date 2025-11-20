<?php
// Simple directory listing for latest test emails
date_default_timezone_set('America/Sao_Paulo');
$dir = __DIR__;
$files = array_filter(scandir($dir), function($f){ return preg_match('/\.eml$/i',$f) && $f !== 'latest.eml'; });
// Closure needs $dir captured
usort($files, function($a,$b) use ($dir){ return filemtime($dir.'/'.$b) <=> filemtime($dir.'/'.$a); });
$latest = @file_get_contents($dir.'/LATEST.txt');
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Outbox de E-mails (Testes)</title>
  <style>
    body { font-family: Arial, sans-serif; margin:40px; }
    table { border-collapse: collapse; width:100%; }
    th, td { padding:8px 10px; border:1px solid #ddd; }
    th { background:#f5f5f5; }
    tr:hover { background:#fafafa; }
    .latest { color:#d00; font-weight:bold; }
    .small { font-size:12px; color:#666; }
  </style>
</head>
<body>
  <h1>Outbox de E-mails (arquivo)</h1>
  <p class="small">Driver atual: FILE. Último: <strong><?= htmlspecialchars($latest ?: 'N/D') ?></strong>.</p>
  <table>
    <thead>
      <tr><th>Arquivo</th><th>Data/Hora</th><th>Tamanho</th></tr>
    </thead>
    <tbody>
    <?php foreach ($files as $f): $path = $dir.'/'.$f; ?>
      <tr class="<?= ($f === ($latest ?: '')) ? 'latest' : '' ?>">
        <td><a href="<?= htmlspecialchars($f) ?>" target="_blank" rel="noopener"><?= htmlspecialchars($f) ?></a></td>
        <td><?= date('d/m/Y H:i:s', filemtime($path)) ?></td>
        <td><?= number_format(filesize($path)/1024, 1, ',', '.') ?> KB</td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <p class="small">Arquivo rápido: <a href="latest.eml" target="_blank">latest.eml</a></p>
</body>
</html>