<?php  
 require_once 'view/conexion.php';
?>
    <div class="container">
        <br />
        <h3 align="center">Registro de restaurantes</h3>
        <br />
        <div style="width:100%; max-width: 600px; margin:0 auto;">
            <div class="panel panel-default">
                <div class="panel-heading">Registra tu propio restaurante fácilmente!</div>
                <div class="panel-body">
                    <span id="success_result"></span>
                    <form method="post" id="repeater_form" enctype="multipart/form-data">
							<div class="form-group">
								<label>Nombre de restaurante</label>
								<input type="text" name="nombrerestaurant" id="nombre" class="form-control" required />
                                <label>Descripcion de restaurante</label>
								<input type="text" name="descrestaurant" id="descripcion" class="form-control" />
                                <label>Email</label>
								<input type="text" name="email" id="email" class="form-control" />
                                         
                                <label>Tipo de restaurante</label>
                                <?php             
                                    $consul = $db->query("SELECT * FROM tipo_restaurante order by tipo_restaurante asc");      
                                ?>
								<select type="text" name="idtipo_restaurante" id="tiporestaurant" class="form-control" >
                                <option value=""  required="" >Seleccione</option> 
                                    <?php foreach ($consul as $fila): ?>
                                        <option value="<?php echo $fila['idtipo_restaurante']?>"> 
                                            <?php echo ucwords($fila['tipo_restaurante'])?> 
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <br>
                                <label>Ubicación del restaurante</label>
								<input type="text" name="direcrestaurant" id="direcrestaurant" class="form-control" />
                                <label>Distrito del restaurante</label>
                                <?php             
                                    $consul = $db->query("SELECT * FROM distrito order by nomdistrito asc");      
                                ?>
								<select type="text" name="iddistrito" id="iddistrito" class="form-control" >
                                <option value=""  required="" >Seleccione</option> 
                                    <?php foreach ($consul as $fila): ?>
                                        <option value="<?php echo $fila['iddistrito']?>"> 
                                            <?php echo ucwords($fila['nomdistrito'])?> 
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <label> Logotipo del restaurante</label>
                                     <input type="file" name="logotiporest" id="logotiporest" class="form-control" required />           
                               
							</div>
							<div id="repeater">
								<div class="repeater-heading" align="right">
									<button type="button" class="btn btn-primary repeater-add-btn">Agregar otro produco</button>
								</div>
								<div class="clearfix"></div>
								<div class="items" data-group="productos_grupo">
									<div class="item-content">
										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<label>Categoria</label>
													<?php             
                                                    $consul = $db->query("SELECT * FROM categoria order by nomcategoria asc");      
                                                    ?>
                                                    <select class="form-control chosen-select" data-skip-name="true" data-name="idcategoria[]"id="idcategoria[]">
                                                    <option value=""  required="" >Seleccione</option> 
                                                        <?php foreach ($consul as $fila): ?>
                                                            <option value="<?php echo $fila['idcategoria']?>"> 
                                                                <?php echo ucwords($fila['nomcategoria'])?> 
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                    <br>
													<label>Producto</label>
                                                    <input type="text" data-skip-name="true" data-name="producto[]" id="producto" class="form-control" />
                                                    
                                                    <label> Imagen</label>
                                                    <input type="file" data-skip-name="true" data-name="thumbnail[]" id="thumbnail" class="form-control" />
                                                    
                                                    
												</div>
                                                
												<div class="col-md-3" style="margin-top:24px;" align="center">
													<button id="remove-btn" onclick="$(this).parents('.items').remove()" class="btn btn-danger">Quitar</button>
												</div>

                                                <br>
                            

                                                <div class="col-md-6">
                                                <br>
                                                    <div class="row-sm-1">
                                                    <label>Calorias</label>
                                                        <input type="text" data-skip-name="true" data-name="calorias[]" id="calor" class="form-control" />
                                                    <label>Precio</label>
                                                        <input type="text" data-skip-name="true" data-name="precio[]" id="pre" class="form-control" />
                                                                    
                                                    </div>
                                                </div>
                                                
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group" align="center">
								<br /><br />
								<input type="submit" name="registrar_btn" class="btn btn-success" value="Registrar" />
							</div>

                                <?php 
                                if (isset($_GET['action'])) {
                                    if ($_GET['action']== 'okRestaurante') {
                                        echo '<center><div class="alert alert-success alert-dismissible fade in" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Felicidades!! </strong> Te acabamos de enviar las credenciales de tu usuario para que ingreses al sistema.
                                        </div>
                                        </center>';
                                    }
                                }
                                ?>
						</form>
                </div>
            </div>
        </div>
    </div>

<?php  
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $rest = new RestauranteController();
    $rest->registrarRestaurante();
    }
?>
    
    <script>
    $(document).ready(function(){

        $("#repeater").createRepeater();


    });
        
    </script>
