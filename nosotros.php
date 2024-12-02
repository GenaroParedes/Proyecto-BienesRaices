<!-- Incluimos el header desde el archivo header.php, por lo tanto ahora 
 no duplicamos nada de codigo ya que lo tenemos en un solo lugar -->
<?php include 'includes/templates/header.php'; ?>

    <main class="contenedor">
        <h1>Conoce sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="Imagen sobre Nosotros">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>25 años de experiencia</blockquote>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex eos asperiores odio eum delectus quisquam minima iste, earum eius officia deserunt tempora praesentium laboriosam! Earum praesentium cum voluptatibus repudiandae similique sit nesciunt. Minima expedita doloribus similique culpa doloremque debitis corrupti sunt in ullam. Aspernatur facilis consectetur dolore ad a. Non dignissimos asperiores praesentium unde nisi, ad aspernatur rem odio temporibus, cum excepturi, quaerat laborum sit nihil ipsam illo? Voluptatum, fuga.</p>
                
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Inventore officia ducimus ab voluptates accusantium consequatur dolores harum sint provident vero, et praesentium, rerum sit necessitatibus quisquam labore illum, a quos!</p>
            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más sobre nosotros</h1>
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono de Precio" loading="lazy"> <!--loading="lazy" para que cargue la imagen cuando se necesite-->
                <h3>Seguridad</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto nulla tempore corporis laboriosam maxime repudiandae! Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono de Precio" loading="lazy"> <!--loading="lazy" para que cargue la imagen cuando se necesite-->
                <h3>Precio</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto nulla tempore corporis laboriosam maxime repudiandae! Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono de Tiempo" loading="lazy"> <!--loading="lazy" para que cargue la imagen cuando se necesite-->
                <h3>Tiempo</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto nulla tempore corporis laboriosam maxime repudiandae! Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                </p>
            </div>
        </div>
    </section>

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