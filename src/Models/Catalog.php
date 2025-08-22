<?php
namespace Models; use Core\DB;
class Catalog {
  public static function all($table){ $pdo=DB::conn(); return $pdo->query("SELECT * FROM {$table} ORDER BY 1")->fetchAll(); }
  public static function create($table,$cols,$vals){ $pdo=DB::conn(); $sql="INSERT INTO {$table} ({$cols}) VALUES ({$vals})"; return $pdo->exec($sql)>0; }
  public static function delete($table,$idcol,$id){ $pdo=DB::conn(); $st=$pdo->prepare("DELETE FROM {$table} WHERE {$idcol}=?"); return $st->execute([$id]); }
}