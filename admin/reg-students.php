<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	if(strlen($_SESSION['alogin'])==0) {   
		header('location:index.php');
	} else {
		if(isset($_GET['inid'])) {
			$id = $_GET['inid'];
			$estado = 0;
			$sql = "UPDATE estudiante SET estado=:estado WHERE id=:id";
			$query = $dbh->prepare($sql);
			$query -> bindParam(':id',$id, PDO::PARAM_STR);
			$query -> bindParam(':estado',$estado, PDO::PARAM_STR);
			$query -> execute();
			header('location:reg-students.php');
		}
		if(isset($_GET['id'])) {
			$id = $_GET['id'];
			$estado = 1;
			$sql = "UPDATE estudiante SET estado=:estado WHERE id=:id";
			$query = $dbh->prepare($sql);
			$query -> bindParam(':id',$id, PDO::PARAM_STR);
			$query -> bindParam(':estado',$estado, PDO::PARAM_STR);
			$query -> execute();
			header('location:reg-students.php');
		}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Listado Estudiantes</title>
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
					<h4 class="header-line">LISTADO DE ESTUDIANTES REGISTRADOS</h4>
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
											<th>Código</th>
											<th>Nombres</th>
											<th>Correo</th>
											<th>Celular</th>
											<th>Fecha Registro</th>
											<th>Estado</th>
											<th>Acción</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql = "SELECT * FROM estudiante WHERE estado NOT LIKE '-1' ORDER BY id DESC";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0) {
												foreach($results as $result) {
										?>                                      
										<tr class="odd gradeX">
											<td class="center"><?php echo htmlentities($cnt);?></td>
											<td class="center"><?php echo htmlentities($result->codigo);?></td>
											<td class="center"><?php echo htmlentities($result->nombres);?></td>
											<td class="center"><?php echo htmlentities($result->correo);?></td>
											<td class="center"><?php echo htmlentities($result->celular);?></td>
											<td class="center"><?php echo htmlentities($result->fechaRegistro);?></td>
											<td class="center">
												<?php
													if($result->estado==1) {
														echo htmlentities("Activo");
													} else {
														echo htmlentities("Bloqueado");
													}
												?>
											</td>
											<td class="center">
												<?php if($result->estado==1) {?>
												<a href="reg-students.php?inid=<?php echo htmlentities($result->id);?>" onclick="return confirm('¿Estás seguro que quieres BLOQUEAR a este estudiante?');" >  <button class="btn btn-danger"> Bloquear</button>
												<?php } else {?>
												<a href="reg-students.php?id=<?php echo htmlentities($result->id);?>" onclick="return confirm('¿Estás seguro que quieres ACTIVAR a este estudiante?');"><button class="btn btn-primary"> Activar</button> 
												<?php } ?>
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