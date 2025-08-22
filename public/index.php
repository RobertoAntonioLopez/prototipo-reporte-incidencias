<?php
require_once __DIR__ . '/../config/config.php';
spl_autoload_register(function($class){
  $base=__DIR__ . '/../src/';
  $path=$base.str_replace(['\\','/'], DIRECTORY_SEPARATOR, $class).'.php';
  if(file_exists($path)) require_once $path;
});

use Controllers\IncidentController;
use Controllers\AuthController;
use Controllers\CommentController;
use Controllers\ApiController;

$r=$_GET['r']??'landing';

switch($r){
  case 'landing': (new IncidentController)->landing(); break;            // 👈 NUEVA portada
  case 'home': (new IncidentController)->home(); break;                  // mapa/listado
  case 'incidents.create': (new IncidentController)->create(); break;    // formulario
  case 'incidents.store': (new IncidentController)->store(); break;
  case 'incidents.show': (new IncidentController)->show(); break;
  case 'comments.store': (new CommentController)->store(); break;

  case 'api.municipios': (new ApiController)->municipios(); break;       // 👈 API municipios

  case 'auth.login': (new AuthController)->loginForm(); break;
  case 'auth.doLogin': (new AuthController)->login(); break;
  case 'auth.logout': (new AuthController)->logout(); break;

  default: http_response_code(404); echo 'Ruta no encontrada';
}
