<!-- En el archivo del header teniamos en los src build/css/app.css, debemos agregarle una barra al inicio
 para que nos tome todos los archivos bien (/build/css/app.css). Lo mismo hacemos con el footer.-->
<?php 
    require '../../includes/config/database.php';
    $db = conectarDB();
    //Consulta para obtener los vendedores para mostrar en el formulario 
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensaje de errores
    $errores = [];

    //Inicializar las variables vacías para guardar los datos de los campos que si se ingresaronç
    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedorId = '';

    // Para verificar que los datos se estan enviando correctamente, utilizamos var_dump($_POST)
    //$_SERVER nos trae la informacion del servidor, en este caso el metodo que se esta utilizando (POST al enviar el formulario)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

        //$_POST nos trae la informacion que se esta enviando por el formulario
        /*echo "<pre>";
        var_dump($_POST);
        echo "</pre>";*/

        //$_FILES nos trae la informacion de los archivos que se estan enviando por el formulario, utilizar para ver los datos que devuelven cuando subimos una imagen
        /*echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";*/

        //exit; Cuando probamos los var_dump y queremos que no se ejecute el codigo de abajo

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
        //Validacion de archivo - Si el campo name esta vacio o si hay un error (por tamaño), entonces no se sube la imagen
        //Estos 
        if(!$imagen['name'] || $imagen['error']) { 
            $errores[] = "La imagen es obligatoria";
        }

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

            //subir la imagen a la carpeta
            //Nombre de imagen, para que cada imagen tenga un nombre distinto:
            $nombreImagen = md5(uniqid( rand(), true)) . '.jpg';
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen); //tmp_name es el nombre temporal del archivo

            // Insertar en la base de datos
            $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedorId) 
            VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorId')";
            //echo $query; //Para probar que funcione

            $resultado = mysqli_query($db, $query);
            if($resultado) {
                //Redireccionar al usuario cuando la propiedad se crea correctamente para que no aprete varias veces el boton
                //Este debe ir siempre antes de incluir codigo HTML
                header('Location: /admin?resultado=1'); 
                //resultado=1 es para que se muestre un mensaje de exito, este se va a mostrar en el index.php
                // en la parte de arriba, donde se hace la consulta de la queryString

            }
        }
        
        
    };

    require '../../includes/funciones.php'; 
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
        <!-- El ENCTYPE se utiliza SIEMPRE que querramos utilizar archivos en el formulario -->
            <fieldset>
                <legend>Información General</legend>
<!--El atributo name en los inputs son los que toman los valores que el usuario ingresa en el formulario, es decir
cuando tengamos que recuperar esos datos ingresados por el formulario al titulo de la propiedad lo vamos a obtener
por medio del atributo titulo ya que es el valor que tiene el name-->
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" 
                value="<?php echo $titulo; ?>">
                <!--El value="" es para que cuando se envie el formulario y haya un error, no se borren los datos ingresados-->
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio de la Propiedad" 
                value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
                <!--En el textarea tiene que ir entre las etiquetas-->
            </fieldset>

            <fieldset>
                <legend>Información de la propiedad</legend>
                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" 
                value="<?php echo $habitaciones; ?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" placeholder="Ej: 3" name="wc" min="1" max="9" 
                value="<?php echo $wc; ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" placeholder="Ej: 3" name="estacionamiento" min="1" max="9" 
                value="<?php echo $estacionamiento; ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                <select name="vendedor">
                    <!-- selected es para que aparezca por defecto --> 
                    <!-- disabled no me deja seleccionar esa opcion, aunque sea la primera que aparezca-->
                    <option value="">-- Seleccione --</option> 
                    <!--Traigo desde BD los vendedores a seleccionar, Trabajar con mysqli_fetch_assoc 
                    (Nos devuelve un array con todas las columnas de la tabla a la que le hagamos la consulta en BD) -->
                    <?php while($vendedor = mysqli_fetch_assoc($resultado)) { ?>
<!--Comparamos el idVendedor(variable creada arriba) de la tabla propiedades con el id de la tabla vendedores, 
si coinciden es porque el usuario ya habia seleccionado alguno de los vendedores y tiró error, por lo tanto para 
que quede el valor que habia seleccionado, tenemos que comparar y si son iguales lo seleccionamos, sino lo dejamos 
vacio (el campo por defecto selected) el valor de vendedorId se carga cuando le damos click a enviar el formulario
Entonces, si anteriormente lo habiamos cargado al vendedor, con esto hacemos que no se borre ante un error. -->
                        <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> 
                            value="<?php echo $vendedor['id']; ?>">
                            <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?>
                        </option>
                    <?php } ?>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php //No hace falta volver a llamar a require 'includes/funciones.php'; ya que lo hicimos al principio del archivo
    incluirTemplate('footer');
?>