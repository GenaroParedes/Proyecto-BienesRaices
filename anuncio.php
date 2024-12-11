<!-- Incluimos el header desde el archivo header.php, por lo tanto ahora 
 no duplicamos nada de codigo ya que lo tenemos en un solo lugar -->
<?php 
    require 'includes/app.php'; 
    incluirTemplate('header');

    $db = conectarDB();

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if (!$id) {
        header('Location: /');
    }

    //Consultar para obtener los datos de la propiedad
    $query = "SELECT * FROM propiedades WHERE id = $id";
    $resultado = mysqli_query($db, $query);
    if ($resultado->num_rows === 0){ //Si el id no existe, no devuelve ninguna fila, por lo tanto redirigimos al index.
        header('Location: /');
    }


    $propiedad = mysqli_fetch_assoc($resultado);
?>

    <main class="contenedor contenido-centrado">
        <h1><?php echo $propiedad['titulo'] ?></h1>
        <img loading="lazy" src="imagenes/<?php echo $propiedad['imagen'] ?>" alt="Imagen de la propiedad">

        <div class="resumen-propiedad">
            <p class="precio"><?php echo $propiedad['precio'] ?></p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc'] ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['estacionamiento'] ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                    <p><?php echo $propiedad['habitaciones'] ?></p>
                </li>
            </ul>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur sapiente doloremque optio consequuntur vitae ut dolores enim dolorem voluptates maxime aliquid quidem esse laudantium saepe quod veritatis sint, magni quae alias velit cumque? Doloremque eius aspernatur repudiandae hic repellendus iusto, sed atque temporibus nemo harum saepe tempora officia odio laboriosam fuga consequatur quasi, beatae magnam? Esse culpa praesentium repellendus ex id excepturi a hic, illum, beatae vitae accusantium, aliquam libero.</p>

            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam ea, esse exercitationem expedita qui impedit deserunt dolor quas, similique officia ratione maxime quia eos vero consequatur repellat rerum non ullam.</p>
        </div>
    </main>

    <?php //No hace falta volver a llamar a require 'includes/funciones.php'; ya que lo hicimos al principio del archivo
    incluirTemplate('footer');

    mysqli_close($db);
    ?>
