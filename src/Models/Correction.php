<?php
namespace Models; use Core\DB;
class Correction {
  public static function create(array $d): bool {
    $pdo=DB::conn(); $st=$pdo->prepare("INSERT INTO correcciones (id_incidencia,id_usuario_solicita,campo,valor_sugerido,motivo) VALUES (?,?,?,?,?)");
    return $st->execute([$d['id_incidencia'],$d['id_usuario_solicita'],$d['campo'],$d['valor_sugerido'],$d['motivo']]);
  }
  public static function pending(): array {
    $pdo=DB::conn(); return $pdo->query("SELECT * FROM correcciones WHERE estado='pendiente' ORDER BY created_at DESC").fetchAll();
  }
}