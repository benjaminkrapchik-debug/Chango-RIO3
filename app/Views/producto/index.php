
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comparador de precios</title>

    <link rel="stylesheet"
          href="<?= base_url('assets/css/productos.css') ?>">
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
        <p>Encontrá los mejores precios para tus compras.</p>
    </header>

    <form class="filtros" action="<?= base_url('productos') ?>" method="get">
        <input
            type="search"
            name="buscar"
            placeholder="Buscar productos..."
            value="<?= esc($buscar ?? '') ?>"
        >

        <button class="boton boton-azul" type="submit">
            Buscar
        </button>

        <select name="orden" onchange="this.form.submit()">
            <option value="nombre"
                <?= ($orden ?? '') === 'nombre' ? 'selected' : '' ?>>
                Nombre
            </option>
            <option value="precio_asc"
                <?= ($orden ?? '') === 'precio_asc' ? 'selected' : '' ?>>
                Menor precio
            </option>
            <option value="precio_desc"
                <?= ($orden ?? '') === 'precio_desc' ? 'selected' : '' ?>>
                Mayor precio
            </option>
        </select>
    </form>

    <a class="boton boton-verde"
       href="<?= base_url('productos/nuevo') ?>">
        + Agregar producto
    </a>

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
                        Stock disponible:
                        <?= esc($producto['stock']) ?>
                    </p>

                    <a class="boton boton-azul"
                       href="<?= base_url('productos/editar/' . $producto['id']) ?>">
                        Editar
                    </a>
                </article>
            <?php endforeach; ?>
        </section>

    <?php else: ?>

        <div class="sin-productos">
            No se encontraron productos. Revisá la búsqueda o agregá un producto.
        </div>

    <?php endif; ?>

</main>

</body>
</html>

