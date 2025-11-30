<?php
// ===== Configuração de e-mail usada pelo cadastro de usuários =====
// Este arquivo dá suporte a dois modos:
// - 'file': salva mensagens em arquivos .eml na pasta outbox (modo simples, sem envio real)
// - 'smtp': tenta enviar via PHPMailer/SMTP, e se falhar, cai para o modo 'file'

// Driver de e-mail em uso: 'file' (padrão). Altere para 'smtp' se desejar envio real.
const MAIL_DRIVER = 'file';

// Parâmetros SMTP (usados apenas quando MAIL_DRIVER === 'smtp').
const SMTP_HOST = 'smtp.gmail.com';    // Servidor SMTP
const SMTP_PORT = 587;                 // Porta (587 TLS, 465 SSL)
const SMTP_SECURE = 'tls';             // 'tls' ou 'ssl'
const SMTP_USER = 'seuemail@gmail.com';// Usuário/conta do SMTP
const SMTP_PASS = 'APP_PASSWORD_AQUI'; // Senha de app

// Remetente padrão mostrado no e-mail.
const MAIL_FROM_EMAIL = 'suporte.gepea@gmail.com';
const MAIL_FROM_NAME  = 'GEPEA';

// Pastas onde os e-mails são gravados no modo 'file'.
const MAIL_OUTBOX_DIR = __DIR__ . '/../arquivos/email_outbox';           
const MAIL_OUTBOX_DIR_CADASTRO = __DIR__ . '/../arquivos/email_outbox/cadastro'; 

// Autoload opcional do Composer (necessário para PHPMailer se quiser usar SMTP).
@include_once __DIR__ . '/../../vendor/autoload.php';

// Envia um e-mail usando o método configurado (SMTP ou arquivo).
function gepea_send_mail(string $toEmail, string $toName, string $subject, string $htmlBody, string $textBody = '', string $category = 'cadastro'): bool {
    // Tenta envio real somente se configurado para SMTP e se a biblioteca PHPMailer existir.
    if (MAIL_DRIVER === 'smtp') {
        if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = SMTP_HOST;
                $mail->Port = SMTP_PORT;
                // Configura tipo de criptografia
            if (SMTP_SECURE === 'ssl') { $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS; }
            else { $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS; }
                // Credenciais SMTP
                $mail->SMTPAuth = true;
                $mail->Username = SMTP_USER;
                $mail->Password = SMTP_PASS;
                // Conteúdo e remetente
                $mail->CharSet = 'UTF-8';
                $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
                $mail->addAddress($toEmail, $toName ?: $toEmail);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mail->Body = $htmlBody;
                $mail->AltBody = $textBody ?: strip_tags($htmlBody);
                // Dispara envio
                $mail->send();
                return true;
            } catch (Throwable $e) {
                // Se algo falhar, caímos para o modo 'file' logo abaixo
            }
        }
    }

    // Modo 'file': escolhe a pasta conforme a categoria
    $category = strtolower(trim($category));
    switch ($category) {
        case 'cadastro':
            $outboxDir = MAIL_OUTBOX_DIR_CADASTRO;
            break;
        default:
            $outboxDir = MAIL_OUTBOX_DIR; // fallback geral
    }
    // Garante existência da pasta
    if (!is_dir($outboxDir)) {
        @mkdir($outboxDir, 0775, true);
    }
    // Monta nome do arquivo com data e e-mail do destinatário
    $fn = $outboxDir . '/' . date('Ymd_His') . '_' . preg_replace('/[^a-z0-9_.-]+/i', '_', $toEmail) . '.eml';
    // Cabeçalhos básicos do e-mail
    $headers = [
        'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM_EMAIL . '>',
        'To: ' . ($toName ? "$toName <$toEmail>" : $toEmail),
        'Subject: ' . $subject,
        'Content-Type: text/html; charset=UTF-8'
    ];
    // Conteúdo final gravado no arquivo .eml
    $content = implode("\r\n", $headers) . "\r\n\r\n" . $htmlBody;
    $ok = (bool)file_put_contents($fn, $content);
    if ($ok) {
        @file_put_contents($outboxDir . '/LATEST.txt', basename($fn));
        @copy($fn, $outboxDir . '/latest.eml');
    }
    return $ok;
}

// Gera a URL base do sistema, opcionalmente com um caminho adicional.
function gepea_base_url(string $targetPath = ''): string {
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost:8080';
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $script = $_SERVER['SCRIPT_NAME'] ?? '/back-end/index.php';
    $dir = str_replace('\\', '/', dirname($script));
    $pos = strpos($dir, '/back-end');
    $basePath = ($pos !== false) ? substr($dir, 0, $pos) . '/back-end' : '/back-end';
    $url = $scheme . '://' . $host . rtrim($basePath, '/');
    if ($targetPath !== '') {
        $url .= '/' . ltrim($targetPath, '/');
    }
    return $url;
}
