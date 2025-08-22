<?php
namespace Models; use Core\DB;
class Comment {
  public static function create(int $inc,int $user,string $content): bool {
    $pdo=DB::conn(); $st=$pdo->prepare("INSERT INTO comentarios (id_incidencia,id_usuario,contenido) VALUES (?,?,?)");
    return $st->execute([$inc,$user,$content]);
  }
  public static function list(int $inc): array {
    $pdo=DB::conn(); $st=$pdo->prepare("SELECT c.*, u.nombre FROM comentarios c JOIN usuarios u ON u.id_usuario=c.id_usuario WHERE c.id_incidencia=? ORDER BY c.created_at DESC");
    $st->execute([$inc]); return $st->fetchAll();
  }
}