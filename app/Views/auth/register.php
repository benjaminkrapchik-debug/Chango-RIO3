
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear cuenta - Mi tienda</title>
    <link rel="stylesheet"
          href="<?= base_url('assets/css/productos.css') ?>">
</head>
<body>

<main class="contenedor">
    <h1>Crear cuenta</h1>
    <p class="subtitulo">Registrate para comparar precios.</p>

    <?php foreach (session()->getFlashdata('errores') ?? [] as $error): ?>
        <p class="aviso"><?= esc($error) ?></p>
    <?php endforeach; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="aviso">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>
    <?php endif; ?>

    <form class="formulario-producto"
          action="<?= site_url('guardarRegistro') ?>"
          method="post">

        <?= csrf_field() ?>

        <label for="nombre">Nombre completo</label>
        <input id="nombre" name="nombre" type="text"
               value="<?= esc(old('nombre') ?? '') ?>"
               required minlength="2" maxlength="100">

        <label for="email">Correo electrónico</label>
        <input id="email" name="email" type="email"
               value="<?= esc(old('email') ?? '') ?>"
               required maxlength="255">

        <label for="password">Contraseña</label>
        <input id="password" name="password" type="password"
               required minlength="8" maxlength="72">

        <button type="submit" class="btn-nuevo">
            Registrarme
        </button>

        <p>¿Ya tenés cuenta?
            <a href="<?= site_url('login') ?>">Ingresá acá</a>
        </p>

        <a href="<?= site_url('/') ?>" class="btn-secundario">
            Volver al menú principal
        </a>
    </form>
</main>

</body>
</html>
