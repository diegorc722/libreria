<?php 
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0) {
	header('location:index.php');
} else {
	if(isset($_POST['update'])) {	
		$codigo = $_SESSION['id'];  
		$nombres = $_POST['nombres'];
		$correo = $_POST['correo'];
		$celular = $_POST['celular'];
		$sql = "UPDATE estudiante SET nombres=:nombres,correo=:correo,celular=:celular WHERE codigo=:codigo";
		$query = $dbh->prepare($sql);
		$query->bindParam(':codigo',$codigo,PDO::PARAM_STR);
		$query->bindParam(':nombres',$nombres,PDO::PARAM_STR);
		$query->bindParam(':correo',$correo,PDO::PARAM_STR);
		$query->bindParam(':celular',$celular,PDO::PARAM_STR);
		$query->execute();
		echo '<script>alert("Tus datos han sido Actualizado!!")</script>';
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Perfil</title>
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
				<div class="col-md-12"><h4 class="header-line">Mi Perfil</h4></div>
			</div>
			<div class="row">
				<div class="col-md-9 col-md-offset-1">
					<div class="panel panel-danger">
						<div class="panel-heading">Formulario</div>
						<div class="panel-body">
							<form name="signup" method="post">
								<?php 
								$codigo=$_SESSION['id'];
								$sql="SELECT nombres,codigo,correo,celular,fechaRegistro,fechaActualizada,estado FROM estudiante WHERE codigo=:codigo";
								$query = $dbh -> prepare($sql);
								$query-> bindParam(':codigo', $codigo, PDO::PARAM_STR);
								$query->execute();
								$results=$query->fetchAll(PDO::FETCH_OBJ);
								$cnt=1;
								if($query->rowCount() > 0) {
									foreach($results as $result){
								?>
								<div class="form-group">
									<label>Fecha Registro : </label>
									<?php echo htmlentities($result->fechaRegistro);?>
								</div>
								<?php if($result->fechaActualizada!="") {?>
								<div class="form-group">
									<label>Fecha Ultima Actualización : </label>
									<?php echo htmlentities($result->fechaActualizada);?>
								</div>
								<?php } ?>
								<div class="form-group">
									<label>Estado Perfil : </label>
									<?php if($result->estado==1) {?>
									<span style="color: green">Activo</span>
									<?php } else { ?>
									<span style="color: red">Bloqueado</span>
									<?php }?>
								</div>
								<div class="form-group">
									<label>Código Estudiante : </label>
									<span style="color: blue;font-weight: bold; font-size: 1.2em;"><?php echo htmlentities($result->codigo);?></span>
								</div>
								<div class="form-group">
									<label>Nombres Completos:</label>
									<input class="form-control" type="text" name="nombres" value="<?php echo htmlentities($result->nombres);?>" autocomplete="off" required />
								</div>
								<div class="form-group">
									<label>Número Celular:</label>
									<input class="form-control" type="text" name="celular" maxlength="10" value="<?php echo htmlentities($result->celular);?>" autocomplete="off" required />
								</div>
								<div class="form-group">
									<label>Correo Electrónico:</label>
									<input class="form-control" type="email" name="correo"  value="<?php echo htmlentities($result->correo);?>"  autocomplete="off" required readonly />
								</div>
								<?php }} ?>
								<button type="submit" name="update" class="btn btn-primary" id="submit">Actualizar Ahora</button>
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
