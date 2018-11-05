<div class="main-content">
			<div class="title">
				Mis Productos
            </div>

<br>
       <div class="container">
    <div class="row clearfix">
		
    	<div class="col-md-12 table-responsive">
			<div align="left">  
			<button class="btn  btn-warning btn-circle" data-toggle="modal" data-target="#nuevoProductoModal" href="#"><i class="fa fa-plus"></i></button>
    
			</div>  
			<br /> 
			<table class="table table-bordered table-hover table-sortable dt-responsive" id="tab_logic">
				<thead>
					<tr >
						<th class="text-center">
							Producto
						</th>
						<th class="text-center">
							Precio
						</th>
						<th class="text-center">
							Categoria
						</th>
						<th class="text-center">
							Imagen
						</th>
    					<th class="text-center">
							Acciones
						</th>
        				
					</tr>
				</thead>
				<tbody>
                    <?php 
                        $prod = new ProductoController();
                        $prod->listarMisProductos();
                      
                    ?>
    				
				</tbody>
			</table>
		</div>
	</div>
	
</div>
                        
</div>


<?php require 'view/dashboard/modal/modal_editarproducto.php'; ?>
<?php require 'view/dashboard/modal/modal_nuevoproducto.php'; ?>
