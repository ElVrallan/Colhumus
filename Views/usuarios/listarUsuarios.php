<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de usuarios</title>
    <link rel="stylesheet" href="./Assets/Css/listaU.css">
</head>
<body>
<?php include './Views/Includes/navbar.php'; ?>
<div style="height: 70px;"></div>
<?php if (!isset($usuarios)) die('No hay datos de usuarios.'); ?>
<h2>Listado de usuarios</h2>
<?php if (empty($usuarios)): ?>
    <div style="color: red; margin: 20px 0;">No hay usuarios registrados en el sistema.</div>
<?php else: ?>
<table border="1" cellpadding="8" style="border-collapse:collapse;width:100%;margin-bottom:30px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre de usuario</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($usuarios as $usuario): ?>
        <?php if (strtolower($usuario['nombre_usuario']) === 'admin') continue; ?>
        <tr>
            <td><?= htmlspecialchars($usuario['id']) ?></td>
            <td><?= htmlspecialchars($usuario['nombre_usuario']) ?></td>
            <td><?= htmlspecialchars($usuario['correo']) ?></td>
            <td>
                <?= $usuario['bloqueado'] ? '<span style="color:red;">Bloqueado</span>' : '<span style="color:green;">Activo</span>' ?>
            </td>
            <td>
                <?php if ($usuario['bloqueado']): ?>
                    <button class="accion-button"
                        style="padding:4px 10px; background:#218838;"
                        onclick="desbloquearUsuarioAjax(<?= (int)$usuario['id'] ?>, this)">
                        Desbloquear
                    </button>
                <?php else: ?>
                    <button class="accion-button"
                        style="padding:4px 10px; background:#d9534f;"
                        onclick="bloquearUsuarioAjax(<?= (int)$usuario['id'] ?>, this)">
                        Bloquear
                    </button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function bloquearUsuarioAjax(usuarioId, btn) {
    Swal.fire({
        title: '¿quieres realizar esta accion ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Denegar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('index.php?action=bloquearUsuario', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: new URLSearchParams({ usuario_id: usuarioId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Listo', 'El usuario ha sido bloqueado.', 'success');
                    // Opcional: Actualiza el estado en la tabla sin recargar
                    btn.textContent = 'Desbloquear';
                    btn.style.background = '#007bff';
                    btn.onclick = function() { desbloquearUsuarioAjax(usuarioId, btn); };
                    btn.closest('tr').querySelector('td:nth-child(4)').innerHTML = '<span style="color:red;">Bloqueado</span>';
                } else {
                    Swal.fire('Error', data.message || 'No se pudo bloquear.', 'error');
                }
            });
        }
    });
}

function desbloquearUsuarioAjax(usuarioId, btn) {
    Swal.fire({
        title: '¿quieres realizar esta accion ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Denegar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('index.php?action=desbloquearUsuario', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: new URLSearchParams({ usuario_id: usuarioId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Listo', 'El usuario ha sido desbloqueado.', 'success');
                    // Opcional: Actualiza el estado en la tabla sin recargar
                    btn.textContent = 'Bloquear';
                    btn.style.background = '#d9534f';
                    btn.onclick = function() { bloquearUsuarioAjax(usuarioId, btn); };
                    btn.closest('tr').querySelector('td:nth-child(4)').innerHTML = '<span style="color:green;">Activo</span>';
                } else {
                    Swal.fire('Error', data.message || 'No se pudo desbloquear.', 'error');
                }
            });
        }
    });
}
</script>
</body>
</html>
