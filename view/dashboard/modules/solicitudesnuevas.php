<div class="main-content">
			<div class="title">
				Nuevos registros de restaurantes
            </div>

<br>
       <div class="container">
    <div class="row clearfix">
    	<div class="col-md-12 table-responsive">
			<table class="table table-bordered table-hover table-sortable" id="tab_logic">
				<thead>
					<tr >
						<th class="text-center">
							Restaurante
						</th>
						<th class="text-center">
							Tipo Restaurante
						</th>
						<th class="text-center">
							Email
						</th>
    					<th class="text-center">
							Admitido
						</th>
        				
					</tr>
				</thead>
				<tbody>
                    <?php 
                        $prod = new RestauranteController();
                        $prod->listarAllRestaurantesAdmision();
                        $prod->admitirRestaurante();
                    ?>
    				
				</tbody>
			</table>
		</div>
	</div>
	
</div>
                        
</div>