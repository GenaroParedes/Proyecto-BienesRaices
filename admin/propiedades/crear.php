<!-- En el archivo del header teniamos en los src build/css/app.css, debemos agregarle una barra al inicio
 para que nos tome todos los archivos bien (/build/css/app.css). Lo mismo hacemos con el footer.-->
<?php 
    require '../../includes/app.php'; 
    use App\Propiedad;
    use Intervention\Image\Drivers\Gd\Driver;
    use Intervention\Image\ImageManager;

    //Validar que el usuario este logueado
    estaAutenticado();
    
    //Consulta para obtener los vendedores para mostrar en el formulario 
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    $propiedad = new Propiedad;

    //Arreglo con mensaje de errores
    $errores = Propiedad::getErrores();

    // Para verificar que los datos se estan enviando correctamente, utilizamos var_dump($_POST)
    //$_SERVER nos trae la informacion del servidor, en este caso el metodo que se esta utilizando (POST al enviar el formulario)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
        //Debemos agregar al $_POST la ['propiedad'] que agregamos en el name del formulario
        $propiedad = new Propiedad($_POST['propiedad']);

        //Generar un nombre unico para cada imagen
        $nombreImagen = md5(uniqid( rand(), true)) . '.jpg';
        
        //Como agregamos al name de cada input un arreglo de propiedad, entonces lo debo agregar aca tambien.
        if($_FILES['propiedad']['tmp_name']['imagen']) {
            //Configuracion del manager de imagenes
            $manager = new ImageManager(Driver::class);
            //Leer la imagen y luego redimensionarla
            $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
            $propiedad->setImagen($nombreImagen);
        }

        $errores = $propiedad->validar();

        //Revisar que el arreglo de errores este vacio
        if (empty($errores)){
            
            if (!is_dir(CARPETA_IMAGENES)) { 
                mkdir(CARPETA_IMAGENES); 
            }

            //Guarda la imagen en el servidor
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
            //Guardamos la propiedad en BD
            $resultado = $propiedad->guardar(); 
            if($resultado) {
                //Redireccionar al usuario cuando la propiedad se crea correctamente para que no aprete varias veces el boton
                header('Location: /admin?resultado=1'); 
                //resultado=1 es para que se muestre un mensaje de exito, este se va a mostrar en el index.php
                // en la parte de arriba, donde se hace la consulta de la queryString

            }
        }
    };
    
    incluirTemplate('header');
?>

    <main class="contenedor">
        <h1>Crear Propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!--Debemos mostrar los errores si los hay-->
        <?php foreach($errores as $error) { ?> <!-- Recorremos los errores si no está vacio para mostrarlos-->
            <div class="alerta error"> <!--Le damos estilos para mostrar los errores-->
                <?php echo $error; ?>
            </div>
        <?php } ?>


<!-- El method='GET' expone los datos en la URL cuando se envian los datos, cuando se requiere leer datos de la URL
 o pasar datos de una pantalla a otra se recomienda usar GET, pero tambien tenemos la Opcion del POST, el cual
 no muestra nada por URL, este se recomienda por ejemplo para cuando hay un inicio de sesion o cuando el usuario
 ingresa datos importantes sobre el mismo, para no revelar sus datos. Se utiliza GET por ejemplo cuando estas viendo
 un producto en Markplace, para poder enviar esa URL a otro usuario y que este pueda entrar al mismo producto
 debe utilizar un method='GET' ya que sino el otro usuario no va a poder ver el producto. Cuando visitas una 
 URL es GET ya que necesitamos datos del servidor y cuando enviamos datos (Ej: un formulario) es POST-->
        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php' ?>
            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php //No hace falta volver a llamar a require 'includes/funciones.php'; ya que lo hicimos al principio del archivo
    incluirTemplate('footer');
?>