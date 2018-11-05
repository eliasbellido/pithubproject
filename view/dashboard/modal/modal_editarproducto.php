
<!-- Modal HTML -->
<div id="editarProductoModal" class="modal fade">
	<div class="modal-dialog modal-editarProducto">
		<div class="modal-content">
			<div class="modal-header">
						
				<h4 class="modal-title">Editar Producto</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body editarprod-body">
           
            <!--Acá va mi modal que se llena dinamicamnete desde ajax-->
			</div>
			<div class="modal-footer">
				<a href="#"></a>
			</div>
		</div>
	</div>
</div>     

<?php  
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnModalGrabarProd']) ){

      $rest = new ProductoController();
      $rest->actualizarProducto();
    }
?>