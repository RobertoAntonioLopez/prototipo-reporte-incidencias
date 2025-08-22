<?php include __DIR__ . '/../layout_header.php'; ?>
<h1>Incidencias</h1>
<form method="get" class="filter card">
  <input type="hidden" name="r" value="home">
  <input type="text" name="q" placeholder="Buscar por título" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
  <input type="date" name="from" value="<?= htmlspecialchars($_GET['from'] ?? '') ?>">
  <input type="date" name="to" value="<?= htmlspecialchars($_GET['to'] ?? '') ?>">
  <select name="tipo">
    <option value="">Tipo (todos)</option>
    <?php $tipos = $tipos ?? []; foreach ($tipos as $t): ?>
      <option value="<?= (int)$t['id_tipo'] ?>" <?= (!empty($_GET['tipo']) && $_GET['tipo']==$t['id_tipo'])?'selected':'' ?>><?= htmlspecialchars($t['nombre']) ?></option>
    <?php endforeach; ?>
  </select>
  <select name="provincia">
    <option value="">Provincia (todas)</option>
    <?php $provincias = $provincias ?? []; foreach ($provincias as $p): ?>
      <option value="<?= (int)$p['id_provincia'] ?>" <?= (!empty($_GET['provincia']) && $_GET['provincia']==$p['id_provincia'])?'selected':'' ?>><?= htmlspecialchars($p['nombre']) ?></option>
    <?php endforeach; ?>
  </select>
  <button class="btn">Filtrar</button>
</form>

<div class="grid">
  <div class="card"><div id="map"></div></div>
  <script>
    window.addEventListener('DOMContentLoaded', function () {
      if (typeof initMap === 'function') {
        const markers = <?= json_encode($last24 ?? []) ?>;
        initMap(markers);
      }
    });
  </script>

  <div class="card"><h3>Últimas 24h (aprobadas)</h3><ul>
    <?php foreach (($last24 ?? []) as $i): ?>
      <li><a href="index.php?r=incidents.show&id=<?= (int)$i['id_incidencia'] ?>"><?= htmlspecialchars($i['titulo']) ?></a> <span class="small">· <?= htmlspecialchars($i['tipo_nombre'] ?? 'tipo') ?></span></li>
    <?php endforeach; if (empty($last24)): ?><li>No hay incidencias aprobadas en las últimas 24h.</li><?php endif; ?>
  </ul></div>
</div>

<div id="modal" class="modal" onclick="if(event.target.id==='modal') closeModal()">
  <div class="box">
    <span class="close" onclick="closeModal()">✕</span>
    <h2 class="title"></h2>
    <p class="meta small"></p>
    <p class="desc"></p>
    <p><a class="ver btn" href="#">Ver detalle</a></p>
  </div>
</div>

<div class="card"><h3>Listado (recientes)</h3><table class="table">
  <thead><tr><th>Título</th><th>Fecha</th><th>Estado</th><th>Acciones</th></tr></thead><tbody>
  <?php foreach (($list ?? []) as $r): ?>
    <tr><td><?= htmlspecialchars($r['titulo']) ?></td><td><?= htmlspecialchars($r['fecha_ocurrencia']) ?></td><td><span class="badge"><?= htmlspecialchars($r['estado']) ?></span></td>
    <td><a class="btn outline" href="index.php?r=incidents.show&id=<?= (int)$r['id_incidencia'] ?>">Ver</a></td></tr>
  <?php endforeach; ?></tbody></table></div>
<?php include __DIR__ . '/../layout_footer.php'; ?>
