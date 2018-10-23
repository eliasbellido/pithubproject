<?php

session_start();


    require_once 'model/enlaces.php';
    require_once 'model/restauranteModel/restauranteModel.php';
    require_once 'model/loginModel/loginmodel.php';
    
    require_once 'controller/mvcController/MVCcontroller.php';
    require_once 'controller/restauranteController/restauranteController.php';
    require_once 'controller/loginController/loginController.php';
    
    $index = new MVCcontroller();

    
    if(isset($_SESSION['userEmail'])){
       // if (isset($_GET['action'])) {

         //   if ($_GET['action'] == 'admin') {
            //  header('location:view/dashboard/header/menu.php');
            $index->dashboard();
            exit();
       //     }
     //   }
    }else{
        $index->plantilla();
        
    }
        

    

