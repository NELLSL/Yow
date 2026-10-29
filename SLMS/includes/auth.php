<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
function require_role(array $roles): void {
    if (empty($_SESSION['user_id']) || !in_array($_SESSION['role'] ?? '', $roles, true)) {
        header('Location: ../index.php');
        exit;
    }
}
function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
