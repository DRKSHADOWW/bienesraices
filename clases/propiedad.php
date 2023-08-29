<?php


 namespace App;
 // Código para ver errores
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
class Propiedad{

    // Base de Datos

    
    protected static $columnasDB = ['id','titulo','precio','imagen','descripcion', 'habitaciones', 'wc','estacionamiento', 'creado', 'vendedores_id'];
    protected static $db;
    //Errores
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? "";
        $this->titulo= $args['titulo'] ?? "";
        $this->precio = $args['precio'] ?? "";
        $this->imagen = $args['imagen'] ?? "";
        $this->descripcion = $args['descripcion'] ?? "";
        $this->habitaciones = $args['habitaciones'] ?? "";
        $this->wc = $args['wc'] ?? "";
        $this->estacionamiento = $args['estacionamiento'] ?? "";
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? 1;
    }
    
    // Definir la conexión a la base de datos
    public static function setDB($database){
    self::$db = $database;
       
}

public function guardar(){
        if(isset($this->id)){
            $this->actualizar();
            
        } else {
            $this->crear();
        }

}

    public function crear(){
        

        //////////Sanitizar los datos
            $atributos = $this->sanitizarAtributos();
           
            //Insertar en la base de datos
           
            $query = " INSERT INTO propiedades ( ";
            $query .= join(', ', array_keys($atributos));
            $query .= " ) VALUES (' ";
            $query .= join("', '", array_values($atributos));
            $query .= " ') ";
             
            $resultado = self::$db->query($query);
            return $resultado;

            // debuguear($query);
            
    }          
   
    public function actualizar(){
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'"; //
        }
        $query = " UPDATE propiedades SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= "LIMIT 1 ";

        $resultado = self::$db->query($query);
        
        if($resultado){
            // Redirecciona al usuario.
            header("Location: ../index.php?resultado=2");
             }
    }

    // Identificar y unir los atributos de la BD
    public function atributos(){
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }


    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado =[];

        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Subida de archivos
    public function setImagen($imagen){
           // Elimina la imagen previa

           
            if(isset($this->id)){
                // Comprobar si existe el archivo
                $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
                if($existeArchivo){
                    unlink(CARPETA_IMAGENES.$this->imagen);
                }
                
            }


             //Asignar al atributo de imagen el nombre de la imag
        if($imagen){
            $this->imagen = $imagen;
        }
    }
   // Validación

   public static function getErrores(){
        return self::$errores;
   }

   public function validar(){
    if(strlen($this->titulo) >= 45){
        self::$errores[] = "Debes añadir un titulo, máximo 45 caracteres";
    }
    if(strlen($this->precio) >= 10){
        self::$errores[] = "El precio es obligatorio y máximo 10 dígitos";
    }
    if (strlen($this->descripcion) < 50){
        self::$errores[] = "Debes añadir una descripcion y debe tener al menos 50 caracteres";
    }
    if(!$this->habitaciones){
        self::$errores[] = "El número de habitaciones es obligatorio";
    }
    if(!$this->wc){
        self::$errores[] = "El número de baños es obligatorio";
    }
    if(!$this->estacionamiento){
        self::$errores[] = "El número de lugares de estacionamiento es obligatorio";
    }
    if(!$this->vendedores_id){
        self::$errores[] = "Elige un vendedor";
    }

    if(!$this->imagen){
        self::$errores[] = 'La imagen es Obligatoria';
    }

    return self::$errores;
   }

   //Lista todas los registros
   public static function all(){
    $query = "SELECT * FROM propiedades";
    $resultado = self::consultarSQL($query);

    return $resultado;
   
   }

    // Busca un registro por su ID
    public static function find($id){
        $query = "SELECT * FROM propiedades WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado); // Array_shift : retorna el primer elemento de un arreglo
    }

    //
   public static function consultarSQL($query){
    // Consultar la base dedatos
    $resultado = self::$db->query($query);

    // Iterar la base de datos
    $array = [];
    while($registro = $resultado->fetch_assoc()){
        $array[] = self::crearObjeto($registro);
    }
    // debuguear($array);

    

    // Liberar la memoria
    $resultado->free();

    // retornar los resultados
    return $array;
   }
 // Crea una  un objeto
   protected static function crearObjeto($registro){
    $objeto = new self;
    foreach($registro as $key => $value ){
        if(property_exists($objeto, $key)){ // property_axists revisa un qobjeto que una propiedad exista
            $objeto->$key = $value;
        }
    }
    return $objeto;
   }

   //Sincroniza el objeto en memoria con los cambios realizdos por el usuario
   public function sincronizar($args = []){
    foreach($args as $key => $value){
        if(property_exists($this, $key) && !is_null($value)){
            $this->$key = $value;
        }
    }

    
   }
}
