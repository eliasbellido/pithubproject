<?php require 'header/menu.php'; ?>


<section>
    
    <?php 
        $mvc=new MVCcontroller();
       // echo 'invocando ';
        $mvc->enlacesPaginasController();
        echo 'paso';
	 ?>

</section>

<?php require 'header/footer.php'; ?>

