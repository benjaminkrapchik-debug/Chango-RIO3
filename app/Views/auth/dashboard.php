
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi panel</title>
    <link rel="stylesheet"
          href="<?= base_url('assets/css/dashboard.css') ?>">
</head>
<body>

    <header class="barra">
        <a class="marca" href="<?= site_url('dashboard') ?>">
            Mi Sistema
        </a>

        <nav>
            <a href="<?= site_url('dashboard') ?>">Inicio</a>
            <a href="<?= site_url('productos') ?>">Productos</a>
            <a href="<?= site_url('logout') ?>"
               id="cerrarSesion">Cerrar sesión</a>
        </nav>
    </header>

    <main class="contenedor">
        <section class="bienvenida">
            <p class="etiqueta">PANEL PRINCIPAL</p>

            <h1>
                ¡Hola,
                <?= esc(session()->get('usuario_nombre') ?? 'Usuario') ?>!
            </h1>

            <p>Iniciaste sesión correctamente.</p>

            <div class="datos">
                <strong>Tu correo:</strong>
                <span>
                    <?= esc(session()->get('usuario_email') ?? '') ?>
                </span>
            </div>

            <div class="acciones">
                <a class="boton principal"
                   href="<?= site_url('productos') ?>">
                    Ver productos
                </a>

                <a class="boton secundario"
                   href="<?= site_url('logout') ?>"
                   id="salir">Cerrar sesión</a>
            </div>
        </section>

        <section class="tarjeta">
            <h2>Tu cuenta</h2>
            <p>Desde acá podés acceder a las funciones del sistema.</p>
            <ul>
                <li>Consultar productos.</li>
                <li>Administrar el inventario.</li>
                <li>Cerrar sesión de forma segura.</li>
            </ul>
        </section>
    </main>

    <footer>
        <p>Mi Sistema · Panel de usuario</p>
    </footer>

    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
</body>
</html>
