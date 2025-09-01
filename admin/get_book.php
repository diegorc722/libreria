<?php 
require_once("includes/config.php");
if(!empty($_POST["isbn"])) {
	$isbn = $_POST["isbn"];
	$sql = "SELECT id,nombre,stock FROM libro WHERE isbn=:isbn";
	$query= $dbh -> prepare($sql);
	$query-> bindParam(':isbn', $isbn, PDO::PARAM_STR);
	$query-> execute();
	$results = $query -> fetchAll(PDO::FETCH_OBJ);
	$cnt = 1;
	if($query -> rowCount() > 0) {
		foreach ($results as $result) {
			if($result->stock==0) {
				echo "<span style='color:red'>Sin Stock!!</span><br />";
				echo "<b>Nombre Libro - </b>".$result->nombre;
				echo "<script>$('#submit').prop('disabled',true);</script>";
			} else {
				echo "<span style='color:green'>Libro Encontrado!!</span><br />";
				echo "<b>Nombre Libro :</b>".$result->nombre."<br/>";
				echo "<b>Stock :</b>".$result->stock;
				echo "<script>$('#submit').prop('disabled',false);</script>";
			}
		}
	} else {
		echo "<span style='color:red'>Número ISBN Inválido!!</span>";
		echo "<script>$('#submit').prop('disabled',true);</script>";
	}
}
?>