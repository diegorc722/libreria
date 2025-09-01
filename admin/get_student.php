<?php 
require_once("includes/config.php");
if(!empty($_POST["codigo"])) {
	$codigo = strtoupper($_POST["codigo"]);
	$sql = "SELECT nombres,estado FROM estudiante WHERE codigo=:codigo";
	$query= $dbh -> prepare($sql);
	$query-> bindParam(':codigo', $codigo, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	$cnt = 1;
	if($query -> rowCount() > 0) {
		foreach ($results as $result) {
			if($result->estado==0) {
				echo "<span style='color:red'>Código Estudiante Bloqueado!!</span>"."<br />";
				echo "<b>Nombre Estudiante - </b>".$result->nombres;
				echo "<script>$('#submit').prop('disabled',true);</script>";
			} else {
				echo "<span style='color:green'>Código Estudiante Aceptado!!</span>"."<br />";
				echo "<b>Nombre Estudiante :</b>".$result->nombres;
				echo "<script>$('#submit').prop('disabled',false);</script>";
			}
		}
	} else {
		echo "<span style='color:red'>Código Estudiante Inválido!!</span>";
		echo "<script>$('#submit').prop('disabled',true);</script>";
	}
}
?>