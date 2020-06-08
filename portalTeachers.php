<?php
	session_start();
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
			<div class='backgoundDiv90'></div>

			<?php
				
				include_once("conectionDB.php");
				include_once("funciones.php");
						

					if(isset($_POST['sendLogin'])){
						$conection = Conection::singleton();
				        $existe = $conection->checkPassword();
						$warning = false;
				        if(Password::verify(Funciones::filtrado($_POST["pass"]),$existe[0])){
				        	$_SESSION["log"] = "Jpo4fIA4DsKrUwo1xy0";
				        	header("Location: newIssue.php");
						}else {
							echo '<p class="textCenter marginTop">La contraseña es incorrecta. Inténtelo de nuevo.</p>';

						}
					}else if(isset($_POST['sendAdmin'])){
						$conection = Conection::singleton();
				        $existe = $conection->checkPasswordAdmin();
				        if(Password::verify(Funciones::filtrado($_POST["passAdmin"]),$existe[0])){
				        	$_SESSION["admin"] = "Jpo4fIA4DsKrUwo1xy0";
				        	header("Location: adminPanel.php");
						}else { 
							echo '<p class="textCenter marginTop">La contraseña es incorrecta. Inténtelo de nuevo.</p>';
						}
					}

				

					if(isset($_GET['login']) && $_GET['login'] == "2"){
						?>
						<form action="#" method="post">
							<div class="formLogin">

								<div class="username">
									<span class="tittleForm">Administrador</span>
								</div>
								<div class="password">
									<input class="inputAccess" type="password" name="passAdmin" placeholder="Contraseña" <?php if(isset($_POST["passAdmin"])) echo "value=\"".$_POST["passAdmin"]."\""; ?>>
								</div>
								<div class="login1">
								<input type="submit" class="inputSubmit" name="sendAdmin" value="Acceder">

								</div>
								<p class="textCenter">Cambiar a login de <a class="linkOtherLogin" href="portalTeachers.php"> Profesores</a></p>

							</div>	
						</form>
						

						<?php
					}else {
						?>
							
						<form action="#" method="post">

							<div class="formLogin">

								<div class="username">
									<span class="tittleForm">Profesores</span>
								</div>
								<div class="password">
									<input class="inputAccess" type="password" name="pass" placeholder="Contraseña" <?php if(isset($_POST["pass"])) echo "value=\"".$_POST["pass"]."\""; ?>>
								</div>
								<div class="login1">
								<input type="submit" class="inputSubmit" name="sendLogin" value="Acceder">

								</div>
								<p class="textCenter">Cambiar a login de <a class="linkOtherLogin" href="portalTeachers.php?login=2"> Administrador</a></p>

							</div>
						</form>


						<?php
					}
				
				
				include_once("footer.html")
			?>
		</body>
</html>