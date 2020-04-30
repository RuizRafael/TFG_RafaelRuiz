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
			<h1> Incidencias! </h1>	

			<?php
				

				include_once("conectionDB.php");
				include_once("funciones.php");

				
				$confirm = false;
				if(isset($_POST['enviar'])){
						if(!empty($_POST['email'])){
							if(!empty($_POST['description'])){
								$confirm = true;

							}else{
								echo "La descripcion no puede estar vacía";
							}
						}else{
							echo "Es obligatorio escribir un correo.";
						}
				}
			?>	


				<form name="form1" id="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<h3>Nueva Incidencia</h3>

					<label>Email:</label><input type="email" name="email" <?php if(isset($_POST["email"])) echo "value=\"".$_POST["email"]."\""; ?>><br /><br />

					<label>Descripcion del problema:</label><input type="text" name="description" id="description" <?php if(isset($_POST["description"])) echo "value=\"".$_POST["description"]."\""; ?>><br /><br />

					<label for="department">Departamento</label>
					<select id="department" name="department">
					  <option value="informatica" selected="selected">Informática</option>
					  <option value="lengua">Lengua</option>
					  <option value="matematicas">Matemáticas</option>
					  <option value="carroceria">Carrocería</option>
					</select><br /><br />

					<label for="importance">Nivel de urgencia  ( ⬇️ 1 / 10 ⬆️ )</label>
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
					
					<input type="submit" name="enviar" id="enviar"><br /><br /><br />
				</form><br /><br />

				

				<?php
				
					if($confirm){

				?>
							<table>
								<tr>
									<th>Email</th>
									<th>Descripcion</th>
									<th>Departamento</th>
									<th>Urgencia</th>
								</tr>
								<tr>
									<td><?php echo $_POST['email']; ?></td>
									<td><?php echo $_POST['description']; ?></td>
									<td><?php echo $_POST['department']; ?></td>
									<td><?php echo $_POST['importance']; ?></td>
								</tr>
							</table>
							
							<br />
							<form name="form4" id="form4" action="confirmNewIssue.php" method="post">
								<input type="hidden" name="email" <?php echo "value=\"".$_POST["email"]."\""; ?>>
								<input type="hidden" name="description" <?php echo "value=\"".$_POST["description"]."\""; ?>>
								<input type="hidden" name="department" <?php echo "value=\"".$_POST["department"]."\""; ?>>
								<input type="hidden" name="importance" <?php echo "value=\"".$_POST["importance"]."\""; ?>>
								<input type="submit" name="confirm" value="¿Confirmar?"><br /><br />
							</form>

						
				<?php	
					}
				?>

		</body>
</html>
							