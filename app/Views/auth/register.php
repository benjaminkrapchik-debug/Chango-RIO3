<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear cuenta</title>
</head>
<body>

    <h1>Crear cuenta</h1>

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

    <form action="<?= base_url('guardarRegistro') ?>" method="post">
        <?= csrf_field() ?>

        <label for="nombre">Nombre:</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            value="<?= esc(old('nombre') ?? '') ?>"
            autocomplete="name"
            required
        >

        <br><br>

        <label for="email">Email:</label>
        <input
            type="email"
            id="email"
            name="email"
            value="<?= esc(old('email') ?? '') ?>"
            autocomplete="email"
            required
        >

        <br><br>

        <label for="password">Contraseña:</label>
        <input
            type="password"
            id="password"
            name="password"
            autocomplete="new-password"
            minlength="8"
            required
        >

        <br><br>

        <button type="submit">Registrarme</button>
    </form>

    <p>
        ¿Ya tenés una cuenta?
        <a href="<?= base_url('login') ?>">Iniciar sesión</a>
    </p>

</body>
</html>