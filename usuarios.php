<?php
    //Este archivo se utiliza unicamente para insertar un usuario en la base de datos, luego se debe borrar.

    // Conexion a BD
    require 'includes/config/database.php';
    $db = conectarDB();

    //Datos usuario
    $email = "correo@correo.com";
    $password = "123456";
    //Hasheamos el password
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    //Realizar la consulta
    $query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$passwordHash')";
    //echo $query;

    //Insertar en la base de datos
    mysqli_query($db, $query);
    mysqli_close($db);
