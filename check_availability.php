<?php 
require_once("includes/config.php");
if(!empty($_POST["correo"])) {
	$correo= $_POST["correo"];
	if (filter_var($correo, FILTER_VALIDATE_EMAIL)===false) {
		echo "<span style='color:red'>ERROR : Correo NO Válido</span>";
		echo "<script>$('#submit').prop('disabled',true);</script>";
	} else {
		$sql ="SELECT correo FROM estudiante WHERE correo=:correo";
		$query= $dbh -> prepare($sql);
		$query-> bindParam(':correo', $correo, PDO::PARAM_STR);
		$query-> execute();
		$results = $query -> fetchAll(PDO::FETCH_OBJ);
		$cnt=1;
		if($query -> rowCount() > 0) {
			echo "<span style='color:red'> Correo Ya Existe!!</span>";
			echo "<script>$('#submit').prop('disabled',true);</script>";
		} else{
			echo "<span style='color:green'> Correo Electrónico Disponible para Registro.</span>";
			echo "<script>$('#submit').prop('disabled',false);</script>";
		}
	}
}
?>