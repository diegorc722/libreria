<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['change'])){
	if ($_POST["captcha"] != $_SESSION["captcha"] OR $_SESSION["captcha"]=='') {
		echo "<script>alert('Código CAPTCHA incorrecto!!');</script>" ;
	} else {
		$correo = $_POST['correo'];
		$celular = $_POST['celular'];
		$nuevaclave = md5($_POST['nuevaclave']);
		$sql = "SELECT id FROM estudiante WHERE correo=:correo and celular=:celular";
		$query = $dbh -> prepare($sql);
		$query-> bindParam(':correo', $correo, PDO::PARAM_STR);
		$query-> bindParam(':celular', $celular, PDO::PARAM_STR);
		$query-> execute();
		$results = $query -> fetchAll(PDO::FETCH_OBJ);
		if($query -> rowCount() > 0) {
			$sql="UPDATE estudiante SET clave=:nuevaclave WHERE correo=:correo AND celular=:celular";
			$cambio = $dbh -> prepare($sql);
			$cambio -> bindParam(':correo', $correo, PDO::PARAM_STR);
			$cambio -> bindParam(':celular', $celular, PDO::PARAM_STR);
			$cambio -> bindParam(':nuevaclave', $nuevaclave, PDO::PARAM_STR);
			$cambio ->execute();
			echo "<script>alert('Su clave fue cambiado exitosamente!!');</script>";
		} else {
			echo "<script>alert('Correo o Celular inválido!!');</script>"; 
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Recuperar Clave</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<script type="text/javascript">
		function valid(){
			if(document.change.nuevaclave.value!= document.change.confirmarclave.value) {
				alert("Clave nueva y Clave confirmada no coinciden!!");
				document.change.confirmarclave.focus();
				return false;
			}
			return true;
		}
	</script>
</head>
<body>
	<?php include('includes/header.php'); ?>
	<div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">Recuperación de Clave de Usuario</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
					<div class="panel panel-info">
						<div class="panel-heading">Formulario</div>
						<div class="panel-body">
							<form name="change" method="post" onSubmit="return valid();">
								<div class="form-group">
									<label>Ingrese Correo Electrónico:</label>
									<input class="form-control" type="email" name="correo" required autocomplete="off" />
								</div>
								<div class="form-group">
									<label>Ingrese Numero Celular:</label>
									<input class="form-control" type="text" name="celular" required autocomplete="off" />
								</div>
								<div class="form-group">
									<label>Ingrese Nueva Clave:</label>
									<input class="form-control" type="password" name="nuevaclave" required autocomplete="off"  />
								</div>
								<div class="form-group">
									<label>Confirme Nueva Clave:</label>
									<input class="form-control" type="password" name="confirmarclave" required autocomplete="off"  />
								</div>
								<div class="form-group">
									<label>Ingrese Código Captcha:</label>
									<input type="text" class="form-control1"  name="captcha" maxlength="5" autocomplete="off" required  style="height:25px;" />&nbsp;<img src="captcha.php">
								</div> 
								<button type="submit" name="change" class="btn btn-info">Cambiar Clave</button> | <a href="index.php">Acceder</a>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('includes/footer.php');?>
	<script src="assets/js/jquery-1.10.2.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/custom.js"></script>
</body>
</html>