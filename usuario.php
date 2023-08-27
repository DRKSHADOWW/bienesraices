<?php

// Importar la conexión

require 'includes/app.php';
$db = conectarDB();
// crear un email y password
$email = "correo@correo.com";
$password = "12345";

$passwordhash = password_hash($password, PASSWORD_BCRYPT); // Código para hashear contraseñas
// query para crear el usuario
$query = "INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$passwordhash}');";
// Agregarlo a la base de datos$
mysqli_query($db, $query);
?>