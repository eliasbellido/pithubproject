<?php
ob_start();

 

class RestauranteController{

    public function registrarRestaurante(){

        if(isset($_POST['nombrerestaurant'])){
            
            //insertar restaurante
            $restaurant = $_POST['nombrerestaurant'];
            $descrestaurant = $_POST['descrestaurant'];
            $tiporestaurant = $_POST['idtipo_restaurante'];
            $direccion = $_POST['direcrestaurant'];
            $distrito = $_POST['iddistrito'];
            $email = $_POST['email'];

            //imagen
            $logotipo = $_FILES['logotiporest'];

            //insertar restaurant_producto

            $idcat = $_POST['idcategoria'];
            $producto = $_POST['producto'];
            $calorias = $_POST['calorias'];
            $precio = $_POST['precio'];
            //$fechaActual = date('Y-m-d H:i:s');

            //insertar imagenes de los productos
            $imagenProductos = $_FILES['thumbnail'];

            //insertar usuario
            $clave = RestauranteModel::uniqueId(6);
            $tipo_usuario = 2; //corporativo
            $vigente = 0; //recién registrado)              

            $datosController = array("nomrestaurante"=> $restaurant,
   	 		                     "descripcionrestaurante"=>$descrestaurant,
                                 "imagen"=>$logotipo,
                                 "idtipo_restaurante"=>$tiporestaurant,
                                 "direccion"=>$direccion,
                                 "iddistrito"=>$distrito,
                                 "email"=>$email,
                                 "idcategoria"=>$idcat,
                                 "producto"=>$producto,
                                 "calorias"=>$calorias,
                                 "imagenProductos"=>$imagenProductos,
                                 "precio"=>$precio,
                                 //"fecharegistro"=>$fechaActual,
                                 "clave"=>$clave,
                                 "tipo_usuario"=>$tipo_usuario,
                                 "esvigente" => $vigente);

            $rpta = RestauranteModel::registrarRestaurante($datosController);

            if($rpta == 'exito'){
                //return'se registró';
                header('location:okRestaurante');
                //header('location:registrarRestaurante');
            }else{
                header('location:registrarRestaurante');

            }
                                     

        }
    }

    public function actualizarRestaurante(){


      if(isset($_POST['nomRestaurante'])){
        

          //insertar restaurante
          $restaurant = $_POST['nomRestaurante'];
          $descrestaurant = $_POST['descRestaurante'];
          $tiporestaurant = $_POST['tipoRestId'];
          $direccion = $_POST['direcRest'];
          //$distrito = $_POST['iddistrito'];
          //$email = $_POST['email'];

          //imagen
          //$logotipo = $_FILES['logotiporest'];

          $datosController = array("nomrestaurante"=> $restaurant,
                             "descripcionrestaurante"=>$descrestaurant,
                               //"imagen"=>$logotipo,
                               "idtipo_restaurante"=>$tiporestaurant,
                               "direccion"=>$direccion,
                               //"iddistrito"=>$distrito,
                               "email"=>$_SESSION['userEmail']
                               //"idcategoria"=>$idcat,
                               );

          $rpta = RestauranteModel::actualizarRestaurante($datosController);

          if($rpta == 'exito'){
              //echo 'se actualizò';
              header('location:miRestaurante');
              //header('location:registrarRestaurante');
          }else{
              header('location:admin');

          }
                                   

      }
  }


    public function listarAllRestaurantes(){

        $respuesta = RestauranteModel::listarRestaurantes(1);

        foreach($respuesta as $row){
            echo ' <div class="item">
        

                    <div class="logoContainer">
                    <img src='.$row['imagen'].' alt="" class="logoRestaurante"/>
                    </div>

                    <div class="description">
                    <span>'.ucwords($row['nomrestaurante']).'</span>
                    <span>'.ucfirst(strtolower($row['tipo_restaurante'])).'</span>
                    
                    </div>

                    <div class="solicitar">
                    <a data-id="'.$row['idrestaurante'].'" class="btn" role="button" href="index.php?action=restaurante&idrest='.$row['idrestaurante'].'">Visitar</a>
                    

                    
                    </div>

            </div>
            
            ';
        }

       
    }

    public function listarAllRestaurantesAdmision(){

      $respuesta = RestauranteModel::listarRestaurantes(0);

      foreach($respuesta as $row){
          echo '

          <tr class="hidden">
						<td data-name="name">
						    <input type="text" name="nom_rest"  placeholder="Name" class="form-control" value="'.$row['nomrestaurante'].'" readonly/>
						</td>
						<td data-name="mail">
						    <input type="text" name="tipo_rest" placeholder="Tipo Restaurante" class="form-control" value="'.$row['tipo_restaurante'].'" readonly/>
						</td>
						<td data-name="desc">
						    <input type="text" name="email_rest" placeholder="Email" class="form-control" value="'.$row['email'].'" readonly/>
						</td>
                        <td data-name="del">
                        
                            <center>
                                <a name="del0" class="fa fa-check btn btn-info" href="index.php?action=nuevasolicitudes&idres='.$row['email'].'"></a>
                            </center>
                        
                        </td>
					</tr>
          
          ';
      }

     
  }

  public function admitirRestaurante(){

   
    //sendMailAceptado($nomRest, $destinatario);

      if (isset($_GET['idres'])) {
        $idRest = $_GET['idres'];

        $restaur = RestauranteModel::obtenerRestaurante($idRest);

        $nomRest = $restaur['nomrestaurante'];
        $destinatario = $restaur['email'];
        $estadoRest = $restaur['restaurante_fechaaceptado'];
         //  var_dump($nomRest.' '.$destinatario);
      $respuesta = RestauranteModel::admitirRestaurante($idRest);
        if ($respuesta == 'exito') {
            if($estadoRest != null){ 
                header('location:nuevasolicitudes');
            }else{//si tiene fecha null significa que ha sido admitido por 1ra vez
                RestauranteModel::sendMailAceptado($nomRest, $destinatario);
                header('location:nuevasolicitudes');
            }
        
        }
      }

  }

    
    
     public function obtenerRestaurante(){

        $respuestaTR = RestauranteModel::obtenerTipoRest();

        $row = RestauranteModel::obtenerRestaurante($_SESSION['userEmail']);

        $idTipoR = $row['idtipo_restaurante'];

        //var_dump($idTipoR);

        echo'  

        <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail4">Email</label>
          <input type="email" class="form-control" name="email" id="inputEmail4" placeholder="Email" value="'.$row['email'].'" disabled>
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Password</label>
          <input type="password" class="form-control" id="inputPassword4" placeholder="Password" value="'.$row['clave'].'" disabled>
        </div>
      </div>
      <div class="form-group">
        <label for="nomRestaurante">Nombre del restaurante</label>
        <input type="text" class="form-control" name="nomRestaurante" id="nomRestaurante" placeholder="Acá va el nombre del restaurante" value="'.$row['nomrestaurante'].'" disabled >
      </div>
      <div class="form-group">
        <label for="descRestaurante">Descripción del restaurante</label>
        <input type="text" class="form-control" name="descRestaurante" id="descRestaurante" placeholder="Acá va la descripción del restaurante" value="'.$row['descripcionrestaurante'].'" disabled>
      </div>
      <div class="form-row">
      
        <div class="form-group col-md-6">
          <label for="direcRest">Dirección</label>
          <input type="text" class="form-control" name="direcRest" id="direcRest" value="'.$row['direccion'].'" disabled>
        </div>
        <div class="form-group col-md-6">
          <label for="tipoRest">Tipo Restaurante</label>
          <select id="tipoRest" name="tipoRestId" class="form-control" disabled>';
            
            foreach($respuestaTR as $rowTR){

            echo '<option value="'.$rowTR['idtipo_restaurante'].'" '.(($rowTR['idtipo_restaurante']==$idTipoR)?'selected':"").'>'.$rowTR['tipo_restaurante'].'</option>';
            }

            echo '
            
            </select>
        </div>
       
      </div>
    
        
        ';

          
        

        

        

        
    }

    

    
 

    
}