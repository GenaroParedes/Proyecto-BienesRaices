<?php
    //Esto es para verificar si la sesion ya esta iniciada, si no lo está la inicia, esto se hace para que no de error
    if(!isset($_SESSION)) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? false; //Si no existe la sesion, le asigna false
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raíces</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
<!--Para agregar el header distinto en index.php, iniciamos una variable inicio en true en index,
luego acá verificamos si está en true, y si lo está agrega la clase inicio, sino no la agrega, como
esta variable va a ser true unicamente en index.php, solo se van a aplicar esos estilos a esa pagina. 
El isset se utiliza para que no se muestre informacion sobre nuestro sistema. -->
<!-- Ahora ya podemos borrar el isset ya que en el archivo de funciones, si la variable inicio no está inicializada
 por parametro la iguala a false, esto hace que no devuelva error, entonces el isset ya no es necesario -->
    <header class="header <?php echo $inicio ? 'inicio' : '' ?>"> 
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.svg" alt="Logo de Bienes Raíces">
                </a>
                
                <div class="mobile-menu"> <!--Para el menu responsive-->
                    <img src="/build/img/barras.svg" alt="Icono Menu Responsive">
                </div>
                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="Icono dark-mode">
                    <nav class="navegacion">
                        <a href="nosotros.php">Nosotros</a>
                        <a href="anuncios.php">Anuncios</a>
                        <a href="blog.php">Blog</a>
                        <a href="contacto.php">Contacto</a>
                        <?php if ($auth) { ?> <!--Si el usuario esta autenticado, muestra el boton de cerrar sesion-->
                            <a href="cerrar-sesion.php">Cerrar Sesión</a>
                        <?php } ?>
                    </nav> <!--.navegacion-->
                </div>
            </div> <!--.barra-->

            <?php
                if ($inicio) {
                    echo "<h1>Venta de Casas y Departamentos Exclusivos</h1>";
                }
                // echo $inicio ? "<h1>Venta de Casas y Departamentos Exclusivos</h1>" : ''; //Otra forma de hacerlo
            ?>
        </div> <!--.contenedor header-->
    </header>