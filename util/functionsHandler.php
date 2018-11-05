
<?php


require '../model/conexion.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['nombrerestaurant'])  && !empty($_POST['nombrerestaurant'])) {
        
    // echo 'dentro ';
        $restaurante = new RestauranteController();
        $result = $restaurante->registrarRestaurante();
    // echo $result;

        echo '
                <div class="alert alert-success alert-dismissible fade in">
                Felicidades, acabas de registrar tu restaurante.
                <br> Adicionalmente,
                te hemos enviado unas credenciales que te permitirán ingresar a nuestro sistema.
                </div>
                ';

    }
    else if(isset($_POST['prod_id']) && !empty($_POST['prod_id'])){

       

            try{
                $conexion = Conexion::conectar();

                // $respuestaTR = RestauranteModel::obtenerTipoRest();
                // var_dump($respuestaTR);
    
                $sql = "SELECT *
                FROM restaurante_producto t1 
                INNER JOIN categoria t2
                 on t1.idcategoria = t2.idcategoria
                WHERE t1.id = :idProd
                 ";
    
                $stmt = $conexion->prepare($sql);
                $stmt->bindValue(':idProd', $_POST['prod_id']);
    
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);  
    
    
                $producto = $stmt->fetch();
                //sacamos el id del producto para luego compararlo con el select 
                $productoID = $producto['idcategoria'];
    
                $sql = "SELECT * FROM categoria t1";
            
                $stmt = $conexion->prepare($sql);
    
                $stmt->execute();
                $tipoRest = $stmt->fetchAll();

    
                
                
                echo '
                <form  id="frmModalEditarProducto" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" value="'.$producto['id'].'" class="form-control" id="idProd" name="modal_idproducto" placeholder="ID del producto" required="required"/>		
                </div>
                <div class="form-group">
                    <input type="text" value="'.$producto['nomproducto'].'" class="form-control" id="idProd" name="modal_productonombre" placeholder="Nombre del producto" required="required"/>		
                </div>
                <div class="form-group">
                <select id="tipoPro" name="idcategoria" class="form-control"> ';
                
                foreach($tipoRest as $rowTR){
    
                echo 
                 '<option value="'.$rowTR['idcategoria'].'" '.(($rowTR['idcategoria']==$productoID)?'selected':"").'>'
                    .ucwords($rowTR['nomcategoria']).'
                  </option>
                 ';
               
                }
    
                echo '
                
                </select>
                </div>
                <div class="form-group">
                    <input type="text" value="'.$producto['calorias'].'" class="form-control" name="modal_productocalorias" placeholder="Calorías" required="required">	
                </div>         
                <div class="form-group">
                    <input type="text" value="'.$producto['precio'].'" class="form-control" name="modal_productoprecio" placeholder="Precio" required="required">	
                </div>   
                <div class="form-group">
                    <input type="hidden" value="'.$producto['imagenproducto'].'" class="form-control" name="modal_currentproductoimg" placeholder="Precio" required="required">	
                </div>  
                <div class="form-group">
                        <label for="customFileEdit" class="custom-fileLabel">
                            <i class="fa fa-upload"></i>
                            <span id="fileSpanEdit">Cargar una nueva imagen</span>
                        </label>
                        <input type="file" id="customFileEdit" class="form-control" name="modal_editproductoimage[]" />                                                    
                </div>      
                <div class="form-group">
                    <button type="submit" id="btnModalSaveProd" class="btn btn-primary btn-lg btn-block saveProductEdit-btn" name="btnModalGrabarProd">Grabar</button>
                </div>
                </form>
                        ';
            
    
            }catch(Exception $e){
                
                return var_dump($e);
            }finally{
                $stmt = null;
                $conexion = null;
            }
    
       
   
    }else{
        echo 'error';
    }
}

?>

