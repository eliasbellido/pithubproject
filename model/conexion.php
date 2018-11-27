<?php

class Conexion{
    public function conectar(){
        try {
            $db = new PDO('mysql:host=127.0.0.1;dbname=restauranteBD','root','admin@bellido');
            $db->exec('SET CHARACTER SET utf8');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db;
        } catch (Exception $e) {
            echo "Error de conexión: ". $e->getMessage. $e->getLine;
        }
    }

    
}