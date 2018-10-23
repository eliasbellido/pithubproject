<?php
require '../conexion.php';
?>

<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Registro de restaurantes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
        <script src="/pitrestaurant/js/repeater.js" type="text/javascript"></script>
    </head>
<body>
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
                                                    <select class="form-control chosen-select" data-skip-name="true" data-name="idcategoria[]"id="idcategoria[]"  required>
                                                    <option value=""  required="" >Seleccione</option> 
                                                        <?php foreach ($consul as $fila): ?>
                                                            <option value="<?php echo $fila['idcategoria']?>"> 
                                                                <?php echo ucwords($fila['nomcategoria'])?> 
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                    <br>
													<label>Producto</label>
                                                    <input type="text" data-skip-name="true" data-name="producto[]" id="producto" class="form-control" required />
                                                    
                                                    <label> Imagen</label>
                                                    <input type="file" data-skip-name="true" data-name="thumbnail[]" id="thumbnail" class="form-control" required />
                                                    
                                                    
												</div>
                                                
												<div class="col-md-3" style="margin-top:24px;" align="center">
													<button id="remove-btn" onclick="$(this).parents('.items').remove()" class="btn btn-danger">Quitar</button>
												</div>

                                                <br>

                                                <div class="col-md-6">
                                                <br>
                                                <label>Calorias</label>
                                                    <input type="text" data-skip-name="true" data-name="calorias[]" id="calor" class="form-control" required />
                                                                    
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
						</form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    $(document).ready(function(){

        $("#repeater").createRepeater();

        $('#repeater_form').on('submit', function(event){

            var formdata = new FormData(this);
            event.preventDefault();
            $.ajax({
                enctype: 'multipart/form-data',
                url:"/pitrestaurant/controller/registrarController.php",
                method:"POST",
                data: formdata,//$(this).serialize(),
               // dataType: "json",
                processData: false,  // tell jQuery not to process the data
                contentType: false,  
                success:function(data)
                {
                    console.log( "success:",data );
    
                    $('#repeater_form')[0].reset();
                    //$("#repeater").createRepeater();
                    $('#success_result').html(data);
                    /*setInterval(function(){
                        location.reload();
                    }, 3000);*/
                },
                error: function (e) {

                    console.log("ERROR : ", e);

                }
            });
        });

    });
        
    </script>
    </body>
</html>