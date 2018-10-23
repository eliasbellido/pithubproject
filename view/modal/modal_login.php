

<!-- Modal HTML -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog modal-login">
		<div class="modal-content">
			<div class="modal-header">
				<div class="avatar">
					<img src="assets/images/avatar.png" alt="Avatar">
				</div>				
				<h4 class="modal-title">Login</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form  method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="username" placeholder="Usuario" required="required">		
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Contraseña" required="required">	
					</div>        
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-lg btn-block login-btn" name="btnIngresar">Ingresar</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="#">Te olvidaste la contraseña?</a>
			</div>
		</div>
	</div>
</div>     

<?php  
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnIngresar']) ){

    $rest = new LoginController();
    $rest->validarCredenciales();
    }
?>