<?php
namespace Controllers;
use Models\Incident;
use Core\CSRF;
use Core\DB;

class IncidentController {

  // 👇 Nueva página de inicio
  public function landing(){
    include __DIR__ . '/../Views/landing.php';
  }

  public function home(){
    $filters=[
      'provincia'=>$_GET['provincia']??null,
      'tipo'=>$_GET['tipo']??null,
      'q'=>$_GET['q']??null,
      'from'=>$_GET['from']??null,
      'to'=>$_GET['to']??null
    ];
    $list=Incident::list($filters); $last24=Incident::last24hApproved();
    $pdo=DB::conn();
    $tipos=$pdo->query("SELECT * FROM tipos_incidencia ORDER BY nombre")->fetchAll();
    $provincias=$pdo->query("SELECT * FROM provincias ORDER BY nombre")->fetchAll();
    include __DIR__ . '/../Views/incidents/home.php';
  }

  public function create(){
    $csrf=CSRF::token(); 
    $pdo=DB::conn();
    $tipos=$pdo->query("SELECT * FROM tipos_incidencia ORDER BY nombre")->fetchAll();
    $provincias=$pdo->query("SELECT id_provincia, nombre FROM provincias ORDER BY nombre")->fetchAll(); // 👈 para el dropdown
    include __DIR__ . '/../Views/incidents/create.php';
  }

  public function store(){
    if(!CSRF::check($_POST['csrf']??'')){ http_response_code(400); exit('CSRF'); }
    $d=[
      'id_usuario_reportero'=>1,
      'fecha_ocurrencia'=>$_POST['fecha'],
      'titulo'=>trim($_POST['titulo']),
      'descripcion'=>trim($_POST['descripcion']),
      'id_provincia'=>(int)$_POST['provincia'],
      'id_municipio'=>(int)$_POST['municipio'],
      'id_barrio'=>$_POST['barrio']? (int)$_POST['barrio']:null,
      'lat'=>$_POST['lat']?:null,
      'lng'=>$_POST['lng']?:null,
      'muertos'=>(int)$_POST['muertos'],
      'heridos'=>(int)$_POST['heridos'],
      'perdida_estimada'=>(float)$_POST['perdida']
    ];
    $tipos = array_map('intval', $_POST['tipos'] ?? []);
    $links = array_map('trim', array_filter(explode(',', $_POST['links'] ?? '')));
    $id=Incident::create($d,$tipos,$links);

    if(!empty($_FILES['foto']['name']) && is_uploaded_file($_FILES['foto']['tmp_name'])){
      $dir = __DIR__ . '/../../public/uploads/';
      if(!is_dir($dir)) mkdir($dir,0777,true);
      $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) ?: 'jpg';
      $fname = 'inc_' . $id . '_' . time() . '.' . $ext;
      if(move_uploaded_file($_FILES['foto']['tmp_name'], $dir.$fname)){
        \Models\Incident::attachPhoto($id, 'uploads/' . $fname);
      }
    }
    header('Location: index.php?r=incidents.show&id='.$id);
  }

  public function show(){
    $id=(int)($_GET['id']??0);
    $inc=Incident::find($id);
    if(!$inc){ http_response_code(404); exit('No encontrada'); }
    $csrf=CSRF::token();
    $media=\Models\Incident::media($id);
    $links=\Models\Incident::links($id);
    include __DIR__ . '/../Views/incidents/show.php';
  }
}
