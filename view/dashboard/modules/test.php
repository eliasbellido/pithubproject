<div class="main-content">
			<div class="title">
				Mi información
            </div>
            
			<div class="main">
				<div class="widget" style="text-align: center; flex-basis: 98%; height: 100%; padding: 0 10px 10px 10px; font-size: 1.1em; ">

				<form method="post" id="miRest">
                    <?php 
                    $prod = new RestauranteController();
                    $prod->obtenerRestaurante();
					?>
					<button type="button" id="editarbtn" class="btn btn-primary">Editar</button>
     				<input type="submit" id="grabarbtn" class="btn btn-primary" value="Grabar"/>
					

				</form>
                </div>
			</div>
           
<?php  
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
		echo'presiono';
		
    $rest = new RestauranteController();
    $rest->actualizarRestaurante();
    }
?>
                
</div>
