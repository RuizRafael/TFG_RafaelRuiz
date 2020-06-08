


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
            <?php
                include_once("funciones.php");

                if (isset($_POST['create']) || isset($_POST['delete']) || isset($_POST['insert']) || isset($_POST['deleteTables']) ||  isset($_POST['update']) || isset($_POST['cleanRows'])) {
                    $db = new mysqli("127.0.0.1", "rafa", "HQdbIUoQ6LsQ");
                    if ($db->connect_errno) {
                        echo "Falló conexión a MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
                    }
                    
                    if (isset($_POST['create'])) {
                       /* DROP database IF EXISTS tfg;
                                CREATE  DATABASE IF NOT EXISTS tfg;*/
                        $sentencia = <<<EOT
                                CREATE  DATABASE IF NOT EXISTS rafa;

                                use rafa;

                                CREATE TABLE issues (
                                iss_id int(4) AUTO_INCREMENT NOT NULL COMMENT "issuesIdNNPK" ,
                                iss_email VARCHAR(65) NOT NULL COMMENT "issuesEmailNN" , 
                                iss_description VARCHAR(25000) NOT NULL COMMENT "issuesDescriptionNN" , 
                                iss_hour VARCHAR(5) NOT NULL COMMENT "issuesHourNN" , 
                                iss_date DATE NOT NULL COMMENT "issuesDateNN" , 
                                iss_department VARCHAR(15) NOT NULL COMMENT "issuesDepartmentNN" , 
                                iss_importance int(2) NOT NULL COMMENT "issuesImportanceNN" ,
                                iss_state int(1) NOT NULL COMMENT "issuesStateNN" ,
                                iss_note VARCHAR(2000) NOT NULL COMMENT "issuesNoteNN" , 
                                iss_show int(1) NOT NULL COMMENT "issuesShowNN" ,

                                PRIMARY KEY (iss_id)) ENGINE = MYISAM;

                                CREATE TABLE passwordLogin (
                                pass_passLogin VARCHAR(100) NOT NULL COMMENT "passwordLoginNN" ,
                                PRIMARY KEY (pass_passLogin)) ENGINE = MYISAM;

                                CREATE TABLE passwordAdmin (
                                pass_passAdmin VARCHAR(100) NOT NULL COMMENT "passwordLoginNN" ,
                                PRIMARY KEY (pass_passAdmin)) ENGINE = MYISAM;
                                                
                                insert into passwordLogin values ("");
                                insert into passwordAdmin values ("");

EOT;

                        if (!$db->multi_query($sentencia)) { 
                            echo "Error al crear la base de datos: (" . $db->errno . ") " . $db->error;
                        } else {
                            echo "<p>La base de datos ha sido creada correctamente!</p>";
                        }
                    }else if (isset($_POST['insert'])) {
                        $date = date("Y-m-d");
                        $hour = date("G:i");
                        $dateHour = date("d/m")."-".date("G:i");
                        $sentencia = <<<EOT
                                use rafa;

                                insert into issues values (null,"rafa@rafa.com","Prueba sin revisar","16:00","2020-03-25","Administrador",10,"1","($dateHour) Máquina : Esto es la primera nota de prueba",1);
                                insert into issues values (null,"rafa@rafa.com","Prueba en proceso","17:00","2020-03-26","Administrador",5,"2","",1);
                                insert into issues values (null,"rafa@rafa.com","Prueba finalizado","18:00","2020-03-27","Administrador",1,"3","",1);

                                insert into issues values (null,"","Se han introducido 4 registros de prueba. ","$hour","$date","Administrador",0,"0","",1);
     

EOT;


                        if (!$db->multi_query($sentencia)) { 
                            echo '<p>Error al insertar los datos</p>';
                        } else {
                            echo "<p>Los datos se han introducido correctamente!</p>";

                        }


                    
                    } else if (isset($_POST['update'])) {
                        $passwords = Funciones::loadConf("1");
                        $passHashedConf = Password::hash($passwords["teacher"]);
                        $passHashedConfAdmin = Password::hash($passwords["admin"]);
                        $date = date("Y-m-d");
                        $hour = date("G:i");
                        $dateHour = date("d/m")."-".date("G:i");
                        $sentencia = <<<EOT
                                use rafa;

                               
                                insert into issues values (null,"","Se han actualizado las contraseñas","$hour","$date","Administrador",0,"0","",1);
                                update passwordLogin set pass_passLogin = "$passHashedConf";
                                update passwordAdmin set pass_passAdmin = "$passHashedConfAdmin";

EOT;


                        if (!$db->multi_query($sentencia)) { 
                            echo '<p>Error al actualizar las contraseñas.</p>';
                        } else {
                            echo "<p>Las contraseñas se han actualizado correctamente!</p>";

                        }


                    
                    } else if (isset($_POST['cleanRows'])) {
                        $sentencia = <<<EOT
                                use rafa;

                                delete from issues;
                                delete from passwordAdmin;
                                delete from passwordLogin;
EOT;


                        if (!$db->multi_query($sentencia)) { 
                            echo '<p>Error al limpiar datos</p>';
                        } else {
                            echo "<p>Los datos se han limpiado!</p>";

                        }


                    
                    } else if (isset($_POST['deleteTables'])) {
                        $sentencia = <<<EOT
                                use rafa;

                                drop table issues;
                                drop table passwordAdmin;
                                drop table passwordLogin;
EOT;


                        if (!$db->multi_query($sentencia)) { 
                            echo '<p>Error al borrar tablas</p>';
                        } else {
                            echo "<p>Las tablas se han borrado!</p>";

                        }


                    
                    } else if (isset($_POST['delete'])) {

                        if (!$db->query('DROP DATABASE rafa')) {
                            echo '<p>Error al borrar la tabla</p>';
                        } else {
                            echo "<p>La base de datos se ha eliminado correctamente.</p>";

                        }
                    } 
                    echo " <a href='".$_SERVER['PHP_SELF']."?j9RTNCcGLxT1H=OO5puMa9Sr6Tj3cGosWDdYMRnl'><label>🔙Volver</label></a>";

                } else {
                    if(isset($_GET['j9RTNCcGLxT1H']) && $_GET['j9RTNCcGLxT1H'] == "OO5puMa9Sr6Tj3cGosWDdYMRnl"){
                ?>
                    <div class="marginButtons"></div>
                        <form id="form8" action="creaTablas.php" method="post">
                            <input type="submit" class="btn-blue" name="create" value="Crear Base de Datos">
                            <input type="submit" class="btn-green" name="insert" value="Insertar Incidencias de Prueba">
                            <input type="submit" class="btn-yellow" name="update" value="Actualizar Contraseñas">
                            <input type="submit" class="btn-red" name="delete" value="Borrar Base de Datos">
                            <input type="submit" class="btn-red" name="deleteTables" value="Borrar Todas las tablas">
                            <input type="submit" class="btn-red" name="cleanRows" value="Clean rows">

                        </form>
                        <p class="textCenter">Ir al  <a href="portalTeachers.php"> inicio</a></p></div>
                    </div>

                <?php
                    
                    } else {
                        header("Location: portalTeachers.php");
                    }
                }
                ?>
                        
        </body>
</html>