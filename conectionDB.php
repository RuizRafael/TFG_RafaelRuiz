<?php
	include_once("funciones.php");

	class Conection
	{
	    private $conexion;
	    private static $instancia;


	    function __construct()
	    {
	        $dsn = 'mysql:host=localhost;dbname=tfg;charset=utf8';
	        $usuario = 'rafa';
	        $pass = '';

	        try {
	            $this->conexion = new PDO($dsn, $usuario, $pass);
	        } catch (PDOException $e) {
	            die("¡Error!: " . $e->getMessage() . "<br/>");
	        }
	    }


	    public static function singleton()
	    {
	        if (!isset(self::$instancia)) {
	            self::$instancia = new self();
	        }
	        return self::$instancia;
	    }

	    public function __clone()
	    {
	        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
	    }

	  
		
	    public function checkPassword($pass_passLogin){
			$consulta = $this->conexion->prepare("select pass_passLogin from passwordlogin");
			$consulta->execute();		
			$resultado = $consulta->fetch();
			return $resultado;		
		}
		public function checkPasswordAdmin($pass_passLogin){
			$consulta = $this->conexion->prepare("select pass_passAdmin from passwordadmin");
			$consulta->execute();		
			$resultado = $consulta->fetch();
			return $resultado;		
		}

		/* Introduce en la base de datos una nueva incidencia */
		public function newIssue($iss_email,$iss_description,$iss_department,$iss_importance){
			$date = date("Y-m-d");
			$hour = date("G:i");
			$consulta = $this->conexion->prepare("insert into issues values(null,:iss_email,:iss_description,:hour,:date,:iss_department,:iss_importance,1)");
			$consulta->execute(array(':iss_email' =>$iss_email,':iss_description' =>$iss_description,':hour' =>$hour,':date' =>$date,':iss_department' =>$iss_department,':iss_importance' =>$iss_importance));
		}

		public function allIssues(){
			$consulta = $this->conexion->prepare("select * from issues");
			$consulta->execute();
			$resultado = $consulta->fetchAll(PDO::FETCH_NUM);
			return $resultado;		
		}

		
		/*
		public function datosCuenta($cu_ncu){
			$consulta = $this->conexion->prepare("select * from cuentas where cu_ncu=:cu_ncu");
			$consulta->setFetchMode();
			$consulta->execute(array(':cu_ncu' =>$cu_ncu));
			$resultado = $consulta->fetchAll();
			return $resultado;			
		}

		
		

	
		

*/



		

	}
?>