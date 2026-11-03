
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comparador de precios</title>

    <link rel="stylesheet"
          href="<?= base_url('assets/css/producto.css') ?>">
</head>
<body>


   

<nav class="barra">
    <div>
        <a href="<?= base_url('/') ?>">Inicio</a>
        <a href="<?= base_url('productos') ?>">Productos</a>
    </div>

    <form action="<?= base_url('logout') ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit">Cerrar sesión</button>
    </form>
</nav>

<main class="contenedor">
    <header class="encabezado">
        <h1>Comparador de precios</h1>
        <p>Consultá los productos disponibles.</p>
    </header>

    <form class="filtros" action="<?= base_url('productos') ?>" method="get">
        <input
            type="search"
            name="buscar"
            placeholder="Buscar producto..."
            value="<?= esc($buscar ?? '') ?>"
        >
        <button class="boton boton-azul" type="submit">Buscar</button>
    </form>

    <?php if (!empty($productos)): ?>
        <section class="productos">
            <?php foreach ($productos as $producto): ?>
                <article class="producto">
                    <h3><?= esc($producto['nombre']) ?></h3>

                    <p>
                        <?= esc($producto['descripcion'] ?? 'Sin descripción') ?>
                    </p>

                    <div class="precio">
                        $<?= number_format((float) $producto['precio'], 2, ',', '.') ?>
                    </div>

                    <p class="stock">
                        Stock: <?= esc($producto['stock']) ?>
                    </p>
                </article>
            <?php endforeach; ?>
        </section>
    <?php else: ?>
        <div class="sin-productos">
            No hay productos para mostrar.
        </div>
    <?php endif; ?>
</main>
<footer class="footer">
        <p>2026 - Todos los derechos reservados.</p>
    </footer>
</body>
</html>
