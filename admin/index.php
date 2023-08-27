    <?php
    
require '../includes/app.php';
 estaAutenticado();
use App\Propiedad;
    // Llamar a la base de datos  
    // Implementar u método para obtner todas las propiedades
    $propiedades = Propiedad::all();
    
    
    $resultado = $_GET['resultado'] ?? null; // ?? placeholder = buscar este valor y si no existe le agrega null

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id){
            // Eliminar el archivo
            $query = "SELECT imagen FROM propiedades WHERE  id = {$id}";

            $resultado= mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);

            unlink('../imagenes' . $propiedad['imagen']);
            
            // Eliminar la propiedad
            $query = "DELETE FROM propiedades WHERE id = {$id}";
            $resultado = mysqli_query($db, $query);
            if($resultado){
                header('location: index.php?resultado=3');
            }
        }
        
    }

 
    incluirTemplates('header');
    ?>


    <main class="contenedor seccion">
       
        <h1>Administrador de bienes raices</h1>
        <?php if(intval($resultado) === 1): ?>
            <p class="alerta exito">Creado Correctamente</p>
            <?php elseif(intval($resultado) === 2): ?>
                <p class="alerta exito">Actualizado Correctamente</p>
                <?php elseif(intval($resultado) === 3): ?>
                <p class="alerta exito">Eliminado Correctamente</p>
            
            <?php endif; ?>
            <a href="../admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad </a>

            <table class="propiedades">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody> <!-- Mostrar resultados-->
                    <?php foreach($propiedades as $propiedad): ?>
                    <tr>
                        <td><?php echo $propiedad->id; ?></td>
                        <td><?php echo $propiedad->titulo; ?></td>
                        <td><img src="../imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"></td>
                        <td> $ <?php echo number_format($propiedad->precio); ?></td>
                        <td>
                            <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="submit"  class="boton-rojo-block " value="Eliminar">
                            </form>
                            
                            <a href="propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>"class="boton-amarillo-block" >Actualizar</a>
                        </td>
                    </tr>
                    
                    <?php endforeach; ?>


                </tbody>
                
            </table>
    </main>

    <?php  
   
    // Cerrar la Conexión
    mysqli_close($db);
    incluirTemplates('footer');
    ?>
    