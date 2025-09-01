<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	if(strlen($_SESSION['alogin'])==0) {   
		header('location:index.php');
	} else {
		if(isset($_POST['update'])) {
			$id=intval($_GET['id']);
			$nombres=$_POST['nombres'];
			$sql="UPDATE autor SET nombres=:nombres WHERE id=:id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':nombres',$nombres,PDO::PARAM_STR);
			$query->bindParam(':id',$id,PDO::PARAM_STR);
			$query->execute();
			$_SESSION['updatemsg']="Autor Actualizado Correctamente!!";
			header('location:manage-authors.php');
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
					<h4 class="header-line">EDITAR AUTOR</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<div class="panel panel-info">
						<div class="panel-heading">Formulario</div>
						<div class="panel-body">
							<form role="form" method="post">
								<div class="form-group">
									<label>Nombre Autor:</label>
									<?php
										$id=intval($_GET['id']);
										$sql = "SELECT * FROM autor WHERE id=:id";
										$query = $dbh -> prepare($sql);
										$query->bindParam(':id',$id,PDO::PARAM_STR);
										$query->execute();
										$results=$query->fetchAll(PDO::FETCH_OBJ);
										$cnt=1;
										if($query->rowCount() > 0) {
											foreach($results as $result) {
									?>
									<input class="form-control" type="text" name="nombres" value="<?php echo htmlentities($result->nombres);?>" required />
									<?php }} ?>
								</div>
								<button type="submit" name="update" class="btn btn-info">Actualizar Autor</button>
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