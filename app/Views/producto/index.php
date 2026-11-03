<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comparador de precios</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/producto.css') ?>">
</head>
<body>

<header class="barra">
    <nav>
        <a href="<?= base_url('dashboard') ?>">Inicio</a>
        <a href="<?= base_url('productos') ?>" class="activo">Productos</a>
    </nav>

    <form action="<?= base_url('logout') ?>" method="post">
        <?= csrf_field() ?>
        <button class="cerrar">Cerrar sesión</button>
    </form>
</header>

<main class="contenido">
    <h1>Comparador de precios</h1>
    <p class="subtitulo">Consultá los productos disponibles.</p>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <p class="aviso"><?= esc(session()->getFlashdata('mensaje')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <form action="<?= base_url('productos') ?>" method="get" class="buscador">
        <input type="search" name="buscar"
               value="<?= esc($buscar ?? '') ?>"
               placeholder="Buscar producto...">
        <button class="btn-buscar">Buscar</button>
    </form>

    <button class="btn-agregar" type="button"
            onclick="document.getElementById('formAgregar').classList.toggle('oculto')">
        ＋ Agregar Productos
    </button>

    <section id="formAgregar" class="formulario oculto">
        <h2>Agregar producto</h2>

        <form action="<?= base_url('productos/guardar') ?>" method="post">
            <?= csrf_field() ?>

            <input type="text" name="nombre"
                   placeholder="Nombre del producto" required>

            <input type="number" name="precio"
                   placeholder="Precio" min="0.01" step="0.01" required>

            <input type="number" name="stock"
                   placeholder="Stock" min="0" required>

            <button class="btn-buscar" type="submit">
                Guardar producto
            </button>
        </form>
    </section>

    <h2 class="titulo">🛒 Productos disponibles</h2>

    <section class="grilla">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <article class="tarjeta">
                    <div class="foto">🛒</div>

                    <div class="datos">
                        <h3><?= esc($producto['nombre']) ?></h3>

                        <p class="precio">
                            $<?= number_format((float)$producto['precio'], 0, ',', '.') ?>
                        </p>

                        <p class="stock">
                            Stock: <?= esc($producto['stock']) ?>
                        </p>

                        <form action="<?= base_url('productos/eliminar/' . $producto['id']) ?>"
                              method="post"
                              onsubmit="return confirm('¿Eliminar este producto?')">
                            <?= csrf_field() ?>
                            <button class="btn-eliminar" type="submit">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="vacio">No hay productos para mostrar.</p>
        <?php endif; ?>
    </section>
</main>

<footer>2026 - Todos los derechos reservados.</footer>

</body>
</html>
