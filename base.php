<?php 
    require 'includes/funciones.php'; 
    incluirTemplate('header');
?>

    <main class="contenedor">
        <h1>
            Base por si queremos agregar otras paginas en el futuro, para tener un template base
        </h1>
    </main>

<?php //No hace falta volver a llamar a require 'includes/funciones.php'; ya que lo hicimos al principio del archivo
    incluirTemplate('footer');
?>