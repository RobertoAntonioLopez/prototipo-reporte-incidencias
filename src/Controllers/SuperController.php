<?php
namespace Controllers; use Core\Auth; use Core\CSRF; use Models\Incident; use Models\Correction;
class SuperController {
  private function guard(){ if(!Auth::isSuper()){ header('Location: index.php?r=auth.login'); exit; } }
  public function dashboard(){ $this->guard(); $pendings=Incident::pendings(); include __DIR__ . '/../Views/super/dashboard.php'; }
  public function approve(){ $this->guard(); if(!CSRF::check($_POST['csrf']??'')) exit('CSRF'); $id=(int)($_POST['id']??0); Incident::approve($id); header('Location: index.php?r=super.dashboard'); }
  public function merge(){ $this->guard(); if(!CSRF::check($_POST['csrf']??'')) exit('CSRF'); $target=(int)$_POST['target']; $source=(int)$_POST['source']; Incident::merge($target,$source); header('Location: index.php?r=super.dashboard'); }
  public function corrections(){ $this->guard(); $csrf=CSRF::token(); $list=Correction::pending(); include __DIR__ . '/../Views/super/corrections.php'; }
  public function stats(){ $this->guard(); include __DIR__ . '/../Views/super/stats.php'; }
}