<?php
        
require '../controller/restauranteController/restauranteController.php';

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

    }else{
        echo '<div class="alert alert-danger">
        Hubo un problema a la hora de registrar, por favor vuelve a intentar.
    </div>
    ';

    }
}else{
    echo 'error';
}
?>