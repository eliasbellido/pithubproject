<div class="main-content">
			<div class="title">
				Mi información
            </div>
            
			<div class="main">
				<div class="widget" style="text-align: center; flex-basis: 98%; height: 100%; padding: 0 10px 10px 10px; font-size: 1.1em; ">

				<form method="post">
                    <?php 
                    $prod = new RestauranteController();
                    $prod->obtenerRestaurante();
					?>
				</form>
                </div>
                
				
                
			</div>
</div>
        
