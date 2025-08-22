<?php include __DIR__ . '/../layout_header.php'; ?>
<h1>Panel /super</h1>
<p class="flex"><a class="btn outline" href="index.php?r=auth.logout">Cerrar sesión</a>
<a class="btn outline" href="index.php?r=super.corrections">Correcciones</a>
<a class="btn outline" href="index.php?r=super.catalogs">Catálogos</a>
<a class="btn outline" href="index.php?r=super.stats">Estadísticas</a></p>
<div class="card"><h3>Reportes pendientes</h3>
<table class="table"><thead><tr><th>ID</th><th>Título</th><th>Fecha</th><th>Acción</th></tr></thead><tbody>
<?php foreach ($pendings as $p): ?>
<tr><td>#<?= (int)$p['id_incidencia'] ?></td><td><?= htmlspecialchars($p['titulo']) ?></td><td><?= htmlspecialchars($p['fecha_ocurrencia']) ?></td><td>
<form action="index.php?r=super.approve" method="post" style="display:inline">
  <input type="hidden" name="csrf" value="<?= htmlspecialchars(\Core\CSRF::token()) ?>">
  <input type="hidden" name="id" value="<?= (int)$p['id_incidencia'] ?>">
  <button class="btn">Aprobar</button>
</form>
<a class="btn outline" href="index.php?r=incidents.show&id=<?= (int)$p['id_incidencia'] ?>">Ver</a>
</td></tr>
<?php endforeach; if (empty($pendings)): ?><tr><td colspan="4">No hay pendientes</td></tr><?php endif; ?>
</tbody></table></div>
<div class="card"><h3>Unir reportes similares</h3>
<form action="index.php?r=super.merge" method="post" class="flex">
  <input type="hidden" name="csrf" value="<?= htmlspecialchars(\Core\CSRF::token()) ?>">
  <label>ID destino<input type="number" name="target" required></label>
  <label>ID origen<input type="number" name="source" required></label>
  <button class="btn">Unir</button>
</form>
<p class="muted">Se moverán comentarios, correcciones, medios, enlaces y tipos al destino.</p>
</div>
<?php include __DIR__ . '/../layout_footer.php'; ?>