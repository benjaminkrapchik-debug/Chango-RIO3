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

    <a href="<?= site_url('dashboard') ?>" class="marca">
        CHANGO RIO 3
    </a>

    <nav class="menu-derecha">

        <?php if (session()->get('logueado')): ?>

            <span class="saludo">
                Hola, <?= esc(session()->get('usuario_nombre')) ?>
            </span>

            <a href="<?= site_url('productos') ?>"
               class="btn btn-azul btn-grande">
                Productos
            </a>

            <a href="<?= site_url('supermercados') ?>"
               class="btn btn-azul btn-grande">
                Supermercados
            </a>

            <a href="<?= site_url('historial') ?>"
               class="btn btn-azul btn-grande">
                Historial
            </a>

            <form action="<?= site_url('logout') ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-eliminar btn-grande">
                    Cerrar sesión
                </button>
            </form>

        <?php else: ?>

            <a href="<?= site_url('login') ?>" class="btn btn-azul">
                Ingresar
            </a>

            <a href="<?= site_url('registro') ?>" class="btn btn-azul">
                Registrarse
            </a>

        <?php endif; ?>

    </nav>

</header>

<section class="presentacion">

    <div class="portada-presentacion">

        <div class="texto-portada">
            <span class="etiqueta">🛒 TU COMERCIO, MÁS CERCA</span>

            <h1>Bienvenidos a <span>CHANGO RIO 3</span></h1>

            <p>
                Una nueva forma de comprar mejor, comparar precios
                y encontrar las mejores oportunidades en Río Tercero.
            </p>

            <div class="frase-portada">
                ¡Comprá inteligente, compará y ahorrá!
            </div>
        </div>

        <div class="imagen-portada">
            <div class="circulo-imagen">
                🛍️
            </div>
            <span class="decoracion decoracion-uno">🥑</span>
            <span class="decoracion decoracion-dos">🥛</span>
            <span class="decoracion decoracion-tres">🍎</span>
        </div>

    </div>

    <div class="contenido-presentacion">

        <div class="titulo-seccion">
            <span>¿QUIÉNES SOMOS?</span>
            <h2>Conocé nuestra plataforma</h2>
        </div>

        <p class="texto-presentacion">
            CHANGO RIO 3 es una plataforma pensada para los vecinos
            de Río Tercero. Nuestro propósito es facilitar las compras
            cotidianas mediante la consulta y comparación de productos,
            precios y promociones de diferentes supermercados.
        </p>

        <p class="texto-presentacion">
            Queremos que cada persona pueda encontrar mejores opciones,
            organizar sus compras y aprovechar su dinero de la mejor
            manera. Todo desde un mismo lugar, de forma sencilla y rápida.
        </p>

    </div>

    <div class="objetivos-presentacion">

        <div class="tarjeta-objetivo">
            <div class="icono-objetivo">💰</div>
            <h3>Ahorrá dinero</h3>
            <p>Encontrá precios convenientes y aprovechá promociones.</p>
        </div>

        <div class="tarjeta-objetivo">
            <div class="icono-objetivo">🔎</div>
            <h3>Compará precios</h3>
            <p>Consultá diferentes opciones antes de elegir dónde comprar.</p>
        </div>

        <div class="tarjeta-objetivo">
            <div class="icono-objetivo">🛒</div>
            <h3>Comprá mejor</h3>
            <p>Organizá tus compras y encontrá todo en un mismo lugar.</p>
        </div>

    </div>

    <div class="ubicacion-presentacion">

        <div class="icono-ubicacion">📍</div>

        <div>
            <span>NUESTRA UBICACIÓN</span>
            <h2>Río Tercero, Córdoba</h2>
            <p>
                CHANGO RIO 3 está pensado para los vecinos de Río Tercero
                y su comunidad, conectando a los consumidores con los
                comercios de la ciudad.
            </p>
        </div>

        <div class="bandera-ubicacion">🇦🇷</div>

    </div>

</section>
</main>

<footer class="footer">
    <p>2026 - Todos los derechos reservados.</p>
</footer>

</body>
</html>