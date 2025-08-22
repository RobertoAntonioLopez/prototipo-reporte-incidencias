<?php
namespace Controllers; use Models\Comment;
class CommentController {
  public function store(){
    if(!\Core\CSRF::check($_POST['csrf']??'')) { http_response_code(400); exit('CSRF'); }
    $inc=(int)$_POST['id_incidencia']; $content=trim($_POST['contenido']);
    if($content){ Comment::create($inc,1,$content); }
    header('Location: index.php?r=incidents.show&id='.$inc);
  }
}