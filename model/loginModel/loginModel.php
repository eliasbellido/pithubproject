<?php
require_once 'model/conexion.php';

class LoginModel{

    public function validarCredenciales($dataModel){

        try{
            $conexion = Conexion::conectar();

            $sql = "SELECT * FROM usuario WHERE (email = :email AND clave = :clave)";
        
            $stmt = $conexion->prepare($sql);

            $stmt->bindValue(':email', $dataModel['email']);
            $stmt->bindValue(':clave', $dataModel['clave']);
            $stmt->execute();

            $resultado = $stmt->fetch();

            if($resultado != false){
                return '1';
            }
            
        }catch(Exception $e){            
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }

    }
}