<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	if(strlen($_SESSION['login'])==0) {
		header('location:index.php');
	} else {
		if(isset($_GET['del'])) {
			$id=$_GET['del'];
			$sql = "DELETE FROM libro WHERE id=:id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':id', $id, PDO::PARAM_STR);
			$query->execute();
			$_SESSION['delmsg'] = "Categoría Eliminada con Éxito!!";
			header('location:manage-books.php');
		}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Préstamos</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
	<?php include('includes/header.php');?>
	<div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">Gestión de Préstamos</h4>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">Préstamos</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th>#</th>
												<th>Libro</th>
												<th>ISBN</th>
												<th>Fecha Retiro</th>
												<th>Fecha Entrega</th>
												<th>Multa (en Pesos)</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$codigo = $_SESSION['id'];
												$sql = "SELECT p.id,l.nombre,p.libro,p.fechaPrestamo,p.fechaDevolucion,p.multa,p.estado FROM prestamo p
												JOIN estudiante e ON e.codigo = p.estudiante
												JOIN libro l ON l.isbn = p.libro
												WHERE e.codigo = :codigo 
												ORDER BY p.id DESC";
												$query = $dbh -> prepare($sql);
												$query->bindParam(':codigo', $codigo, PDO::PARAM_STR);
												$query->execute();
												$results=$query->fetchAll(PDO::FETCH_OBJ);
												$cnt=1;
												if($query->rowCount() > 0) {
													foreach($results as $result) {
											?>									  
											<tr class="odd gradeX">
												<td class="center"><?php echo htmlentities($cnt);?></td>
												<td class="center"><?php echo htmlentities($result->nombre);?></td>
												<td class="center"><?php echo htmlentities($result->libro);?></td>
												<td class="center"><?php echo htmlentities($result->fechaPrestamo);?></td>
												<td class="center"><?php if($result->fechaPrestamo == 1) {?>
													<span style="color:red">
														<?php   echo htmlentities($result->fechaDevolucion); ?>
													</span>
													<?php } else {
														echo htmlentities($result->fechaDevolucion);
													}?>
												</td>
												<td class="center"><?php echo htmlentities($result->multa);?></td>
											</tr>
											<?php $cnt=$cnt+1;}} ?>									  
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('includes/footer.php');?>
	<script src="assets/js/jquery-1.10.2.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/dataTables/jquery.dataTables.js"></script>
	<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
	<script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
