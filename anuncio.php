<?php

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('location: index.php');
}
// Importar la conexión
require 'includes/app.php';
 $db = conectarDB();  // Instancia de la conexión
// Consultar
 $query = "SELECT * FROM propiedades  WHERE id = {$id}";
 
// Obtener resultados
 $resultado = mysqli_query($db, $query);
 if(!$resultado->num_rows){
    header('location: index.php');
 }
 $propiedad = mysqli_fetch_assoc($resultado);

   

    incluirTemplates('header');
?>

 
    <main class="contenedor seccion contenido-centrado">
   
        
        <h1><?php echo $propiedad['titulo']; ?></h1>

            <img loading="lazy" src="imagenes/<?php echo $propiedad['imagen']; ?>" alt="imagen de la propiedad">
        
        <div class="resumen-propiedad">
            <p class="precio">$<?php echo number_format($propiedad['precio']);?></p>
           
            <ul class="iconos-caracteristicas-p">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['estacionamiento']; ?></p>
                </li>
                <li>
                    <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad['habitaciones']; ?></p>
                </li>
            </ul>
            

            <p><?php echo $propiedad['descripcion']; ?></p>

            
        </div>
    </main>

    <?php
     
    incluirTemplates('footer');
    mysqli_close($db);
 
?>