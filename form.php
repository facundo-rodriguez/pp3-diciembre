
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
</head>
<body>
    
<?php
   
   include_once ('config.php');
   include_once( 'conexion.php');

   $con = new db();

   $sql_alumnos="select concat(u.User ,' - ',u.fk_Plan,' - ',p.DNI,' - ',p.Nombre,' ',p.Apellido) as alumnos, u.Id_Usuario  as id_usuario 
        from  Usuario u 
        inner join Persona p on p.DNI=u.fk_DNI
        where u.fk_Rol=1;";

    $sql_materias="select Id_Materia as id_materia, Descripcion as descripcion 
        from Materia where Descripcion!='No Aplica' ";

   $result_alumnos = $con->query_prepare($sql_alumnos,NULL);  

   $result_materias = $con->query_prepare($sql_materias,NULL);  

   

   ?>

    <form action="excel.php" method="post">

        <div>

            <label for="opciones_alumnos">Seleccione un alumno:</label>
            <select name="opciones_alumnos" id="opciones_alumnos">

                <option value="todos_alumnos">todos los alumnos</option>
                <?php
                    while($row=$result_alumnos->fetch_assoc()){
                ?>

                    <option value="<?php echo $row["id_usuario"] ?>"><?php echo $row["alumnos"] ?></option>

                <?php
                }
                ?>
            </select>

        </div>

        <div>
            <label for="opciones_materias">Seleccione una materia:</label>
            <select name="opciones_materias" id="opciones_materias">

                <option value="todas_materias">todos las materias</option>
                <?php
                    while($row=$result_materias->fetch_assoc()){
                ?>

                    <option value="<?php echo $row["id_materia"] ?>"><?php echo $row["descripcion"] ?></option>

                <?php
                }
                ?>
            </select>
                
        </div>
                
        <input type="submit" value="generar excel">
    </form>
   
    
    <h2>Finales por alumno</h2>

    <form action="ver_finales.php" method="post">
                
        <div>

            <label for="opc_alumnos">Seleccione un alumno:</label>
            <select name="opc_alumnos" id="opc_alumnos">

                <?php
                   
                    $result_alumnos = $con->query_prepare($sql_alumnos,NULL);  

                    $con->close();

                    while($row=$result_alumnos->fetch_assoc()){
                ?>

                    <option value="<?php echo $row["id_usuario"] ?>"><?php echo $row["alumnos"] ?></option>

                <?php
                }
                ?>
            </select>
            
            <input type="submit" value="ver finales">
        </div>

    </form>
    
</body>
</html>