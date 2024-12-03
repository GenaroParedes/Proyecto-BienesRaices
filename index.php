<!-- Incluimos el header desde el archivo header.php, por lo tanto ahora 
 no duplicamos nada de codigo ya que lo tenemos en un solo lugar -->
<?php 
    require 'includes/funciones.php'; 
    /*Empezamos a mejorar nuestro codigo, en vez de llamar a include 'includes/templates/header.php'; 
    lo vamos a llamar desde la funcion incluirTemplate, asi nos queda mejor organizado nuestro codigo
    Como en la funcion incluirTemplate tenemos $inicio = false, si no le pasamos nada por parametro,
    esto nos permite que si no le pasamos nada por parametro, la variable $inicio sea false, y no se aplique la clase inicio*/
    incluirTemplate('header', $inicio = true);
?>

    <main class="contenedor seccion">
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
    </main>

    <section class="seccion contenedor">
        <h2>Casas y Depas en venta</h2>
        <div class="contenedor-anuncios">
            <div class="anuncio">
                <picture>
                    <source srcset="build/img/anuncio1.webp" type="image/webp">
                    <source srcset="build/img/anuncio1.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/anuncio1.jpg" alt="Anuncio">
                </picture>

                <div class="contenido-anuncio">
                    <h3>Casa de Lujo en el Lago</h3>
                    <p>Casa en el lago con excelente vista, acabados de lujo a un excelente precio</p>
                    <p class="precio">$3,000,000</p>

                    <ul class="iconos-caracteristicas">
                        <li>
                            <img class="icono" src="build/img/icono_wc.svg" alt="icono wc">
                            <p>3</p>
                        </li>
                        <li>
                            <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                            <p>3</p>
                        </li>
                        <li>
                            <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                            <p>4</p>
                        </li>
                    </ul>

                    <a href="anuncios.php" class="boton-naranja-block">Ver Propiedad</a>
                </div> <!--.contenido-anuncio-->
            </div> <!--.anuncio-->
            <div class="anuncio">
                <picture>
                    <source srcset="build/img/anuncio2.webp" type="image/webp">
                    <source srcset="build/img/anuncio2.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/anuncio2.jpg" alt="Anuncio">
                </picture>

                <div class="contenido-anuncio">
                    <h3>Casa terminados de lujo</h3>
                    <p>Casa con diseño moderno, asi como tecnologia inteligente y amueblada</p>
                    <p class="precio">$2,000,000</p>

                    <ul class="iconos-caracteristicas">
                        <li>
                            <img class="icono" src="build/img/icono_wc.svg" alt="icono wc">
                            <p>3</p>
                        </li>
                        <li>
                            <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                            <p>3</p>
                        </li>
                        <li>
                            <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                            <p>4</p>
                        </li>
                    </ul>

                    <a href="anuncios.php" class="boton-naranja-block">Ver Propiedad</a>
                </div> <!--.contenido-anuncio-->
            </div> <!--.anuncio-->
            <div class="anuncio">
                <picture>
                    <source srcset="build/img/anuncio3.webp" type="image/webp">
                    <source srcset="build/img/anuncio3.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/anuncio3.jpg" alt="Anuncio">
                </picture>

                <div class="contenido-anuncio">
                    <h3>Casa con alberca</h3>
                    <p>Casa con alberca y acabados de lujo en la ciudad, excelente oportunidad</p>
                    <p class="precio">$3,000,000</p>

                    <ul class="iconos-caracteristicas">
                        <li>
                            <img class="icono" src="build/img/icono_wc.svg" alt="icono wc">
                            <p>3</p>
                        </li>
                        <li>
                            <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                            <p>3</p>
                        </li>
                        <li>
                            <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                            <p>4</p>
                        </li>
                    </ul>

                    <a href="anuncios.php" class="boton-naranja-block">Ver Propiedad</a>
                </div> <!--.contenido-anuncio-->
            </div> <!--.anuncio-->
        </div> <!--.contenedor-anuncios-->

        <div class="centrar-btn">
            <a href="anuncios.php" class="boton-verde">Ver Todas</a>
        </div>
    </section>

    <section class="imagen-contacto">
        <h2>Encuentra la casa de tus sueños</h2>
        <p>Llena el formulario de contacto y un asesor se pondrá en contacto contigo a la brevedad</p>
        <a href="contacto.php" class="boton-naranja">Contactános</a>
    </section>

    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
            <h3>Nuestro Blog</h3>

            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog1.webp" type="image/webp">
                        <source srcset="build/img/blog1.jpg" type="image/jpeg">
                        <img loading="lazy" src="build/img/blog1.jpg" alt="Texto Entrada Blog">
                    </picture>
                </div>
                <div class="texto-entrada">
                    <a href="entrada.php">
                        <h4>Terraza en el techo de tu casa</h4>
                        <p class="informacion-meta">Escrito el: <span>28/11/2024</span> - por: <span>Admin</span></p>
                        <p>Consejos para construir una terraza en el techo de tu casa con los mejores materiales y ahorrando dinero</p>
                    </a>
                </div>
            </article>
            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog2.webp" type="image/webp">
                        <source srcset="build/img/blog2.jpg" type="image/jpeg">
                        <img loading="lazy" src="build/img/blog2.jpg" alt="Texto Entrada Blog">
                    </picture>
                </div>
                <div class="texto-entrada">
                    <a href="entrada.php">
                        <h4>Guía para la decoración de tu hogar</h4>
                        <p class="informacion-meta">Escrito el: <span>28/11/2024</span> - por: <span>Admin</span></p>
                        <p>Maximiza el espacio en tu hogar con esta guía, aprende a combinar muebles y colores para darle vida a tu espacio</p>
                    </a>
                </div>
            </article>
        </section>

        <section class="testimoniales">
            <h2>Testimoniales</h2>
            <div class="testimonial">
                <blockquote>
                    El personal se comportó de una excelente forma, muy buena atención y la casa que me ofrecieron cumple con todas mis expectativas.
                </blockquote>
                <p>- Genaro Paredes</p>
            </div>
        </section>
    </div>

    <?php //No hace falta volver a llamar a require 'includes/funciones.php'; ya que lo hicimos al principio del archivo
    incluirTemplate('footer');
    ?>
