<?php
use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;
require '../../includes/app.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
estaAutenticado();


    // Validar URL por ID válido
     $id = $_GET['id'];
     $id = filter_var($id, FILTER_VALIDATE_INT);
 
     if(!$id){
         header('location:  ../index.php');
     }
     //Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);
    if(!$propiedad){
        header('location:  ../index.php');
    }
        //Arreglo con mensajes de errores

        $errores = Propiedad::getErrores();
        
        
     if ($_SERVER['REQUEST_METHOD'] === "POST"){
        
        $args = $_POST['propiedad'];
        $propiedad->sincronizar($args);
    
        // Validación subida de archivos
        $errores = $propiedad->validar();
        
        
        $nombreImagen = md5(uniqid(rand(), true) ). ".jpg";
         // Realiza un resize a la imagen con intervention
         if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
            $propiedad->setImagen($nombreImagen);
         }
       
        
    // Revisar que el arreglo de errores este vacío

    if(empty($errores)){
        // Almacenar la imagen
        
        $image->save(CARPETA_IMAGENES . $nombreImagen);
        $resultado = $propiedad->guardar();
        
        //Insertar en la base de datos
            }  
         }

      incluirTemplates('header');


?>

<main class="contenedor seccion">
    
        <h1>Actualizar Propiedad</h1>
        
        <a href="../index.php" class="boton boton-verde">Volver</a>
         <?php  foreach($errores as $error): ?>
            <div class="alerta error">
            <?php echo $error; ?>
            </div>
            
            <?php endforeach; ?>
        <form  class="formulario" method="POST" enctype="multipart/form-data" >

        <?php include '../../includes/formulario_propiedades.php'; ?>
          <input type="submit"  class="boton boton-verde" value="Actualizar propiedad" >
           
        </form>
    </main>

    <?php  
    incluirTemplates('footer');
    ?>
