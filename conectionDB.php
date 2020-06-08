<?php
	include_once("funciones.php");

	class Conection
	{
	    private $connection;
	    private static $instance;


	    function __construct()
	    {
	        $dsn = 'mysql:host=127.0.0.1;dbname=rafa;charset=utf8';
	        $user = 'rafa';
	        $pass = 'HQdbIUoQ6LsQ';

	        try {
	            $this->connection = new PDO($dsn, $user, $pass);
	        } catch (PDOException $e) {
	            die("¡Error!: " . $e->getMessage() . "<br/>");
	        }
	    }


	    public static function singleton()
	    {
	        if (!isset(self::$instance)) {
	            self::$instance = new self();
	        }
	        return self::$instance;
	    }

	    public function __clone()
	    {
	        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
	    }

	  
		
		//Comprobacion de las contraseñas de login y administrador.
	    public function checkPassword(){
			$query = $this->connection->prepare("select pass_passLogin from passwordLogin");
			$query->execute();		
			$resultado = $query->fetch();
			return $resultado;		
		}
		public function checkPasswordAdmin(){
			$query = $this->connection->prepare("select pass_passAdmin from passwordAdmin");
			$query->execute();		
			$resultado = $query->fetch();
			return $resultado;		
		}

		/* Introduce en la base de datos una nueva incidencia */
		public function newIssue($iss_email,$iss_description,$iss_department,$iss_importance){
			$date = date("Y-m-d");
			$hour = date("G:i");
			$query = $this->connection->prepare("insert into issues values(null,:iss_email,:iss_description,:hour,:date,:iss_department,:iss_importance,1,'',1)");
			$query->execute(array(':iss_email' =>$iss_email,':iss_description' =>$iss_description,':hour' =>$hour,':date' =>$date,':iss_department' =>$iss_department,':iss_importance' =>$iss_importance));
		}

		//Devuelve todas las incidencias por orden de ID
		public function allIssues($orderName = ""){
			if($orderName == "Id"){
				$ordered = "order by iss_id";
			} else if($orderName == "Email"){
				$ordered = "order by iss_email";
			} else if($orderName == "Descripción"){
				$ordered = "order by iss_description";
			} else if($orderName == "Hora"){
				$ordered = "order by iss_hour";
			} else if($orderName == "Fecha"){
				$ordered = "order by iss_date";
			} else if($orderName == "Departamento"){
				$ordered = "order by iss_department";
			} else if($orderName == "Urgencia"){
				$ordered = "order by iss_importance desc";
			} else if($orderName == "Estado"){
				$ordered = "order by iss_state";
			} else if($orderName == "Notas"){
				$ordered = "order by iss_note desc";
			} else {
				$ordered = "order by iss_id";
			}
			$query = $this->connection->prepare("select * from issues where iss_show=1 $ordered");
			$query->execute();
			$resultado = $query->fetchAll(PDO::FETCH_NUM);
			return $resultado;		
		}

		//Devuelve el ultimo id que se ha añadido a la tabla
		public function selectLastID(){
			$query = $this->connection->prepare("select iss_id from issues order by iss_id desc limit 1");
			$query->execute();
			$resultado = $query->fetch(PDO::FETCH_NUM);
			return $resultado;		
		}

		//Devuelve la incidencia correspondiente al ID
		public function issuesId($id){
			$query = $this->connection->prepare("select * from issues where iss_id=:id");
			$query->execute(array(':id' =>$id));
			$resultado = $query->fetchAll(PDO::FETCH_NUM);
			return $resultado;		
		}

		//Devuelve todas las incidencias correspondiente al correo
		
		public function issuesEmail($iss_email){
			$query = $this->connection->prepare("select * from issues where iss_email=:iss_email");
			$query->execute(array(':iss_email' =>$iss_email));
			$resultado = $query->fetchAll(PDO::FETCH_NUM);
			return $resultado;		
		}

		//Actualiza el registro para que no aparezca en la tabla de administrador
		
		public function deleteId($id) {
			$query = $this->connection->prepare("update issues set iss_show=0 where iss_id=:id");
			$query->execute(array(':id' =>$id));
		}

		//Actualiza el estado de la incidencia del ID indicado
		
		public function updateState($state,$id) {
			$query = $this->connection->prepare("update issues set iss_state=:state where iss_id=:id");
			$query->execute(array(':state' =>$state, ':id' =>$id));
		}

		//Actualiza la nota de la incidencia del ID indicado
		
		public function updateNote($note,$id) {
			$query = $this->connection->prepare("update issues set iss_note=:note where iss_id=:id");
			$query->execute(array(':note' =>$note, ':id' =>$id));
		}

	
		





		

	}
?>