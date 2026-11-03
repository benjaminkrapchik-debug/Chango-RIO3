<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<div class="container mt-4">

    <h1>Editar producto</h1>

    <form
        action="<?= base_url('productos/actualizar/' . $producto['id']) ?>"
        method="post"
    >

        <div class="mb-3">
            <label>Nombre</label>

            <input
                type="text"
                name="nombre"
                class="form-control"
                value="<?= esc($producto['nombre']) ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label>Descripción</label>

            <textarea
                name="descripcion"
                class="form-control"
            ><?= esc($producto['descripcion']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Precio</label>

            <input
                type="number"
                step="0.01"
                name="precio"
                class="form-control"
                value="<?= esc($producto['precio']) ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label>Stock</label>

            <input
                type="number"
                name="stock"
                class="form-control"
                value="<?= esc($producto['stock']) ?>"
                required
            >
        </div>

        <button class="btn btn-success">
            Actualizar
        </button>

        <a href="<?= base_url('productos') ?>"
           class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>

</body>
</html>
