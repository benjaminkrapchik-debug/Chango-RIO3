<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link rel="stylesheet"
      href="<?= base_url('assets/css/login.css') ?>">
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

    <form action="<?= site_url('iniciarSesion') ?>" method="post">
        <?= csrf_field() ?>

        <div>
            <label for="email">Correo electrónico:</label>
            <input
                type="email"
                id="email"
                name="email"
                autocomplete="email"
                required
            >
        </div>

        <br>

        <div>
            <label for="password">Contraseña:</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >
        </div>

        <br>

        <button type="submit">Ingresar</button>
    </form>

    <p>
        ¿No tenés una cuenta?
        <a href="<?= site_url('register') ?>">Registrate acá</a>
    </p>

</body>
</html>