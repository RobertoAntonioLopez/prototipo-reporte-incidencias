function coloredIcon(kind){
  const colors={accidente:'#ef4444',robo:'#f59e0b',desastre:'#8b5cf6',pelea:'#10b981','default':'#60a5fa'};
  const c = colors[(kind||'').toLowerCase()] || colors['default'];
  const svg = encodeURIComponent(`<svg xmlns='http://www.w3.org/2000/svg' width='30' height='42' viewBox='0 0 30 42'>
  <defs><filter id='a' x='-50%' y='-50%' width='200%' height='200%'><feGaussianBlur in='SourceAlpha' stdDeviation='2'/><feOffset dy='2'/><feMerge><feMergeNode/><feMergeNode in='SourceGraphic'/></feMerge></filter></defs>
  <path filter='url(#a)' d='M15 0C6.7 0 0 6.7 0 15c0 11.25 15 27 15 27s15-15.75 15-27C30 6.7 23.3 0 15 0z' fill='${c}'/>
  <circle cx='15' cy='15' r='6' fill='white'/></svg>`);
  return L.icon({iconUrl:`data:image/svg+xml,${svg}`, iconSize:[30,42], iconAnchor:[15,42], popupAnchor:[0,-36]});
}

function initMap(markers){
  const map=L.map('map').setView([18.4861,-69.9312],11);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'&copy; OpenStreetMap'}).addTo(map);
  const group = L.markerClusterGroup();
  (markers||[]).forEach(m=>{
    if(!m.lat||!m.lng) return;
    const icon=coloredIcon(m.tipo_nombre);
    const mk=L.marker([m.lat,m.lng],{icon}).on('click',()=>openIncModal(m)).bindTooltip(m.titulo);
    group.addLayer(mk);
  });
  map.addLayer(group);
  setTimeout(()=>{ map.invalidateSize(); }, 250); // 👈 asegura render
}

function openIncModal(m){
  const el=document.getElementById('modal'); if(!el) return;
  el.style.display='flex';
  el.querySelector('.title').textContent=m.titulo;
  el.querySelector('.desc').textContent=m.descripcion||'';
  el.querySelector('.meta').textContent=`${(m.tipo_nombre||'Tipo no especificado')} · ${m.fecha_ocurrencia||''}`;
  const link=el.querySelector('.ver'); if(link) link.href=`index.php?r=incidents.show&id=${m.id_incidencia}`;
}
function closeModal(){ const el=document.getElementById('modal'); if(el) el.style.display='none'; }

function initPicker(latInputId, lngInputId){
  const latEl=document.getElementById(latInputId), lngEl=document.getElementById(lngInputId);
  const map=L.map('pickermap').setView([18.4861,-69.9312],11);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);
  let marker=null;
  map.on('click', e=>{
    const {lat,lng}=e.latlng;
    if(latEl) latEl.value=lat.toFixed(6);
    if(lngEl) lngEl.value=lng.toFixed(6);
    if(marker) marker.setLatLng([lat,lng]); else marker=L.marker([lat,lng]).addTo(map);
  });
  setTimeout(()=>{ map.invalidateSize(); }, 250);
}
