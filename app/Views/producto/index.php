
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comparador de precios</title>

    <link rel="stylesheet"
          href="<?= base_url('assets/css/productos.css') ?>?v=2">
</head>
<body>

<header class="cabecera">
    <a href="<?= site_url('/') ?>" class="logo">🐭</a>
    <div class="menu-derecha">
        <a href="<?= site_url('/') ?>" class="btn-secundario">Inicio</a>
        <a href="#carrito" class="btn-carrito">
            🛒 Carrito (<span id="contador">0</span>)
        </a>

        <?php if (session()->get('logueado')): ?>
            <form action="<?= site_url('logout') ?>" method="post">
                <?= csrf_field() ?>
                <button class="btn-secundario" type="submit">
                    Cerrar sesión
                </button>
            </form>
        <?php endif; ?>
    </div>
</header>

<main class="contenedor">
    <h1>Comparador de precios</h1>
    <p class="subtitulo">
        Encontrá los mejores precios para tus compras.
    </p>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <p class="aviso">
            <?= esc(session()->getFlashdata('mensaje')) ?>
        </p>
    <?php endif; ?>

    <form action="<?= site_url('productos') ?>"
          method="get" class="buscador">
        <input type="search" name="buscar"
               placeholder="Buscar productos..."
               value="<?= esc($buscar ?? '') ?>">
        <button type="submit">⌕</button>
    </form>

    <div class="herramientas">
        <form action="<?= site_url('productos') ?>" method="get">
            <input type="hidden" name="buscar"
                   value="<?= esc($buscar ?? '') ?>">

            <label for="orden">Ordenar por:</label>
            <select name="orden" id="orden"
                    onchange="this.form.submit()">
                <option value="nombre"
                    <?= ($orden ?? '') === 'nombre' ? 'selected' : '' ?>>
                    Nombre
                </option>
                <option value="precio"
                    <?= ($orden ?? '') === 'precio' ? 'selected' : '' ?>>
                    Precio más bajo
                </option>
                <option value="precio_desc"
                    <?= ($orden ?? '') === 'precio_desc' ? 'selected' : '' ?>>
                    Precio más alto
                </option>
                <option value="stock"
                    <?= ($orden ?? '') === 'stock' ? 'selected' : '' ?>>
                    Mayor stock
                </option>
            </select>
        </form>

        <a href="<?= site_url('productos/nuevo') ?>"
           class="btn-nuevo">+ Agregar producto</a>
    </div>

    <section class="lista-productos">
        <?php if (empty($productos)): ?>
            <p class="sin-productos">
                No se encontraron productos.
            </p>
        <?php else: ?>
            <?php foreach ($productos as $producto): ?>
                <article class="producto">
                    <div class="foto-producto">🛍️</div>

                    <div class="datos-producto">
                        <h2><?= esc($producto['nombre']) ?></h2>

                        <?php if (!empty($producto['descripcion'])): ?>
                            <p class="descripcion">
                                <?= esc($producto['descripcion']) ?>
                            </p>
                        <?php endif; ?>

                        <p class="precio">
                            $<?= number_format(
                                (float) $producto['precio'],
                                2, ',', '.'
                            ) ?>
                        </p>

                        <p class="stock">
                            Stock: <?= (int) $producto['stock'] ?>
                        </p>
                    </div>

                    <div class="acciones">
                        <button type="button"
                                class="btn-agregar"
                                <?= (int) $producto['stock'] <= 0
                                    ? 'disabled' : '' ?>
                                onclick="agregarAlCarrito(
                                    <?= (int) $producto['id'] ?>,
                                    '<?= esc($producto['nombre'], 'js') ?>'
                                )">+</button>

                        <a class="btn-editar"
                           href="<?= site_url(
                               'productos/editar/' . $producto['id']
                           ) ?>">Editar</a>

                        <form method="post"
                              action="<?= site_url(
                                  'productos/eliminar/' . $producto['id']
                              ) ?>"
                              onsubmit="return confirm(
                                  '¿Querés eliminar este producto?'
                              )">
                            <?= csrf_field() ?>
                            <button type="submit"
                                    class="btn-eliminar">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <section class="carrito" id="carrito">
        <h2>Mi carrito</h2>
        <ul id="lista-carrito"></ul>
        <button type="button" onclick="vaciarCarrito()">
            Vaciar carrito
        </button>
    </section>
</main>

<script>
const carrito = {};

function agregarAlCarrito(id, nombre) {
    if (!carrito[id]) {
        carrito[id] = { nombre: nombre, cantidad: 0 };
    }

    carrito[id].cantidad++;
    mostrarCarrito();
}

function mostrarCarrito() {
    const lista = document.getElementById('lista-carrito');
    lista.replaceChildren();

    let cantidad = 0;

    Object.values(carrito).forEach(producto => {
        cantidad += producto.cantidad;

        const item = document.createElement('li');
        item.textContent =
            producto.nombre + ' x ' + producto.cantidad;

        lista.appendChild(item);
    });

    document.getElementById('contador').textContent = cantidad;
}

function vaciarCarrito() {
    Object.keys(carrito).forEach(id => delete carrito[id]);
    mostrarCarrito();
}
</script>

</body>
</html>
