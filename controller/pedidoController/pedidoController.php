<?php
ob_start();

 

class PedidoController{

    public function listarPedidosNuevos(){

    $respuesta = PedidoModel::listarPedidosNuevos($_SESSION['userRestId']);
    
        foreach($respuesta as $row){
            echo '
    
            <tr class="hidden">
                          <td data-name="name">
                              <input type="text" name="cli_email"  placeholder="Email del cliente" class="form-control" value="'.$row['email'].'" readonly/>
                          </td>
                          <td data-name="mail">
                              <input type="text" name="pedido_fechacreacion" placeholder="Fecha de creación" class="form-control" value="'.$row['pedido_fechacreacion'].'" readonly/>
                          </td>
                          
                          <td data-name="desc">
                              <input type="text" name="pedido_total" placeholder="Monto total" class="form-control" value="'.$row['pedido_total'].'" readonly/>
                          </td>
                          <td data-name="desc">
                              <input type="text" name="pedido_tipopago" placeholder="Tipo pago" class="form-control" value="'.$row['tipo_pago'].'" readonly/>
                          </td>
                          <td data-name="desc">
                              <input type="text" name="pedido_direntrega" placeholder="Dirección de la entrega" class="form-control" value="'.$row['pedido_direccionentrega'].'" readonly/>
                          </td>
                          <td data-name="del">
                          
                              <center>
                                  <a name="del0" class="fa fa-check btn btn-info" href="index.php?action=nuevospedidos&idpedido='.$row['idpedido'].'"></a>
                              </center>
                          
                          </td>

                        
                      </tr>
            
            ';
        }
    
       
     }

     public function aceptarPedido(){

   
        //sendMailAceptado($nomRest, $destinatario);
    
          if (isset($_GET['idpedido'])) {
            $idPedido = $_GET['idpedido'];
                    
            /*
            $nomRest = $restaur['nomrestaurante'];
            $destinatario = $restaur['email'];
            $estadoRest = $restaur['restaurante_fechaaceptado'];*/
             
          $respuesta = PedidoModel::aceptarPedido($idPedido);
            if ($respuesta == 'exito') {
                if($estadoRest != null){ 
                    header('location:nuevospedidos');
                }else{
                    //RestauranteModel::sendMailAceptado($nomRest, $destinatario);
                    header('location:nuevospedidos');
                }
            
            }
          }
    
      }

}