<?php

/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'util/phpmail/Exception.php';
require_once 'util/phpmail/PHPMailer.php';
require_once 'util/phpmail/SMTP.php';

require_once 'model/conexion.php';

class PedidoModel{

    public function listarPedidosNuevos($idrestaurante){

        try{
            $conexion = Conexion::conectar();

            $sql = "SELECT t1.idpedido, t3.email, t1.pedido_fechacreacion, t1.pedido_total, t2.tipo_pago, t1.pedido_direccionentrega FROM pedido t1
             INNER JOIN tipo_pago t2
              on t1.tipo_pago = t2.idtipo_pago
              INNER JOIN usuario t3
              on t1.idusuario = t3.idusuario
              WHERE t1.idrestaurante = :idrestaurante
              AND t1.pedido_estado = 1
              ORDER BY t1.idpedido DESC";
        
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':idrestaurante', $idrestaurante);


            $stmt->execute();

            return $stmt->fetchAll();


        }catch(Exception $e){
            
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }

    
    }

    public function aceptarPedido($idpedido){
        $conexion = Conexion::conectar();

        try{
            $conexion->beginTransaction();

            $query = "UPDATE pedido
            SET pedido_estado = 2, pedido_fechaaceptado = NOW()          
            WHERE idpedido = :idpedido";
             

            $stmt = $conexion->prepare($query);

            $stmt->bindValue(':idpedido', $idpedido);
            

            if($stmt->execute()){

                $conexion->commit();

                return 'exito';                
            
            }

        }catch(Exception $e){
            $conexion->rollBack();
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }
    }

}