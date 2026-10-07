<?php
require_once __DIR__.'/config.php';
$user = current_user();
$dashboard = [
    'admin' => '/admin/dashboard.php',
    'host' => '/host/dashboard.php',
    'coordinator' => '/coordinator/dashboard.php',
    'volunteer' => '/volunteer/dashboard.php',
][$user['role'] ?? ''] ?? '/user/dashboard.php';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page_title ?? 'Eventora') ?> · Eventora</title>
<meta name="description" content="Eventora — smart college event and fest management platform.">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/app.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark site-nav sticky-top"><div class="container py-2">
<a class="navbar-brand brand" href="/index.php"><span class="brand-mark"><i class="bi bi-stars"></i></span> EVENTORA</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nav"><ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
<li class="nav-item"><a class="nav-link" href="/index.php#events">Events</a></li><li class="nav-item"><a class="nav-link" href="/index.php#how">How it works</a></li>
<?php if ($user): ?><li class="nav-item"><a class="nav-link" href="<?=e($dashboard)?>">Dashboard</a></li><li class="nav-item"><a class="btn btn-sm btn-light rounded-pill px-3" href="/logout.php">Logout</a></li>
<?php else: ?><li class="nav-item"><a class="nav-link" href="/login.php">Sign in</a></li><li class="nav-item"><a class="btn btn-sm btn-primary rounded-pill px-3" href="/register.php">Join Eventora</a></li><?php endif; ?>
</ul></div></div></nav>
<?php if ($msg = flash('success')): ?><div class="container mt-3"><div class="alert alert-success border-0 shadow-sm"><?= e($msg) ?></div></div><?php endif; ?>
<?php if ($msg = flash('error')): ?><div class="container mt-3"><div class="alert alert-danger border-0 shadow-sm"><?= e($msg) ?></div></div><?php endif; ?>
