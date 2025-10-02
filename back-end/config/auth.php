<?php
    require_once 'conexao.php';
    function isLoggedIn() {
        return isset($_SESSION['id_usuario']);
    }
    function isAdmin() {
        return isset($_SESSION['eh_adm']) && $_SESSION['eh_adm'] == true;
    }
    function login($email, $password) {
        try {
            $pdo = getConexao();
            
            $stmt = $pdo->prepare("SELECT id_usuario, nome_user, email_user, senha_user, eh_adm, foto_user FROM usuarios WHERE email_user = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['senha_user'])) {
                    $_SESSION['id_usuario'] = $user['id_usuario'];
                    $_SESSION['nome_user'] = $user['nome_user'];
                    $_SESSION['email_user'] = $user['email_user'];
                    $_SESSION['eh_adm'] = (bool)$user['eh_adm'];
                    $_SESSION['foto_user'] = $user['foto_user'];
                    $_SESSION['logged_in'] = true;

                    return true;
                }
            }
            
            return false;
            
        } catch (PDOException $e) {
            error_log("Erro no login: " . $e->getMessage());
            return false;
        }
    }


    function logout() {
        $_SESSION = array();
        session_destroy();
        header('Location: ../anonimo/index.php');
        exit();
    }

    function requireLogin() {
        if (!isLoggedIn()) {
            header('Location: ../login.php');
            exit();
        }
    }

    function requireAdmin() {
        requireLogin();
        if (!isAdmin()) {
            header('Location: ../membro/index-membro.php');
            exit();
        }
    }

    function getCurrentUser() {
        if (isLoggedIn()) {
            return [
                'id_usuario' => $_SESSION['id_usuario'],
                'nome_user' => $_SESSION['nome_user'],
                'email_user' => $_SESSION['email_user'],
                'eh_adm' => $_SESSION['eh_adm'],
                'foto_user' => $_SESSION['foto_user']
            ];
        }
        return null;
    }
?>