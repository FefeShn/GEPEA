<?php
session_start();
// Destroi todas as variáveis de sessão
$_SESSION = array();
// Se desejar destruir completamente a sessão, também apague o cookie de sessão.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
// Redireciona para a página inicial anônima
header('Location: ../anonimo/index.php');
exit();
