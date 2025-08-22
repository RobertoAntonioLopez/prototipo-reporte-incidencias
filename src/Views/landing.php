<?php include __DIR__ . '/layout_header.php'; ?>
<div class="hero card">
  <h1>Reporte de Incidencias RD</h1>
  <p class="lead">
    Plataforma académica en PHP + MySQL para registrar, visualizar y gestionar incidencias en la República Dominicana.
    Incluye mapa interactivo, filtros, comentarios, correcciones y panel /super para validación.
  </p>
  <div class="actions">
    <a class="btn" href="index.php?r=home">Ver mapa y listado</a>
    <a class="btn outline" href="index.php?r=incidents.create">Reportar incidencia</a>
    <a class="btn outline" href="index.php?r=auth.login">Entrar a /super</a>
  </div>
</div>

<div class="card-grid">
  <a class="card link" href="index.php?r=home">
    <h3>Mapa en vivo</h3>
    <p>Incidencias aprobadas de las últimas 24 horas con clustering e íconos por tipo.</p>
  </a>
  <a class="card link" href="index.php?r=incidents.create">
    <h3>Reportar</h3>
    <p>Formulario con foto, links y selección de coordenadas desde un mini-mapa.</p>
  </a>
  <a class="card link" href="index.php?r=auth.login">
    <h3>/super</h3>
    <p>Valida reportes, gestiona catálogos y consulta estadísticas.</p>
  </a>
</div>
<?php include __DIR__ . '/layout_footer.php'; ?>
