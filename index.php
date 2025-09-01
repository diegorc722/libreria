<?php
session_start();
error_reporting(0);
include('includes/config.php');
$_SESSION['login'] = '';
if(isset($_POST['login'])) {
	if ($_POST["captcha"] != $_SESSION["captcha"] || empty($_SESSION["captcha"])) {
		echo "<script>alert('Código CAPTCHA incorrecto!!');</script>" ;
	} else {
		$correo = $_POST['correo'];
		$clave = md5($_POST['clave']);
		$sql = "SELECT codigo,estado FROM estudiante WHERE correo=:correo AND clave=:clave";
		$query = $dbh -> prepare($sql);
		$query -> bindParam(':correo',$correo,PDO::PARAM_STR);
		$query -> bindParam(':clave',$clave,PDO::PARAM_STR);
		$query -> execute();
		$results = $query -> fetchAll(PDO::FETCH_OBJ);
		if($query -> rowCount() > 0) {
			foreach ($results as $result) {
				$_SESSION['id'] = $result -> codigo;
				if($result -> estado == 1) {
					$_SESSION['login'] = $_POST['correo'];
					echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
				} else {
					echo "<script>alert('Tu Cuenta ha sido Bloqueada!! Por favor contacte al administrador');</script>";
				}
			}
		} else {
			echo "<script>alert('Correo y/o Contraseña Incorrecta!!');</script>";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Acceso Estudiante</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
	<?php include('includes/header.php'); ?>
	<div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">Acceso del Sistema Estudiante</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
					<div class="panel panel-info">
						<div class="panel-heading">Formulario Acceso</div>
						<div class="panel-body">
							<form role="form" method="post">
								<div class="form-group">
									<label>Ingrese Correo Electrónico:</label>
									<input class="form-control" type="text" name="correo" required autocomplete="off"/>
								</div>
								<div class="form-group">
									<label>Ingrese Clave:</label>
									<input class="form-control" type="password" name="clave" required autocomplete="off"/>
									<p class="help-block"><a href="user-forgot-password.php">¿Olvidó su Clave?</a></p>
								</div>
								<div class="form-group">
									<label>Ingrese código Captcha :</label>
									<input type="text" name="captcha" maxlength="5" autocomplete="off" required  style="height:25px;"/>&nbsp;<img src="captcha.php">
								</div> 
								<button type="submit" name="login" class="btn btn-info">ACCEDER</button> | <a href="signup.php">Registrarme</a>
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