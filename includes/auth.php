<?php
// includes/auth.php
if (session_status() === PHP_SESSION_NONE) session_start();

function isLoggedIn(): bool {
    return !empty($_SESSION['user_id']);
}

function requireAuth(): void {
    if (!isLoggedIn()) {
        header('Location: /auth/login.php'); exit;
    }
}

function requireGuest(): void {
    if (isLoggedIn()) {
        header('Location: /products.php'); exit;
    }
}

function currentUserId(): ?int {
    return isLoggedIn() ? (int)$_SESSION['user_id'] : null;
}
