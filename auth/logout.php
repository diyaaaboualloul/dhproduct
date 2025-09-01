<?php
// auth/logout.php
require_once __DIR__ . '/../includes/auth.php';
if (session_status() === PHP_SESSION_NONE) session_start();
unset($_SESSION['user_id']);
session_regenerate_id(true); // optional but good practice
header('Location: /auth/login.php');
exit;
