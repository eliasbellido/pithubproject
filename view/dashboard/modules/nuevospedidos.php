<div class="main-content">
			<div class="title">
				Nuevos pedidos
            </div>

<br>
       <div class="container">
    <div class="row clearfix">
    	<div class="col-md-12 table-responsive">
			<table class="table table-bordered table-hover table-sortable" id="tab_logic">
				<thead>
					<tr >
						<th class="text-center">
							Cliente
						</th>
						<th class="text-center">
							Fecha de creación
						</th>
						<th class="text-center">
							Monto total del pedido
						</th>
						<th class="text-center">
							Tipo de pago
						</th>
                        <th class="text-center">
							Dirección de entrega
						</th>
    					<th class="text-center">
							Aceptar pedido
						</th>
        				
					</tr>
				</thead>
				<tbody>
                    <?php 
                        $prod = new PedidoController();
                        $prod->listarPedidosNuevos();
                        $prod->aceptarPedido();
                    ?>
    				
				</tbody>
			</table>
		</div>
	</div>
	
</div>
                        
</div>