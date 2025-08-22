<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html><html lang="es"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= APP_NAME ?></title>
<link rel="stylesheet" href="assets/css/app.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">
</head><body>
<div class="topbar">
  <div class="flex">
    <a href="index.php?r=landing"><strong><?= APP_NAME ?></strong></a>
    <a href="index.php?r=home">Mapa</a>
    <a href="index.php?r=incidents.create">Reportar</a>
  </div>
  <div class="flex">
    <a href="index.php?r=auth.login">/super</a>
  </div>
</div>
<div class="container">
