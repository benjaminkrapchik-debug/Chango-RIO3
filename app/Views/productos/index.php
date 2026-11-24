
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comparador de precios - CHANGO RIO 3</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/productos.css') ?>">
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

            <a href="<?= site_url('/') ?>" class="btn btn-azul btn-grande">
                Inicio
            </a>

            <a href="<?= site_url('supermercados') ?>" class="btn btn-azul btn-grande">
                Supermercados
            </a>

            <a href="<?= site_url('historial') ?>" class="btn btn-azul btn-grande">
                Historial
            </a>

            <form action="<?= site_url('logout') ?>" method="post" class="form-logout">
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


<?php
$cantidadCarrito = 0;

if (!empty($carrito)) {
    foreach ($carrito as $item) {
        $cantidadCarrito += (int)$item['cantidad'];
    }
}
?>

<!-- BOTON FLOTANTE DEL CARRITO -->

<button type="button"
        class="boton-carrito-flotante"
        onclick="abrirCarrito()">

    🛒 Mi carrito

    <span class="contador-carrito">
        <?= $cantidadCarrito ?>
    </span>

</button>


<!-- VENTANA EMERGENTE DEL CARRITO -->

<div id="fondoCarrito" class="fondo-carrito">

    <section class="ventana-carrito">

        <button type="button"
                class="cerrar-carrito"
                onclick="cerrarCarrito()">
            ✕
        </button>

        <h2>🛒 Mi carrito</h2>

        <?php if (!empty($carrito)): ?>

            <?php foreach ($carrito as $item): ?>

                <div class="producto-carrito">

                    <div>
                        <h3><?= esc($item['nombre']) ?></h3>

                        <p>
                            Precio: $
                            <?= number_format($item['precio'], 0, ',', '.') ?>
                        </p>

                        <p>
                            Cantidad: <?= esc($item['cantidad']) ?>
                        </p>

                        <strong>
                            Subtotal: $
                            <?= number_format(
                                $item['precio'] * $item['cantidad'],
                                0, ',', '.'
                            ) ?>
                        </strong>
                    </div>

                    <form action="<?= base_url('carrito/eliminar/' . $item['id']) ?>"
                          method="post">

                        <?= csrf_field() ?>

                        <button type="submit" class="btn-eliminar-carrito">
                            Eliminar
                        </button>

                    </form>

                </div>

            <?php endforeach; ?>

            <div class="total-carrito">

                <h2>
                    TOTAL: $
                    <?= number_format($totalCarrito, 0, ',', '.') ?>
                </h2>

                <form action="<?= base_url('carrito/vaciar') ?>" method="post">
                    <?= csrf_field() ?>

                    <button type="submit" class="btn-vaciar">
                        Vaciar carrito
                    </button>
                </form>

                <form action="<?= site_url('carrito/finalizar') ?>" method="post">
                    <?= csrf_field() ?>

                    <button type="submit" class="btn-comprar">
                        Finalizar compra
                    </button>
                </form>

            </div>

        <?php else: ?>

            <p class="carrito-vacio">
                🛒 Todavía no agregaste productos al carrito.
            </p>

        <?php endif; ?>

    </section>

</div>


<main class="contenido">

    <h1>Comparador de precios</h1>

    <p class="subtitulo">
        Consultá y compará los productos disponibles.
    </p>


    <?php if (session()->getFlashdata('mensaje')): ?>
        <p class="aviso">
            <?= esc(session()->getFlashdata('mensaje')) ?>
        </p>
    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>
        <p class="error">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>
    <?php endif; ?>


    <!-- BUSCADOR -->

    <form action="<?= base_url('productos') ?>" method="get" class="buscador">

        <input type="search"
               name="buscar"
               placeholder="Buscar producto..."
               value="<?= esc($buscar ?? '') ?>">

        <button type="submit" class="btn-buscar">
            Buscar
        </button>

    </form>


    <!-- BOTON AGREGAR -->

    <button type="button"
            class="btn-agregar"
            onclick="document.getElementById('formAgregar').classList.toggle('oculto')">

        + Agregar productos

    </button>


    <!-- FORMULARIO PARA AGREGAR PRODUCTOS -->

    <section id="formAgregar" class="formulario oculto">

        <h2>Agregar nuevo producto</h2>

        <form action="<?= base_url('productos/guardar') ?>"
              method="post"
              enctype="multipart/form-data">

            <?= csrf_field() ?>

            <input type="text"
                   name="nombre"
                   placeholder="Producto y marca"
                   required>

            <input type="number"
                   name="precio"
                   placeholder="Precio"
                   min="1"
                   required>

            <input type="number"
                   name="stock"
                   placeholder="Stock"
                   min="0"
                   required>

            <select name="supermercado_id" required>
                <option value="">Seleccionar supermercado</option>

                <?php foreach ($supermercados as $super): ?>
                    <option value="<?= esc($super['id']) ?>">
                        <?= esc($super['nombre']) ?>
                    </option>
                <?php endforeach; ?>

            </select>

            <label>Imagen del producto:</label>

            <input type="file"
                   name="imagen"
                   accept="image/jpeg,image/png,image/webp">

            <button type="submit" class="btn-guardar">
                Guardar producto
            </button>

        </form>

    </section>


    <!-- PRODUCTOS DISPONIBLES -->

    <h2 class="titulo">Productos disponibles</h2>

    <section class="grilla">

        <?php if (!empty($productos)): ?>

            <?php foreach ($productos as $producto): ?>

                <?php
                $imagenesFijas = [
                    2  => 'images16.jfif',
                    3  => '02-leche.png',
                    4  => '03-arroz.png',
                    6  => '04-yerba.png',
                    7  => '05-oreo.png',
                    8  => '06-chocolinas.png',
                    9  => '07-fideos.png',
                    10 => '08-aceite.png',
                    11 => '09-harina.png',
                    12 => '10-agua.png',
                    13 => '11-jabon.png',
                    14 => '12-carne.png',
                    15 => '13-detergente.png',
                    16 => '14-lavandina.png',
                    17 => '15-papel.png',
                    18 => '16-cafe.png',
                    19 => '17-dulce.png',
                    20 => '18-fernet.png',
                    21 => '19-vino.png',
                    22 => '20-whisky.png',
                ];

                $archivoImagen = $imagenesFijas[$producto['id']] ?? null;
                ?>

                <article class="tarjeta">

                    <!-- IMAGEN -->

                    <div class="foto">

                        <?php if ($archivoImagen): ?>

                            <img
                                src="<?= base_url('uploads/productos/' . $archivoImagen) ?>"
                                class="imagen-producto"
                                alt="<?= esc($producto['nombre']) ?>"
                            >

                        <?php else: ?>

                            <span>🛒</span>

                        <?php endif; ?>

                    </div>


                    <!-- INFORMACION -->

                    <div class="datos">

                        <h3>
                            <?= esc($producto['nombre']) ?>
                        </h3>

                        <p class="precio">
                            $<?= number_format(
                                (float)$producto['precio'],
                                0, ',', '.'
                            ) ?>
                        </p>

                        <p class="stock">
                            Stock: <?= esc($producto['stock']) ?>
                        </p>

                        <?php if (!empty($producto['supermercado'])): ?>

                            <p class="supermercado-producto">
                                <?= esc($producto['supermercado']) ?>
                            </p>

                        <?php endif; ?>


                        <!-- ELIMINAR PRODUCTO -->

                        <form action="<?= base_url('productos/eliminar/' . $producto['id']) ?>"
                              method="post"
                              onsubmit="return confirm('¿Querés eliminar este producto?')">

                            <?= csrf_field() ?>

                            <button type="submit" class="btn-eliminar">
                                Eliminar
                            </button>

                        </form>


                        <!-- AGREGAR AL CARRITO -->

                        <form action="<?= base_url('carrito/agregar/' . $producto['id']) ?>"
                              method="post"
                              class="form-carrito">

                            <?= csrf_field() ?>

                            <label>Cantidad:</label>

                            <input type="number"
                                   name="cantidad"
                                   value="1"
                                   min="1"
                                   max="<?= esc($producto['stock']) ?>"
                                   required>

                            <button type="submit" class="btn-carrito">
                                Agregar al carrito
                            </button>

                        </form>

                    </div>

                </article>

            <?php endforeach; ?>

        <?php else: ?>

            <p class="vacio">
                No hay productos para mostrar.
            </p>

        <?php endif; ?>

    </section>

</main>


<footer>
    2026 - Todos los derechos reservados.
</footer>


<!-- JAVASCRIPT -->

<script>

function abrirCarrito() {
    document.getElementById('fondoCarrito').classList.add('activo');
}

function cerrarCarrito() {
    document.getElementById('fondoCarrito').classList.remove('activo');
}

// Cerrar tocando fuera de la ventana
document.getElementById('fondoCarrito').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarCarrito();
    }
});

// Cerrar con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarCarrito();
    }
});

</script>

</body>
</html>
