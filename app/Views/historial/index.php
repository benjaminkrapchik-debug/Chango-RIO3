
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mi historial - CHANGO RIO 3</title>

    <link rel="stylesheet"
          href="<?= base_url('css/historial.css?v=6') ?>">
</head>

<body>

<header class="barra">
    <nav>
        <h2>CHANGO RIO 3</h2>

        <div class="menu">
            <span>Hola, <?= esc(session()->get('usuario_nombre')) ?></span>

            <a href="<?= site_url('productos') ?>">Productos</a>
            <a href="<?= site_url('supermercados') ?>">Supermercados</a>
            <a href="<?= site_url('/') ?>">Inicio</a>

            <form action="<?= site_url('logout') ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="cerrar">Cerrar sesión</button>
            </form>
        </div>
    </nav>
</header>

<main class="contenedor-historial">

    <h1>📋 Mi historial</h1>

    <p class="descripcion">
        Consultá todas tus compras realizadas dentro de CHANGO RIO 3.
    </p>

    <?php if (!empty($compras)): ?>

        <?php foreach ($compras as $compra): ?>

            <div class="compra">

                <h2>🛒 Compra #<?= esc($compra['id']) ?></h2>

                <p class="fecha">
                    Fecha: <?= esc($compra['fecha']) ?>
                </p>

                <h3>Productos comprados</h3>

                <?php foreach ($compra['productos'] as $producto): ?>

                    <div class="producto-historial">

                        <strong>
                            <?= esc($producto['nombre_producto']) ?>
                        </strong>

                        <span>
                            Precio: $
                            <?= number_format($producto['precio'], 2, ',', '.') ?>
                        </span>

                        <span>
                            Cantidad: <?= esc($producto['cantidad']) ?>
                        </span>

                        <span>
                            Subtotal: $
                            <?= number_format($producto['subtotal'], 2, ',', '.') ?>
                        </span>

                    </div>

                <?php endforeach; ?>

                <div class="total">
                    TOTAL: $
                    <?= number_format($compra['total'], 2, ',', '.') ?>
                </div>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <div class="vacio">
            <h2>🕒 Todavía no tenés compras</h2>
            <p>Cuando realices compras aparecerán acá.</p>
        </div>

    <?php endif; ?>

    <a href="<?= site_url('productos') ?>" class="volver">
        Volver a productos
    </a>

</main>

<footer>
    <p>2026 - Todos los derechos reservados.</p>
</footer>

</body>
</html>
