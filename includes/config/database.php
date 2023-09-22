<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '', 'bienesraices_crud');
    // $db->set_charset('utf8');
    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    }
    
    

    return $db;
    
}


