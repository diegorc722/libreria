<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	if(strlen($_SESSION['alogin'])==0) {
		header('location:index.php');
	} else {
		if(isset($_POST['return'])) {
			$id = intval($_GET['id']);
			$multa = $_POST['multa'];
			$estado = 1;
			$sql = "UPDATE prestamo SET multa=:multa,estado=:estado WHERE id=:id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':id',$id,PDO::PARAM_STR);
			$query->bindParam(':multa',$multa,PDO::PARAM_STR);
			$query->bindParam(':estado',$estado,PDO::PARAM_STR);
			$query->execute();
			$_SESSION['msg']="libro retornado con éxito!!";
			header('location:manage-issued-books.php');
		}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Actualizar Préstamos</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<script>
		function getstudent() {
			$("#loaderIcon").show();
			jQuery.ajax({
				url: "get_student.php",
				data:'codigo='+$("#codigo").val(),
				type: "POST",
				success:function(data){
					$("#get_student_name").html(data);
					$("#loaderIcon").hide();
				},
				error:function (){}
			});
		}
		function getbook() {
			$("#loaderIcon").show();
			jQuery.ajax({
				url: "get_book.php",
				data:'isbn='+$("#isbn").val(),
				type: "POST",
				success:function(data){
					$("#get_book_name").html(data);
					$("#loaderIcon").hide();
				},
				error:function (){}
			});
		}
	</script>
	<style type="text/css">
		.others{
			color:red;
		}
	</style>
</head>
<body>
	<?php include('includes/header.php');?>
	<div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">REGISTRAR DEVOLUCIÓN</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
					<div class="panel panel-info">
						<div class="panel-heading">Formulario</div>
						<div class="panel-body">
							<form role="form" method="post">
								<?php
									$id=intval($_GET['id']);
									$sql = "SELECT p.id,e.nombres estudiante,l.nombre libro,l.isbn,p.estado,p.fechaPrestamo,p.fechaDevolucion,p.multa,l.precio FROM prestamo p
											JOIN estudiante e ON e.codigo=p.estudiante 
											JOIN libro l ON l.isbn = p.libro WHERE p.id=:id";
									$query = $dbh -> prepare($sql);
									$query->bindParam(':id',$id,PDO::PARAM_STR);
									$query->execute();
									$results=$query->fetchAll(PDO::FETCH_OBJ);
									$cnt=1;
									if($query->rowCount() > 0) {
										foreach($results as $result) {
								?>
								<div class="form-group">
									<label>Nombre Estudiante:</label>
									<?php echo htmlentities($result->estudiante);?>
								</div>
								<div class="form-group">
									<label>Libro:</label>
									<?php echo htmlentities($result->libro);?>
								</div>
								<div class="form-group">
									<label>ISBN :</label>
									<?php echo htmlentities($result->isbn);?>
								</div>
								<div class="form-group">
									<label>Fecha Préstamo:</label>
									<?php echo htmlentities($result->fechaPrestamo);?>
								</div>
								<div class="form-group">
									<label>Fecha Devolución:</label>
									<?php
										if($result->estado==0) {
											if ($result->fechaDevolucion < date('Y-m-d H:i:s')) {
											    echo "<span style='color:red'>Aún no devuelto - Retrasado (Fecha Límite: {$result->fechaDevolucion})</span>";
											} else {
											    echo "<span style='color:green'>Aún no devuelto -  A Tiempo (Fecha Límite: {$result->fechaDevolucion}) (A Tiempo)</span>";
											}
										} else {
											echo htmlentities($result->fechaDevolucion);
										}
									?>
								</div>
								<div class="form-group">
									<label>Multa (en Pesos):</label>
									<?php
										if($result->estado==0) {
											echo '<input class="form-control" type="number" name="multa" id="multa" required autofocus/>';
										} else {
											if ($result->multa == 0) {
											    echo "<span style='color:green'>No hay multa</span>";
											} else {
											    echo "<span style='color:red'>{$result->multa}</span>";
											}
										}
									?>
								</div>
								<?php if($result->estado==0) { ?>
								<button type="submit" name="return" id="submit" class="btn btn-info">Registrar</button>
								<?php }}} ?>
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
