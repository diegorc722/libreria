<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	if(strlen($_SESSION['alogin'])==0) {
		header('location:index.php');
	} else {
		if(isset($_POST['update'])) {
			$nombre = $_POST['nombre'];
			$categoria = $_POST['categoria'];
			$autor = $_POST['autor'];
			$isbn = $_POST['isbn'];
			$precio = $_POST['precio'];
			$stock = $_POST['stock'];
			$id = intval($_GET['id']);
			$sql="UPDATE libro SET nombre=:nombre,categoria=:categoria,autor=:autor,isbn=:isbn,precio=:precio,stock=:stock WHERE id=:id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':nombre',$nombre,PDO::PARAM_STR);
			$query->bindParam(':categoria',$categoria,PDO::PARAM_STR);
			$query->bindParam(':autor',$autor,PDO::PARAM_STR);
			$query->bindParam(':isbn',$isbn,PDO::PARAM_STR);
			$query->bindParam(':precio',$precio,PDO::PARAM_STR);
			$query->bindParam(':stock',$stock,PDO::PARAM_STR);
			$query->bindParam(':id',$id,PDO::PARAM_STR);
			$query->execute();
			$_SESSION['msg']="Libro actualizado con éxito!!";
			header('location:manage-books.php');
		}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Editar Libro</title>
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
					<h4 class="header-line">EDITAR LIBRO</h4>
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
									$sql = "SELECT l.id,l.nombre libro,c.nombre categoria,a.nombres autor,l.isbn,l.precio,l.stock FROM libro l JOIN categoria c ON c.id=l.categoria JOIN autor a ON a.id=l.autor WHERE l.id=:id";
									$query = $dbh -> prepare($sql);
									$query->bindParam(':id',$id,PDO::PARAM_STR);
									$query->execute();
									$results=$query->fetchAll(PDO::FETCH_OBJ);
									$cnt=1;
									if($query->rowCount() > 0) {
										foreach($results as $result) {
								?>
								<div class="form-group">
									<label>Nombre Libro:<span style="color:red;">*</span></label>
									<input class="form-control" type="text" name="nombre" value="<?php echo htmlentities($result->libro);?>" required />
								</div>
								<div class="form-group">
									<label>Categoría:<span style="color:red;">*</span></label>
									<select class="form-control" name="categoria" required="required">
										<option value="<?php echo htmlentities($result->id);?>"> <?php echo htmlentities($catname=$result->categoria);?></option>
										<?php
											$estado=1;
											$sql1 = "SELECT * FROM  categoria WHERE estado=:estado";
											$query1 = $dbh -> prepare($sql1);
											$query1-> bindParam(':estado',$estado, PDO::PARAM_STR);
											$query1->execute();
											$resultss=$query1->fetchAll(PDO::FETCH_OBJ);
											if($query1->rowCount() > 0) {
												foreach($resultss as $row) {
													if($catname==$row->nombre) {
														continue;
													} else {
										?>
										<option value="<?php echo htmlentities($row->id);?>"><?php echo htmlentities($row->nombre);?></option>
										<?php }}} ?> 
									</select>
								</div>
								<div class="form-group">
									<label>Autor:<span style="color:red;">*</span></label>
									<select class="form-control" name="autor" required="required">
										<option value="<?php echo htmlentities($result->id);?>"> <?php echo htmlentities($athrname=$result->autor);?></option>
										<?php
											$sql2 = "SELECT * FROM autor WHERE estado NOT LIKE -1";
											$query2 = $dbh -> prepare($sql2);
											$query2->execute();
											$result2=$query2->fetchAll(PDO::FETCH_OBJ);
											if($query2->rowCount() > 0) {
												foreach($result2 as $ret) {
													if($athrname==$ret->nombres) {
														continue;
													} else {
										?>  
										<option value="<?php echo htmlentities($ret->id);?>"><?php echo htmlentities($ret->nombres);?></option>
										<?php }}} ?> 
									</select>
								</div>
								<div class="form-group">
									<label>Número ISBN:<span style="color:red;">*</span></label>
									<input class="form-control" type="text" name="isbn" value="<?php echo htmlentities($result->isbn);?>" required="required" />
									<p class="help-block">ISBN es un Número Único Internacional Normalizado de Libros.</p>
								</div>
								<div class="form-group">
									<label>Precio:<span style="color:red;">*</span></label>
									<input class="form-control" type="text" name="precio" value="<?php echo htmlentities($result->precio);?>" required="required" />
								</div>
								<div class="form-group">
									<label>Stock:<span style="color:red;">*</span></label>
									<input class="form-control" type="number" name="stock" value="<?php echo htmlentities($result->stock);?>" required="required" />
								</div>
								<?php }} ?>
								<button type="submit" name="update" class="btn btn-info">Editar Libro</button>
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