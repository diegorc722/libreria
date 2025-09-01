<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0) { 
	header('location:index.php');
} else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Panel Control</title>
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
					<h4 class="header-line">PANEL DE CONTROL: ESTUDIANTE</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-6">
					<div class="alert alert-info back-widget-set text-center">
						<i class="fa fa-bars fa-5x"></i>
						<?php
							$codigo=$_SESSION['id'];
							$sql1 ="SELECT id FROM prestamo WHERE estudiante=:codigo";
							$query1 = $dbh -> prepare($sql1);
							$query1->bindParam(':codigo',$codigo,PDO::PARAM_STR);
							$query1->execute();
							$results1=$query1->fetchAll(PDO::FETCH_OBJ);
							$prestamos=$query1->rowCount();
							echo '	<h3>'.htmlentities($prestamos).'</h3>';
							echo '	Libros Prestados';
						?>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6">
					<?php
					$estado=0;
					$sql2 ="SELECT id FROM prestamo WHERE estudiante=:codigo AND estado=:estado";
					$query2 = $dbh -> prepare($sql2);
					$query2->bindParam(':codigo',$sid,PDO::PARAM_STR);
					$query2->bindParam(':estado',$estado,PDO::PARAM_STR);
					$query2->execute();
					$results2=$query2->fetchAll(PDO::FETCH_OBJ);
					$librospendiente=$query2->rowCount();
					if ($librospendiente == 0) {
						echo '<div class="alert alert-success back-widget-set text-center">';
					} else {
						echo '<div class="alert alert-danger back-widget-set text-center">';
					}
					echo '	<i class="fa fa-recycle fa-5x"></i>';
					echo '	<h3>'.htmlentities($librospendiente).'</h3>';
					echo '	Libros No Devueltos';
					echo '</div>';
					?>					
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
