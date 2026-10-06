<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
</head>

<body>

    <h1>Iniciar sesión</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p>
            <?= session()->getFlashdata('error') ?>
        </p>
    <?php endif; ?>

    <form action="<?= base_url('iniciarSesion') ?>" method="post">

        <label>Email:</label>
        <input type="email" name="email" required>

        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <br><br>

        <button type="submit">Ingresar</button>

    </form>

    <p>
        ¿No tenés una cuenta?
        <a href="<?= base_url('register') ?>">Registrate</a>
    </p>
    <!-- VENTANA MODAL DE INICIO DE SESIÓN -->
<div id="modal-login" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
  <div style="background: white; padding: 30px; border-radius: 8px; width: 320px; box-shadow: 0px 4px 10px rgba(0,0,0,0.3); position: relative;">
    
    <h3 style="margin-top: 0; margin-bottom: 20px; color: #333;">Iniciar Sesión</h3>
    
    <form id="form-login" onsubmit="procesarLogin(event)">
      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Usuario o Correo:</label>
        <input type="text" id="login-username" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
      </div>
      
      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Contraseña:</label>
        <input type="password" id="login-password" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
      </div>
      
      <div style="display: flex; justify-content: space-between;">
        <button type="button" onclick="cerrarModal()" style="background: #ccc; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">Cancelar</button>
        <button type="submit" style="background: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">Entrar</button>
      </div>
    </form>
    
  </div>
</div>

</body>
</html>
    <p>
        ¿Ya tenés una cuenta????
        <a href="<?= base_url('login') ?>">Iniciar sesión</a>
    </p>


</body>
</html>