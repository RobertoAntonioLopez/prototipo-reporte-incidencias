<?php include __DIR__ . '/../layout_header.php'; ?>
<h1>Correcciones pendientes</h1>
<div class="card"><table class="table"><thead><tr><th>ID</th><th>Incidencia</th><th>Campo</th><th>Valor</th><th>Motivo</th><th>Acción</th></tr></thead><tbody>
<?php foreach ($list as $c): ?>
<tr>
  <td>#<?= (int)$c['id_correccion'] ?></td>
  <td><a href="index.php?r=incidents.show&id=<?= (int)$c['id_incidencia'] ?>">#<?= (int)$c['id_incidencia'] ?></a></td>
  <td><?= htmlspecialchars($c['campo']) ?></td>
  <td><?= htmlspecialchars($c['valor_sugerido']) ?></td>
  <td><?= htmlspecialchars($c['motivo']) ?></td>
  <td class="flex">
    <form action="index.php?r=corrections.approve" method="post">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(\Core\CSRF::token()) ?>">
      <input type="hidden" name="id" value="<?= (int)$c['id_correccion'] ?>">
      <button class="btn">Aprobar</button>
    </form>
    <form action="index.php?r=corrections.reject" method="post">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(\Core\CSRF::token()) ?>">
      <input type="hidden" name="id" value="<?= (int)$c['id_correccion'] ?>">
      <button class="btn outline">Rechazar</button>
    </form>
  </td>
</tr>
<?php endforeach; if(empty($list)): ?><tr><td colspan="6">No hay correcciones</td></tr><?php endif; ?>
</tbody></table></div>
<?php include __DIR__ . '/../layout_footer.php'; ?>