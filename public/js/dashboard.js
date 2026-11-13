
document.addEventListener('DOMContentLoaded', function () {
    const enlacesSalir = [
        document.getElementById('cerrarSesion'),
        document.getElementById('salir')
    ];

    enlacesSalir.forEach(function (enlace) {
        if (!enlace) return;

        enlace.addEventListener('click', function (evento) {
            const confirmar = window.confirm(
                '¿Seguro que querés cerrar sesión?'
            );

            if (!confirmar) {
                evento.preventDefault();
            }
        });
    });
});
