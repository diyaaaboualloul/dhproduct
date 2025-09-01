<?php

// Require a PDO connection (use your minimal db.php from before)
require_once __DIR__.'/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // DELETE
        if (!empty($_POST['delete_id'])) {
            $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
            $stmt->execute([(int)$_POST['delete_id']]);
        }
        // UPDATE
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
        // ADD (default)
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
        // Keep production silent; during dev, uncomment the next line
        // error_log($e->getMessage());
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}
