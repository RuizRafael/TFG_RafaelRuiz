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
				
					/* Conseguir hash de contraseñas
					$resultado = Password::hash("rafael");
					echo $resultado;
					*/
					if(isset($_POST['sendLogin'])){
						$conection = Conection::singleton();
				        $existe = $conection->checkPassword($_POST["pass"]);
				       // if(Password::verify($_POST["pass"],$existe[0])){
				        if($_POST["pass"] == $existe[0]){
				        	header("Location: newIssue.php");
						}else { 
							echo "La contraseña es incorrecta. Inténtelo de nuevo.";
						}
					}else if(isset($_POST['sendAdmin'])){
						$conection = Conection::singleton();
				        $existe = $conection->checkPasswordAdmin($_POST["passAdmin"]);
				     //   if(Password::verify($_POST["passAdmin"],$existe[0])){
				        if($_POST["passAdmin"] == $existe[0]){
				        	header("Location: adminPanel.php");
						}else { 
							echo "La contraseña es incorrecta. Inténtelo de nuevo.";
						}
					}

				if(isset($_GET['login'])){
					echo '<form name="form4"  action="#" method="post">';
					if($_GET['login'] == "1"){
						?>
							
							<label>Contraseña para poner incidencia:</label><input type="pass" name="pass" <?php if(isset($_POST["pass"])) echo "value=\"".$_POST["pass"]."\""; ?>><br /><br />
							<input type="submit" name="sendLogin" id="enviar"><br /><br /><br />

								
						<?php
					}else if($_GET['login'] == "2"){
						?>
							<label>Contraseña del administrador:</label><input type="passAdmin" name="passAdmin" <?php if(isset($_POST["passAdmin"])) echo "value=\"".$_POST["passAdmin"]."\""; ?>><br /><br />
							<input type="submit" name="sendAdmin" value="Acceder"><br /><br /><br />
							
						<?php
					}else{
						header("Location: login.php");
					}
					echo "</form>";
				}else{
					header("Location: login.php");
				}
			?>	

	

						
		</body>
</html>