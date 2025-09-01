<?php
// includes/user_model.php
// assumes $pdo from includes/config.php

function user_find_by_id(int $id): ?array {
    global $pdo;
    $stmt = $pdo->prepare('SELECT id, name, email, password_hash FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $u = $stmt->fetch();
    return $u ?: null;
}

function user_find_by_email(string $email): ?array {
    global $pdo;
    $stmt = $pdo->prepare('SELECT id, name, email, password_hash FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $u = $stmt->fetch();
    return $u ?: null;
}

function user_create(string $name, string $email, string $password): ?int {
    global $pdo;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
    $stmt->execute([$name, $email, $hash]);
    return (int)$pdo->lastInsertId();
}
