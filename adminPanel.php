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
			<h1>C<span class="subtitulo">reate</span>R<span class="subtitulo">ead</span>U<span class="subtitulo">pdate</span>D<span class="subtitulo">elete</span></h1>
	
			<table align="center">
			    <tr >
			      <td class="primera_fila">Id</td>
			      <td class="primera_fila">Email</td>
			      <td class="primera_fila">Hora</td>
			      <td class="primera_fila">Fecha</td>
			      <td class="primera_fila">Departamento</td>
			      <td class="primera_fila">Urgencia</td>
			      <td class="primera_fila">Estado</td>
			    </tr> 
			   
			   <?php
			   		include_once("conectionDB.php");

			   	
			      	$conection = Conection::singleton();
				    $issues = $conection->allIssues();
				  
					/*
					echo "<pre>";
					print_r($resultado);
					echo "</pre>";
					*/
					for ($i=0; $i < count($issues); $i++) { 
						echo "<tr>";
						for ($j=0; $j <= 7 ; $j++) { 
							 echo "<td>".$issues[$i][$j]."</td>";
						}
				
						echo "</tr>";   
					}
					

					
					


				?>
						
			      		</form>
				
			</table>
		</body>
</html>