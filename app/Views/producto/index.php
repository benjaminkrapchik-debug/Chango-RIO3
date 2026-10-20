
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>

    <h1>Lista de productos</h1>

    <?php if (empty($productos)): ?>
        <p>No hay productos cargados.</p>
    <?php else: ?>
        <?php foreach ($productos as $producto): ?>
            <div>
                <h3><?= esc($producto['nombre']) ?></h3>
                <p>Precio: $<?= esc($producto['precio']) ?></p>
                <p>Stock: <?= esc($producto['stock']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>
