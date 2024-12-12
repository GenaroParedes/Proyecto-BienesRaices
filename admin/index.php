<!-- Aquí vamos a ingresar cuando querramos realizar un CRUD con el usuario ADMIN -->
<?php 
    require '../includes/app.php';
    use App\Propiedad;

    //Validar que el usuario este logueado
    estaAutenticado();
    
    //Implementar un metodo para obtener todas las propiedades - Necesitamos una sola instancia, por esto lo hacemos estatico
    $propiedades = Propiedad::all();
    $resultado = null;

    //Cuando apretamos el click en el boton eliminar, se va a realizar un POST, para eliminar esa propiedad.
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        //El $_POST no va a existir hasta que no se mande el REQUEST_METHOD, por eso es importante ponerlo dentro de este if
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT); //Validamos que sea un entero

        if ($id) {
            //Eliminar el archivo de la imagen
            $queryImagen = "SELECT imagen FROM propiedades WHERE id = $id";
            $resultadoImagen = mysqli_query($db, $queryImagen);
            $propiedad = mysqli_fetch_assoc($resultadoImagen);
            unlink('../imagenes/' . $propiedad['imagen']);

            //Eliminar la propiedad
            $query = "DELETE FROM propiedades WHERE id = $id";
            $resultado = mysqli_query($db, $query);

            if($resultado) {
                header('Location: /admin?resultado=3'); //3 es que se elimino correctamente
            }
        }
    }

    incluirTemplate('header');
?>

    <main class="contenedor">
        <h1>Administrador de Bienes Raíces</h1>
        <?php if($resultado == 1) { ?>
            <p class="alerta exito">Propiedad creada correctamente</p>
        <?php } else if ($resultado == 2) { ?>
            <p class="alerta exito">Propiedad actualizada correctamente</p>
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

            <tbody> <!-- 4 - Mostrar los resultados - Debemos modificar el while por un foreach para recorrer los objetos -->
                <?php foreach( $propiedades as $propiedad ) { ?>
                    <tr>
                        <!--Debemos modificar la sintaxis de arreglo por la sintaxis de objeto-->
                        <td> <?php echo $propiedad -> id; ?> </td>
                        <td> <?php echo $propiedad -> titulo; ?> </td>
                        <td><img src="/imagenes/<?php echo $propiedad -> imagen ?>" alt="Imagen Casa" class="imagen-tabla"></td>
                        <td>$<?php echo $propiedad -> precio; ?> </td>
                        <td>
                <!--para borrar una propiedad vamos a tener un formulario -->
                            <form method="POST" class="w-100">
                                <!--Input que no se ven pero se utilizan para obtener el id-->
                                <input type="hidden" name="id" value="<?php echo $propiedad -> id; ?>">
                                <input type="submit" href="/admin/propiedades/borrar.php" class="boton-rojo-block" value="Eliminar">
                            </form>
                <!-- en el href vamos a pasar el id de la propiedad a actualizar, para poder ingresar los datos de la propiedad
                 al formulario para que el usuario no tenga que cargar todo nuevamente -->
                            <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad -> id ?>" class="boton-naranja-block">Actualizar</a>
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