const views = document.querySelectorAll(".view");
function show(v) {
  views.forEach((e) => e.classList.remove("active"));
  document.getElementById(v).classList.add("active");
  window.scrollTo({ top: 0, behavior: "smooth" });
}
document.querySelectorAll("[data-view]").forEach((b) => {
  b.addEventListener("click", (e) => {
    const id = e.currentTarget.getAttribute("data-view");
    show(id);
  });
});
document.querySelectorAll("a.goto").forEach((a) => {
  a.addEventListener("click", (e) => {
    e.preventDefault();
    const id = e.currentTarget.getAttribute("data-view");
    show(id);
  });
});
const formLogin = document.getElementById("formLogin");
const loginMsg = document.getElementById("loginMsg");
formLogin.addEventListener("submit", (e) => {
  e.preventDefault();
  const email = document.getElementById("emailLogin").value.trim();
  const pass = document.getElementById("passLogin").value.trim();
  if (!email || !pass || pass.length < 6) {
    loginMsg.textContent = "Verifica tu correo y contraseña (mín. 6).";
    loginMsg.style.color = "#ff9aa2";
    return;
  }
  loginMsg.textContent = "¡Bienvenido! (mock)";
  loginMsg.style.color = "#9cffc7";
  show("view-dashboard");
});
const formRegister = document.getElementById("formRegister");
const regMsg = document.getElementById("regMsg");
formRegister.addEventListener("submit", (e) => {
  e.preventDefault();
  const name = document.getElementById("nameReg").value.trim();
  const email = document.getElementById("emailReg").value.trim();
  const pass = document.getElementById("passReg").value.trim();
  if (name.length < 2 || !email || pass.length < 6) {
    regMsg.textContent =
      "Completa nombre, correo y contraseña válida (mín. 6).";
    regMsg.style.color = "#ff9aa2";
    return;
  }
  regMsg.textContent = "Cuenta creada (mock). Ahora inicia sesión.";
  regMsg.style.color = "#9cffc7";
  setTimeout(() => show("view-login"), 700);
});
const formReport = document.getElementById("formReport");
const reportMsg = document.getElementById("reportMsg");
formReport.addEventListener("submit", (e) => {
  e.preventDefault();
  const titulo = document.getElementById("titulo").value.trim();
  const fecha = document.getElementById("fecha").value;
  const tipo = document.getElementById("tipo").value;
  const descripcion = document.getElementById("descripcion").value.trim();
  if (titulo.length < 3 || !fecha || !tipo || descripcion.length < 10) {
    reportMsg.textContent =
      "Completa los campos obligatorios (título, fecha, tipo, descripción mínima).";
    reportMsg.style.color = "#ff9aa2";
    return;
  }
  reportMsg.textContent = "Incidencia guardada (mock).";
  reportMsg.style.color = "#9cffc7";
  addMockCard({ titulo, tipo, descripcion, fecha });
  setTimeout(() => show("view-list"), 500);
});
const cards = document.getElementById("cards");
function addMockCard({ titulo, tipo, descripcion, fecha }) {
  const el = document.createElement("div");
  el.className = "inc-card";
  el.innerHTML = `<h4>${titulo}</h4><div class='inc-meta'>${tipo} • ${new Date(
    fecha
  ).toLocaleString()}</div><p>${descripcion.slice(
    0,
    120
  )}...</p><button class='btn outline'>Ver detalle</button>`;
  el.querySelector("button").addEventListener("click", () =>
    openDialog(titulo, descripcion)
  );
  cards.prepend(el);
}
addMockCard({
  titulo: "Colisión vehicular múltiple",
  tipo: "Accidente",
  descripcion:
    "Choque entre 3 vehículos en la Av. Principal. Un carril cerrado, tránsito lento. Autoridades en el lugar.",
  fecha: new Date().toISOString(),
});
addMockCard({
  titulo: "Sismo leve reportado",
  tipo: "Desastre",
  descripcion:
    "Se percibe un sismo leve en la zona metropolitana. Sin daños reportados.",
  fecha: new Date(Date.now() - 3600 * 1000).toISOString(),
});
const dlg = document.getElementById("dlg");
const dlgTitle = document.getElementById("dlgTitle");
const dlgBody = document.getElementById("dlgBody");
document
  .getElementById("dlgClose")
  .addEventListener("click", () => dlg.close());
function openDialog(t, d) {
  dlgTitle.textContent = t;
  dlgBody.textContent = d;
  dlg.showModal();
}
