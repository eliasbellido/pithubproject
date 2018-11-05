<?php require 'header/menu.php'; ?>


<section class="site-content">
    
    <?php 
        $mvc=new MVCcontroller();
       // echo 'invocando ';
        $mvc->enlacesPaginasController();
       // echo 'paso';
	 ?>

</section>

<?php require 'header/footer.php'; ?> 
