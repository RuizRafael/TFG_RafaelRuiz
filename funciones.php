<?php
	class Funciones{

	    function __construct(){
	    }

		public function filtrado($datos){
			$datos= trim($datos); 
			$datos= stripslashes($datos); 
			$datos= htmlspecialchars($datos);  
			return $datos;
		}
		
	}


	class Password {
	    public static function hash($password) {
	        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 8]);
	    }
	    public static function verify($password, $hash) {
	        return password_verify($password, $hash);
	    }
	}

?>