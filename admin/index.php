<!-- Aquí vamos a ingresar cuando querramos realizar un CRUD con el usuario ADMIN -->
<?php 
    //Conexion a la base de datos para listar las propiedades - Esto lo vamos a hacer muchas veces - Son 5 pasos
    // 1 - Importar la conexion
    require '../includes/config/database.php';
    $db = conectarDB();
    // 2 - Escribir el query
    $query = "SELECT * FROM propiedades";
    // 3 - Consultar la BD
    $resultadoConsulta = mysqli_query($db, $query);
    
    
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

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!-- 4 - Mostrar los resultados -->
                <?php while($propiedad = mysqli_fetch_assoc($resultadoConsulta)) { ?>
                    <tr>
                        <td> <?php echo $propiedad['id']; ?> </td>
                        <td> <?php echo $propiedad['titulo']; ?> </td>
                        <td><img src="/imagenes/<?php echo $propiedad['imagen'] ?>" alt="Imagen Casa" class="imagen-tabla"></td>
                        <td>$<?php echo $propiedad['precio']; ?> </td>
                        <td>
                            <a href="#" class="boton-rojo-block">Eliminar</a>
                            <a href="#" class="boton-naranja-block">Actualizar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
<?php
    // 5 - Cerrar la conexion
    mysqli_close($db);
    incluirTemplate('footer');
?> 