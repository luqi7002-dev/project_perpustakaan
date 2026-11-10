<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function wajib_login(): void {
    if (empty($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
}

function e($nilai): string {
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}
