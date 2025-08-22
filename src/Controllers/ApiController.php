<?php
namespace Controllers;
use Core\DB;

class ApiController {
  public function municipios(){
    header('Content-Type: application/json; charset=utf-8');
    $prov = (int)($_GET['provincia'] ?? 0);
    if($prov <= 0){ echo json_encode([]); return; }
    $pdo=DB::conn();
    $st=$pdo->prepare("SELECT id_municipio, nombre FROM municipios WHERE id_provincia=? ORDER BY nombre");
    $st->execute([$prov]);
    echo json_encode($st->fetchAll());
  }
}
