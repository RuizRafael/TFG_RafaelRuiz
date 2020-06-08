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
					<div class="hoverNav teachersNav" title="Nueva Incidencia"><a id="nav1" href="newIssue.php"><img width='50' src='assets/img/teachers.png'></a></div>
					<div class="hoverNav teachersSearch" title="Buscador de Incidencia"><a href="searchIssue.php"><img width='50' src='assets/img/search.png'></a></div>
					<div class="hoverNav adminNav activeNavSite" title="Panel de Administrador"><a href="adminPanel.php"><img width='50' src='assets/img/admin.png'></a></div>
					<div class="hoverNavLine"></div>
				</div>
			</div>

			<div class="logoutIcon tutorialIcon" title="Volver atrás"><a href="adminPanel.php"><img width='30' src='assets/img/goback.png'></a></div>
			<div class="logoutIcon" title="Cerrar Sesión"><a href="adminPanel.php?logout=0"><img width='30' src='assets/img/logout.png'></a></div>

			
				<img src='assets/img/tutorial2.png'>


				

			<?php
				include_once("footer.html")
			?>
		</body>
</html>