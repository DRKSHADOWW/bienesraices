<?php

require 'includes/app.php';
$db = conectarDB();
// Autnenticar el usuario

$errores = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
 echo "<pre>";
 var_dump($_POST);
 echo "</pre>";

$email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
$password = mysqli_real_escape_string($db, $_POST['password']);

if(!$email){
    $errores[] = "El E-mail es  obligatorio o no es válido";
}

if(!$password){
    $errores[] = "El Password es obligatorio o no es válido";
}

if(empty($errores)){

    // Revisar si existe usuario

    $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
    $resultado = mysqli_query($db, $query);
    
 if($resultado->num_rows){
    //revisar si el password es correcto
    $usuario = mysqli_fetch_assoc($resultado);

    // Verificar el password
    
    $auth = password_verify($password, $usuario['password']);
   if($auth){
        // El usuario está autenticado
     
        session_start();

        //Llenar el arreglo de la sessión

       
        $_SESSION['usuario'] = $usuario['email'];
        $_SESSION['login'] = true;
       
        header('location: /bienesraices_copia/admin/index.php');
       
       

   }else{
    $errores[] = "El password es incorrecto";
   }

 }else{
    $errores[] = "El usuario no existe";
 }
}

}


// Incluye el header
   

    incluirTemplates('header');
?>


    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sessión</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error;?>
            </div>
        <?php endforeach; ?>
        <form method="POST" class="formulario">
        <fieldset>
                <legend>Email y Password</legend>

           

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email" >

                <label for="password">password</label>
                <input type="password" name="password" placeholder="Tu Password" id="telefono" >

            </fieldset>
            <input type="submit" value="Iniciar Session" class="boton boton-verde">
        </form>
    </main>

    <?php
    incluirTemplates('footer');
?>