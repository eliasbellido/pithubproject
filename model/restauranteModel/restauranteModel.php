<?php

/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'util/phpmail/Exception.php';
require_once 'util/phpmail/PHPMailer.php';
require_once 'util/phpmail/SMTP.php';

require_once 'model/conexion.php';

class RestauranteModel{

    public function listarRestaurantes($vigente){

        try{
            $conexion = Conexion::conectar();

            $sql = "SELECT * FROM restaurante t1
             INNER JOIN tipo_restaurante t2
              on t1.idtipo_restaurante = t2.idtipo_restaurante
              WHERE t1.vigente = :vigente";
        
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':vigente', $vigente);


            $stmt->execute();

            return $stmt->fetchAll();


        }catch(Exception $e){
            
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }

    
    }

    public function obtenerRestaurante($email){

        try{
            $conexion = Conexion::conectar();

            $sql = "SELECT * FROM restaurante t1 
            INNER JOIN tipo_restaurante t2
             on t1.idtipo_restaurante = t2.idtipo_restaurante
              INNER JOIN usuario t3
              on t1.email = t3.email
              WHERE t1.email = :email";

            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':email', $email);

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);  


            return $stmt->fetch();


        }catch(Exception $e){
            
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }

    
    }

    public function obtenerTipoRest(){
        try{
            $conexion = Conexion::conectar();

            $sql = "SELECT * FROM tipo_restaurante t1";
        
            $stmt = $conexion->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();


        }catch(Exception $e){
            
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }
    }



    public function registrarRestaurante($datosModel){

        $conexion = Conexion::conectar();

        try{
            $conexion->beginTransaction();

            $query = "INSERT INTO restaurante (nomrestaurante, descripcionrestaurante, imagen, idtipo_restaurante, direccion, iddistrito, email, restaurante_fecharegistro, vigente) VALUES (:nomrestaurante,:descripcionrestaurante, :imagen, :idtipo_restaurante, :direccion, :iddistrito, :email, NOW(), :vigente)";

            $stmt = $conexion->prepare($query);

            $nomRest = $datosModel['nomrestaurante'];
            $nombreImgLogoRest = $datosModel['imagen']['name'];
            $email = $datosModel['email'];
            $claveUsuario = $datosModel['clave'];
            
            $stmt->bindValue(':nomrestaurante', $nomRest);
            $stmt->bindValue(':descripcionrestaurante', $datosModel['descripcionrestaurante']);
            $stmt->bindParam(':imagen', $nombreImgLogoRest);
            $stmt->bindValue(':idtipo_restaurante', $datosModel['idtipo_restaurante']);
            $stmt->bindValue(':direccion', $datosModel['direccion']);
            $stmt->bindValue(':iddistrito', $datosModel['iddistrito']);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':vigente', $datosModel['esvigente']);
            //$stmt->bindValue(':restaurante_fecharegistro',$datosModel['fecharegistro']);

            $nomPersonalizadoRest = trim($email,' ').'_logo';

            $nombreImgLogoRest = self::subirLogotipo($datosModel['imagen'],$nomPersonalizadoRest);


            if($nombreImgLogoRest != null && $stmt->execute()){

                $idrest = $conexion->lastInsertId();

                self::registrarProductos($datosModel,$idrest,$conexion);

                    self::registrarUsuario($datosModel,$conexion);
                    $conexion->commit();
    
    
                    self::sendMail($nomRest,$email,$claveUsuario);
                    return 'exito';
                
            
            }

            

        }catch(Exception $e){
            $conexion->rollBack();
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }
    }

    public function admitirRestaurante($idRest){
        $conexion = Conexion::conectar();

        try{
            $conexion->beginTransaction();

            $query = "UPDATE restaurante
            SET vigente = 1, restaurante_fechaaceptado = NOW()          
            WHERE email = :idrest";
             

            $stmt = $conexion->prepare($query);

            $stmt->bindValue(':idrest', $idRest);
            

            if($stmt->execute()){

                $conexion->commit();

                return 'exito';                
            
            }

        }catch(Exception $e){
            $conexion->rollBack();
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }
    }

    public function actualizarRestaurante($datosModel){

        $conexion = Conexion::conectar();

        try{
            $conexion->beginTransaction();

            $query = "UPDATE restaurante
            SET nomrestaurante = :nomrestaurante,
             descripcionrestaurante = :descripcionrestaurante,
             direccion = :direccion,
             idtipo_restaurante = :idtipo_restaurante
            WHERE email = :email";
             

            $stmt = $conexion->prepare($query);

            $nomRest = $datosModel['nomrestaurante'];
           // $nombreImgLogoRest = $datosModel['imagen']['name'];
            $email = $datosModel['email'];

            $stmt->bindValue(':nomrestaurante', $nomRest);
            $stmt->bindValue(':descripcionrestaurante', $datosModel['descripcionrestaurante']);
            //$stmt->bindParam(':imagen', $nombreImgLogoRest);
            $stmt->bindValue(':idtipo_restaurante', $datosModel['idtipo_restaurante']);
            $stmt->bindValue(':direccion', $datosModel['direccion']);
           // $stmt->bindValue(':iddistrito', $datosModel['iddistrito']);
            $stmt->bindValue(':email', $email);
            //$stmt->bindValue(':restaurante_fecharegistro',$datosModel['fecharegistro']);


            if($stmt->execute()){

                $conexion->commit();
    
                return 'exito';
                
            
            }

            

        }catch(Exception $e){
            $conexion->rollBack();
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }
    }

    public function registrarUsuario($dataModel,$cnx){

        $query = "INSERT INTO usuario (email, clave, idtipo_usuario, vigente)
        VALUES (:email, :clave, :idtipo_usuario, :vigente)";

        

        $stmt = $cnx->prepare($query);

        $stmt->bindValue(':email', $dataModel['email']);
        $stmt->bindValue(':clave', $dataModel['clave']);
        $stmt->bindValue(':idtipo_usuario', $dataModel['tipo_usuario']);
        $stmt->bindValue(':vigente', $dataModel['esvigente']);

        if ($stmt-> execute()){
            return '1';
        }else{
            return '0';
        }

        
        
        


    }

    public function registrarProductos($dataModel,$idrest,$cnx){

        //            $imagenProductos = $_FILES['thumbnail'];


        $totalProductos = count($dataModel['imagenProductos']['name']);
        
        $query = "INSERT INTO restaurante_producto (idrestaurante, nomproducto, idcategoria, calorias, imagenproducto, precio, producto_fecharegistro) 
        VALUES (:idrestaurante,:nomproducto, :idcategoria, :calorias, :imagenproducto, :precio, NOW())";


        $imagenProducto = $dataModel['imagenProductos'];

        $nomPersonalizadoRest = trim($dataModel['email'],' ').'_prod';

        for($i = 0 ; $i < $totalProductos ; $i++){

   
            $nombreImgProd = self::subirImgProductos($imagenProducto,$nomPersonalizadoRest,$i);
            
            //linkeando los parametros con el query
            $data = array(
                ':idrestaurante'=> $idrest,
                ':nomproducto'=> $dataModel['producto'][$i],
                ':idcategoria'=> $dataModel['idcategoria'][$i],
                ':calorias'=> $dataModel['calorias'][$i],
                ':imagenproducto'=> $nombreImgProd,
                ':precio'=> $dataModel['precio'][$i]
                //':p_fecharegistro'=>$dataModel['fecharegistro'][$i]              
            );
           

            $stmt = $cnx->prepare($query);
            $result2 = $stmt->execute($data);

            
        }

    }

    public function registrarProductoCnx($dataModel){

        //            $imagenProductos = $_FILES['thumbnail'];

        $conexion = Conexion::conectar();

        try{
            $conexion->beginTransaction();

            $totalProductos = count($dataModel['imagenproducto']['name']);
            
            $query = "INSERT INTO restaurante_producto (idrestaurante, nomproducto, idcategoria, calorias, imagenproducto, precio, producto_fecharegistro) 
            VALUES (:idrestaurante,:nomproducto, :idcategoria, :calorias, :imagenproducto, :precio, NOW())";


            $imagenProducto = $dataModel['imagenproducto'];

            $nomPersonalizadoRest = trim($dataModel['email'],' ').'_prod';

            for($i = 0 ; $i < $totalProductos ; $i++){

    
                $nombreImgProd = self::subirImgProductos($imagenProducto,$nomPersonalizadoRest,$i);
                
                //linkeando los parametros con el query
                $data = array(
                    ':idrestaurante'=> $dataModel['idRest'],
                    ':nomproducto'=> $dataModel['producto'][$i],
                    ':idcategoria'=> $dataModel['idcategoria'][$i],
                    ':calorias'=> $dataModel['calorias'][$i],
                    ':imagenproducto'=> $nombreImgProd,
                    ':precio'=> $dataModel['precio'][$i]
                    //':p_fecharegistro'=>$dataModel['fecharegistro'][$i]              
                );
                

                $stmt = $conexion->prepare($query);
                
                if($stmt->execute($data)){
                    $conexion->commit();
                   
                    return 'exito' ;
                }
                
            }
        }catch(Exception $e){
            $conexion->rollBack();
            return 'error'.$e;
        }finally{
            $stmt = null;
            $conexion = null;
        }

    }


    public function subirImgProductos($imgProducto, $id, $contador ){

       // $imgsProds = $imgProducto['name'];
        $folder = "uploads/";
        $rutaEnBd = "uploads/";

        $nuevoNombre = self::stringURLSafe($imgProducto['name'][$contador]);

        $prefijo = self::uniqueId(4);

       // echo ''.$id.$prefijo.$nuevoNombre;

        $path = $folder.$id.$prefijo.$nuevoNombre;
       

        $allowed = array('jpeg','png','jpg');
        $filename = $nuevoNombre;

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext,$allowed)){
            echo "Solo formatos de archivo JPG, JPEG, PNG y GIF son permitidos";
            return;
        }else{
           $resultado = move_uploaded_file($imgProducto['tmp_name'][$contador],$path);
           return ($resultado) ? $rutaEnBd.$id.$prefijo.$filename:null;

        }

    }
    public function subirLogotipo($logotipoFile,$id){

        $folder = "uploads/";
        $rutaEnBd = "uploads/";

        $nuevoNombre = self::stringURLSafe($logotipoFile['name']);

        $prefijo = self::uniqueId(4);

        //echo ''.$id.$prefijo.$nuevoNombre;

        $path = $folder.$id.$prefijo.$nuevoNombre;
       

        $allowed = array('jpeg','png','jpg');
        $filename = $nuevoNombre;

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext,$allowed)){
            echo "Solo formatos de archivo JPG, JPEG, PNG y GIF son permitidos";
            return;
        }else{
           $resultado = move_uploaded_file($logotipoFile['tmp_name'],$path);
           return ($resultado) ? $rutaEnBd.$id.$prefijo.$filename:null;

        }
    }

    // Esta funcion nos limpiara el nombre del archivo eliminando cualquier caracter raro
    function stringURLSafe($string){
        $str = str_replace('-', ' ', $string);
        $str = str_replace('_', ' ', $string);
        //$str = str_replace('.', ' ', $string);
        $str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('','.'), $str);
        $str = trim(strtolower($str));
        return $str;
    }
    // Mi version cuando quiero generar un id unico de longitud fija :)
    function uniqueId($l = 8) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }

    public function sendMail($nomRest, $destinatario, $clave){


        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
           // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'pithubproject@gmail.com';                 // SMTP username
            $mail->Password = 'pit@bellido';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('non-reply@gmail.com'); //se tiene que configurar este correo desde gmail para que envie desde ese from dado
            $mail->addAddress($destinatario);     // Add a recipient              // Name is optional
            $mail->addReplyTo('elias.bellido@holascharff.com');


            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Registro de nuevo usuario';
            $mail->Body    = 'Hola <b>'.$nomRest.'!</b><br>
                            <br>Gracias por registrarte, a continuación podrás hacer uso de estas
                            <br> credenciales para ingresar una vez que tu solicitud sea aceptada.
                            <br><br>Usuario: '.$destinatario.
                            '<br>Clave: '.$clave                            
                            ;
            $mail->AltBody = 'Tus credenciales -> Usuario: '.$destinatario.' Clave: '.$clave;

            $mail->send();
            return 'Message has been sent';
        } catch (Exception $e) {
            return 'Message could not be sent.'.'/Mailer Error: ' . $mail->ErrorInfo;
        }   
    }

    public function sendMailAceptado($nomRest, $destinatario){


        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
           // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'pithubproject@gmail.com';                 // SMTP username
            $mail->Password = 'pit@bellido';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('non-reply@gmail.com'); //se tiene que configurar este correo desde gmail para que envie desde ese from dado
            $mail->addAddress($destinatario);     // Add a recipient              // Name is optional
            $mail->addReplyTo('elias.bellido@holascharff.com');


            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Solicitud aceptada';
            $mail->Body    = 'Hola <b>'.$nomRest.'!</b><br>
                            <br>Tenemos buenas noticias!
                            <br>Tu solicitud ha sido sea aceptada y ya puedes visualizar tu restaurante en nuestra web.'                                                                  
                            ;
            $mail->AltBody = 'Tu solicitud ha sido aceptada!';

            $mail->send();
            return 'Message has been sent';
        } catch (Exception $e) {
            return 'Message could not be sent.'.'/Mailer Error: ' . $mail->ErrorInfo;
        }   
    }
    
}