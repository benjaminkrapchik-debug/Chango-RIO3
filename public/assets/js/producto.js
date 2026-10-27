
document.addEventListener("DOMContentLoaded", function () {
    // Diseño general
    document.body.style.margin = "0";
    document.body.style.minHeight = "100vh";
    document.body.style.fontFamily = "Courier New, monospace";
    document.body.style.color = "white";
    document.body.style.background =
        "linear-gradient(135deg, #39258d, #25284d, #172b38)";

    // Contenido principal
    const contenedor = document.querySelector(".contenedor");

    if (contenedor) {
        contenedor.style.width = "min(620px, 94%)";
        contenedor.style.margin = "35px auto";
    }

    // Título
    const titulo = document.querySelector("h1");

    if (titulo) {
        titulo.style.textAlign = "center";
        titulo.style.fontSize = "29px";
    }

    // Subtítulo
    const subtitulo = document.querySelector(".subtitulo");

    if (subtitulo) {
        subtitulo.style.textAlign = "center";
        subtitulo.style.color = "#deddf4";
    }

    // Tarjetas de productos
    document.querySelectorAll(".producto").forEach(function (producto) {
        producto.style.display = "flex";
        producto.style.alignItems = "center";
        producto.style.gap = "15px";
        producto.style.padding = "18px";
        producto.style.marginBottom = "15px";
        producto.style.borderRadius = "15px";
        producto.style.background = "white";
        producto.style.color = "#292943";
        producto.style.boxShadow = "0 5px 18px #00000020";
    });

    // Botones rosas
    document.querySelectorAll(
        ".btn-carrito, .btn-nuevo, .btn-agregar, .btn-cerrar"
    ).forEach(function (boton) {
        boton.style.background = "#f34463";
        boton.style.color = "white";
        boton.style.border = "none";
        boton.style.borderRadius = "8px";
        boton.style.padding = "11px 15px";
        boton.style.cursor = "pointer";
        boton.style.textDecoration = "none";
    });

    // Precio azul
    document.querySelectorAll(".precio").forEach(function (precio) {
        precio.style.color = "#0868b9";
        precio.style.fontSize = "19px";
        precio.style.fontWeight = "bold";
    });

    // Nombre del producto rosa
    document.querySelectorAll(".datos-producto h2").forEach(function (nombre) {
        nombre.style.color = "#f34463";
        nombre.style.fontSize = "14px";
    });

    // Buscador
    document.querySelectorAll(".buscador").forEach(function (buscador) {
        buscador.style.display = "flex";
        buscador.style.height = "49px";
        buscador.style.overflow = "hidden";
        buscador.style.background = "white";
        buscador.style.borderRadius = "13px";
        buscador.style.margin = "25px 0";
    });

    document.querySelectorAll(".buscador input").forEach(function (input) {
        input.style.flex = "1";
        input.style.minWidth = "0";
        input.style.padding = "12px";
        input.style.border = "none";
        input.style.fontSize = "15px";
    });
});
