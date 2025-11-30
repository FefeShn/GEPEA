<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../config/auth.php';

// $paginaAtiva pode ser definida pela página chamadora
if (!function_exists('isLoggedIn')) {
    // Fallback de segurança, mas auth.php já define
    function isLoggedIn() { return isset($_SESSION['id_usuario']); }
    function isAdmin() { return !empty($_SESSION['eh_adm']); }
}

if (!isLoggedIn()) {
    include __DIR__ . '/menu-anonimo.php';
} else if (isAdmin()) {
    include __DIR__ . '/menu-admin.php';
} else {
    include __DIR__ . '/menu-membro.php';
}
