<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= esc($titulo) ?> - CHANGO RIO 3</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .resultado {
            background: white;
            width: 90%;
            max-width: 450px;
            padding: 35px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 5px 25px #0002;
        }

        .icono {
            font-size: 75px;
        }

        h1 {
            color: #0033a0;
        }

        p {
            color: #555;
            line-height: 1.6;
        }

        a {
            display: inline-block;
            background: #0033a0;
            color: white;
            padding: 13px 25px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 15px;
        }
    </style>
</head>

<body>

<div class="resultado">

    <div class="icono">
        <?php if ($estado === 'aprobado'): ?>
            ✅
        <?php elseif ($estado === 'rechazado'): ?>
            ❌
        <?php else: ?>
            ⏳
        <?php endif; ?>
    </div>

    <h1><?= esc($titulo) ?></h1>

    <p><?= esc($mensaje) ?></p>

    <a href="<?= site_url('productos') ?>">
        Volver a CHANGO RIO 3
    </a>

    <br>

    <a href="<?= site_url('historial') ?>">
        Ver mi historial
    </a>

</div>

</body>
</html>