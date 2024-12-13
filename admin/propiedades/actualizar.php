<?php
    require '../../includes/app.php'; 
    
    use App\Propiedad;
    use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Drivers\Gd\Driver;
 
    
    estaAutenticado();
 
    //Validar la URL por ID válido    
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    
    if(!$id){
        header('Location: /admin');
    }
 
 
    //Consulta para obtener datos de propiedad   
    $propiedad = Propiedad::find($id);     
 
    //Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);
 
    //Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();
 
    //Ejecutar el código despues de que el usuario mande el formulario
 
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Asignar los atributos
        $args = $_POST ['propiedad'];
 
        $propiedad->sincronizar($args); 
 
        //Validación
        $errores = $propiedad->validar();     
        
        //Generar un nombre único
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
 
        //Subida de archivos
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $manager = new Image(Driver::class);
            $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800,600);
            $propiedad->setImagen($nombreImagen);
        }
 
        //Revisar que el array de errores este vacio
        if(empty($errores)) {
            //Almacenar la imagen
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);
            }
            $propiedad->guardar();
            
            if($resultado){
                //Redireccionar al usuario.
                header('Location: /admin?resultado=2');
            }
 
        }
    }       
    incluirTemplate('header');      
?>

    <main class="contenedor">
        <h1>Actualizar Propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!--Debemos mostrar los errores si los hay-->
        <?php foreach($errores as $error) { ?> <!-- Recorremos los errores si no está vacio para mostrarlos-->
            <div class="alerta error"> <!--Le damos estilos para mostrar los errores-->
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <!--Llevamos todo el form a un template, pero las cosas que cambian (en actualizar y crear las dejamos)
        como por ejemplo la etiqueta form aca tiene method="POST", en actualizar tiene method="GET" y lo mismo
        para el input-->
        <form class="formulario" method="POST" enctype="multipart/form-data">
        <!-- El ENCTYPE se utiliza SIEMPRE que querramos utilizar archivos en el formulario -->
            <?php include '../../includes/templates/formulario_propiedades.php' ?>
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php //No hace falta volver a llamar a require 'includes/funciones.php'; ya que lo hicimos al principio del archivo
    incluirTemplate('footer');
?>