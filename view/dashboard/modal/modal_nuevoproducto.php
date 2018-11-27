<?php  
 require_once 'view/conexion.php';
?>
<!-- Modal HTML -->
<div id="nuevoProductoModal" class="modal fade">
	<div class="modal-dialog modal-nuevoProducto">
		<div class="modal-content">
			<div class="modal-header">
						
				<h4 class="modal-title">Agregar Producto</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body nuevoprod-body">
                <form  method="post" id="frmModalNuevoProducto" enctype="multipart/form-data">
					<div class="form-group">
                    <input type="text" class="form-control" name="modal_newproductonombre[]" placeholder="Nombre del producto" required="required"/>		
					</div>
					<div class="form-group">
                    <?php             
                         $consul = $db->query("SELECT * FROM categoria order by nomcategoria asc");      
                    ?>
                    <select class="form-control chosen-select" id="idcategoria" name="idcategoria[]" required>
                                    <option value=""  required="" >Seleccione</option> 
                                            <?php foreach ($consul as $fila): ?>
                                                    <option value="<?php echo $fila['idcategoria']?>"> 
                                            <?php echo ucwords($fila['nomcategoria'])?> 
                                    </option>
                            <?php endforeach ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="modal_newproductocalorias[]" placeholder="Calorías" required="required"/>	
                    </div>         
                    <div class="form-group">
                        <input type="text" class="form-control" name="modal_newproductoprecio[]" placeholder="Precio" required="required"/>	
                    </div>     
                    <div class="form-group">
                        <label for="customFile" class="custom-fileLabel">
                            <i class="fa fa-upload"></i>
                            <span id="fileSpan">Seleccione una imagen</span>
                        </label>
                        <input type="file" id="customFile" class="form-control" name="modal_newproductoimage[]" />                                                    
                    </div>     
					<div class="form-group">
                        <button type="submit" id="btnModalSaveNewProd" class="btn btn-primary btn-lg btn-block saveProductNew-btn" name="btnModalGrabarNuevoProd">Grabar</button>
                    </div>
                    
                    
				</form>          
			</div>
			<div class="modal-footer">
				<a href="#"></a>
			</div>
		</div>
	</div>
</div>     

<?php  
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnModalGrabarNuevoProd']) ){
        
        echo'<script type="text/javascript">
        console.log( "entro al metodo" ); 
      
       </script>';
      $rest = new ProductoController();
      $rest->registrarNuevoProducto();
    }
?>