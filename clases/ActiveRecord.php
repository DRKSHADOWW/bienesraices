<?php
namespace App;

class ActiveRecord {

    // Base de Datos

    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';
    //Errores
    protected static $errores = [];

    

   
    
    
    // Definir la conexión a la base de datos
    public static function setDB($database){
    self::$db = $database;
       
}

public function guardar(){
        if( !is_null($this->id)){
            $this->actualizar();
            
        } else {
            $this->crear();
        }

}

    public function crear(){
        

        //////////Sanitizar los datos
            $atributos = $this->sanitizarAtributos();
           
            //Insertar en la base de datos
           
            $query = " INSERT INTO " . static::$tabla . " ( ";
            $query .= join(', ', array_keys($atributos));
            $query .= " ) VALUES (' ";
            $query .= join("', '", array_values($atributos));
            $query .= " ') ";
             
            $resultado = self::$db->query($query);

            if($resultado){
                // Redirecciona al usuario.
                header("Location: ../index.php?resultado=1");
                 }

            // debuguear($query);
            
    }          
   
    public function actualizar(){
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'"; //
        }
        $query = " UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= "LIMIT 1 ";

        $resultado = self::$db->query($query);
        
        if($resultado){
            // Redirecciona al usuario.
            header("Location: ../index.php?resultado=2");
             }
    }

    //Eliminar un registro
    public function eliminar(){
        //Eliminar el registro
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado){
            $this->borrarImagen();
            header('location: index.php?resultado=3');
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

           
            if(!is_null($this->id)){
                // Comprobar si existe el archivo
               $this->borrarImagen();
                
            }


             //Asignar al atributo de imagen el nombre de la imag
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    // Elimina el archivo 
    public function borrarImagen(){
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo){
            unlink(CARPETA_IMAGENES.$this->imagen);
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
    $query = "SELECT * FROM ". static::$tabla;
    $resultado = self::consultarSQL($query);

    return $resultado;
   
   }

    // Busca un registro por su ID
    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
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
    $objeto = new static;
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