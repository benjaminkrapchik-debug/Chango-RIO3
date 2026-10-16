
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
            supermercados
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
        
<section class="seccion">
    <h2>🔥 Ofertas destacadas</h2>
    <p class="subtitulo">
        Ofertas de ejemplo para tu comparador.
        Actualizá los precios con los de tus supermercados.
    </p>

    <div class="rejilla">
        <article class="producto-card">
            <img
                src="https://images.unsplash.com/photo-1563636619-e9143da7973b?auto=format&fit=crop&w=600&q=80"
                alt="Botella de leche">

            <div class="producto-info">
                <span class="oferta">OFERTA</span>
                <h3>Leche</h3>
                <p>Supermercado A</p>
                <p class="precio-anterior">$1.800</p>
                <p class="precio">$1.500</p>
            </div>
        </article>

        <article class="producto-card">
            <img
                src="https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=600&q=80"
                alt="Paquete de arroz">

            <div class="producto-info">
                <span class="oferta">OFERTA</span>
                <h3>Arroz</h3>
                <p>Supermercado B</p>
                <p class="precio-anterior">$2.000</p>
                <p class="precio">$1.650</p>
            </div>
        </article>

        <article class="producto-card">
            <img
                src="https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?auto=format&fit=crop&w=600&q=80"
                alt="Aceite de cocina">

            <div class="producto-info">
                <span class="oferta">OFERTA</span>
                <h3>Aceite</h3>
                <p>Supermercado C</p>
                <p class="precio-anterior">$3.500</p>
                <p class="precio">$2.900</p>
            </div>
        </article>
    </div>
</section>

<section class="seccion">
    <div class="titulo-fila">
        <div>
            <h2>🛒 Todos los productos</h2>
            <p class="subtitulo">
                Productos cargados en tu base de datos.
            </p>
        </div>

        <a class="boton-productos"
           href="<?= site_url('productos') ?>">
            Ver todos
        </a>
    </div>

    <div class="rejilla">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <article class="producto-card">
                    <div class="producto-info">
                        <span class="etiqueta-stock">
                            <?= (int) ($producto['stock'] ?? 0) ?> en stock
                        </span>

                        <h3>
                            <?= esc($producto['nombre'] ?? 'Producto') ?>
                        </h3>

                        <p>
                            <?= esc($producto['descripcion'] ?? '') ?>
                        </p>

                        <p class="precio">
                            $<?= number_format(
                                (float) ($producto['precio'] ?? 0),
                                2,
                                ',',
                                '.'
                            ) ?>
                        </p>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="vacio">
                Todavía no hay productos cargados.
                Entrá a Productos para comenzar.
            </p>
        <?php endif; ?>
    </div>
</section>

<section class="seccion">
    <h2>🏪 Nuestros supermercados</h2>
    <p class="subtitulo">
        Explorá las tiendas que participan en el comparador.
    </p>

    <div class="rejilla">
        <article class="supermercado-card">
            <img
                src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=700&q=80"
                alt="Frutas y verduras de supermercado">
            <div class="producto-info">
                <h3>Supermercado A</h3>
                <p>Productos y promociones</p>
                <a href="<?= site_url('productos') ?>">
                    Ver productos →
                </a>
            </div>
        </article>

        <article class="supermercado-card">
            <img
                src="https://images.unsplash.com/photo-1604719312566-8912e9c8a213?auto=format&fit=crop&w=700&q=80"
                alt="Pasillo de supermercado">
            <div class="producto-info">
                <h3>Supermercado B</h3>
                <p>Compará sus precios</p>
                <a href="<?= site_url('productos') ?>">
                    Ver productos →
                </a>
            </div>
        </article>

        <article class="supermercado-card">
            <img
                src="https://images.unsplash.com/photo-1601599561213-832382fd07ba?auto=format&fit=crop&w=700&q=80"
                alt="Compras de alimentos">
            <div class="producto-info">
                <h3>Supermercado C</h3>
                <p>Descubrí otras opciones</p>
                <a href="<?= site_url('productos') ?>">
                    Ver productos →
                </a>
            </div>
        </article>
    </div>
</section>

    </main>

    <footer>
        <p>Mi Sistema · Panel de usuario</p>
    </footer>

    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
</body>
</html>
