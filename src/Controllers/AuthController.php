<?php
namespace Controllers; use Core\CSRF;
class AuthController {
  public function loginForm(){ $csrf=\Core\CSRF::token(); include __DIR__ . '/../Views/auth/login.php'; }
  public function login(){ if(!\Core\CSRF::check($_POST['csrf']??'')) exit('CSRF');
    $email=$_POST['email']??''; $pass=$_POST['password']??'';
    if($email===env('SUPER_USER','admin@demo.com') && $pass===env('SUPER_PASS','demo123')){ if(session_status()!==PHP_SESSION_ACTIVE) session_start(); $_SESSION['super']=$email; header('Location: index.php?r=home'); return; }
    header('Location: index.php?r=auth.login&err=1'); }
  public function logout(){ if(session_status()!==PHP_SESSION_ACTIVE) session_start(); unset($_SESSION['super']); header('Location: index.php?r=auth.login'); }
}