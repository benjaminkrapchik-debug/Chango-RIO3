<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi cuenta</title>
</head>
<body>

    <h1>¡Bienvenido/a, <?= esc(session()->get('usuario_nombre')) ?>!</h1>

    <p>Iniciaste sesión correctamente.</p>

    <p>
        Tu correo es:
        <?= esc(session()->get('usuario_email')) ?>
    </p>

    <form action="<?= base_url('logout') ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit">Cerrar sesión</button>
    </form>

</body>
</html>