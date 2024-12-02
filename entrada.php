<!-- Incluimos el header desde el archivo header.php, por lo tanto ahora 
 no duplicamos nada de codigo ya que lo tenemos en un solo lugar -->
<?php include 'includes/templates/header.php'; ?>

    <main class="contenedor contenido-centrado">
        <h1>Guía para la decoracion de tu hogar</h1>

        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada2.jpg" alt="Imagen de la propiedad">
        </picture>

        <p class="informacion-meta">Escrito el: <span>28/11/2024</span> - por: <span>Admin</span></p>

        <div class="resumen-propiedad">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur sapiente doloremque optio consequuntur vitae ut dolores enim dolorem voluptates maxime aliquid quidem esse laudantium saepe quod veritatis sint, magni quae alias velit cumque? Doloremque eius aspernatur repudiandae hic repellendus iusto, sed atque temporibus nemo harum saepe tempora officia odio laboriosam fuga consequatur quasi, beatae magnam? Esse culpa praesentium repellendus ex id excepturi a hic, illum, beatae vitae accusantium, aliquam libero.</p>

            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam ea, esse exercitationem expedita qui impedit deserunt dolor quas, similique officia ratione maxime quia eos vero consequatur repellat rerum non ullam.</p>
        </div>
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