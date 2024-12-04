<!-- Aquí vamos a ingresar cuando querramos realizar un CRUD con el usuario ADMIN -->
<?php 
    //Este 'resultado' es el que viene en la queryString, cuando enviamos el formulario para dar de alta una propiedad
    $resultado = $_GET['resultado'] ?? null; //el ?? null, me permite que si no hay nada en la variable, no me de error, le asigna null
    require '../includes/funciones.php'; 
    incluirTemplate('header');
?>

    <main class="contenedor">
        <h1>Administrador de Bienes Raíces</h1>
        <?php if($resultado) { ?>
            <p class="alerta exito">Propiedad creada correctamente</p>
        <?php } ?>
        <a href="/admin/propiedades/crear.php" class="boton-verde">Nueva Propiedad</a>
    </main>
<?php
    incluirTemplate('footer');
?> 