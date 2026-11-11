
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comparador de precios</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/productos.css') ?>">
</head>

<body>

<header class="barra">
    <nav>
        <a href="<?= site_url('/') ?>" class="marca">Inicio</a>
        <a href="<?= base_url('productos') ?>" class="activo">Productos</a>
    </nav>

    <form action="<?= base_url('logout') ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit" class="cerrar">Cerrar sesión</button>
    </form>
</header>

<main class="contenido">

    <h1>Comparador de precios</h1>
    <p class="subtitulo">Consultá y compará los productos disponibles.</p>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <p class="aviso"><?= esc(session()->getFlashdata('mensaje')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <!-- BUSCADOR -->
    <form action="<?= base_url('productos') ?>" method="get" class="buscador">
        <input type="search" name="buscar"
               placeholder="Buscar producto..."
               value="<?= esc($buscar ?? '') ?>">
        <button type="submit" class="btn-buscar">Buscar</button>
    </form>

    <!-- AGREGAR PRODUCTOS -->
    <button type="button" class="btn-agregar"
        onclick="document.getElementById('formAgregar').classList.toggle('oculto')">
        ＋ Agregar productos
    </button>

    <section id="formAgregar" class="formulario oculto">
        <h2>Agregar nuevo producto</h2>

        <form action="<?= base_url('productos/guardar') ?>" method="post">
            <?= csrf_field() ?>

            <input type="text" name="nombre"
                   placeholder="Producto y marca" required>

            <input type="number" name="precio"
                   placeholder="Precio" min="1" required>

            <input type="number" name="stock"
                   placeholder="Stock" min="0" required>

            <button type="submit" class="btn-guardar">
                Guardar producto
            </button>
        </form>
    </section>

    <!-- CARRITO -->
    <section class="seccion-carrito">
        <h2>🛒 Mi carrito</h2>

        <?php if (!empty($carrito)): ?>
            <div class="lista-carrito">

                <?php foreach ($carrito as $item): ?>
                    <div class="producto-carrito">
                        <div>
                            <h3><?= esc($item['nombre']) ?></h3>
                            <p>Precio: $<?= number_format($item['precio'], 2, ',', '.') ?></p>
                            <p>Cantidad: <?= esc($item['cantidad']) ?></p>
                            <strong>
                                Subtotal:
                                $<?= number_format($item['precio'] * $item['cantidad'], 2, ',', '.') ?>
                            </strong>
                        </div>

                        <form action="<?= base_url('carrito/eliminar/' . $item['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn-eliminar-carrito">
                                Eliminar
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="total-carrito">
                <h2>TOTAL: $<?= number_format($totalCarrito, 2, ',', '.') ?></h2>

                <form action="<?= base_url('carrito/vaciar') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-vaciar">Vaciar carrito</button>
                </form>
            </div>

        <?php else: ?>
            <p class="carrito-vacio">Todavía no agregaste productos al carrito.</p>
        <?php endif; ?>
    </section>

    <!-- PRODUCTOS -->
    <h2 class="titulo">🛒 Productos disponibles</h2>

    <section class="grilla">

        <?php if (!empty($productos)): ?>

            <?php foreach ($productos as $producto): ?>

                <?php
                    $supermercado = $producto['supermercado'] ?? '';
                    $imagen = $producto['imagen'] ?? '';

                    $logo = '';

                    if (stripos($supermercado, 'vea') !== false) {
                        $logo = 'vea.png';
                    } elseif (stripos($supermercado, 'luconi') !== false) {
                        $logo = 'luconi.png';
                    } elseif (stripos($supermercado, 'caracol') !== false) {
                        $logo = 'caracol.png';
                    }
                ?>

                <article class="tarjeta">

                    <div class="foto">
                        <?php if (!empty($imagen)): ?>
                            <img src="<?= base_url('assets/images/productos/' . rawurlencode($imagen)) ?>"
                                 alt="<?= esc($producto['nombre']) ?>">
                        <?php else: ?>
                            <span>🛒</span>
                        <?php endif; ?>
                    </div>

                    <div class="datos">

                        <h3><?= esc($producto['nombre']) ?></h3>

                        <p class="precio">
                            $<?= number_format((float)$producto['precio'], 0, ',', '.') ?>
                        </p>

                        <p class="stock">
                            Stock: <?= esc($producto['stock']) ?>
                        </p>

                        <?php if (!empty($supermercado)): ?>
                            <div class="supermercado-producto">

                                <?php if (!empty($logo)): ?>
                                    <img src="<?= base_url('assets/images/' . $logo) ?>"
                                         alt="<?= esc($supermercado) ?>">
                                <?php endif; ?>

                                <span><?= esc($supermercado) ?></span>
                            </div>
                        <?php endif; ?>

                        <!-- ELIMINAR -->
                        <form action="<?= base_url('productos/eliminar/' . $producto['id']) ?>"
                              method="post"
                              onsubmit="return confirm('¿Seguro que querés eliminar este producto?')">

                            <?= csrf_field() ?>

                            <button type="submit" class="btn-eliminar">
                                🗑 Eliminar
                            </button>
                        </form>

                    </div>
                </article>

                <!-- AGREGAR AL CARRITO -->
                <form action="<?= base_url('carrito/agregar/' . $producto['id']) ?>"
                      method="post" class="form-carrito">

                    <?= csrf_field() ?>

                    <label>Cantidad:</label>

                    <input type="number" name="cantidad"
                           value="1" min="1" max="<?= esc($producto['stock']) ?>"
                           required>

                    <button type="submit" class="btn-carrito">
                        Agregar al carrito
                    </button>
                </form>

            <?php endforeach; ?>

        <?php else: ?>

            <p class="vacio">No hay productos para mostrar.</p>

        <?php endif; ?>

    </section>

</main>

<footer>
    2026 - Todos los derechos reservados.
</footer>

</body>
</html>
