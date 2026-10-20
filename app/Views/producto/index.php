
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-white">

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Productos</h1>
        <a href="<?= base_url('productos/nuevo') ?>"
           class="btn btn-primary">Nuevo producto</a>
    </div>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('mensaje')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= esc($producto['id']) ?></td>
                            <td><?= esc($producto['nombre']) ?></td>
                            <td><?= esc($producto['descripcion'] ?? '') ?></td>
                            <td>$ <?= esc($producto['precio']) ?></td>
                            <td><?= esc($producto['stock']) ?></td>
                            <td>
                                <a href="<?= base_url('productos/editar/' . $producto['id']) ?>"
                                   class="btn btn-warning btn-sm">Editar</a>

                                <form action="<?= base_url('productos/eliminar/' . $producto['id']) ?>"
                                      method="post" class="d-inline"
                                      onsubmit="return confirm('¿Querés eliminar este producto?')">
                                    <?= csrf_field() ?>
                                    <button type="submit"
                                            class="btn btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            No hay productos cargados.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
        Volver a mi cuenta
    </a>
</div>

</body>
</html>
