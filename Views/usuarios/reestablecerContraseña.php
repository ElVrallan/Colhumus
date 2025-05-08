<h2>Reestablecer contraseña</h2>
<form method="POST" action="?action=reestablecerContraseña">
    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

    <label>Nueva contraseña:</label>
    <input type="password" name="contraseña" required><br>

    <button type="submit">Reestablecer</button>
</form>

<p><a href="?action=login">Volver al inicio de sesión</a></p>
