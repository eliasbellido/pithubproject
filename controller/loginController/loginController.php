<?php
ob_start();

//require_once 'model/restauranteModel/restauranteModel.php';
class LoginController{

   
    public function validarCredenciales(){

        $usuario = $_POST['username'];
        $clave = $_POST['password'];

        $datosController = array("email" => $usuario, "clave" => $clave);

        $rpta = LoginModel::validarCredenciales($datosController);

        if($rpta){
            $_SESSION['userEmail'] = $usuario;
            $_SESSION['userTipo'] = $rpta['idtipo_usuario'];
            $_SESSION['userRestId'] = $rpta['idrestaurante'];
            header('location:admin');
        }else{
            header('location:inicio');
        }
    }

    public function cerrarSesion(){

       // session_destroy();
       $_SESSION = array();

       unset($_SESSION['userEmail']); 
       session_destroy();

       header('location:salir');

    }
}