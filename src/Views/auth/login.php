<?php include __DIR__ . '/../layout_header.php'; ?>
<h1>/super – Iniciar sesión</h1>
<?php if (!empty($_GET['err'])): ?><div class="card" style="border-color:#c33;color:#fbb">Credenciales inválidas</div><?php endif; ?>
<div class="card">
  <form action="index.php?r=auth.doLogin" method="post">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
    <label>Correo<input type="email" name="email" value="<?= htmlspecialchars(env('SUPER_USER','admin@demo.com')) ?>"></label>
    <label>Contraseña<input type="password" name="password" value="<?= htmlspecialchars(env('SUPER_PASS','demo123')) ?>"></label>
    <button class="btn">Entrar</button>
  </form>
</div>
<?php include __DIR__ . '/../layout_footer.php'; ?>