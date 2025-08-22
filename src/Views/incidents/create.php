<?php include __DIR__ . '/../layout_header.php'; ?>
<h1>Reportar incidencia</h1>
<form action="index.php?r=incidents.store" method="post" enctype="multipart/form-data" class="card">
  <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">

  <div class="grid" style="grid-template-columns:1fr 1fr; gap:12px">
    <label>Título<input type="text" name="titulo" required maxlength="140"></label>
    <label>Fecha<input type="datetime-local" name="fecha" required></label>

    <label>Provincia
      <select name="provincia" id="provincia" required>
        <option value="">Selecciona una provincia</option>
        <?php foreach (($provincias ?? []) as $p): ?>
          <option value="<?= (int)$p['id_provincia'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <label>Municipio
      <select name="municipio" id="municipio" required disabled>
        <option value="">Selecciona un municipio</option>
      </select>
    </label>

    <label>Barrio (ID opcional)<input type="number" name="barrio" min="1" placeholder="Opcional"></label>

    <label>Latitud<input id="ilat" type="number" step="0.000001" name="lat" placeholder="Click en mini-mapa para autollenar"></label>
    <label>Longitud<input id="ilng" type="number" step="0.000001" name="lng" placeholder="Click en mini-mapa para autollenar"></label>

    <label>Muertos<input type="number" name="muertos" min="0" value="0"></label>
    <label>Heridos<input type="number" name="heridos" min="0" value="0"></label>

    <label>Pérdida estimada (RD$)<input type="number" name="perdida" min="0" step="0.01" value="0"></label>
    <label>Foto (jpg/png)<input type="file" name="foto" accept="image/*"></label>

    <label>Links a redes (separados por coma)
      <input type="text" name="links" placeholder="https://twitter.com/..., https://instagram.com/...">
    </label>
  </div>

  <label>Tipos (Ctrl+Click para múltiples)
    <select name="tipos[]" multiple size="4">
      <?php foreach (($tipos ?? []) as $t): ?>
        <option value="<?= (int)$t['id_tipo'] ?>"><?= htmlspecialchars($t['nombre']) ?></option>
      <?php endforeach; ?>
    </select>
  </label>

  <label>Descripción<textarea name="descripcion" rows="4" required></textarea></label>

  <div class="card mini"><div id="pickermap" style="height:100%"></div></div>

  <button class="btn" type="submit">Enviar (pendiente de validación)</button>
</form>

<p class="small">*Haz click en el mini-mapa para rellenar Lat/Lng automáticamente.</p>

<script>
  // Mini-mapa selector
  initPicker('ilat','ilng');

  // Cargar Municipios según Provincia
  const selProv = document.getElementById('provincia');
  const selMuni = document.getElementById('municipio');

  selProv.addEventListener('change', async () => {
    selMuni.innerHTML = '<option value="">Cargando...</option>';
    selMuni.disabled = true;
    const id = selProv.value;
    if(!id){ selMuni.innerHTML = '<option value="">Selecciona un municipio</option>'; return; }

    try{
      const resp = await fetch('index.php?r=api.municipios&provincia='+encodeURIComponent(id));
      const data = await resp.json();
      selMuni.innerHTML = '<option value="">Selecciona un municipio</option>';
      data.forEach(m => {
        const opt = document.createElement('option');
        opt.value = m.id_municipio;
        opt.textContent = m.nombre;
        selMuni.appendChild(opt);
      });
      selMuni.disabled = false;
    }catch(e){
      selMuni.innerHTML = '<option value="">Error cargando municipios</option>';
    }
  });
</script>
<?php include __DIR__ . '/../layout_footer.php'; ?>
