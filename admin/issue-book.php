<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {
	header('location:index.php');
} else {
	if(isset($_POST['issue'])) {
		$isbn = strtoupper($_POST['isbn']);
		$codigo = $_POST['codigo'];
		$sql="INSERT INTO prestamo(libro,estudiante) VALUES(:isbn,:codigo)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':isbn',$isbn,PDO::PARAM_STR);
		$query->bindParam(':codigo',$codigo,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if($lastInsertId) {
			$_SESSION['msg']="Préstamo registrado con éxito!!";
			header('location:manage-issued-books.php');
		} else {
			$_SESSION['error']="Algo salió mal. Inténtalo de nuevo!!";
			header('location:manage-issued-books.php');
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Ingresar Libro</title>
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
					<h4 class="header-line">REGISTRAR PRÉSTAMO</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
					<div class="panel panel-info">
						<div class="panel-heading">Formulario</div>
						<div class="panel-body">
							<form role="form" method="post">
								<div class="form-group">
									<label>Código de Estudiante: <span style="color:red;">*</span></label>
									<input class="form-control" type="text" name="codigo" id="codigo" onBlur="getstudent()" autocomplete="off"  required />
								</div>
								<div class="form-group">
									<span id="get_student_name" style="font-size:16px;"></span> 
								</div>
								<div class="form-group">
									<label>Número ISBN Libro:<span style="color:red;">*</span></label>
									<input class="form-control" type="text" name="isbn" id="isbn" onBlur="getbook()"  required="required" />
								</div>
								<div class="form-group">
									<span id="get_book_name" style="font-size:16px;"></span> 
								</div>
								<button type="submit" name="issue" id="submit" class="btn btn-info">Registrar Préstamo</button>
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