<?php
namespace Core; require_once __DIR__ . '/../../config/config.php';
class Auth {
  public static function start(){ if(session_status()!==PHP_SESSION_ACTIVE) session_start(); }
  public static function loginSuper($email){ self::start(); $_SESSION['super']=$email; }
  public static function logoutSuper(){ self::start(); unset($_SESSION['super']); }
  public static function isSuper(): bool { self::start(); return !empty($_SESSION['super']); }
  public static function loginReporter($email,$name){ self::start(); $_SESSION['reporter']=['email'=>$email,'name'=>$name,'id'=>1]; }
  public static function reporter(){ self::start(); return $_SESSION['reporter'] ?? null; }
}