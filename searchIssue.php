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
					<div class="hoverNav teachersSearch activeNavSite" title="Buscador de Incidencia"><a href="searchIssue.php"><img width='50' src='assets/img/search.png'></a></div>
					<div class="hoverNav adminNav" title="Panel de Administrador"><a href="adminPanel.php"><img width='50' src='assets/img/admin.png'></a></div>
					<div class="hoverNavLine"></div>
				</div>
			</div>
			<div class="logoutIcon" title="Cerrar Sesión"><a href="newIssue.php?logout=0"><img width='30' src='assets/img/logout.png'></a></div>
			
			<?php

				function printFormID(){
					?>
					<div class='backgoundDiv100'></div>

					<form action=" <?php $_SERVER['PHP_SELF']; ?>" method="get">
						<div class="formLogin">

							<div class="username">
								<span class="tittleForm tittleSearchID">Buscador de Incidencia</span>
							</div>
							<div class="password">
								<input class="inputAccess" type="text" name="idIssue" placeholder="Id de la Incidencia" <?php if(isset($_POST["idIssue"])) echo "value=\"".$_POST["idIssue"]."\""; ?>>
							</div>
							<div class="login1">
							<input type="submit" class="inputSubmit" name="sendId" value="Comprobar">

							</div>
							<p class="textCenter">Buscar incidencias por tu <a class="linkOtherLogin" href="searchIssue.php?login=2"> Correo Electrónico</a></p>

						</div>	
					</form>
					<?php
				}
				function printFormEmail(){
					?>
					<div class='backgoundDiv100'></div>

					<form action=" <?php $_SERVER['PHP_SELF']; ?>" method="get">
						<div class="formLogin">

							<div class="username">
								<span class="tittleForm tittleSearchID">Buscador de Incidencia</span>
							</div>
							<div class="password">
								<input class="inputAccess inputEmail" type="text" name="emailIssue" placeholder="Correo Electrónico" <?php if(isset($_POST["emailIssue"])) echo "value=\"".$_POST["emailIssue"]."\""; ?>>
							</div>
							<div class="login1">
							<input type="submit" class="inputSubmit" name="sendEmail" value="Comprobar">

							</div>
							<p class="textCenter">Buscar por <a class="linkOtherLogin" href="searchIssue.php"> ID de Incidencia</a></p>

						</div>	
					</form>
					<?php
				}


				
			 	if(isset($_GET['sendEmail'])){
			      	header("Location: ".$_SERVER['PHP_SELF']."?table=true&emailIssue=".$_GET['emailIssue']);
			 	} else if(isset($_GET['sendId'])){
			 		if($_GET['idIssue'] == ""){
			 			echo '<p class="textCenter marginTop">Tienes que introducir un ID, inténtelo de nuevo.</p>';
			 		} else if($_GET['idIssue'] == "0"){
			 			echo '<p class="textCenter marginTop">Tienes que introducir un ID mayor que 0.</p>';
			 		} else {
			      		header("Location: ".$_SERVER['PHP_SELF']."?table=true&idIssue=".$_GET['idIssue']);
			 		}
			 	}

				if(isset($_SESSION['log'])){
					$conection = Conection::singleton();
					if(isset($_GET['addNote'])){
			      		if($_POST['note'] != ""){
			      			$datehOUR = date("d/m")."-".date("G:i");
			      			if($_GET['note'] != ""){
			      				$noteUpdated = $_GET['note']."<br />";
			      			}
			      			$noteUpdated = $noteUpdated ."(".$datehOUR.") Autor: ".$_POST['note'];
			      			echo $noteUpdated;
			      			$conection->updateNote($noteUpdated,$_GET['addNote']);	
			      			header("Location: ".$_SERVER['PHP_SELF']."?table=true&idIssue=".$_GET['addNote']);

			      		}
			      	}

					if (isset($_GET['table'])) {

						if (isset($_GET['emailIssue'])) {
			      			$email = Funciones::filtrado($_GET['emailIssue']);
			      			$issueInfo = $conection->issuesEmail($email);
						} else if (isset($_GET['idIssue'])) {
							$id = Funciones::filtrado($_GET['idIssue']);
			      			$issueInfo = $conection->issuesId($id);
						}

			      		if(isset($id) && $issueInfo == []){
							echo '<p class="textCenter marginTop">No existe ninguna incidencia con el ID "'.$id.'"</p>';
							printFormID();
			      		} else if(isset($email) && $issueInfo == []){
							echo '<p class="textCenter marginTop">No existe ninguna incidencia para el correo "'.$email.'"</p>';
							printFormEmail();
			      		} else {


							echo '<div class="tableContent">';
								echo '<table class="issuesPanel" align="center">';
									$array = ["Id","Email","Descripción","Hora","Fecha","Departamento","Urgencia","Estado","Notas"];
				   					for ($i=0; $i < count($array) ; $i++) { 
				   						echo "<td class='firstRow'>".$array[$i]."</td>";
				   					}
									echo "</tr>"; 
									for ($j=0; $j < count($issueInfo); $j++) { 
											if ($j%2 == 0) {
												echo "<tr class='borderBlack'>";
											}else {
												echo "<tr class='borderLight'>";
											}
						      			for ($i=0; $i <= 7 ; $i++) {
											if($i == "2"){
												echo '<td class="leftAlign">'.$issueInfo[$j][$i].'</div></td>';
											}else if($i == "7"){
												echo "<td>".Funciones::colorState($issueInfo[$j][7])."</div></td>";
											} else {
												echo "<td>".$issueInfo[$j][$i]."</td>";
											}
										}
										echo "<td><a href='".$_SERVER['PHP_SELF']."?table=true&idIssue=".$issueInfo[$j][0]."&noteId=".$issueInfo[$j][0]."' title='Abrir panel de notas'>";
										if($issueInfo[$j][8] != ""){
											echo "<img width='30' src='assets/img/noteW.png'>";
										} else {
											echo "<img width='30' src='assets/img/note.png'>";
										}
										echo "</a></td></tr>";
									}

								echo "</table></div>";
			      		}
			      		if(isset($_GET['noteId'])){
				      		$issueInfo = $conection->issuesId($_GET['noteId']);

				      		?>

				      		<div id="panelNote" class="note">
					          <!-- Contenido oculto, visible al desplegarse con el boton superior -->
					          <div class="note-content">
					            <div class="note-header">
					              <span class="close">X</span>
					              <?php echo "<h3>Notas incidencia ID: ".$issueInfo[0][0]."<br />De : ".$issueInfo[0][1]." <br />".$issueInfo[0][3]." del ".$issueInfo[0][4]."</h3></div><p class='notesWithDate'>".$issueInfo[0][8].""; ?>
					            
									<form action="<?php echo $_SERVER['PHP_SELF']."?addNote=".$issueInfo[0][0]."&note=".$issueInfo[0][8] ?>" method="post">
										<textarea class="inputNote" placeholder="Toca para añadir una nota!" name="note"></textarea>
						             
						            	<div class="note-footer">
						            	<input class="textCenter noteSubmit" type="submit" value="Guardar">
				              		</form>
					            </div>
					          </div>
					        </div>

					        <?php
						    echo "<script>";
							echo "panelInformacion();";
							echo "</script>";
						}
						echo "<div class='backgoundDiv80'></div>";

					} else if (isset($_GET['login']) && $_GET['login']=="2") {
						printFormEmail();
					} else {
						printFormID();
					}

			
				}else{
					header("Location: portalTeachers.php");
				}		
				include_once("footer.html")
			?>
		</body>
</html>
							