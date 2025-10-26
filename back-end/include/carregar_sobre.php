<?php
$file = __DIR__ . '/sobre_conteudo.html';
if (is_readable($file)) {
    readfile($file);
} else {
    echo '<p>Conteúdo de Sobre ainda não foi definido.</p>';
}
