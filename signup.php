<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['signup'])) {
	if ($_POST["captcha"] != $_SESSION["captcha"] || empty($_SESSION["captcha"])) {
	echo "<script>alert('Código CAPTCHA incorrecto!!');</script>" ;
	} else {
		$nombres=$_POST['nombres'];
		$celular=$_POST['celular'];
		$correo=$_POST['correo']; 
		$clave=md5($_POST['clave']); 
		$codigo="E";
		$sql="INSERT INTO estudiante (codigo,nombres,celular,correo,clave) VALUES (:codigo,:nombres,:celular,:correo,:clave)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':nombres',$nombres,PDO::PARAM_STR);
		$query->bindParam(':celular',$celular,PDO::PARAM_STR);
		$query->bindParam(':correo',$correo,PDO::PARAM_STR);
		$query->bindParam(':codigo',$codigo,PDO::PARAM_STR);
		$query->bindParam(':clave',$clave,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId) {
			$sql="SELECT codigo FROM estudiante WHERE id = :id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':id',$lastInsertId,PDO::PARAM_STR);
			$query->execute();
			$codigo=$query->fetchColumn();
			echo "<script>alert('Estudiante Registrado Correctamente!! Tu codigo es {$codigo}')</script>";
		} else {
			echo "<script>alert('Algo salió mal. Intente Nuevamente!!');</script>";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Registro Estudiante</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<script type="text/javascript">
		function valid(){
			if(document.signup.clave.value != document.signup.confirmarclave.value){
				alert("Las contraseñas no coinciden!!");
				document.signup.confirmarclave.focus();
				return false;
			}
			return true;
		}
		function checkAvailability() {
			$("#loaderIcon").show();
			jQuery.ajax({
				url: "check_availability.php",
				data:'correo='+$("#correo").val(),
				type: "POST",
				success:function(data){
					$("#user-availability-status").html(data);
					$("#loaderIcon").hide();
				},
				error:function (){}
			});
		}
	</script>
</head>
<body>
	<?php include('includes/header.php');?>
	<div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">Registro Estudiante</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9 col-md-offset-1">
					<div class="panel panel-danger">
						<div class="panel-heading">Formulario</div>
						<div class="panel-body">
							<form name="signup" method="post" onSubmit="return valid();">
								<div class="form-group">
									<label>Ingrese Nombres Completos:</label>
									<input class="form-control" type="text" name="nombres" autocomplete="off" required/>
								</div>
								<div class="form-group">
									<label>Ingrese Número Celular:</label>
									<input class="form-control" type="text" name="celular" maxlength="10" autocomplete="off" required/>
								</div>
								<div class="form-group">
									<label>Ingrese Correo Electrónico:</label>
									<input class="form-control" type="email" name="correo" id="correo" onBlur="checkAvailability()" autocomplete="off" required/>
									<span id="user-availability-status" style="font-size:12px;"></span> 
								</div>
								<div class="form-group">
									<label>Ingrese Clave:</label>
									<input class="form-control" type="password" name="clave" autocomplete="off" required/>
								</div>
								<div class="form-group">
									<label>Confirme Clave:</label>
									<input class="form-control"  type="password" name="confirmarclave" autocomplete="off" required/>
								</div>
								<div class="form-group">
									<label>Ingrese Código Captcha:</label>
									<input type="text"  name="captcha" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
								</div>
								<button type="submit" name="signup" class="btn btn-danger" id="submit">Registrar Ahora</button>
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
