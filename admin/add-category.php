<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {   
	header('location:index.php');
} else {
	if(isset($_POST['create'])) {
		$nombre=$_POST['nombre'];
		$estado=$_POST['estado'];
		$sql="INSERT INTO categoria (nombre,estado) VALUES(:nombre,:estado)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':nombre',$nombre,PDO::PARAM_STR);
		$query->bindParam(':estado',$estado,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId) {
			$_SESSION['msg']="Categoría Agregada Correctamente";
			header('location:manage-categories.php');
		} else {
			$_SESSION['error']="Algún error ocurrió. Por favor intente de nuevo";
			header('location:manage-categories.php');
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Agregar Categorías</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
	<?php include('includes/header.php');?>
	<div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">REGISTRAR CATEGORÍA</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				<div class="panel panel-info">
					<div class="panel-heading">Formulario</div>
					<div class="panel-body">
						<form role="form" method="post">
							<div class="form-group">
								<label>Nombre Categoría:</label>
								<input class="form-control" type="text" name="nombre" autocomplete="off" required />
							</div>
							<div class="form-group">
								<label>Estado:</label>
								<div class="radio">
									<label>
										<input type="radio" name="estado" id="estado" value="1" checked="checked">Activo
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="estado" id="estado" value="0">Inactivo
									</label>
								</div>
							</div>
							<button type="submit" name="create" class="btn btn-info">Agregar</button>
						</form>
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
<?php } ?>