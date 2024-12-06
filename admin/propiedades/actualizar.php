<!-- En el archivo del header teniamos en los src build/css/app.css, debemos agregarle una barra al inicio
 para que nos tome todos los archivos bien (/build/css/app.css). Lo mismo hacemos con el footer.-->
 <?php
    
    //Obtenemos el valor del id de la propiedad a actualizar que viene en la queryString
    $id = $_GET['id'];
    //Valido que por la URL venga un INT y que el usuario no me esté ingresando otra cosa a proposito
    //Si el usuario me ingresa un string, el filter_var me va a devolver false
    $id = filter_var($id, FILTER_VALIDATE_INT); //Devuelve INT si es un numero, si no devuelve false
    //var_dump($id); 

    //Si el id no es un entero, redireccionar de nuevo a la pagina admin
    if (!$id) {
        header('Location: /admin');
    }

 
    require '../../includes/config/database.php';
    $db = conectarDB();

    //Consulta para obtener la propiedad con id pasada por la URL
    $consultaPropiedad = "SELECT * FROM propiedades WHERE id = $id";
    $resultadoPropiedad = mysqli_query($db, $consultaPropiedad);
    //Como resultado vamos a obtener una unica propiedad entonces la guardamos en una variable
    $propiedad = mysqli_fetch_assoc($resultadoPropiedad);

    //Consulta para obtener los vendedores para mostrar en el formulario 
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensaje de errores
    $errores = [];

    //En este caso en vez de crear las variables vacias como para crear una propiedad,
    //vamos a asignarle los valores de la propiedad que queremos actualizar
    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedorId = $propiedad['vendedorId'];
    //La imagen no la cargamos al seleccionador de archivos porque mostraria rutas que no queremos mostrar
    //La mostraremos aparte
    $imagenPropiedad = $propiedad['imagen'];

    // Para verificar que los datos se estan enviando correctamente, utilizamos var_dump($_POST)
    //$_SERVER nos trae la informacion del servidor, en este caso el metodo que se esta utilizando (POST al enviar el formulario)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

        //$_POST nos trae la informacion que se esta enviando por el formulario
        /*echo "<pre>";
        var_dump($_POST);
        echo "</pre>";*/

        //$_FILES nos trae la informacion de los archivos que se estan enviando por el formulario, utilizar para ver los datos que devuelven cuando subimos una imagen
       /* echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";*/

        //exit; //Cuando probamos los var_dump y queremos que no se ejecute el codigo de abajo

        /*Para tomar los valores de cada campo del formulario, con mysqli_real_escape_string evitamos inyeccion SQL, 
        es decir, verifica los tipos de datos que se ingresan, tambien evita que se ingresen caracteres especiales, 
        ademas de que se asegura que los datos ingresados sean del tipo correcto*/
        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
        $vendedorId = mysqli_real_escape_string($db, $_POST['vendedor']);
        $creado = date('Y/m/d');
        //Asignar files hacia una variable
        $imagen = $_FILES['imagen'];

        /*echo "<pre>";
        var_dump($imagen);
        echo "</pre>";
        exit;*/

        //Validar toda la informacion
        if (!$titulo) {
            $errores[] = "Debes añadir un titulo";
        }

        if (!$precio) {
            $errores[] = "El precio es obligatorio";
        }

        if (strlen($descripcion) < 50) {
            $errores[] = "La descripción es obligatoria y debe contener más de 50 caracteres";
        }

        if (!$habitaciones) {
            $errores[] = "El número de habitaciones es obligatorio";
        }

        if (!$wc) {
            $errores[] = "El número de baños es obligatorio";
        }

        if (!$estacionamiento) {
            $errores[] = "El número de estacionamientos es obligatorio";
        }

        if (!$vendedorId) {
            $errores[] = "Elige un vendedor";
        }
        
        //Acá la validacion de la imagen está de más ya que el usuario quizás quiere dejar la imagen que ya está
        //entonces no es obligatoria
        /*if(!$imagen['name'] || $imagen['error']) { 
            $errores[] = "La imagen es obligatoria";
        }*/

        //Validar por tamaño (1Mb máximo)
        $tamaño = 1000 * 1000; //1Mb
        if ($imagen['size'] > $tamaño) {
            $errores[] = "La imagen es muy pesada";
        }

        /*echo "<pre>";
        var_dump($errores);
        echo "</pre>";*/

        //Revisar que el arreglo de errores este vacio
        if (empty($errores)){
            //Subida de archivos
            //Crear carpeta
            $carpetaImagenes = '../../imagenes/'; //Carpeta donde se van a guardar los archivos (imagenes subidas)
            if (!is_dir($carpetaImagenes)) { //is_dir verifica si existe la carpeta
                mkdir($carpetaImagenes); //Si no existe la carpeta, la crea
            }

            //Si ya hay una imagen en la base de datos, cuando actualicemos y carguemos otra imagen, borramos la anterior
            if ($imagen['name']) {
                //Si cargamos una nueva imagen, entonces eliminamos la anterior
                unlink($carpetaImagenes . $propiedad['imagen']);
                //Nombre de imagen, para que cada imagen tenga un nombre distinto:
                $nombreImagen = md5(uniqid( rand(), true)) . '.jpg';
                //subir la imagen a la carpeta
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen); //tmp_name es el nombre temporal del archivo
            } else {
                //Si no cargamos una nueva imagen, entonces mantenemos la anterior
                $nombreImagen = $propiedad['imagen'];
            }


            // Actualizar en la base de datos - Los INT no llevan comillas simples, en un UPDATE, siempre debemos tener un WHERE
            $query = "UPDATE propiedades SET titulo = '$titulo', precio = '$precio', imagen = '$nombreImagen',
            descripcion = '$descripcion', habitaciones = $habitaciones, wc = $wc, estacionamiento = $estacionamiento, 
            vendedorId = $vendedorId WHERE id = $id";
            //echo $query; //Para probar que funcione - Siempre comprobar en Dbeaver que la query funcione.
            //exit; //Para que no se ejecute el codigo de abajo


            $resultado = mysqli_query($db, $query);
            if($resultado) {
                //Redireccionar al usuario - Le pasamos como resultado un 2 ahora en vez de 1 como en la creacion
                header('Location: /admin?resultado=2'); 
            }
        }
        
        
    };

    require '../../includes/funciones.php'; 
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

        <form class="formulario" method="POST" enctype="multipart/form-data">
        <!-- El ENCTYPE se utiliza SIEMPRE que querramos utilizar archivos en el formulario -->
            <fieldset>
                <legend>Información General</legend>
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">
                <!--El value="" es para que cuando se envie el formulario y haya un error, no se borren los datos ingresados-->
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio de la Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
                <!--Mostramos la imagen abajo-->
                <img src="/imagenes/<?php echo $imagenPropiedad ?>" alt="Imagen Propiedad" class="imagen-small">
                

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información de la propiedad</legend>
                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" placeholder="Ej: 3" name="wc" min="1" max="9" value="<?php echo $wc; ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" placeholder="Ej: 3" name="estacionamiento" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                <select name="vendedor">
                    <option value="">-- Seleccione --</option> 
                    <?php while($vendedor = mysqli_fetch_assoc($resultado)) { ?>
                        <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"><?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php //No hace falta volver a llamar a require 'includes/funciones.php'; ya que lo hicimos al principio del archivo
    incluirTemplate('footer');
?>