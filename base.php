<!--Este lo mantengo ya que es la base de las paginas-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raíces</title>
    <link rel="stylesheet" href="build/css/app.css">
</head>
<body>
    <header class="header">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="build/img/logo.svg" alt="Logo de Bienes Raíces">
                </a>
                
                <div class="mobile-menu"> <!--Para el menu responsive-->
                    <img src="build/img/barras.svg" alt="Icono Menu Responsive">
                </div>
                <div class="derecha">
                    <img class="dark-mode-boton" src="build/img/dark-mode.svg" alt="Icono dark-mode">
                    <nav class="navegacion">
                        <a href="nosotros.php">Nosotros</a>
                        <a href="anuncios.php">Anuncios</a>
                        <a href="blog.php">Blog</a>
                        <a href="contacto.php">Contacto</a>
                    </nav> <!-- Tenemos que agregar todo esto a las otras paginas .php
                                esto con PHP se facilita mucho, si no tuvieramos PHP hay que copiar
                                este mismo codigo en todas las paginas, con PHP esto lo podemos hacer
                                en una sola linea de codigo. Ahora ponemos todo en las paginas luego veremos
                                como hacerlo con PHP -->
                </div>
            </div> <!--.barra-->

            <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
        </div> <!--.contenedor header-->
    </header>

    <main class="contenedor">
        <h1>
            Base por si queremos agregar otras paginas en el futuro, para tener un template base
        </h1>
    </main>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="nosotros.php">Nosotros</a>
                <a href="anuncios.php">Anuncios</a>
                <a href="blog.php">Blog</a>
                <a href="contacto.php">Contacto</a>
            </nav>
        </div>

        <p class="copyright">Todos los derechos reservados 2024 &copy;</p>
    </footer>
    <script src="build/js/bundle.min.js"></script>
</body>
</html>