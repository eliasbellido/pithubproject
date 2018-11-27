<?php
require_once 'model/conexion.php';

class LoginModel{

    public function validarCredenciales($dataModel){

        try{
            $conexion = Conexion::conectar();

            $sql = "SELECT t1.email,t1.idtipo_usuario,t2.idrestaurante FROM usuario t1
            LEFT JOIN restaurante t2
            ON t1.email = t2.email
            WHERE
             (t1.email = :email AND t1.clave = :clave AND t1.idtipo_usuario not in (3))";
        
            $stmt = $conexion->prepare($sql);

            $stmt->bindValue(':email', $dataModel['email']);
            $stmt->bindValue(':clave', $dataModel['clave']);
            $stmt->execute();

            $resultado = $stmt->fetch();

            if($resultado != false){
                //return '1';
                return $resultado;
            }
            
        }catch(Exception $e){            
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }

    }
}