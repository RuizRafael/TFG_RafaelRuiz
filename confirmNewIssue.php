<?php
	include_once("conectionDB.php");
	include_once("funciones.php");
?>
<!DOCTYPE html>

<html lang="es"> 
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Rafa"/>
		<meta name="description" content="Control Incidencias IES Enrique Tierno Galvan"/>
		<title>Control Incidencias</title>
		<link rel="stylesheet" type="text/css" href="assets/css/css.css">
		<link rel="icon" type="image/png" href="assets/img/icon.png" />

		<script src="assets/js/js.js"></script>
	</head>
		<body>	

			<div class="nav">
				<div class="navCenter">
					<div class="hoverNav teachersNav activeNavSite" title="Nueva Incidencia"><a id="nav1" href="newIssue.php"><img width='50' src='assets/img/teachers.png'></a></div>
					<div class="hoverNav teachersSearch" title="Buscador de Incidencia"><a href="searchIssue.php"><img width='50' src='assets/img/search.png'></a></div>
					<div class="hoverNav adminNav" title="Panel de Administrador"><a href="adminPanel.php"><img width='50' src='assets/img/admin.png'></a></div>
					<div class="hoverNavLine"></div>
				</div>
			</div>
			<div class="logoutIcon" title="Cerrar Sesión"><a href="newIssue.php?logout=0"><img width='30' src='assets/img/logout.png'></a></div>

						<div class='backgoundDiv90'></div>

			<?php
				

					if(isset($_POST['newIssue'])){

						$emailAuthor = Funciones::filtrado($_POST['email']);
						$description = Funciones::filtrado($_POST['description']);
						$department = Funciones::filtrado($_POST['department']);
						$importance = Funciones::filtrado($_POST['importance']);

						$conection = Conection::singleton();
						
					
			?>

						<div class="formLogin">

							<div class="username confirmAlert ">
																				
			<?php
						if(isset($_COOKIE['controlTime'])){
							echo '<span class="tittleForm">Error!</span></div>';
							echo "<br /><p class='paddingText'>Se ha actualizado la página y tu consulta ya se había mandado, vuelve atrás si quieres añadir otra.<p><br />";
						}else {
							$issueID = $conection->newIssue($emailAuthor,$description,$department,$importance);

							echo '<span class="tittleForm">Enviado!</span></div>';
						

							$subjectAdmin = "Nueva Incidencia. IES Tierno Galvan.";
							$emails = Funciones::loadConf("2");
					       	$issueID = $conection->selectLastID();
					      	 
					      	for ($i=1; $i <= count($emails['emails']); $i++) { 
					       		$emailNum = "email".$i;
								Email::sendEmail("2",$emails['emails'][$emailNum],$issueID[0],"","",$description,$department,$importance);    
							}	
							$correct = Email::sendEmail("1",$emailAuthor,$issueID[0],"","",$description,$department,$importance); 
	   
							if($correct){
								echo "<p class='paddingText'>Tu consulta con el ID: ".$issueID[0]." se ha mandado, recibiras una copia por correo. <br />(Revisa la bandeja de \"Correo no deseado\" o \"Spam\")</p>";
							} else {
								echo "<p class='paddingText'>Tu consulta con el ID: ".$issueID[0]." se ha mandado, pero un error no hace posible el envio de una copia por email.<p>";
							}
							
								
							setcookie("controlTime", "true", time() + (30), "/"); // 86400 = 1 day
						}
							echo '<p class="textCenter">Volver <a class="underlined" href="newIssue.php"> atrás</a></p></div>';

					}else{
						header("Location: newIssue.php");
					}
					

				include_once("footer.html")
			?>
						
		</body>
</html>