<?php 
 //Formulario para iniciar sesion y autenticar al usuario
    require 'includes/app.php';
    $db = conectarDB();

    $errores = [];
    //Autenticar el usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /*echo "<pre>";
        var_dump($_POST);
        echo "</pre>";*/

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if (!$email){
            $errores[] = "El email es obligatorio o no es válido";
        }
        if (!$password) {
            $errores[] = "El password es obligatorio";
        }

        if(empty($errores)) {
            //Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query($db, $query);
            
            if ($resultado -> num_rows) { //En caso de que haya resultados entra al if (Si existe un registro con ese email)
                //Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                //Verificar si el password es correcto o no
                $auth = password_verify($password, $usuario['password']);

                if ($auth) {
                    //El usuario esta autenticado
                    session_start(); //Iniciar sesion para guardar el usuario, para poder utilizar $_SESSION se debe inciar sesion

                    //Llenar el arreglo de la sesion
                    $_SESSION['usuario'] = $usuario['email']; //Guardamos el email del usuario en la sesion
                    $_SESSION['login'] = true; //Guardamos un valor booleano para saber si el usuario esta logueado o no

                    header('Location: /admin');
                } else {
                    $errores[] = "El password es incorrecto";
                }
            } else {
                $errores[] = "El usuario no existe";
            }
        }
    }


    require 'includes/funciones.php'; 
    incluirTemplate('header');
?>

    <main class="contenedor contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error) { ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST" class="formulario">
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <!-- el required es para que no deje enviar el formulario si no se introdujo nada en los campos-->
                <input placeholder="Tu Email" name="email" type="email" id="email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Tu Password" required>
            </fieldset>

            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>
    </main>

<?php //No hace falta volver a llamar a require 'includes/funciones.php'; ya que lo hicimos al principio del archivo
    incluirTemplate('footer');
?>