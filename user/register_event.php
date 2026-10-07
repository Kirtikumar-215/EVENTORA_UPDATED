<?php
require_once __DIR__ . '/../includes/config.php';
require_role(['student','host','coordinator','volunteer']); db_required();$id=(int)($_GET['id']??0);$s=$pdo->prepare('INSERT IGNORE INTO registrations(user_id,event_id,status) VALUES(?,?,\'confirmed\')');try{$s->execute([current_user()['id'],$id]);flash('success','Your event registration is confirmed.');}catch(Throwable $e){flash('error','Unable to register right now.');}redirect('/user/events.php');
