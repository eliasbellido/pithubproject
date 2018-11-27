
<?php


require '../model/conexion.php';

if(isset($_POST["user_email"])){
    
        /*
    $username = mysqli_real_escape_string($connect, $_POST["user_email"]);
    $query = "SELECT * FROM users WHERE username = '".$username."'";
    $result = mysqli_query($connect, $query);
    echo mysqli_num_rows($result);*/
    try{

        $conexion = Conexion::conectar();

                // $respuestaTR = RestauranteModel::obtenerTipoRest();
                // var_dump($respuestaTR);
    
                $sql = "SELECT *
                FROM usuario WHERE email = :email
                 ";
    
                $stmt = $conexion->prepare($sql);
                $stmt->bindValue(':email', $_POST['user_email']);
    
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);  
    
    
                $userEmail = $stmt->fetch();

                if($userEmail){
                    echo 1;
                }

    }catch(Exception $e){
                    
        return var_dump($e);
    }finally{
        $stmt = null;
        $conexion = null;
    }
}

?>
