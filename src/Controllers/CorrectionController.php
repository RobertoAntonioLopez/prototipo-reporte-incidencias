<?php
namespace Controllers; use Models\Correction; use Models\Incident; use Core\CSRF;
class CorrectionController {
  public function store(){
    if(!CSRF::check($_POST['csrf']??'')) { http_response_code(400); exit('CSRF'); }
    $d=['id_incidencia'=>(int)$_POST['id_incidencia'],'id_usuario_solicita'=>1,'campo'=>$_POST['campo'],'valor_sugerido'=>$_POST['valor'],'motivo'=>$_POST['motivo']??''];
    Correction::create($d);
    header('Location: index.php?r=incidents.show&id='.$d['id_incidencia']);
  }
  public function approve(){ if(!CSRF::check($_POST['csrf']??'')) { http_response_code(400); exit('CSRF'); }
    $id=(int)$_POST['id']; $corr=Correction::find($id); if($corr){ Incident::applyField((int)$corr['id_incidencia'],$corr['campo'],$corr['valor_sugerido']); Correction::resolve($id,'aprobada',2); }
    header('Location: index.php?r=super.corrections'); }
  public function reject(){ if(!CSRF::check($_POST['csrf']??'')) { http_response_code(400); exit('CSRF'); }
    $id=(int)$_POST['id']; Correction::resolve($id,'rechazada',2); header('Location: index.php?r=super.corrections'); }
}