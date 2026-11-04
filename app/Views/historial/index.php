<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($titulo) ?></title>

    <link rel="stylesheet" href="<?= base_url('assets/css/inicio.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/historial.css') ?>">
</head>

<body>

<header class="navbar">
    <a href="<?= site_url('/') ?>" class="marca">
        CHANGO RIO 3
    </a>

    <nav class="menu-derecha">
        <span class="saludo">
            Hola, <?= esc(session()->get('usuario_nombre')) ?>
        </span>

        <a href="<?= site_url('productos') ?>" class="btn btn-azul">Productos</a>
        <a href="<?= site_url('supermercados') ?>" class="btn btn-azul">Supermercados</a>
        <a href="<?= site_url('/') ?>" class="btn btn-azul">Inicio</a>

        <form action="<?= site_url('logout') ?>" method="post">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-eliminar">
                Cerrar sesión
            </button>
        </form>
    </nav>
</header>

<main class="contenedor-historial">

    <div class="encabezado-historial">
        <h1>📋 Mi historial</h1>
        <p>Consultá todas tus actividades dentro de CHANGO RIO 3.</p>
    </div>

    <?php if (!empty($historial)): ?>

        <div class="tabla-historial">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Actividad</th>
                            <th>Detalles</th>
                            <th>Fecha y hora</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($historial as $registro): ?>
                            <tr>
                                <td>
                                    <strong><?= esc($registro['actividad']) ?></strong>
                                </td>

                                <td>
                                    <?= esc($registro['detalles'] ?? 'Sin detalles') ?>
                                </td>

                                <td>
                                    <?= esc(date(
                                        'd/m/Y H:i',
                                        strtotime($registro['fecha_hora'])
                                    )) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>

        <div class="historial-vacio">
            <h2>🕒 Todavía no tenés actividades</h2>
            <p>Cuando realices actividades en CHANGO RIO 3, aparecerán acá.</p>
        </div>

    <?php endif; ?>

    <a href="<?= site_url('productos') ?>" class="volver">
        Volver a productos
    </a>

</main>

<footer class="footer">
    <p>2026 - Todos los derechos reservados.</p>
</footer>

</body>
</html>