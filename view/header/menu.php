<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>PitHub Project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="stylesheet" href="/pitrestaurant/css/headerstyle.css" type="text/css">
        <link rel="stylesheet" href="/pitrestaurant/css/style.css" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="/pitrestaurant/js/repeater.js" type="text/javascript"></script>
    </head>
    
    <body class="site">

        <header>
            <div class="containerNav">

                <h1 class="logo">PitHub<span>Project</span></h1>
               
                <nav class="site-nav">
                    <ul>
                        <li><a href="inicio"><i class="fa fa-home site-nav--icon"></i>Inicio</a></li> 
                        <li><a href="registrarRestaurante"><i class="fa fa-info site-nav--icon"></i>Registrate</a></li>
                        <?php if (!isset($_SESSION['userEmail'] )): ?>
                            <li><a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil site-nav--icon"></i>Iniciar Sesión</a></li>
                        <?php else: ?>
                            <li><a href="admin"><i class="fa fa-pencil site-nav--icon"></i><?php echo $_SESSION['userEmail'] ;?></a></li>

                        <?php endif ?>

                        
                       
                        
                    </ul> 
                </nav>
                
                <div class="menu-toggle">
                    <div class="hamburger"></div>
                </div>
            
            </div>

        </header>

        		   <?php require 'view/modal/modal_login.php'; ?>


  
 
       