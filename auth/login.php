<?php
// auth/login.php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/user_model.php';

requireGuest(); // block logged-in users

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if ($email === '' || $pass === '') {
        $error = 'Email and password are required.';
    } else {
        $user = user_find_by_email($email);
        if ($user && password_verify($pass, $user['password_hash'])) {
            $_SESSION['user_id'] = (int)$user['id'];
            header('Location: /products.php');
            exit;
        }
        $error = 'Invalid credentials.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login</title>
  <style>
    body{font-family:system-ui,Arial;margin:24px}
    form{max-width:420px} label{display:block;margin:10px 0 6px}
    input{width:100%;padding:10px;border:1px solid #ccc;border-radius:6px}
    button{margin-top:12px;padding:10px 14px;border:0;border-radius:6px;background:#2b7cff;color:#fff;cursor:pointer}
    .error{color:#b00020;margin:10px 0}
    .muted{color:#666;margin-top:10px}
  </style>
</head>
<body>
  <h1>Log in</h1>

  <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

  <form method="post" action="">
    <label for="email">Email</label>
    <input id="email" name="email" type="email" required>

    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>

    <button type="submit">Login</button>
  </form>

  <div class="muted">No account? <a href="/auth/register.php">Create one</a></div>
</body>
</html>
