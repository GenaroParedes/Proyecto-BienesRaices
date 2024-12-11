<!-- Incluimos el header desde el archivo header.php, por lo tanto ahora 
 no duplicamos nada de codigo ya que lo tenemos en un solo lugar -->
<?php 
    require 'includes/app.php'; 
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Nuestros Anuncios</h1>
        
        <?php 
            $limite = 25;
            include 'includes/templates/anuncios.php'; 
        ?>
    </main>

    <?php //No hace falta volver a llamar a require 'includes/funciones.php'; ya que lo hicimos al principio del archivo
    incluirTemplate('footer');
    ?>
