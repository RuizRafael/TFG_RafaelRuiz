<?php
	// Import PHPMailer classes into the global namespace
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	require 'vendor/autoload.php';
	class Funciones{

	    function __construct(){
	    }
	    public 	$array = ["Id","Email","Hora","Fecha","Departamento","Urgencia","Estado"];

		public function filtrado($datos){
			$datos= trim($datos); 
			$datos= stripslashes($datos); 
			$datos= htmlspecialchars($datos);  
			return $datos;
		}

		public function logOut() {
			session_unset();
			session_destroy();
			session_start();
			session_regenerate_id(true);
		}

		public function colorState($number){
			if($number == "0"){
				$result = "<div class='state state0'>Informativo";
			} else if($number == "1"){
				$result = "<div class='state state1'>Sin revisar";
			} else if($number == "2"){
				$result = "<div class='state state2'>En proceso";
			} else if($number == "3"){
				$result = "<div class='state state3'>Finalizado";
			} else {
				$result = "<div>";
			}
			return $result;
		}

		public function loadConf($option){
			$archivo = __DIR__ . "/assets/conf/conf.php";
			if($option == "1"){
				$contenido = parse_ini_file($archivo, false);
			}else {
				$contenido = parse_ini_file($archivo, true);
			}
			return $contenido;	
		}
			
	}


	class Password {
	    public static function hash($password) {
	        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 9]);
	    }
	    public static function verify($password, $hash) {
	        return password_verify($password, $hash);
	    }
	}

	class Email {
		public static function sendEmail($to, $email, $issueID, $state1, $state2, $description="Sin descripción", $department="Sin departamento", $importance="Sin importancia"){
			$mail = new PHPMailer(true);
			try {
			    //Server settings
				$mail->SMTPOptions = array(
				    'ssl' => array(
				    'verify_peer' => false,
				    'verify_peer_name' => false,
				    'allow_self_signed' => true
				    )
			    );

			    //$mail->SMTPDebug = 2;    //Descomentar para activar el debug
			    $mail->isSMTP();                                       
			    $mail->Host       = 'smtp.gmail.com';                
			    $mail->SMTPAuth   = true;                           
			    //Mismo nombre y passw que esta escrito en el ssmtp.conf    
			    $mail->Username   = 'noreplytiernogalvanincidencias@gmail.com';                    
			    $mail->Password   = 'Nohay2sin3';                              
			    $mail->SMTPSecure = 'tls';
			    $mail->Port       = 587;                                  

			    //Recipients
			    $mail->setFrom('noreplytiernogalvanincidencias@gmail.com', 'Incidencias T.Galvan.');
			   
				$mail->addAddress($email);     

				$mail->isHTML(true); 

				 // Contenido del correo
				// 1 = Author, 2 = copia admin, 3 = notificar cambio de estado
				
				if($to == "1"){
					$subject = "Copia de la Incidencia (ID ".$issueID."). IES Tierno Galvan.";
					$body = "Incidencia número ".$issueID.".<br />Descripción: ".$description.". <br />Del departamento: ". $department.". <br />Con una urgencia: ". $importance."<br /><br /><br />Puedes consultar el estado de tu incidencia en la página de búsqueda incidencias con el ID:".$issueID." o directamente escribiendo tu correo electrónico";
				} else if($to == "2") {
					$subject = "Nueva Incidencia (ID ".$issueID."). IES Tierno Galvan.";
					$body = "Incidencia número ".$issueID.".<br />Descripción: ".$description.". <br />Del departamento: ". $department.". <br />Con una urgencia: ". $importance;			
				} else if($to == "3") {	
					$subject = "Cambio de Estado en la incidencia con (ID ".$issueID."). IES Tierno Galvan.";
					$body = "Cambio de Estado en la incidencia con (ID ".$issueID.").<br /> Ha pasado de estar ".Funciones::colorState($state1)." a ".Funciones::colorState($state2).". <br />Puedes consultar el estado de tu incidencia en la página de búsqueda incidencias con el ID:".$issueID." o directamente escribiendo tu correo electrónico";
				} else {
					$subject = "Nueva nota en la incidencia con (ID ".$issueID."). IES Tierno Galvan.";
					$body = "Nueva nota del Administrador en la incidencia con (ID ".$issueID.").<br />".$description." 
					 <br />Puedes consultar el estado de tu incidencia en la página de búsqueda incidencias con el ID:".$issueID." o directamente escribiendo tu correo electrónico";		
				}
			  
			    $mail->Subject = $subject;
			    $mail->Body    = $body;
			  
			    $mail->send();
				$correct = true;
			} catch (Exception $e) {
				$correct = false;
			}
			return $correct;
			
		}
	}


?>