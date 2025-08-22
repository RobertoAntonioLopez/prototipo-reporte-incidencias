<?php
namespace Controllers; use Core\Auth; use Core\CSRF; use Core\DB; use Models\Catalog;
class CatalogController {
  private function guard(){ if(!Auth::isSuper()){ header('Location: index.php?r=auth.login'); exit; } }
  public function index(){ $this->guard(); $pdo=DB::conn();
    $provincias=$pdo->query("SELECT * FROM provincias ORDER BY nombre")->fetchAll();
    $municipios=$pdo->query("SELECT m.*, p.nombre AS provincia FROM municipios m JOIN provincias p ON p.id_provincia=m.id_provincia ORDER BY p.nombre,m.nombre")->fetchAll();
    $barrios=$pdo->query("SELECT b.*, m.nombre AS municipio FROM barrios b JOIN municipios m ON m.id_municipio=b.id_municipio ORDER BY m.nombre,b.nombre")->fetchAll();
    $tipos=$pdo->query("SELECT * FROM tipos_incidencia ORDER BY nombre")->fetchAll();
    $csrf=CSRF::token(); include __DIR__ . '/../Views/catalogs/index.php';
  }
  public function add(){ $this->guard(); if(!CSRF::check($_POST['csrf']??'')) exit('CSRF');
    $t=$_POST['t']; $n=trim($_POST['nombre']);
    $pdo=DB::conn();
    switch($t){
      case 'prov': $st=$pdo->prepare("INSERT INTO provincias (nombre) VALUES (?)"); $st->execute([$n]); break;
      case 'muni': $st=$pdo->prepare("INSERT INTO municipios (id_provincia,nombre) VALUES (?,?)"); $st->execute([(int)$_POST['id_provincia'],$n]); break;
      case 'barr': $st=$pdo->prepare("INSERT INTO barrios (id_municipio,nombre) VALUES (?,?)"); $st->execute([(int)$_POST['id_municipio'],$n]); break;
      case 'tipo': $st=$pdo->prepare("INSERT INTO tipos_incidencia (nombre) VALUES (?)"); $st->execute([$n]); break;
    }
    header('Location: index.php?r=super.catalogs');
  }
  public function del(){ $this->guard(); if(!CSRF::check($_POST['csrf']??'')) exit('CSRF');
    $t=$_POST['t']; $id=(int)$_POST['id']; $pdo=DB::conn();
    switch($t){
      case 'prov': Catalog::delete('provincias','id_provincia',$id); break;
      case 'muni': Catalog::delete('municipios','id_municipio',$id); break;
      case 'barr': Catalog::delete('barrios','id_barrio',$id); break;
      case 'tipo': Catalog::delete('tipos_incidencia','id_tipo',$id); break;
    }
    header('Location: index.php?r=super.catalogs');
  }
}