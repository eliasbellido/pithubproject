<?php
require_once 'model/conexion.php';

class ProductoModel{

    public function obtenerProductos($idRest){

        try{
            $conexion = Conexion::conectar();

            $sql = "SELECT t3.nomrestaurante, t1.nomproducto, t2.nomcategoria, t1.calorias, t1.precio, t1.imagenproducto
            FROM restaurante_producto t1 
            INNER JOIN categoria t2
             on t1.idcategoria = t2.idcategoria
              INNER JOIN restaurante t3
              on t1.idrestaurante = t3.idrestaurante
              WHERE t1.idrestaurante = :idrest";

            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':idrest', $idRest);

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);  


            return $stmt->fetchAll();


        }catch(Exception $e){
            
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }

    
    }

    public function obtenerMisProductos($usuario){

        try{
            $conexion = Conexion::conectar();

            $sql = "SELECT t1.id, t3.nomrestaurante, t1.nomproducto, t2.nomcategoria, t1.calorias, t1.precio, t1.imagenproducto
            FROM restaurante_producto t1 
            INNER JOIN categoria t2
             on t1.idcategoria = t2.idcategoria
              INNER JOIN restaurante t3
              on t1.idrestaurante = t3.idrestaurante
              WHERE t3.email = :email";

            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':email', $usuario);

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);  


            return $stmt->fetchAll();


        }catch(Exception $e){
            
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }

    
    }

    public function obtenerProducto($idProd){

        try{
            $conexion = Conexion::conectar();

            $sql = "SELECT t1.id, t3.nomrestaurante, t1.nomproducto, t2.nomcategoria, t1.calorias, t1.precio, t1.imagenproducto
            FROM restaurante_producto t1 
            INNER JOIN categoria t2
             on t1.idcategoria = t2.idcategoria
            WHERE t1.id = :idProd
             ";

            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':idProd', $usuario);

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);  


            return $stmt->fetchAll();


        }catch(Exception $e){
            
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }

    }

    public function actualizarProducto($datosModel){

        $conexion = Conexion::conectar();
        $miVar;

        try{
            $conexion->beginTransaction();

            $imgProducto = $datosModel['imgProducto'];

            if(($imgProducto['size'][0] > 0)){//si hay imagen seleccionada

            
                $query = "UPDATE restaurante_producto
                    SET nomproducto = :nomproducto,
                    idcategoria = :idcategoria,
                    calorias = :calorias,
                    precio = :precio,
                    imagenproducto = :imgprod
                    WHERE id = :id";              
                      


                $stmt = $conexion->prepare($query);

                $nomProducto = $datosModel['nomproducto'];
                $nomPersonalizadoProd = trim($datosModel['email'],' ').'_prod';

                $nombreImgProd = RestauranteModel::subirImgProductos($imgProducto,$nomPersonalizadoProd,0);


                $stmt->bindValue(':nomproducto', $nomProducto);
                $stmt->bindValue(':idcategoria', $datosModel['idProductoCate']);
                $stmt->bindValue(':calorias', $datosModel['calorias']);
                $stmt->bindValue(':precio', $datosModel['precio']);
                $stmt->bindParam(':imgprod', $nombreImgProd);
            
                $stmt->bindValue(':id', $datosModel['idProducto']);
                //$stmt->bindValue(':restaurante_fecharegistro',$datosModel['fecharegistro']);


                if($stmt->execute()){

                    self::removerImagen($datosModel['oldimgProducto']);

                    

                    $conexion->commit();
        
                    return 'exito1'; //con imagen
                    
                
                }
               
            }else{ //sí no hay imagen seleccionada

        
                $query = "UPDATE restaurante_producto
                        SET nomproducto = :nomproducto,
                        idcategoria = :idcategoria,
                        calorias = :calorias,
                        precio = :precio
                        WHERE id = :id";
                

                $stmt = $conexion->prepare($query);

                $nomProducto = $datosModel['nomproducto'];
            // $nombreImgLogoRest = $datosModel['imagen']['name'];

                $stmt->bindValue(':nomproducto', $nomProducto);
                $stmt->bindValue(':idcategoria', $datosModel['idProductoCate']);
                $stmt->bindValue(':calorias', $datosModel['calorias']);
                $stmt->bindValue(':precio', $datosModel['precio']);
            
                $stmt->bindValue(':id', $datosModel['idProducto']);
                //$stmt->bindValue(':restaurante_fecharegistro',$datosModel['fecharegistro']);


                if($stmt->execute()){

                    $conexion->commit();
        
                    return 'exito0'; //sin imagen
                    
                
                }
            }

     

        }catch(Exception $e){
            $conexion->rollBack();
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }
    }

    public function removerImagen($file){
               
        
        if(file_exists($file)){            
            unlink($file);
            return 1; //se eliminó
        }else{
            return 0; //no se eliminó
        }
    }
    
}