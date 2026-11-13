<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Supermercados - CHANGO RIO 3</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/supermercado.css') ?>">
</head>

<body>

<header class="barra-super">
    <a href="<?= site_url('/') ?>" class="marca">CHANGO RIO 3</a>

    <nav>
        <a href="<?= site_url('productos') ?>">Productos</a>
        <a href="<?= site_url('/') ?>">Inicio</a>

        <form action="<?= site_url('logout') ?>" method="post">
            <?= csrf_field() ?>
            <button type="submit">Cerrar sesión</button>
        </form>
    </nav>
</header>

<main class="pagina-super">

    <section class="portada-super">
        <span>🏪 COMERCIOS DE NUESTRA CIUDAD</span>
        <h1>Supermercados</h1>
        <p>
            Conocé los comercios disponibles en CHANGO RIO 3.
            Encontrá distintas opciones para tus compras y compará precios.
        </p>
    </section>

    <section class="seccion-comercios">

        <div class="titulo-comercios">
            <h2>Comercios disponibles</h2>
            <p>Conocé algunas de las opciones para realizar tus compras.</p>
        </div>

        <div class="grilla-super">

            <!-- VEA -->
            <a href="<?= site_url('productos/vea') ?>" class="tarjeta-supermercado">

                <div class="logo-supermercado">
                    <img src="<?= base_url('assets/img/vea.png') ?>" alt="Logo Vea">
                </div>

                <div class="contenido-tarjeta">
                    <small>CADENA DE SUPERMERCADOS</small>
                    <h2>Supermercado Vea</h2>

                    <p>
                        Una cadena de supermercados con distintas opciones
                        de productos para el hogar, alimentos y bebidas.
                    </p>

                    <div class="informacion">
                        <strong>📍 Ubicación</strong>
                        <span>Río Tercero, Córdoba</span>
                    </div>

                    <div class="informacion">
                        <strong>🛒 Productos</strong>
                        <span>Alimentos, bebidas y más.</span>
                    </div>

                    <div class="ver-productos">
                        Ver productos de Vea →
                    </div>
                </div>

            </a>

            <!-- LUCONI -->
            <a href="<?= site_url('productos/luconi') ?>" class="tarjeta-supermercado">

                <div class="logo-supermercado">
                    <img src="<?= base_url('assets/img/luconi.png') ?>" alt="Logo Luconi">
                </div>

                <div class="contenido-tarjeta">
                    <small>CADENA DE SUPERMERCADOS</small>
                    <h2>Luconi</h2>

                    <p>
                        Una propuesta comercial con productos de consumo
                        diario, artículos para el hogar y más.
                    </p>

                    <div class="informacion">
                        <strong>📍 Ubicación</strong>
                        <span>Río Tercero, Córdoba</span>
                    </div>

                    <div class="informacion">
                        <strong>🛒 Productos</strong>
                        <span>Almacén, bebidas, limpieza y más.</span>
                    </div>

                    <div class="ver-productos">
                        Ver productos de Luconi →
                    </div>
                </div>

            </a>

            <!-- CARACOL -->
            <a href="<?= site_url('productos/caracol') ?>" class="tarjeta-supermercado">

                <div class="logo-supermercado">
                    <img src="<?= base_url('assets/img/caracol.png') ?>" alt="Logo Caracol">
                </div>

                <div class="contenido-tarjeta">
                    <small>CADENA DE SUPERMERCADOS</small>
                    <h2>Caracol</h2>

                    <p>
                        Espacio destinado a los supermercados y comercios
                        de cercanía que forman parte de nuestra plataforma.
                    </p>

                    <div class="informacion">
                        <strong>📍 Ubicación</strong>
                        <span>Río Tercero, Córdoba</span>
                    </div>

                    <div class="informacion">
                        <strong>🛒 Productos</strong>
                        <span>Productos y ofertas del comercio adherido.</span>
                    </div>

                    <div class="ver-productos">
                        Ver productos de Caracol →
                    </div>
                </div>

            </a>

        </div>
    </section>

    <section class="mensaje-final-super">
        <h2>💙💛 Comprá mejor con CHANGO RIO 3</h2>

        <p>
            Nuestro objetivo es conectar a los vecinos con los comercios
            de la ciudad y facilitar la comparación de precios.
        </p>

        <span>📍 Río Tercero, Córdoba, Argentina</span>
    </section>

</main>

<footer class="footer-super">
    <p>2026 - CHANGO RIO 3 - Todos los derechos reservados.</p>
</footer>

</body>
</html>