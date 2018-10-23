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

            //insertar imagenes de los productos
            $imagenProductos = $_FILES['thumbnail'];

            //insertar usuario
            $clave = RestauranteModel::uniqueId(6);
            $tipo_usuario = 2; //corporativo
            $vigente = 1; //activo

                

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

    public function listarAllRestaurantes(){

        $respuesta = RestauranteModel::listarRestaurantes();

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
                    <button class="plus-btn" type="button" name="button" >
                        Pedir ahora
                    </button>
                    
                    </div>

            </div>
            
            ';
        }

       
    }
    public function obtenerRestaurante(){

        $respuesta = RestauranteModel::obtenerRestaurante($_SESSION['userEmail']);

        echo'  

        <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail4">Email</label>
          <input type="email" class="form-control" id="inputEmail4" placeholder="Email" value='.$_SESSION['userEmail'].' readonly>
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Password</label>
          <input type="text" class="form-control" id="inputPassword4" placeholder="Password" value='.$respuesta['clave'].' readonly>
        </div>
      </div>
      <div class="form-group">
        <label for="inputAddress">Nombre del restaurante</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" value='.$respuesta['nomrestaurante'].' readonly>
      </div>
      <div class="form-group">
        <label for="inputAddress2">Descripción del restaurante</label>
        <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" value='.$respuesta['descripcionrestaurante'].' readonly>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputCity">Dirección</label>
          <input type="text" class="form-control" id="inputCity" value='.$respuesta['direccion'].' readonly>
        </div>
        <div class="form-group col-md-6">
          <label for="inputState">Distrito</label>
          <select id="inputState" class="form-control" disabled>
            <option selected>'.$respuesta['tipo_restaurante'].'</option>
            <option>...</option>
          </select>
        </div>
       
      </div>
    
      <button type="submit" class="btn btn-primary">Actualizar</button>
        
        ';

        

        
    }
 

    
}