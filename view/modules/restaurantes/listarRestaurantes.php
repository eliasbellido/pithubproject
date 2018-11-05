<div class="shopping-cart">
      <div class="title">
        Restaurantes disponibles
      </div>

      <?php 
          $prod = new RestauranteController();
          $prod->listarAllRestaurantes();
	 	 ?>
</div>

