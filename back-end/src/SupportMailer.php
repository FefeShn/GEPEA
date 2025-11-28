<?php
namespace Support;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/config.php';

class SupportMailer
{
    public function send(array $ticket): bool
    {
        // Require composer autoload se presente (suporta raiz e back-end)
        $autoloadCandidates = [
            dirname(__DIR__) . '/vendor/autoload.php',     // quando src estava na raiz
            dirname(__DIR__, 2) . '/vendor/autoload.php',  // quando src está em back-end/src
            __DIR__ . '/../vendor/autoload.php',           // vendor dentro de back-end
        ];
        foreach ($autoloadCandidates as $autoload) {
            if (is_file($autoload)) { require_once $autoload; break; }
        }
        // Inclui configuração de email para acesso às constantes de diretórios
        $emailConfigCandidates = [
            __DIR__ . '/../config/email.php',              // back-end/config/email.php (src dentro de back-end)
            dirname(__DIR__) . '/config/email.php',        // back-end/config/email.php (caminho alternativo)
            dirname(__DIR__, 2) . '/back-end/config/email.php', // caso chamada a partir da raiz com caminhos antigos
        ];
        foreach ($emailConfigCandidates as $emailConfig) {
            if (is_file($emailConfig)) { require_once $emailConfig; break; }
        }
        if (!class_exists(PHPMailer::class)) {
            // PHPMailer não disponível: salva fallback em outbox de suporte e retorna false
            $this->fallbackFile($ticket, '[GEPEA] Novo ticket de suporte: ' . ($ticket['title'] ?? '(sem título)'));
            return false;
        }
        $mail = new PHPMailer(true);
        try {
            $smtpHost = envv('SMTP_HOST', 'localhost');
            $smtpPort = (int) envv('SMTP_PORT', 25);
            $smtpUser = envv('SMTP_USER', '');
            $smtpPass = envv('SMTP_PASS', '');
            $smtpSecure = strtolower(envv('SMTP_SECURE', 'none'));
            $supportEmail = envv('SUPPORT_EMAIL', 'support@example.com');

            $mail->isSMTP();
            $mail->Host = $smtpHost;
            $mail->Port = $smtpPort;
            if ($smtpUser !== '' || $smtpPass !== '') {
                $mail->SMTPAuth = true;
                $mail->Username = $smtpUser;
                $mail->Password = $smtpPass;
            }
            if ($smtpSecure === 'tls') $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            if ($smtpSecure === 'ssl') $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

            $mail->setFrom($supportEmail, 'GEPEA Suporte');
            $mail->addAddress($supportEmail, 'Suporte');
            $mail->addReplyTo($ticket['email'] ?? $supportEmail, $ticket['name'] ?? 'Usuário');

            $mail->Subject = '[GEPEA] Novo ticket de suporte: ' . ($ticket['title'] ?? '(sem título)');
            $body  = "Nome: " . ($ticket['name'] ?? '') . "\n";
            $body .= "E-mail: " . ($ticket['email'] ?? '') . "\n";
            $body .= "IP: " . ($ticket['ip'] ?? '') . "\n";
            $body .= "User-Agent: " . ($ticket['user_agent'] ?? '') . "\n\n";
            $body .= ($ticket['message'] ?? '');
            $mail->Body = $body;
            $mail->AltBody = $body;

            $ok = $mail->send();
            if (!$ok) {
                $this->fallbackFile($ticket, $mail->Subject);
            }
            return $ok;
        } catch (\Throwable $e) {
            $this->fallbackFile($ticket, '[GEPEA] Novo ticket de suporte: ' . ($ticket['title'] ?? '(sem título)'));
            return false;
        }
    }

    private function fallbackFile(array $ticket, string $subject): void
    {
        // Usa constante se definida, senão constrói caminho relativo
        $dir = defined('MAIL_OUTBOX_DIR_SUPORTE') ? MAIL_OUTBOX_DIR_SUPORTE : (__DIR__ . '/../arquivos/email_outbox/suporte');
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $email = $ticket['email'] ?? 'anonimo@example.com';
        $name  = $ticket['name'] ?? 'Anônimo';
        $fn = $dir . '/' . date('Ymd_His') . '_' . preg_replace('/[^a-z0-9_.-]+/i', '_', $email) . '.eml';
        $headers = [
            'From: GEPEA Suporte <' . ($ticket['support_email'] ?? 'support@example.com') . '>',
            'To: Suporte <' . ($ticket['support_email'] ?? 'support@example.com') . '>',
            'Reply-To: ' . ($name ?: 'Usuario') . ' <' . $email . '>',
            'Subject: ' . $subject,
            'Content-Type: text/plain; charset=UTF-8'
        ];
        $body  = "Nome: {$name}\n";
        $body .= "E-mail: {$email}\n";
        $body .= "IP: " . ($ticket['ip'] ?? '') . "\n";
        $body .= "User-Agent: " . ($ticket['user_agent'] ?? '') . "\n\n";
        $body .= ($ticket['message'] ?? '');
        $content = implode("\r\n", $headers) . "\r\n\r\n" . $body;
        if (file_put_contents($fn, $content)) {
            @file_put_contents($dir . '/LATEST.txt', basename($fn));
            @copy($fn, $dir . '/latest.eml');
        }
    }
}
