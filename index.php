<?php

session_start();

    $dir = dirname(__FILE__);
    //var_dump($dir.'/model/enlaces.php');

    require_once $dir.'/model/enlaces.php';
    require_once $dir.'/model/restauranteModel/restauranteModel.php';
    require_once $dir.'/model/restauranteModel/productoModel.php';
    require_once $dir.'/model/pedidoModel/pedidoModel.php';
    require_once $dir.'/model/loginModel/loginmodel.php';
    
    require_once $dir.'/controller/mvcController/MVCcontroller.php';
    require_once $dir.'/controller/restauranteController/restauranteController.php';
    require_once $dir.'/controller/restauranteController/productoController.php';
    require_once $dir.'/controller/pedidoController/pedidoController.php';
    require_once $dir.'/controller/loginController/loginController.php';
    
    $index = new MVCcontroller();

    
    if(isset($_SESSION['userEmail'])){
        //if (isset($_GET['action'])) {

         //   if ($_GET['action'] == 'admin') {
            //  header('location:view/dashboard/header/menu.php');
            $index->dashboard();
           // exit();
       //     }
        
    }else{
        
        $index->plantilla();
        
    }
        

    

