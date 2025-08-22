<?php include __DIR__ . '/../layout_header.php'; ?>
<h1>Catálogos</h1>
<div class="grid" style="grid-template-columns:1fr 1fr; gap:16px">
  <div class="card"><h3>Provincias</h3>
    <form action="index.php?r=super.catalogs.add" method="post" class="flex">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>"><input type="hidden" name="t" value="prov">
      <input type="text" name="nombre" placeholder="Nueva provincia"><button class="btn">Agregar</button>
    </form>
    <ul><?php foreach($provincias as $p): ?><li class="flex" style="justify-content:space-between">
      <?= htmlspecialchars($p['nombre']) ?>
      <form action="index.php?r=super.catalogs.del" method="post"><input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>"><input type="hidden" name="t" value="prov"><input type="hidden" name="id" value="<?= (int)$p['id_provincia'] ?>"><button class="btn outline">Eliminar</button></form>
    </li><?php endforeach; ?></ul>
  </div>
  <div class="card"><h3>Tipos de Incidencia</h3>
    <form action="index.php?r=super.catalogs.add" method="post" class="flex">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>"><input type="hidden" name="t" value="tipo">
      <input type="text" name="nombre" placeholder="Nuevo tipo"><button class="btn">Agregar</button>
    </form>
    <ul><?php foreach($tipos as $t): ?><li class="flex" style="justify-content:space-between">
      <?= htmlspecialchars($t['nombre']) ?>
      <form action="index.php?r=super.catalogs.del" method="post"><input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>"><input type="hidden" name="t" value="tipo"><input type="hidden" name="id" value="<?= (int)$t['id_tipo'] ?>"><button class="btn outline">Eliminar</button></form>
    </li><?php endforeach; ?></ul>
  </div>
  <div class="card"><h3>Municipios</h3>
    <form action="index.php?r=super.catalogs.add" method="post" class="flex">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>"><input type="hidden" name="t" value="muni">
      <input type="number" name="id_provincia" placeholder="ID provincia" style="max-width:140px"><input type="text" name="nombre" placeholder="Nuevo municipio"><button class="btn">Agregar</button>
    </form>
    <ul><?php foreach($municipios as $m): ?><li><?= htmlspecialchars($m['provincia'].' / '.$m['nombre']) ?>
      <form action="index.php?r=super.catalogs.del" method="post" style="display:inline"><input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>"><input type="hidden" name="t" value="muni"><input type="hidden" name="id" value="<?= (int)$m['id_municipio'] ?>"><button class="btn outline">Eliminar</button></form>
    </li><?php endforeach; ?></ul>
  </div>
  <div class="card"><h3>Barrios</h3>
    <form action="index.php?r=super.catalogs.add" method="post" class="flex">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>"><input type="hidden" name="t" value="barr">
      <input type="number" name="id_municipio" placeholder="ID municipio" style="max-width:160px"><input type="text" name="nombre" placeholder="Nuevo barrio"><button class="btn">Agregar</button>
    </form>
    <ul><?php foreach($barrios as $b): ?><li><?= htmlspecialchars($b['municipio'].' / '.$b['nombre']) ?>
      <form action="index.php?r=super.catalogs.del" method="post" style="display:inline"><input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>"><input type="hidden" name="t" value="barr"><input type="hidden" name="id" value="<?= (int)$b['id_barrio'] ?>"><button class="btn outline">Eliminar</button></form>
    </li><?php endforeach; ?></ul>
  </div>
</div>
<?php include __DIR__ . '/../layout_footer.php'; ?>