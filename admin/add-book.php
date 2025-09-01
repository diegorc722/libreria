<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {
	header('location:index.php');
} else {
	if(isset($_POST['add'])) {
		$nombre = $_POST['nombre'];
		$categoria = $_POST['categoria'];
		$autor = $_POST['autor'];
		$isbn = $_POST['isbn'];
		$precio = $_POST['precio'];
		$stock = $_POST['stock'];
		$sql="INSERT INTO libro(nombre,categoria,autor,isbn,precio,stock) VALUES (:nombre,:categoria,:autor,:isbn,:precio,:stock)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':nombre',$nombre,PDO::PARAM_STR);
		$query->bindParam(':categoria',$categoria,PDO::PARAM_STR);
		$query->bindParam(':autor',$autor,PDO::PARAM_STR);
		$query->bindParam(':isbn',$isbn,PDO::PARAM_STR);
		$query->bindParam(':precio',$precio,PDO::PARAM_STR);
		$query->bindParam(':stock',$stock,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId) {
			$_SESSION['msg']="Libro Agregado exitosamente!!";
			header('location:manage-books.php');
		} else {
			$_SESSION['error']="Algo salió mal. Por favor, inténtelo de nuevo.";
			header('location:manage-books.php');
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Agregar Libro</title>
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
					<h4 class="header-line">Registrar Libro</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				<div class="panel panel-info">
					<div class="panel-heading">Formulario</div>
					<div class="panel-body">
						<form role="form" method="post">
							<div class="form-group">
								<label>Nombre Libro:<span style="color:red;">*</span></label>
								<input class="form-control" type="text" name="nombres" autocomplete="off"  required />
							</div>
							<div class="form-group">
								<label> Categoría:<span style="color:red;">*</span></label>
								<select class="form-control" name="categoria" required="required">
									<option value=""> (Seleccione Categoría)</option>
									<?php 
									$estado=1;
									$sql = "SELECT id,nombre FROM  categoria WHERE estado=:estado";
									$query = $dbh -> prepare($sql);
									$query -> bindParam(':estado',$estado, PDO::PARAM_STR);
									$query->execute();
									$results=$query->fetchAll(PDO::FETCH_OBJ);
									$cnt=1;
									if($query->rowCount() > 0) {
										foreach($results as $result) {
									?>
									<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->nombre);?></option>
									<?php }} ?>
								</select>
							</div>
							<div class="form-group">
								<label> Autor:<span style="color:red;">*</span></label>
								<select class="form-control" name="autor" required="required">
									<option value=""> (Seleccione Autor)</option>
									<?php
										$sql = "SELECT id,nombres FROM  autor WHERE estado NOT LIKE -1";
										$query = $dbh -> prepare($sql);
										$query->execute();
										$results=$query->fetchAll(PDO::FETCH_OBJ);
										$cnt=1;
										if($query->rowCount() > 0) {
											foreach($results as $result) {
									?>  
									<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->nombres);?></option>
									<?php }} ?> 
								</select>
							</div>
							<div class="form-group">
								<label>Número ISBN:<span style="color:red;">*</span></label>
								<input class="form-control" type="text" name="isbn"  required="required" autocomplete="off"  />
								<p class="help-block">ISBN es un Número Único Internacional Normalizado de Libros.</p>
							</div>
							<div class="form-group">
								<label>Precio:<span style="color:red;">*</span></label>
								<input class="form-control" type="text" name="precio" autocomplete="off"   required="required" />
							</div>
							<div class="form-group">
								<label>Stock:<span style="color:red;">*</span></label>
								<input class="form-control" type="number" name="stock" autocomplete="off"   required="required" />
							</div>
							<button type="submit" name="add" class="btn btn-info">Agregar</button>
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