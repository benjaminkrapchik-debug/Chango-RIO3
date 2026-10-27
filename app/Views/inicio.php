<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi tienda</title>

    <link rel="stylesheet"
          href="<?= base_url('assets/css/inicio.css') ?>">
</head>
<body>

    <header class="navbar">
        <a href="<?= site_url('/') ?>" class="marca">Mi tienda</a>

        <nav>
            <?php if (session()->get('usuario_id')): ?>

                <span class="saludo">
                    Hola, <?= esc(session()->get('usuario_nombre')) ?>
                </span>

                <a href="<?= site_url('productos') ?>"
                   class="btn btn-azul">
                    Ver productos
                </a>

                <form action="<?= site_url('logout') ?>"
                      method="post" class="form-logout">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-borde">
                        Cerrar sesión
                    </button>
                </form>

            <?php else: ?>

                <a href="<?= site_url('login') ?>"
                   class="btn btn-borde">Ingresar</a>

                <a href="<?= site_url('registro') ?>"
                   class="btn btn-azul">Registrarse</a>

            <?php endif; ?>
        </nav>
        <nav>
    <?php if (session()->get('logueado')): ?>

        <span>
            Hola, <?= esc(session()->get('usuario_nombre')) ?>
        </span>

        <a href="<?= site_url('productos') ?>">Productos</a>

        <form action="<?= site_url('logout') ?>"
              method="post"
              style="display:inline">
            <?= csrf_field() ?>
            <button type="submit">Cerrar sesión</button>
        </form>

    <?php else: ?>

        <a href="<?= site_url('login') ?>">Ingresar</a>
        <a href="<?= site_url('registro') ?>">Registrarse</a>

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