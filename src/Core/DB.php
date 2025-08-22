<?php
namespace Core;
require_once __DIR__ . '/../../config/config.php';
use PDO; use PDOException;
class DB {
  public static function conn(): PDO {
    static $pdo=null; if($pdo) return $pdo;
    $host=env('DB_HOST','127.0.0.1'); $port=env('DB_PORT','3306'); $db=env('DB_NAME','reporte_incidencias');
    $user=env('DB_USER','root'); $pass=env('DB_PASS','');
    $dsn="mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
    $opt=[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC];
    try { $pdo=new PDO($dsn,$user,$pass,$opt); return $pdo; }
    catch(PDOException $e){ http_response_code(500); echo "<h1>Error BD</h1><pre>".htmlspecialchars($e->getMessage())."</pre>"; exit; }
  }
}