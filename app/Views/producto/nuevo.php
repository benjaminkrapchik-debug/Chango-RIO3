
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar producto</title>
    <link rel="stylesheet"
          href="<?= base_url('assets/css/productos.css') ?>">
</head>
<body>

<main class="contenedor">
    <h1>Agregar producto</h1>
    <p class="subtitulo">Completá los datos del producto.</p>

    <form class="formulario-producto"
          action="<?= site_url('productos/guardar') ?>"
          method="post">

        <?= csrf_field() ?>

        <?php foreach (session()->getFlashdata('errores') ?? [] as $error): ?>
            <p class="aviso"><?= esc($error) ?></p>
        <?php endforeach; ?>

        <label for="nombre">Nombre del producto</label>
        <input id="nombre" name="nombre" type="text"
               value="<?= esc(old('nombre') ?? '') ?>"
               required maxlength="150">

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion"
                  rows="3"><?= esc(old('descripcion') ?? '') ?></textarea>

        <label for="precio">Precio ($)</label>
        <input id="precio" name="precio" type="number"
               min="0" step="0.01"
               value="<?= esc(old('precio') ?? '') ?>" required>

        <label for="stock">Unidades disponibles</label>
        <input id="stock" name="stock" type="number"
               min="0" step="1"
               value="<?= esc(old('stock') ?? '') ?>" required>

        <button type="submit" class="btn-nuevo">
            Guardar producto
        </button>

        <a href="<?= site_url('productos') ?>"
           class="btn-secundario">Volver al listado</a>
    </form>
</main>

</body>
</html>
