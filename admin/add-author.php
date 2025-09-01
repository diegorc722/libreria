<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {
	header('location:index.php');
} else {
	if(isset($_POST['create'])) {
		$nombres=$_POST['nombres'];
		$sql="INSERT INTO  autor (nombres) VALUES(:nombres)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':nombres',$nombres,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId) {
			$_SESSION['msg']="Autor Agregado Correctamente!!";
			header('location:manage-authors.php');
		} else {
			$_SESSION['error']="Algo Salió mal. Intentelo Nuevamente.";
			header('location:manage-authors.php');
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Agregar Autor</title>
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
					<h4 class="header-line">REGISTRAR AUTOR</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<div class="panel panel-info">
						<div class="panel-heading">Formulario</div>
						<div class="panel-body">
							<form role="form" method="post">
								<div class="form-group">
									<label>Nombre de Autor:</label>
									<input class="form-control" type="text" name="nombres" autocomplete="off"  required />
								</div>
								<button type="submit" name="create" class="btn btn-info">Agregar</button>
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
<?php } ?>