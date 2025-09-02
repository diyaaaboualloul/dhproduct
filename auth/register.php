
<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/user_model.php';

requireGuest(); 

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $pass     = $_POST['password'] ?? '';
    $confirm  = $_POST['password_confirm'] ?? '';

    //  validation
    if ($name === '' || $email === '' || $pass === '' || $confirm === '') {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email.';
    } elseif (strlen($pass) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($pass !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (user_find_by_email($email)) {
        $error = 'Email already in use.';
    } else {
        $user_id = user_create($name, $email, $pass);
        $_SESSION['user_id'] = $user_id;       // log in
        header('Location: /products.php');     // go to protected area
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Register</title>
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
  <h1>Create account</h1>

  <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

  <form method="post" action="">
    <label for="name">Name</label>
    <input id="name" name="name" type="text" required>

    <label for="email">Email</label>
    <input id="email" name="email" type="email" required>

    <label for="password">Password (min 8)</label>
    <input id="password" name="password" type="password" required>

    <label for="password_confirm">Confirm Password</label>
    <input id="password_confirm" name="password_confirm" type="password" required>

    <button type="submit">Register</button>
  </form>

  <div class="muted">Already have an account? <a href="/auth/login.php">Log in</a></div>
</body>
</html>
