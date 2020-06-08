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

			<div class="logoutIcon tutorialIcon" title="Tutorial"><a href='tutorial.php' target="_blank"><img width='30' src='assets/img/tutorial.png'></a></div>
			<div class="logoutIcon" title="Cerrar Sesión"><a href="adminPanel.php?logout=0"><img width='30' src='assets/img/logout.png'></a></div>

			<div class="adminPanel">
				<div class="tableContent">
					<table class="issuesPanel" align="center">
						<tr >
					 <?php

						function checkOrderBy(){
							$get = "";
							if(isset($_GET['orderedBy'])){
								$get = "?orderedBy=".$_GET['orderedBy'];
							}
							header("Location: adminPanel.php".$get);

						}

					 	if(isset($_GET['logout'])){
					 		Funciones::logout();
							header("Location: portalTeachers.php?login=2");
					 	}

					 	if(isset($_SESSION['admin']) && ($_SESSION['admin'] == "Jpo4fIA4DsKrUwo1xy0")){
					      	$conection = Conection::singleton();				  

					      	if(isset($_GET['updateTo']) and isset($_GET['id'])){

					      		$issueInfo = $conection->issuesId($_GET['id']);

							    $conection->updateState($_GET['updateTo'],$_GET['id']);
							    
							   	Email::sendEmail("3",$issueInfo[0][1],$_GET['id'],$issueInfo[0][7],$_GET['updateTo'],"","","");    

							 	checkOrderBy();
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
					      	if(isset($_GET['addNote'])){
					      		if($_POST['note'] != ""){
					      			$datehOUR = date("d/m")."-".date("G:i");
					      			if($_GET['note'] != ""){
					      				$noteUpdated = $_GET['note']."<br />";
					      			}
			      					$noteUpdated = $noteUpdated ."(".$datehOUR.") Administrador: ".$_POST['note'];
					      			echo $noteUpdated;
					      			$conection->updateNote($noteUpdated,$_GET['addNote']);

					      			$issueInfo = $conection->issuesId($_GET['addNote']);

					      			Email::sendEmail("4",$issueInfo[0][1],$issueInfo[0][0],"","",$noteUpdated,"","");    

							    	checkOrderBy();
		
					      		}
					      	}
					      	if(isset($_GET['confirmed'])){
						        $conection->deleteId($_GET['confirmed']);
								checkOrderBy();
							}


					 		
			   				$array = ["Id","Email","Descripción","Hora","Fecha","Departamento","Urgencia","Estado","Notas"];
			   					for ($i=0; $i < count($array) ; $i++) { 
			   						if($i == 3 || $i == 4){
										echo "<td class='firstRow'>".$array[$i]."</td>";
			   						} else {
			   							echo "<td class='firstRow' title='Ordenar por ".$array[$i]."'><a class='whiteLinks' href='adminPanel.php?orderedBy=".$array[$i]."'>".$array[$i]."</a></td>";
			   						}
			   						
			   					}
					  
							echo "</tr>"; 
						
					   
							if(isset($_GET['orderedBy'])){
						    	$issues = $conection->allIssues($_GET['orderedBy']);
							} else {	   	
						    	$issues = $conection->allIssues();
						    }
							for ($i=0; $i < count($issues); $i++) { 
								if ($i%2 == 0) {
									$borderBlack = "borderBlack";
									echo "<tr class='".$borderBlack."'>";
								}else {
									echo "<tr class='borderLight'>";
								}

								for ($j=0; $j <= 7 ; $j++) {
									if($j == "2"){
										echo '<td class="leftAlign">'.$issues[$i][$j].'</td>';
									}else if($j == "6"){
										echo '<td>'.$issues[$i][$j].'</td>';

									}else if($j == "7" and (isset($_GET['update']) and $_GET['update'] == ($issues[$i][0]))){
										$get = "&id=".$issues[$i][0];
										if(isset($_GET['orderedBy'])){
											$get = $get. "&orderedBy=".$_GET['orderedBy'];
										}
										echo '<td><a href="adminPanel.php?updateTo=1'.$get.'"><div class="state state1">Sin revisar</div></a><a href="adminPanel.php?updateTo=2'.$get.'"><div class="state state2">En proceso</div></a><a href="adminPanel.php?updateTo=3'.$get.'"><div class="state state3">Finalizado</div></a></td>';

									}else if($j == "7"){
										$order = "";
										if(isset($_GET['orderedBy'])){
											$order = "&orderedBy=".$_GET['orderedBy'];
										}
										echo "<td><a href='adminPanel.php?update=".$issues[$i][0].$order."' title='Editar Estado'>".Funciones::colorState($issues[$i][7])."</div></a></td>";

									} else {
										echo "<td>".$issues[$i][$j]."</td>";
									}
									

								}
								$orderGet = "";
								if(isset($_GET['orderedBy'])){
									$orderGet = $orderGet. "&orderedBy=".$_GET['orderedBy'];
								}
								echo "<td><a href='#' onclick='confirmDelete(".$issues[$i][0].")'  title='Borrar Incidencia'><img width='30' src='assets/img/bin.jpg'></a><a href='adminPanel.php?noteId=".$issues[$i][0].$orderGet."' title='Abrir panel de notas'>";
								if($issues[$i][8] != ""){
									echo "<img width='30' src='assets/img/noteW.png'>";
								} else {
									echo "<img width='30' src='assets/img/note.png'>";
								}
								echo "</a></td></tr>";   
							}
		
						}else{
					        header("Location: portalTeachers.php?login=2");
						}

					?>


										
					</table>
				</div>
			</div>

			<?php
				include_once("footer.html")
			?>
		</body>
</html>