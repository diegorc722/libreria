<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	if(strlen($_SESSION['alogin'])==0) {
		header('location:index.php');
	} else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Administrar Préstamos</title>
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
					<h4 class="header-line">REGISTRO DE PRÉSTAMOS</h4>
				</div>
				<div class="row">
					<?php if($_SESSION['error']!="") {?>
					<div class="col-md-6">
						<div class="alert alert-danger" >
							<strong>Error:</strong> 
							<?php echo htmlentities($_SESSION['error']);?>
							<?php echo htmlentities($_SESSION['error']="");?>
						</div>
					</div>
					<?php } ?>
					<?php if($_SESSION['msg']!="") {?>
					<div class="col-md-6">
						<div class="alert alert-success" >
							<strong>Éxito:</strong> 
							<?php echo htmlentities($_SESSION['msg']);?>
							<?php echo htmlentities($_SESSION['msg']="");?>
						</div>
					</div>
					<?php } ?>
					<?php if($_SESSION['delmsg']!="") {?>
					<div class="col-md-6">
						<div class="alert alert-success" >
							<strong>Éxito:</strong> 
							<?php echo htmlentities($_SESSION['delmsg']);?>
							<?php echo htmlentities($_SESSION['delmsg']="");?>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">Tabla de Registro</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr>
											<th>#</th>
											<th>Estudiante</th>
											<th>Libro</th>
											<th>ISBN</th>
											<th>Fecha Préstamo</th>
											<th>Fecha Devolución</th>
											<th>Multa (en Pesos)</th>
											<th>Acción</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql = "SELECT p.id,e.nombres estudiante,l.nombre libro,l.isbn,p.estado,p.fechaPrestamo,p.fechaDevolucion,p.multa FROM prestamo p
											JOIN estudiante e ON e.codigo=p.estudiante 
											JOIN libro l ON l.isbn = p.libro ORDER BY p.id DESC";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0) {
												foreach($results as $result) {
										?>
										<tr class="odd gradeX">
											<td class="center"><?php echo htmlentities($cnt);?></td>
											<td class="center"><?php echo htmlentities($result->estudiante);?></td>
											<td class="center"><?php echo htmlentities($result->libro);?></td>
											<td class="center"><?php echo htmlentities($result->isbn);?></td>
											<td class="center"><?php echo htmlentities($result->fechaPrestamo);?></td>
											<td class="center">
												<?php
													if($result->estado==0) {
														echo "<p style='color:red;'>Aún no retornado</p>";
													} else {
														echo htmlentities($result->fechaDevolucion);
													}
												?>
											</td>
											<td class="center"><?php echo htmlentities($result->multa);?></td>
											<td class="center">
												<a href="update-issue-bookdeails.php?id=<?php echo htmlentities($result->id);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i>Actualizar</button>
											</td>
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
	<?php include('includes/footer.php');?>
	<script src="assets/js/jquery-1.10.2.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/dataTables/jquery.dataTables.js"></script>
	<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
	<script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>