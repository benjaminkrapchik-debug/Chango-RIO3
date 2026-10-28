<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CHANGO RIO 3</title>

    <link rel="stylesheet"
          href="<?= base_url('assets/css/inicio.css') ?>">
</head>
<body>

    <header class="navbar">
        <a href="<?= site_url('/') ?>" class="marca">CHANGO RIO 3</a>

      
<nav class="menu-derecha">
    <?php if (session()->get('logueado')): ?>

        <span class="saludo">
            Hola, <?= esc(session()->get('usuario_nombre')) ?>
        </span>

        <a href="<?= site_url('productos') ?>"
           class="btn-secundario">
            Productos
        </a>

        <form action="<?= site_url('logout') ?>" method="post">
            <?= csrf_field() ?>
            <button type="submit" class="btn-cerrar">
                Cerrar sesión
            </button>
        </form>

    <?php else: ?>

        <a href="<?= site_url('login') ?>"
           class="btn-secundario">
            Ingresar
        </a>

        <a href="<?= site_url('registro') ?>"
           class="btn-nuevo">
            Registrarse
        </a>

    <?php endif; ?>
</nav>

    </header>

    <main class="principal">
        <h1>Bienvenido a la plataforma</h1>

        <?php if (session()->get('usuario_id')): ?>

            <p>Iniciaste sesión correctamente.</p>
            <p>Ya podés consultar y comparar los precios de los productos.</p>

            <a href="<?= site_url('productos') ?>"
               class="btn btn-azul btn-grande">
                Ir al comparador de precios
            </a>

        <?php else: ?>

            <p>
                Iniciá sesión o registrate desde el menú superior
                para comenzar.
            </p>

        <?php endif; ?>

        <?php if (session()->getFlashdata('mensaje')): ?>
            <p class="mensaje">
                <?= esc(session()->getFlashdata('mensaje')) ?>
            </p>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="error">
                <?= esc(session()->getFlashdata('error')) ?>
            </p>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <p>2026 - Todos los derechos reservados.</p>
    </footer>

</body>
</html>