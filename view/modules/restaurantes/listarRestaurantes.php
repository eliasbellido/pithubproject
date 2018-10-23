<div class="shopping-cart"><br>
      <div class="title">
        Restaurantes disponibles
      </div>

      <?php 
          $prod = new RestauranteController();
          $prod->listarAllRestaurantes();
	 	 ?>
</div>

