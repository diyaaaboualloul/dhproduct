<?php

require_once __DIR__.'/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!empty($_POST['delete_id'])) {
            $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
            $stmt->execute([(int)$_POST['delete_id']]);
        }
        elseif (!empty($_POST['update_id'])) {
            $id    = (int)($_POST['update_id'] ?? 0);
            $title = trim($_POST['title'] ?? '');
            $desc  = trim($_POST['description'] ?? '');
            $price = (float)($_POST['price'] ?? -1);

            if ($title !== '' && $desc !== '' && $price >= 0) {
                $stmt = $pdo->prepare('UPDATE products SET title = ?, `desc` = ?, price = ? WHERE id = ?');
                $stmt->execute([$title, $desc, $price, $id]);
            }
        }
        else {
            $title = trim($_POST['title'] ?? '');
            $desc  = trim($_POST['description'] ?? '');
            $price = (float)($_POST['price'] ?? -1);

            if ($title !== '' && $desc !== '' && $price >= 0) {
                $stmt = $pdo->prepare('INSERT INTO products (title, `desc`, price) VALUES (?, ?, ?)');
                $stmt->execute([$title, $desc, $price]);
            }
        }
    } catch (Throwable $e) {
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}
