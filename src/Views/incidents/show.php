<?php include __DIR__ . '/../layout_header.php'; ?>
<h1><?= htmlspecialchars($inc['titulo']) ?></h1>
<div class="card">
  <p class="small"><strong>Fecha:</strong> <?= htmlspecialchars($inc['fecha_ocurrencia']) ?> · <strong>Estado:</strong> <span class="badge"><?= htmlspecialchars($inc['estado']) ?></span></p>
  <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($inc['descripcion'])) ?></p>
  <p><strong>Ubicación:</strong> <?= htmlspecialchars($inc['lat'] ?? '') ?>, <?= htmlspecialchars($inc['lng'] ?? '') ?></p>
  <?php if (!empty($media)): $m=$media[0]; ?>
    <p><strong>Foto:</strong><br><img src="<?= htmlspecialchars($m['ruta']) ?>" alt="Foto" style="max-width:520px;border-radius:12px;border:1px solid rgba(255,255,255,.08)"></p>
  <?php endif; ?>
  <?php if (!empty($links)): ?>
    <p><strong>Links:</strong>
      <ul><?php foreach ($links as $l): ?><li><a href="<?= htmlspecialchars($l['url']) ?>" target="_blank"><?= htmlspecialchars($l['url']) ?></a></li><?php endforeach; ?></ul>
    </p>
  <?php endif; ?>
</div>

<?php if ($inc['lat'] && $inc['lng']): ?>
  <div class="card"><div id="map"></div></div>
  <script>
    window.addEventListener('DOMContentLoaded', function () {
      if (typeof initMap === 'function') {
        initMap([{
          lat: <?= (float)$inc['lat'] ?>,
          lng: <?= (float)$inc['lng'] ?>,
          titulo: <?= json_encode($inc['titulo']) ?>,
          tipo_nombre: 'detalle',
          descripcion: <?= json_encode($inc['descripcion']) ?>
        }]);
      }
    });
  </script>
<?php endif; ?>

<div class="card"><h3>Comentarios</h3>
  <form action="index.php?r=comments.store" method="post" class="flex" style="gap:8px">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
    <input type="hidden" name="id_incidencia" value="<?= (int)$inc['id_incidencia'] ?>">
    <input type="text" name="contenido" placeholder="Escribe un comentario..." required>
    <button class="btn">Publicar</button>
  </form>
  <ul>
  <?php $com = Models\Comment::list((int)$inc['id_incidencia']); foreach($com as $c): ?>
    <li><?= htmlspecialchars($c['contenido']) ?> <small class="small">[<?= htmlspecialchars($c['created_at']) ?>]</small></li>
  <?php endforeach; if(empty($com)): ?><li>No hay comentarios.</li><?php endif; ?>
  </ul>
</div>
<?php include __DIR__ . '/../layout_footer.php'; ?>
