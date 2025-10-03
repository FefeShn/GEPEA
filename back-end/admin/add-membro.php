<?php
session_start();
require '../config/auth.php';

if (!isAdmin()) {
    header('Location: ../anonimo/login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nomeMembro'] ?? '');
    $email = trim($_POST['emailMembro'] ?? '');
    $cargo = $_POST['cargoMembro'] ?? '';
    $lattes = trim($_POST['lattesMembro'] ?? '');
    $senha = $_POST['senhaMembro'] ?? '';
    $foto = '';

    if (isset($_FILES['fotoMembro']) && $_FILES['fotoMembro']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['fotoMembro']['name'], PATHINFO_EXTENSION);
        $foto = '../imagens/' . uniqid('membro_') . '.' . $ext;
        move_uploaded_file($_FILES['fotoMembro']['tmp_name'], $foto);
    }
    if (empty($foto)) {
        $foto = '../imagens/user-foto.png';
    }

    if (empty($nome) || empty($email) || empty($cargo) || empty($senha)) {
        $error = 'Preencha todos os campos obrigatórios!';
    } else {
        $pdo = getConexao();
        $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email_user = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = 'Já existe um membro com esse e-mail!';
        } else {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome_user, email_user, senha_user, foto_user, eh_adm, cargo_user, lattes_user) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $eh_adm = 0; // Membro comum
            $stmt->execute([
                $nome,
                $email,
                $senha,
                $foto,
                $eh_adm,
                $cargo,
                $lattes
            ]);
            $success = 'Membro cadastrado com sucesso!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php include "../include/head.php"; ?>
<body>
    <?php include "../include/navbar.php"; ?>
    <div class="container-scroller">
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="members-header">
                    <h1 class="page-title">Cadastrar Novo Membro</h1>
                    <div class="members-actions">
                        <a href="membros-admin.php" class="add-member-button">
                            <i class="ti-arrow-left"></i>Voltar para membros
                        </a>
                    </div>
                </div>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <div class="support-form-container">
                    <form action="add-membro.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nomeMembro">Nome Completo *</label>
                            <input type="text" name="nomeMembro" id="nomeMembro" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="emailMembro">Email *</label>
                            <input type="email" name="emailMembro" id="emailMembro" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="cargoMembro">Cargo no Grupo *</label>
                            <select name="cargoMembro" id="cargoMembro" class="form-control" required>
                                <option value="" disabled selected>Selecione o cargo...</option>
                                <option value="coordenador">Coordenador</option>
                                <option value="vice-coordenador">Vice-Coordenador</option>
                                <option value="bolsista">Bolsista</option>
                                <option value="membro">Membro</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="lattesMembro">Currículo Lattes</label>
                            <input type="text" name="lattesMembro" id="lattesMembro" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="senhaMembro">Senha Inicial *</label>
                            <input type="password" name="senhaMembro" id="senhaMembro" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="fotoMembro">Foto do Perfil</label>
                            <div class="file-upload-container">
                                <input type="file" name="fotoMembro" id="fotoMembro" class="file-input" accept="image/jpeg,image/png" hidden>
                                <label for="fotoMembro" class="file-upload-button">
                                    <i class="ti-camera"></i>
                                    <span class="file-upload-text">Selecionar Foto</span>
                                </label>
                                <span class="file-name" id="fileName">Nenhum arquivo selecionado</span>
                            </div>
                            <small class="legenda">Formatos aceitos: JPG, PNG. Tamanho máximo: 2MB</small>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti-plus"></i>Cadastrar Membro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-primary {
            background-color: var(--verde);
            border-color: var(--verde);
        }

        .btn-primary:hover {
            background-color: var(--amarelo);
            border-color: var(--amarelo);
        }
        .file-upload-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 5px;
        }

        .file-upload-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--verde);
            color: white;
            padding: 12px 20px;
            border-radius: var(--borda-radius);
            cursor: pointer;
            transition: var(--transicao-normal);
            border: none;
            font-weight: 500;
            text-align: center;
            justify-content: center;
            box-shadow: var(--sombra-leve);
        }

        .file-upload-button:hover {
            background-color: var(--amarelo);
            transform: translateY(-2px);
            box-shadow: var(--sombra-media);
        }

        .file-upload-button i {
            font-size: 1.2rem;
        }

        .file-upload-text {
            font-size: 0.95rem;
        }

        .file-name {
            font-size: 0.9rem;
            color: #666;
            padding: 8px 12px;
            background-color: var(--cinza-claro);
            border-radius: var(--borda-radius);
            border: 1px solid var(--cinza-medio);
        }

        .file-input:focus + .file-upload-button {
            outline: 2px solid var(--verde);
            outline-offset: 2px;
        }
    </style>

    <script>
        document.getElementById('fotoMembro').addEventListener('change', function(e) {
            const fileName = document.getElementById('fileName');
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
                fileName.style.color = 'var(--verde)';
                fileName.style.fontWeight = '500';
            } else {
                fileName.textContent = 'Nenhum arquivo selecionado';
                fileName.style.color = '#666';
                fileName.style.fontWeight = 'normal';
            }
        });
    </script>
</body>
</html>