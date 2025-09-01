<?php
	session_start();
	error_reporting(0);
	include('includes/config.php');
	if(strlen($_SESSION['login'])==0) {   
		header('location:index.php');
	} else {
		if(isset($_POST['change'])) {
			$clave = md5($_POST['clave']);
			$nuevaclave = md5($_POST['nuevaclave']);
			$correo = $_SESSION['login'];
			$sql = "SELECT clave FROM estudiante WHERE correo=:correo AND clave=:clave";
			$query = $dbh -> prepare($sql);
			$query -> bindParam(':correo', $correo, PDO::PARAM_STR);
			$query -> bindParam(':clave', $clave, PDO::PARAM_STR);
			$query -> execute();
			$results = $query -> fetchAll(PDO::FETCH_OBJ);
			if($query -> rowCount() > 0) {
				$con ="UPDATE estudiante SET clave=:nuevaclave where correo=:correo";
				$chngpwd1 = $dbh -> prepare($con);
				$chngpwd1 -> bindParam(':correo', $correo, PDO::PARAM_STR);
				$chngpwd1 -> bindParam(':nuevaclave', $nuevaclave, PDO::PARAM_STR);
				$chngpwd1 -> execute();
				$msg="Su Clave se cambió exitosamente!!";
			} else {
				$error="Su clave antigua no coincide con la registrada!!";
			}
		}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>OLMS | Cambiar Clave</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	<style>
		.errorWrap {
			padding: 10px;
			margin: 0 0 20px 0;
			background: #fff;
			border-left: 4px solid #dd3d36;
			-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
			box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
		}
		.succWrap{
			padding: 10px;
			margin: 0 0 20px 0;
			background: #fff;
			border-left: 4px solid #5cb85c;
			-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
			box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
		}
	</style>
</head>
<script type="text/javascript">
	function valid() {
		if(document.cambio.nuevaclave.value!= document.cambio.confirmarclave.value) {
			alert("Las contraseñas no coinciden!!");
			document.cambio.confirmarclave.focus();
			return false;
		}
		return true;
	}
</script>
<body>
	<?php include('includes/header.php');?>
	<div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">Cambio de Clave</h4>
				</div>
			</div>
			<?php if($error) {?>
			<div class="errorWrap"><strong>ERROR </strong>:<?php echo htmlentities($error); ?> </div>
			<?php } else if($msg) {?>
			<div class="succWrap"><strong>EXITO </strong>:<?php echo htmlentities($msg); ?> </div>
			<?php }?>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
					<div class="panel panel-info">
						<div class="panel-heading">Formulario</div>
						<div class="panel-body">
							<form method="post" onSubmit="return valid();" name="cambio">
								<div class="form-group">
									<label>Ingrese Clave Antigua:</label>
									<input class="form-control" type="password" name="clave" autocomplete="off" required  />
								</div>
								<div class="form-group">
									<label>Ingrese Nueva Clave:</label>
									<input class="form-control" type="password" name="nuevaclave" autocomplete="off" required  />
								</div>
								<div class="form-group">
									<label>Confirme Nueva Clave:</label>
									<input class="form-control"  type="password" name="confirmarclave" autocomplete="off" required  />
								</div>
								<button type="submit" name="change" class="btn btn-info">Cambiar Clave</button> 
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