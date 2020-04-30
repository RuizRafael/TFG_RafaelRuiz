<!DOCTYPE html>

<html lang="es"> 
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Rafa"/>
		<meta name="description" content="Control Incidencias IES Enrique Tierno Galvan"/>
		<title>Control Incidencias</title>
		<link rel="stylesheet" type="text/css" href="assets/css.css">

		<script src="js.js"></script>
	</head>
		<body>	
			<h1> Incidencias </h1>	

			<?php
				

				include_once("conectionDB.php");
				include_once("funciones.php");

				

				if(isset($_POST['enviar'])){
						
				}
			?>	

			<div class="buttons">
				<a class="login issue" href="portalTeachers.php?login=1"><label>Nueva Incidencia</label></a>
				<a class="login admin" href="portalTeachers.php?login=2"><label>Administrador</label></a> 
			</div>	
			
			

						
		</body>
</html>