<?php
    
    
    session_start();


    require '../conexion.php';
    require '../util/PHPMailer.php';




    if(isset($_POST["nombrerestaurant"])){
        
        //inicar la transaccion
        $db->beginTransaction();

        try{

        $restaurant = $_POST['nombrerestaurant'];
        $descrestaurant = $_POST['descrestaurant'];
        $tiporestaurant = $_POST['idtipo_restaurante'];
        $direccion = $_POST['direcrestaurant'];
        $distrito = $_POST['iddistrito'];
        $email = $_POST['email'];
        

        //mover imagenes a la carpeta uploads
        $folder = "../uploads/";

        $logotipo = $_FILES['logotiporest']['name'];


        $path = $folder . $logotipo;
        $target_file = $folder.basename($_FILES["logotiporest"]["name"]);

        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        $allowed = array('jpeg','png','jpg');
        $filename = $_FILES['logotiporest']['name'];

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext,$allowed)){
            echo "Solo formatos de archivo JPG, JPEG, PNG y GIF son permitidos";
            return;
        }else{
            move_uploaded_file($_FILES['logotiporest']['tmp_name'],$path);

        }

        $sql = "INSERT INTO restaurante (nomrestaurante, descripcionrestaurante, imagen, idtipo_restaurante, direccion, iddistrito, email) VALUES (:nomrestaurante,:descripcionrestaurante, :imagen, :idtipo_restaurante, :direccion, :iddistrito, :email)";

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':nomrestaurante', $restaurant);
        $stmt->bindValue(':descripcionrestaurante', $descrestaurant);
        $stmt->bindValue(':imagen', $logotipo);
        $stmt->bindValue(':idtipo_restaurante', $tiporestaurant);
        $stmt->bindValue(':direccion', $direccion);
        $stmt->bindValue(':iddistrito', $distrito);
        $stmt->bindValue(':email', $email);


        $result = $stmt->execute();


        //insertar restaurant_producto

        $idrest = $db->lastInsertId();
        $idcat = $_POST['idcategoria'];
        $producto = $_POST['producto'];
        $calorias = $_POST['calorias'];


        $sql2 = "INSERT INTO restaurante_producto (idrestaurante, nomproducto, idcategoria, calorias, imagenproducto) 
        VALUES (:idrestaurante,:nomproducto, :idcategoria, :calorias, :imagenproducto)";


        $countfiles = count($_FILES['thumbnail']['name']);

        for($i = 0 ; $i < $countfiles ; $i++){

            //mover imagenes a la carpeta uploads
            $folder = "../uploads/";

            $thumbnail = $_FILES['thumbnail']['name'][$i];


            $path = $folder . $thumbnail;
            $target_file = $folder.basename($_FILES["thumbnail"]["name"][$i]);

            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            $allowed = array('jpeg','png','jpg');
            $filename = $_FILES['thumbnail']['name'][$i];

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!in_array($ext,$allowed)){
                echo "Solo formatos de archivo JPG, JPEG, PNG y GIF son permitidos";
                return;
            }else{
                move_uploaded_file($_FILES['thumbnail']['tmp_name'][$i],$path);

            }

            //linkeando los parametros con el query
            $data = array(
                ':idrestaurante'=> $idrest,
                ':nomproducto'=> $producto[$i],
                ':idcategoria'=> $idcat[$i],
                ':calorias'=> $calorias[$i],
                ':imagenproducto'=> $thumbnail                
            );

            $stmt2 = $db->prepare($sql2);
            $result2 = $stmt2->execute($data);
        }

        

        if($result && $result2){

            echo '
            <div class="alert alert-success">
             Data Successfully Inserted
            </div>
            ';

            $db->commit();

        }
        
        

        }catch(Exception $e){
            $db->rollBack();
        }finally{
            $stmt = null;
            $stmt2 = null;
        }

        


    }
   
    
?>