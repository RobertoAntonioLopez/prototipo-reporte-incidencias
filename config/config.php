<?php
if (!function_exists('env')) {
  function env($key, $default='') {
    static $vars = null;
    if ($vars === null) {
      $vars = [];
      $envPath = __DIR__ . '/.env';
      if (file_exists($envPath)) {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
          if (str_starts_with(trim($line), '#')) continue;
          if (!str_contains($line, '=')) continue;
          [$k,$v] = array_map('trim', explode('=', $line, 2));
          $vars[$k] = $v;
        }
      }
    }
    return $vars[$key] ?? $default;
  }
}
const APP_NAME = 'Reporte de Incidencias';
date_default_timezone_set('America/Santo_Domingo');
