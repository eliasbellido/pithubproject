<?php

class Paginas{

    public function enlacesPaginasModel($enlaces){

        if($enlaces == "registrarRestaurante"){
            $module = "view/modules/restaurantes/registrarRestaurante.php";
        }
        else if($enlaces =="inicio"){
            $module = "view/modules/restaurantes/listarRestaurantes.php";
        }
        else if($enlaces == "okRestaurante"){

			$module =  "view/modules/restaurantes/registrarRestaurante.php";
		
        }
        else if($enlaces =="restaurante"){
            $module =  "view/modules/restaurantes/restaurante.php";

        }
        
        //login
        else if($enlaces == "admin"){
            if(isset($_SESSION['userEmail']) &&$_SESSION['userTipo']==2){
                $module = "view/dashboard/modules/mirestaurante.php";
            }else if (isset($_SESSION['userEmail']) &&$_SESSION['userTipo']==1){

                $module = "view/dashboard/modules/solicitudesnuevas.php";
            }else{
                //TODO: redirigir pagina donde indica que debe estar logueado
                //$module = "view/modules/restaurantes/listarRestaurantes.php";
                header('location:inicio');
            }
        }
        else if($enlaces == "salir"){
            
             $_SESSION = array();

             unset($_SESSION['userEmail']); 
             unset($_SESSION['userTipo']); 
             session_destroy();
           
             header('location:inicio');
           // $module = "view/modules/restaurantes/listarRestaurantes.php";
            //$module = "index.php";

        }


        //dashboard navegación


        else if($enlaces == "miRestaurante"){
            if(isset($_SESSION['userEmail'])){

            $module = "view/dashboard/modules/mirestaurante.php";
            }else{
                header('location:inicio');
            }
        }
        else if($enlaces == "misproductos"){
            if(isset($_SESSION['userEmail'])){

                $module = "view/dashboard/modules/misproductos.php";
                }else{
                    header('location:inicio');
                }
        }
        else if($enlaces == "nuevasolicitudes"){
            if(isset($_SESSION['userEmail'])){

                $module = "view/dashboard/modules/solicitudesnuevas.php";
                }else{
                    header('location:inicio');
                }
        }
        else if($enlaces == "nuevospedidos"){
            if(isset($_SESSION['userEmail'])){

                $module = "view/dashboard/modules/nuevospedidos.php";
                }else{
                    header('location:inicio');
                }
        }


        else{

            if(isset($_SESSION['userEmail'])){
                $module = "view/dashboard/modules/mirestaurante.php";

            }else{
                $module = "view/modules/restaurantes/listarRestaurantes.php"; 
            }
        }
      //  print $module;
        //echo $module;
        return $module;
    }
}

?>
