<?php include __DIR__ . '/../layout_header.php'; ?>
<h1>Estadísticas (últimos 30 días)</h1>
<div class="card">
<canvas id="chart"></canvas>
</div>
<?php
$pdo = Core\DB::conn();
$data = $pdo->query("SELECT t.nombre AS label, COUNT(*) AS c
FROM incidencia_tipos it JOIN tipos_incidencia t ON t.id_tipo=it.id_tipo
JOIN incidencias i ON i.id_incidencia=it.id_incidencia
WHERE i.estado='aprobada' AND i.fecha_ocurrencia >= (NOW()-INTERVAL 30 DAY)
GROUP BY t.nombre ORDER BY c DESC")->fetchAll();
$labels = array_column($data,'label'); $counts = array_map('intval', array_column($data,'c'));
?>
<script>
const ctx = document.getElementById('chart').getContext('2d');
new Chart(ctx, { type:'bar', data:{ labels: <?= json_encode($labels) ?>, datasets:[{ label:'Incidencias', data: <?= json_encode($counts) ?> }] }, options:{ responsive:true } });
</script>
<?php include __DIR__ . '/../layout_footer.php'; ?>