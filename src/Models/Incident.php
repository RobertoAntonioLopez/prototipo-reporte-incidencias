<?php
namespace Models; use Core\DB;
class Incident {
  public static function create(array $d, array $tipos=[], array $links=[]): int {
    $pdo=DB::conn();
    $sql="INSERT INTO incidencias (id_usuario_reportero, fecha_ocurrencia, titulo, descripcion, id_provincia, id_municipio, id_barrio, lat, lng, muertos, heridos, perdida_estimada, estado)
          VALUES (:uid,:fecha,:titulo,:desc,:prov,:muni,:barrio,:lat,:lng,:muertos,:heridos,:perdida,'pendiente')";
    $st=$pdo->prepare($sql);
    $st->execute([
      ':uid'=>$d['id_usuario_reportero']??1,
      ':fecha'=>$d['fecha_ocurrencia'],
      ':titulo'=>$d['titulo'],
      ':desc'=>$d['descripcion'],
      ':prov'=>$d['id_provincia'],
      ':muni'=>$d['id_municipio'],
      ':barrio'=>$d['id_barrio']?:null,
      ':lat'=>$d['lat']?:null,
      ':lng'=>$d['lng']?:null,
      ':muertos'=>(int)$d['muertos'],
      ':heridos'=>(int)$d['heridos'],
      ':perdida'=>(float)$d['perdida_estimada']
    ]);
    $id=(int)$pdo->lastInsertId();
    if($tipos){
      $ins=$pdo->prepare("INSERT INTO incidencia_tipos (id_incidencia,id_tipo) VALUES (?,?)");
      foreach($tipos as $t){ $ins->execute([$id,$t]); }
    }
    if($links){
      $ins=$pdo->prepare("INSERT INTO incidencia_enlaces (id_incidencia,url) VALUES (?,?)");
      foreach($links as $u){ if($u) $ins->execute([$id,$u]); }
    }
    return $id;
  }

  public static function attachPhoto(int $id, string $ruta): bool {
    $pdo=DB::conn();
    $st=$pdo->prepare("INSERT INTO incidencia_medios (id_incidencia,ruta) VALUES (?,?)");
    return $st->execute([$id,$ruta]);
  }

  public static function last24hApproved(): array {
    $pdo=DB::conn();
    $sql = "
      SELECT i.*,
        (SELECT t.nombre FROM incidencia_tipos it
         JOIN tipos_incidencia t ON t.id_tipo=it.id_tipo
         WHERE it.id_incidencia=i.id_incidencia LIMIT 1) AS tipo_nombre
      FROM incidencias i
      WHERE i.estado='aprobada' AND i.fecha_ocurrencia >= (NOW()-INTERVAL 1 DAY)
      ORDER BY i.fecha_ocurrencia DESC
    ";
    return $pdo->query($sql)->fetchAll();
  }

  public static function list(array $f=[]): array {
    $pdo=DB::conn(); $w=[];$p=[];$join="";
    if (!empty($f['provincia'])) { $w[]="i.id_provincia=:prov"; $p[':prov']=$f['provincia']; }
    if (!empty($f['tipo'])) { $join.=" JOIN incidencia_tipos it ON it.id_incidencia=i.id_incidencia "; $w[]="it.id_tipo=:tipo"; $p[':tipo']=$f['tipo']; }
    if (!empty($f['q'])) { $w[]="i.titulo LIKE :q"; $p[':q']="%".$f['q']."%"; }
    if (!empty($f['from']) && !empty($f['to'])) { $w[]="i.fecha_ocurrencia BETWEEN :f AND :t"; $p[':f']=$f['from']; $p[':t']=$f['to']; }
    $sql="SELECT i.* FROM incidencias i " . $join;
    if($w) $sql.=" WHERE ".implode(" AND ",$w);
    $sql.=" ORDER BY i.created_at DESC LIMIT 200";
    $st=$pdo->prepare($sql); $st->execute($p); return $st->fetchAll();
  }

  public static function find(int $id): ?array {
    $pdo=DB::conn();
    $st=$pdo->prepare("SELECT * FROM incidencias WHERE id_incidencia=?");
    $st->execute([$id]);
    $r=$st->fetch();
    return $r?:null;
  }

  public static function media(int $id): array {
    $pdo=DB::conn(); $st=$pdo->prepare("SELECT * FROM incidencia_medios WHERE id_incidencia=? ORDER BY id_medio DESC");
    $st->execute([$id]); return $st->fetchAll();
  }
  public static function links(int $id): array {
    $pdo=DB::conn(); $st=$pdo->prepare("SELECT * FROM incidencia_enlaces WHERE id_incidencia=?");
    $st->execute([$id]); return $st->fetchAll();
  }
}