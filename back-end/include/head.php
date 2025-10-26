<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GEPEA</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="../../site-front/css/bootstrap.min.css" rel="stylesheet">
  <script src="../../site-front/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <?php
    // Ajusta prefixos relativos conforme a pasta do script atual
    $scriptDir = dirname($_SERVER['PHP_SELF'] ?? '');
    $prefix = '../';
    if (preg_match('#/back-end$#', str_replace('\\','/',$scriptDir))) {
      $prefix = './';
    } elseif (preg_match('#/back-end/[^/]+$#', str_replace('\\','/',$scriptDir))) {
      $prefix = '../';
    }
  ?>
  <link rel="stylesheet" href="<?= $prefix ?>style.css">
  <link rel="shortcut icon" href="<?= $prefix ?>imagens/gepea.png" />
</head>