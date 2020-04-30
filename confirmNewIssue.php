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
							

					if(isset($_POST['confirm'])){
						$conection = Conection::singleton();
				        $issueID = $conection->newIssue($_POST['email'],$_POST['description'],$_POST['department'],$_POST['importance']);
				        echo "Tu consulta se ha mandado, recibiras una copia por correo. Tu numero de incidencia es el ".$issueID;
	

				        $to = "rafaelruiz444@hotmail.com";
						$subject = "Copia de la incidencia.";
						$message = $_POST['description']."<br /> Del departamento: ". $_POST['department']."<br /> Con una urgencia: ". $_POST['importance'];
						 
						mail($to, $subject, $message);
						mail("rafaelruiz444@hotmail.com","asuntillo","Este es el cuerpo del mensaje");









					}else{
						echo "No tienes acceso a esta página sin escribir primero una incidencia.<br /> Seras redirigido al inicio.";
					}


				
			?>	

	

						
		</body>
</html>