<?php
require_once __DIR__.'/includes/config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
    db_required();
    $email=trim($_POST['email']??'');
    $pass=$_POST['password']??'';
    $s=$pdo->prepare('SELECT id,name,email,password,role,status FROM users WHERE email=? LIMIT 1');
    $s->execute([$email]);
    $u=$s->fetch();
    if($u && $u['status']==='active' && password_verify($pass,$u['password'])){
        unset($u['password']);
        $_SESSION['user']=$u;
        flash('success','Welcome back, '.$u['name'].'!');
        $dest=['admin'=>'/admin/dashboard.php','host'=>'/host/dashboard.php','coordinator'=>'/coordinator/dashboard.php','volunteer'=>'/volunteer/dashboard.php'][$u['role']]??'/user/dashboard.php';
        redirect($dest);
    }
    flash('error','Invalid credentials or inactive account.');
}
$page_title='Sign in'; require __DIR__.'/includes/header.php';
?><div class="auth-shell"><div class="auth-card"><div class="text-center mb-4"><div class="brand justify-content-center"><span class="brand-mark"><i class="bi bi-stars"></i></span> EVENTORA</div><h2 class="mt-4">Welcome back</h2><p class="text-secondary">Sign in to your event workspace.</p></div><form method="post"><label class="form-label">Email</label><input class="form-control mb-3" type="email" name="email" required placeholder="you@college.edu" value="<?=e($_POST['email']??'')?>"><label class="form-label">Password</label><input class="form-control mb-3" type="password" name="password" required placeholder="••••••••"><button class="btn btn-primary w-100 rounded-pill py-2">Sign in <i class="bi bi-arrow-right ms-1"></i></button></form><p class="text-center text-secondary small mt-4 mb-0">New here? <a href="/register.php">Create an account</a></p><div class="alert alert-light small mt-4 mb-0">Demo HOD login after importing <code>setup.sql</code>: <strong>hod@eventora.local</strong> / <strong>Eventora@123</strong></div></div></div><?php require __DIR__.'/includes/footer.php'; ?>
