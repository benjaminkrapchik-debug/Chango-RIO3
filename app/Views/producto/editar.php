
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Editar producto</h1>

    <?php if (session()->getFlashdata('errores')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errores') as $error): ?>
                <p><?= esc($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('productos/actualizar/' . $producto['id']) ?>"
          method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control"
                   value="<?= esc(old('nombre') ?? $producto['nombre']) ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control"><?= esc(old('descripcion') ?? $producto['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" name="precio" class="form-control"
                   min="0" step="0.01"
                   value="<?= esc(old('precio') ?? $producto['precio']) ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control"
                   min="0" step="1"
                   value="<?= esc(old('stock') ?? $producto['stock']) ?>"
                   required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="<?= base_url('productos') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
