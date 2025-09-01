<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	if(strlen($_SESSION['alogin'])==0) {   
		header('location:index.php');
	} else {
		if(isset($_POST['update'])) {
			$categoria=$_POST['categoria'];
			$estado=$_POST['estado'];
			$id=intval($_GET['id']);
			$sql="UPDATE categoria SET nombre=:categoria,estado=:estado WHERE id=:id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':categoria',$categoria,PDO::PARAM_STR);
			$query->bindParam(':estado',$estado,PDO::PARAM_STR);
			$query->bindParam(':id',$id,PDO::PARAM_STR);
			$query->execute();
			$_SESSION['updatemsg']="Categoría actualizada con éxito!!";
			header('location:manage-categories.php');
		}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Editar Categoría</title>
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
					<h4 class="header-line">EDITAR CATEGORÍA</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
					<div class="panel panel-info">
						<div class="panel-heading">Formulario</div>
						<div class="panel-body">
							<form role="form" method="post">
								<?php 
									$id=intval($_GET['id']);
									$sql="SELECT * FROM categoria WHERE id=:id";
									$query=$dbh->prepare($sql);
									$query-> bindParam(':id',$id, PDO::PARAM_STR);
									$query->execute();
									$results=$query->fetchAll(PDO::FETCH_OBJ);
									if($query->rowCount() > 0) {
										foreach($results as $result) {               
								?>
								<div class="form-group">
									<label>Nombre Categoría:</label>
									<input class="form-control" type="text" name="categoria" value="<?php echo htmlentities($result->nombre);?>" required />
								</div>
								<div class="form-group">
									<label>Estado:</label>
									<?php if($result->estado==1) {?>
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
									<?php } else { ?>
									<div class="radio">
										<label>
											<input type="radio" name="estado" id="estado" value="0" checked="checked">Inactivo
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="estado" id="estado" value="1">Activo
										</label>
									</div>
									<?php } ?>
								</div>
								<?php }} ?>
								<button type="submit" name="update" class="btn btn-info">Actualizar Cambio</button>
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
