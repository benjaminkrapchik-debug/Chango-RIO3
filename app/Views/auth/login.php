<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
</head>
<body>

    <h1>Iniciar sesión</h1>

    <?php if ($error = session()->getFlashdata('error')): ?>
        <p style="color: red;">
            <?= esc($error) ?>
        </p>
    <?php endif; ?>

    <?php if ($errores = session()->getFlashdata('errores')): ?>
        <?php foreach ($errores as $error): ?>
            <p style="color: red;">
                <?= esc($error) ?>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="<?= base_url('iniciarSesion') ?>" method="post">
        <?= csrf_field() ?>

        <label for="email">Email:</label>
        <input
            type="email"
            id="email"
            name="email"
            autocomplete="email"
            required
        >

        <br><br>

        <label for="password">Contraseña:</label>
        <input
            type="password"
            id="password"
            name="password"
            autocomplete="current-password"
            required
        >

        <br><br>

        <button type="submit">Ingresar</button>
    </form>

    <p>
        ¿No tenés una cuenta?
        <a href="<?= base_url('register') ?>">Registrate</a>
    </p>

</body>
</html>