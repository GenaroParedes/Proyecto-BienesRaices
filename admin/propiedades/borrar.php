<!-- En el archivo del header teniamos en los src build/css/app.css, debemos agregarle una barra al inicio
 para que nos tome todos los archivos bien (/build/css/app.css). Lo mismo hacemos con el footer.-->
 <?php 
    require '../../includes/funciones.php'; 
    incluirTemplate('header');
?>

    <main class="contenedor">
        <h1>
            Borrar
        </h1>
    </main>

<?php //No hace falta volver a llamar a require 'includes/funciones.php'; ya que lo hicimos al principio del archivo
    incluirTemplate('footer');
?>