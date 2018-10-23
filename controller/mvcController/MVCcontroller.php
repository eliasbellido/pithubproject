<?php
ob_start();

class MVCcontroller{

    public function plantilla(){
        include 'view/template.php';
    }

    public function dashboard(){
        if(isset($_SESSION['userEmail'])){
            include 'view/dashboard/dashtemplate.php';
        }
    }

    public function enlacesPaginasController(){

      //  echo ' en funcion ';
        
        if(isset($_GET["action"])){
            $enlacesController = $_GET["action"];
        }else{
            $enlacesController = "index";
        }

       // echo $enlacesController.': ';

        $respuesta = Paginas::enlacesPaginasModel($enlacesController);
        require_once $respuesta;
    }
    
}