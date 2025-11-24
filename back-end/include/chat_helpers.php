<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/discussao_helpers.php';

function chat_normalize_message(string $message): string {
    $map = [
        ':smile:'    => "\u{1F60A}",
        ':grin:'     => "\u{1F600}",
        ':joy:'      => "\u{1F602}",
        ':heart:'    => "\u{2764}\u{FE0F}",
        ':fire:'     => "\u{1F525}",
        ':thumbsup:' => "\u{1F44D}",
        ':party:'    => "\u{1F973}",
        ':pray:'     => "\u{1F64F}",
        ':sad:'      => "\u{1F622}",
        ':clap:'     => "\u{1F44F}",
        ':think:'    => "\u{1F914}"
    ];
    return str_replace(array_keys($map), array_values($map), $message);
}

function chat_transform_row(array $row, bool $viewerIsAdmin): array {
    $isDeleted = (bool)($row['is_deleted'] ?? false);
    $messageText = $row['message'] ?? '';
    if ($isDeleted && !$viewerIsAdmin) {
        $messageText = null;
    }

    $parent = null;
    if (!empty($row['parent_id'])) {
        $parentDeleted = (bool)($row['parent_is_deleted'] ?? false);
        $parentMessage = $row['parent_message'] ?? '';
        if ($parentDeleted && !$viewerIsAdmin) {
            $parentMessage = null;
        }
        $parent = [
            'id' => (int)$row['parent_id'],
            'user_name' => $row['parent_user_name'] ?? 'Usuario',
            'message' => $parentMessage,
            'is_deleted' => $parentDeleted
        ];
    }

    return [
        'id' => (int)($row['id'] ?? 0),
        'chat_id' => (int)($row['chat_id'] ?? 0),
        'user_id' => (int)($row['user_id'] ?? 0),
        'user_name' => $row['nome_user'] ?? 'Usuario',
        'user_role' => $row['cargo_user'] ?? '',
        'user_avatar' => $row['foto_user'] ?? '',
        'user_is_admin' => (bool)($row['eh_adm'] ?? false),
        'parent_id' => !empty($row['parent_id']) ? (int)$row['parent_id'] : null,
        'parent' => $parent,
        'message' => $messageText,
        'is_deleted' => $isDeleted,
        'created_at' => $row['created_at'] ?? '',
        'updated_at' => $row['updated_at'] ?? '',
        'can_delete' => $viewerIsAdmin
    ];
}
