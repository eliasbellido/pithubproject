<?php
ob_start();


class ProductoController{

    
    //para el main front
    public function obtenerProductos(){

        $idRest = $_GET['idrest'];

            
            $respuesta = ProductoModel::obtenerProductos($idRest);

            $categorias = array(); //Nuevo array vacio

            //Este primer foreach recupera toda la data del productoModel y lo ordena según su categoría
            foreach ( $respuesta as $producto ) {
                if(!array_key_exists($producto['nomcategoria'],$categorias)){ //check si la categoria ya existe
                    $categorias[$producto['nomcategoria']] = array(); //crea el array indexado con el nombre de categoria
                }
                $categorias[$producto['nomcategoria']][] = $producto; //agrega el producto a la categoría
               
            }


            //Este nested foreach imprime en la pagina los productos según categoría del nuevo array creado arriba.
            foreach($categorias as $categoria => $prods){
                echo '
                <div class="title">  '.ucfirst($categoria).' </div>
            ';

                foreach($prods as $prod){
                    echo '                    
                    
                    <div class="item">      
        
                            <div class="logoContainer">
                            <img src='.$prod['imagenproducto'].' alt="" class="logoRestaurante"/>
                            </div>
        
                            <div class="description">
                            <span>'.ucwords($prod['nomproducto']).'</span>
                            <span>'.ucfirst(strtolower($prod['nomcategoria'])).'</span>
                            
                            </div>

                            <div class="total-price">S/'.$prod['precio'].'</div>
                            
        
                    </div>
                    
                    ';
                }

            }
       
    }

    public function listarMisProductos(){
   
        $respuesta = ProductoModel::obtenerMisProductos($_SESSION['userEmail']);

        //var_dump($respuesta);
        foreach($respuesta as $row){
            echo '
  
            <tr class="hidden">
                          <td class="align-middle" data-name="productoName">
                              <input type="text" name="prod_nom"  placeholder="Nombre del producto" class="form-control" value="'.$row['nomproducto'].'" readonly/>
                          </td>
                          <td class="align-middle" data-name="productoPrice">
                              <input type="text" name="prod_pre" placeholder="Precio" class="form-control" value="'.$row['precio'].'" readonly/>
                          </td>
                          <td class="align-middle" data-name="productoCategoria">
                              <input type="text" name="prod_cate" placeholder="Categoría" class="form-control" value="'.$row['nomcategoria'].'" readonly/>
                          </td>
                          <td class="align-middle" data-name="productoImagen">
                            <center>
                            <img src='.$row['imagenproducto'].' alt=""  class="logoRestaurante"/>
                            </center>
                          </td>
                          <td class="align-middle" data-name="del">
                          
                              <center>
                                  <a name="del0" class="fa fa-pencil btn btn-info editar_prod" data-idprod="'.$row['id'].'" data-toggle="modal" data-target="#editarProductoModal" href="#"></a>
                              </center>
                          
                          </td>
                      </tr>
            
            ';
        }
  
       
    }

    public function obtenerProducto(){

    }

    public function actualizarProducto(){
   

        if(isset($_POST['modal_productonombre'])){
          
            echo'<script type="text/javascript">
         console.log( "entro al metodo" ); 
       
        </script>';
  
            //productos campo
            $producto = $_POST['modal_productonombre'];
            $categoriaProd = $_POST['idcategoria'];
            $caloriaProd = $_POST['modal_productocalorias'];
            $precioProd = $_POST['modal_productoprecio'];
            
            $idProd = $_POST['modal_idproducto'];
  
            //imagen
            $oldimagenProd = $_POST['modal_currentproductoimg']; //foto antigua
            $imagenProd = $_FILES['modal_editproductoimage']; //foto nueva a reemplazar
  
            $datosController = array("nomproducto"=> $producto,
                               "idProductoCate"=>$categoriaProd,
                                 "oldimgProducto"=>$oldimagenProd,
                                 "imgProducto"=>$imagenProd,
                                 "calorias"=>$caloriaProd,
                                 "precio"=>$precioProd,                                 
                                 "idProducto"=>$idProd,
                                 "email"=>$_SESSION['userEmail']                                
                                 );
  
            $rpta = ProductoModel::actualizarProducto($datosController);
                
            //var_dump($rpta);
           
            if($rpta == 'exito0' || $rpta =='exito1'){ // 0:sin imagen; 1:con imagen
                //echo 'se actualizò';
                header('location:misproductos');
                //header('location:registrarRestaurante');
            }else{
                header('location:admin');
  
            }
                                     
  
        }
    }

    public function registrarNuevoProducto(){

        if(isset($_POST['modal_newproductonombre'])){
            $rest = RestauranteModel::obtenerRestaurante($_SESSION['userEmail']);
            
             $idRest =$rest['idrestaurante'];

             //insertar producto
             $producto = $_POST['modal_newproductonombre'];
             $categoriaProd = $_POST['idcategoria'];
             $caloriaProd = $_POST['modal_newproductocalorias'];
             $precioProd = $_POST['modal_newproductoprecio'];
             
   
             //imagen
             $imagenProd= $_FILES['modal_newproductoimage'];
   
             $datosController = array("producto"=> $producto,
                                "idcategoria"=>$categoriaProd,
                                  "imagenproducto"=>$imagenProd,
                                  "calorias"=>$caloriaProd,
                                  "precio"=>$precioProd,                       
                                  "idRest"=>$idRest,
                                  "email"=>$_SESSION['userEmail']                            
                                  );

           // echo 'los datos del controller: '.var_dump($datosController);                                  
   
             $rpta = RestauranteModel::registrarProductoCnx($datosController);
                    
             if($rpta == 'exito'){                                
                 header('location:misproductos');                 
             }else{
                 header('location:admin');
   
             }



        }
      

        

    }
    
     
 

    
}