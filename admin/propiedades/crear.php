<?php
  

require '../../includes/app.php';
use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

     estaAutenticado();
     $db = conectarDB();
     $propiedad = new Propiedad;

     // Consultar para obtener vendedores

        $consulta = "SELECT * FROM vendedores";
        $resultado = mysqli_query($db, $consulta);
        //Arreglo con mensajes de errores

        $errores = Propiedad::getErrores();
        $propiedad = new Propiedad();
        
     if ($_SERVER['REQUEST_METHOD'] === "POST"){
        // Crea una nueva Instancia
        $propiedad = new Propiedad($_POST['propiedad']);

        
         // Generar un nombre único
         $nombreImagen = md5(uniqid(rand(), true) ). ".jpg";

         // Realiza un resize a la imagen con intervention
         if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
            $propiedad->setImagen($nombreImagen);
         }
        

         //Validar
        $errores = $propiedad->validar();
        

    // Revisar que el arreglo de errores este vacío

    if(empty($errores)){
       
       
       
        // crear la carpeta para subir imagenes
        if(!is_dir(CARPETA_IMAGENES)){
            mkdir(CARPETA_IMAGENES);
        }
        $imagen = $_FILES['imagen'];

        // copy($imagen["tmp_name"], $carpetaImagenes . $nombreImagen );
 
        // Guarda la imagen en el servidor
        $image->save(CARPETA_IMAGENES.$nombreImagen);
       // Guarada en la base de datos
            $propiedad->guardar();

            //Mensaje de exito o de error
           

                
            }
            
           
         }
     
      
      incluirTemplates('header');


?>

<main class="contenedor seccion">
    
        <h1>Crear</h1>
        
        <a href="../index.php" class="boton boton-verde">Volver</a>
         <?php  foreach($errores as $error): ?>
            <div class="alerta error">
            <?php echo $error; ?>
            </div>
            
            <?php endforeach; ?>
        <form action="crear.php" class="formulario" method="POST" enctype="multipart/form-data" name="form1">

            <?php include '../../includes/formulario_propiedades.php'; ?>
                <input type="submit"  class="boton boton-verde" value="Crear propiedad" >
            </fieldset>
            
        </form>
    </main>

    <?php  
    incluirTemplates('footer');
    ?>
