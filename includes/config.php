<?php
// Eventora configuration. Update these values for your hosting provider.
session_start();
date_default_timezone_set('Asia/Kolkata');

$db_host = 'localhost';
$db_name = 'eventora';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    $pdo = null; // Landing/demo pages remain usable without DB; authenticated features require setup.sql.
}

function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function is_logged_in() { return !empty($_SESSION['user']); }
function current_user() { return $_SESSION['user'] ?? null; }
function require_login() { if (!is_logged_in()) { header('Location: /login.php'); exit; } }
function require_role($roles) {
    require_login();
    $roles = (array)$roles;
    if (!in_array($_SESSION['user']['role'] ?? '', $roles, true)) { http_response_code(403); exit('Access denied'); }
}
function flash($key, $message = null) {
    if ($message !== null) { $_SESSION['flash'][$key] = $message; return; }
    $msg = $_SESSION['flash'][$key] ?? null; unset($_SESSION['flash'][$key]); return $msg;
}
function redirect($url) { header("Location: {$url}"); exit; }
function db_required() { global $pdo; if (!$pdo) { http_response_code(503); exit('Database is not configured. Import setup.sql and update includes/config.php.'); } }
function status_badge($status) {
    $map = ['approved'=>'success','pending'=>'warning','rejected'=>'danger','draft'=>'secondary','open'=>'primary','closed'=>'dark','completed'=>'info'];
    $class = $map[strtolower($status)] ?? 'secondary';
    return '<span class="badge text-bg-'.$class.'">'.e(ucfirst($status)).'</span>';
}
?>
