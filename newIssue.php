<?php
	session_start();
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

			<?php

				
			

				if(isset($_GET['logout'])){
			 		Funciones::logout();
					header("Location: portalTeachers.php");
			 	}	

				if(isset($_SESSION['log'])){

			?>				 	

					<div class="formIssue">
						<form action="confirmNewIssue.php" method="post">
							<h1>Nueva Incidencia</h1>

							<label>Email (Gmail preferiblemente):</label><input type="email" name="email" required="required" <?php if(isset($_POST["email"])) echo "value=\"".$_POST["email"]."\""; ?>><br /><br />

							<label>Descripcion del problema:</label><textarea rows="4" cols="50" name="description" id="description" minlength="8" maxlength="24990" required="required" <?php if(isset($_POST["description"])) echo "value=\"".$_POST["description"]."\""; ?>></textarea><br /><br />

							<label for="department">Departamento</label>
							<span class="customSelect">
								<select id="department" name="department">
								  <option value="Informática" selected="selected">Informática</option>
								  <option value="Lengua">Lengua</option>
								  <option value="Matemáticas">Matemáticas</option>
								  <option value="Carrocería">Carrocería</option>
								  <option value="Frío y Calor">Frío y Calor</option>
								</select><br /><br />
							</span>

							<label for="importance">Nivel de urgencia  ( ⬇️ 1 / 10 ⬆️ )</label>
							<span class="customSelect">
								<select id="importance" name="importance">
								  <option value="1" selected="selected">1</option>
								  <option value="2">2</option>
								  <option value="3">3</option>
								  <option value="4">4</option>
								  <option value="5">5</option>
								  <option value="6">6</option>
								  <option value="7">7</option>
								  <option value="8">8</option>
								  <option value="9">9</option>
								  <option value="10">10</option>

								</select><br /><br />
							</span>
							
							<input class="buttonSubmit" type="submit" name="newIssue" id="enviar"><br /><br /><br />
						</form><br /><br />
					</div>
						
			<?php					

				}else{
					header("Location: portalTeachers.php");
				}		

				include_once("footer.html")
			?>

		</body>
</html>
							