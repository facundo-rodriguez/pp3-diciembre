
<?php
    
    include_once ('config.php');
    include_once( 'conexion.php');
    
    $con = new db();
    $datos=explode("/",$_POST["datos"]);
    
    
    $id_final=$datos[0];
    $fecha=$datos[1];
    $id_materia=$datos[2];
    $materia=$datos[3];
    $id_alumno=$datos[4];
    $legajo=$datos[5];

    
    $sql="insert into ActaVolante 
    ( fk_id_Fecha_final, fk_Fecha_Final,fk_Materia, fk_Usuario, fk_Legajo)
    values(?,?,?,?,?)";
    
    $result=$con->query_prepare($sql,[$id_final,$fecha,$id_materia, $id_alumno,$legajo]);
    
    $con->close();

    if($result){
       
        echo "se regristro la inscripcion";
    }
    else{

        echo "no se registro la inscripcion";
    }

?>