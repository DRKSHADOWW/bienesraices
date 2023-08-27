<?php

if(!isset($_SESSION)){
    session_start();
}
$auth = $_SESSION['login'] ?? null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/bienesraices_copia/build/css/app.css">
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio' : '';  ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/bienesraices_copia/index.php">
                    <img src="/bienesraices_copia/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/bienesraices_copia/build/img/barras.svg" alt="i">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/bienesraices_copia/build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="/bienesraices_copia/nosotros.php">Nosotros</a>
                        <a href="/bienesraices_copia/anuncios.php">Anuncios</a>
                        <a href="/bienesraices_copia/blog.php">Blog</a>
                        <a href="/bienesraices_copia/contacto.php">Contacto</a>
                        <?php if($auth):?>
                           <a href="/bienesraices_copia/cerrar-sesion.php">Cerrar Sessión</a>
                            <?php endif; ?>
                    </nav>
                </div>
   
                
            </div> <!--.barra-->
            <?php if($inicio) {?>
                 <h1>Venta de Casas y Departamentos  Exclusivos de Lujo</h1> 
                 <?php } ?>

            <!-- también se puede agregar como operador ternario
                    <?php echo $inicio ? "<h1> Venta de casas y Departamentos Exclusivos de Lujos <h1>": '';?>
            -->
           
        </div>
    </header>
