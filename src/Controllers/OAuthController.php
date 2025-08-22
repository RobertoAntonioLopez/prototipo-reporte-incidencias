<?php
namespace Controllers; use Core\Auth;
class OAuthController {
  public function googleCallback(){ $name=$_GET['name']??'Reportero Demo'; $email=$_GET['email']??'reportero@demo.com'; Auth::loginReporter($email,$name); header('Location: index.php?r=incidents.create'); }
}