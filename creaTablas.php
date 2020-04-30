<?php
if (isset($_POST['create']) || isset($_POST['delete']) || isset($_POST['insert'])) {
    $db = new mysqli("localhost", "rafa", "");
    if ($db->connect_errno) {
        echo "Falló conexión a MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    }
   
    if (isset($_POST['create'])) {
        $sentencia = <<<EOT
            SET PASSWORD = PASSWORD("");
                DROP database IF EXISTS tfg;
                CREATE  DATABASE IF NOT EXISTS tfg;
                use tfg;

               CREATE TABLE admin (
                adm_login VARCHAR(20) NOT NULL COMMENT "adminLoginNNPK" , 
                adm_email VARCHAR(65) NOT NULL COMMENT "adminEmailNN" , 
                adm_password VARCHAR(60) NOT NULL COMMENT "adminPasswordNN" , 
                adm_question2 INT(1) NOT NULL COMMENT "adminQuestion2NN" , 
                adm_password2 VARCHAR(60) NOT NULL COMMENT "adminPassword2NN" ,
                adm_question3 INT(1) NOT NULL COMMENT "adminQuestion3NN" , 
                adm_password3 VARCHAR(60) NOT NULL COMMENT "adminPassword3NN" , 
                PRIMARY KEY (adm_login)) ENGINE = MYISAM;

                CREATE TABLE issues (
                iss_id int(4) AUTO_INCREMENT NOT NULL COMMENT "issuesIdNNPK" ,
                iss_email VARCHAR(65) NOT NULL COMMENT "issuesEmailNN" , 
                iss_description VARCHAR(25000) NOT NULL COMMENT "issuesDescriptionNN" , 
                iss_hour VARCHAR(5) NOT NULL COMMENT "issuesHourNN" , 
                iss_date DATE NOT NULL COMMENT "issuesDateNN" , 
                iss_department VARCHAR(10) NOT NULL COMMENT "issuesDepartmentNN" , 
                iss_importance int(2) NOT NULL COMMENT "issuesImportanceNN" ,
                iss_state int(1) NOT NULL COMMENT "issuesStateNN" ,
                PRIMARY KEY (iss_id)) ENGINE = MYISAM;

                CREATE TABLE passwordLogin (
                pass_passLogin VARCHAR(100) NOT NULL COMMENT "passwordLoginNN" ,
                PRIMARY KEY (pass_passLogin)) ENGINE = MYISAM;

                CREATE TABLE passwordAdmin (
                pass_passAdmin VARCHAR(100) NOT NULL COMMENT "passwordLoginNN" ,
                PRIMARY KEY (pass_passAdmin)) ENGINE = MYISAM;
              
EOT;

        if (!$db->multi_query($sentencia)) { // Ejecuta el conjunto de ordenes de $orden
            echo "Error al crear la base de datos: (" . $db->errno . ") " . $db->error;
        } else {
            echo "<p>La base de datos ha sido creada correctamente!</p>";
        }
    }else if (isset($_POST['insert'])) {
        $sentencia = <<<EOT
                use tfg;

                insert into admin values ("rafael","rafa@rafa.com","Nohay2sin3",1,"rafa",2,"rafa");
                insert into issues values (null,"rafa@rafa.com","No funciona Windows en el ordenador numero 12 al iniciarlo","16:00","2020-03-25","informatica",10,1);
                insert into passwordLogin values ("rafa");
                insert into passwordAdmin values ("rafael");


EOT;

        if (!$db->multi_query($sentencia)) { // Ejecuta el conjunto de ordenes de $orden
            echo '<p>Error al insertar los datos</p>';
        } else {
            echo "<p>Los datos se han introducido correctamente!</p>";
        }
    
    } else if (isset($_POST['delete'])) {

        if (!$db->query('DROP DATABASE tfg')) {
            echo '<p>Error al borrar la tabla</p>';
        } else {
            echo "<p>La base de datos se ha eliminado correctamente.</p>";
        }
    }
} else {
?>
    <form id="form8" action="creaTablas.php" method="post">
        <input type="submit" class="btn-blue" name="create" value="Crear Base de Datos">
        <input type="submit" class="btn-green" name="insert" value="Insertar Datos">
        <input type="submit" class="btn-red" name="delete" value="Borrar Base de Datos">
    </form>
<?php
}
?>
