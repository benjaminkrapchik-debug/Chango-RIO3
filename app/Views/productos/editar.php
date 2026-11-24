
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar producto - CHANGO RIO 3</title>

    <link rel="stylesheet"
          href="<?= base_url('assets/css/productos.css') ?>">
</head>

<body>

<header class="navbar">
    <a href="<?= site_url('productos') ?>" class="marca">
        CHANGO RIO 3
    </a>

    <nav>
        <a href="<?= site_url('productos') ?>" class="btn btn-azul">
            Volver a productos
        </a>
    </nav>
</header>

<main class="contenido">

    <section class="formulario formulario-editar">

        <h1>Editar producto</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('productos/actualizar/' . $producto['id']) ?>"
              method="post">

            <?= csrf_field() ?>

            <label>Nombre del producto</label>
            <input type="text"
                   name="nombre"
                   value="<?= esc(old('nombre', $producto['nombre'])) ?>"
                   required>

            <label>Precio</label>
            <input type="number"
                   name="precio"
                   min="0.01"
                   step="0.01"
                   value="<?= esc(old('precio', $producto['precio'])) ?>"
                   required>

            <label>Stock</label>
            <input type="number"
                   name="stock"
                   min="0"
                   value="<?= esc(old('stock', $producto['stock'])) ?>"
                   required>

            <label>Supermercado</label>
            <select name="supermercado_id" required>
                <?php foreach ($supermercados as $super): ?>
                    <option value="<?= esc($super['id']) ?>"
                        <?= old('supermercado_id', $producto['supermercado_id']) == $super['id'] ? 'selected' : '' ?>>
                        <?= esc($super['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn-guardar-edicion">
                Guardar cambios
            </button>

            <a href="<?= site_url('productos') ?>"
               class="btn-cancelar">
                Cancelar
            </a>

        </form>

    </section>

</main>

<footer>
    CHANGO RIO 3 - Comparador de precios
</footer>

</body>
</html>
