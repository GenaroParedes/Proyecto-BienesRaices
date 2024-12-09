<?php 
    //Importar la conexion
    require 'includes/config/database.php'; //Esta llamada se hace desde el index.php, por ese motivo pasamos la 
                                            //ruta relativa desde esa pagina hacia la database.php.
                                            //Osea, estos anuncios estan en la pagina principal, por eso se hace la llamada desde el index.php  
    //Sino la otra forma de hacerlo seria:
    //require __DIR__ . '../config/database.php'; //Esta llamada se hace desde el anuncios.php, por ese motivo pasamos la 
                                                //ruta relativa desde esa pagina hacia la database.php.
    $db = conectarDB();
    //Consulta
    $query = "SELECT * FROM propiedades LIMIT $limite";
    //Obtener los resultados
    $resultado = mysqli_query($db, $query);
?>

<div class="contenedor-anuncios"> <!-- Iterar para traer cada anuncio -->
    <?php while($propiedad =mysqli_fetch_assoc($resultado)) { ?>
        <div class="anuncio">
            <img loading="lazy" src="imagenes/<?php echo $propiedad['imagen']; ?>" alt="Anuncio">
            

            <div class="contenido-anuncio">
                <h3><?php echo $propiedad['titulo']; ?></h3>
                <p><?php echo $propiedad['descripcion']; ?></p>
                <p class="precio"><?php echo $propiedad['precio']; ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" src="build/img/icono_wc.svg" alt="icono wc">
                        <p><?php echo $propiedad['wc']; ?></p>
                    </li>
                    <li>
                        <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                        <p><?php echo $propiedad['estacionamiento']; ?></p>
                    </li>
                    <li>
                        <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                        <p><?php echo $propiedad['habitaciones']; ?></p>
                    </li>
                </ul>

                <a href="anuncio.php?id=<?php echo $propiedad['id'] ?>" class="boton-naranja-block">Ver Propiedad</a>
            </div> <!--.contenido-anuncio-->
        </div> <!--.anuncio-->
    <?php } ?>
</div> <!--.contenedor-anuncios-->

<!-- Cerrar la conexion -->
 <?php
    mysqli_close($db);
 ?>