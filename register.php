<?php
require_once __DIR__.'/includes/config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
    db_required();
    $name=trim($_POST['name']??'');
    $email=trim($_POST['email']??'');
    $pass=$_POST['password']??'';
    $role=in_array($_POST['role']??'',['student','host','coordinator','volunteer'],true)?$_POST['role']:'student';
    if(strlen($pass)<8){
        flash('error','Password must be at least 8 characters.');
    } else {
        try {
            $s=$pdo->prepare("INSERT INTO users(name,email,password,role,status) VALUES(?,?,?,?,'active')");
            $s->execute([$name,$email,password_hash($pass,PASSWORD_DEFAULT),$role]);
            flash('success','Account created. You can now sign in.');
            redirect('/login.php');
        } catch(PDOException $e){
            flash('error','That email is already registered.');
        }
    }
}
$page_title='Join Eventora'; require __DIR__.'/includes/header.php';
?><div class="auth-shell"><div class="auth-card"><div class="text-center mb-4"><div class="brand justify-content-center"><span class="brand-mark"><i class="bi bi-stars"></i></span> EVENTORA</div><h2 class="mt-4">Join the campus</h2><p class="text-secondary">Create your Eventora identity.</p></div><form method="post"><label class="form-label">Full name</label><input class="form-control mb-3" name="name" required value="<?=e($_POST['name']??'')?>"><label class="form-label">College email</label><input class="form-control mb-3" type="email" name="email" required value="<?=e($_POST['email']??'')?>"><label class="form-label">I want to</label><select class="form-select mb-3" name="role"><option value="student" <?=($_POST['role']??'')==='student'?'selected':''?>>Participate in events</option><option value="host" <?=($_POST['role']??'')==='host'?'selected':''?>>Host events</option><option value="coordinator" <?=($_POST['role']??'')==='coordinator'?'selected':''?>>Coordinate events</option><option value="volunteer" <?=($_POST['role']??'')==='volunteer'?'selected':''?>>Volunteer at events</option></select><label class="form-label">Password</label><input class="form-control mb-3" type="password" name="password" minlength="8" required><button class="btn btn-primary w-100 rounded-pill py-2">Create account</button></form><p class="text-center text-secondary small mt-4 mb-0">Already registered? <a href="/login.php">Sign in</a></p></div></div><?php require __DIR__.'/includes/footer.php'; ?>
