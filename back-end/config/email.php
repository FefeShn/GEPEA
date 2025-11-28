<?php
// Configuração de e-mail (troque para 'smtp' após definir credenciais)
const MAIL_DRIVER = 'file';

// SMTP (exemplo Gmail App Password)
const SMTP_HOST = 'smtp.gmail.com';
const SMTP_PORT = 587;
const SMTP_SECURE = 'tls';
const SMTP_USER = 'seuemail@gmail.com';
const SMTP_PASS = 'APP_PASSWORD_AQUI';

// Remetente e caixa de suporte
const MAIL_FROM_EMAIL = 'seuemail@gmail.com';
const MAIL_FROM_NAME  = 'GEPEA';
const SUPPORT_INBOX   = 'seuemail@gmail.com';

// Diretórios para modo 'file' (segregação por categoria)
const MAIL_OUTBOX_DIR = __DIR__ . '/../arquivos/email_outbox'; // legado / geral
const MAIL_OUTBOX_DIR_SUPORTE = __DIR__ . '/../arquivos/email_outbox/suporte';
const MAIL_OUTBOX_DIR_CADASTRO = __DIR__ . '/../arquivos/email_outbox/cadastro';

// Carrega autoload (PHPMailer se instalado)
@include_once __DIR__ . '/../../vendor/autoload.php';
function gepea_send_mail(string $toEmail, string $toName, string $subject, string $htmlBody, string $textBody = '', string $category = 'cadastro'): bool {
    if (MAIL_DRIVER === 'smtp') {
        if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = SMTP_HOST;
                $mail->Port = SMTP_PORT;
                if (SMTP_SECURE === 'ssl') { $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS; }
                else { $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS; }
                $mail->SMTPAuth = true;
                $mail->Username = SMTP_USER;
                $mail->Password = SMTP_PASS;
                $mail->CharSet = 'UTF-8';
                $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
                $mail->addAddress($toEmail, $toName ?: $toEmail);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mail->Body = $htmlBody;
                $mail->AltBody = $textBody ?: strip_tags($htmlBody);
                $mail->send();
                return true;
            } catch (Throwable $e) { /* se falhar, usa file */ }
        }
    }
    // Seleciona diretório conforme categoria
    $category = strtolower(trim($category));
    switch ($category) {
        case 'suporte':
            $outboxDir = MAIL_OUTBOX_DIR_SUPORTE;
            break;
        case 'cadastro':
            $outboxDir = MAIL_OUTBOX_DIR_CADASTRO;
            break;
        default:
            $outboxDir = MAIL_OUTBOX_DIR; // fallback / desconhecida
    }
    if (!is_dir($outboxDir)) {
        @mkdir($outboxDir, 0775, true);
    }
    $fn = $outboxDir . '/' . date('Ymd_His') . '_' . preg_replace('/[^a-z0-9_.-]+/i', '_', $toEmail) . '.eml';
    $headers = [
        'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM_EMAIL . '>',
        'To: ' . ($toName ? "$toName <$toEmail>" : $toEmail),
        'Subject: ' . $subject,
        'Content-Type: text/html; charset=UTF-8'
    ];
    $content = implode("\r\n", $headers) . "\r\n\r\n" . $htmlBody;
    $ok = (bool)file_put_contents($fn, $content);
    if ($ok) {
        // Marca último e-mail específico da categoria
        @file_put_contents($outboxDir . '/LATEST.txt', basename($fn));
        @copy($fn, $outboxDir . '/latest.eml');
    }
    return $ok;
}

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
