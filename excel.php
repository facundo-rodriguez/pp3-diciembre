
<?php

    include_once ('config.php');
    include_once( 'conexion.php');

    $con = new db();

    $id_alumno=$_POST["opciones_alumnos"];
    $id_materia=$_POST["opciones_materias"];

    $result_materias="";

    $where="";

    $order="";

    $sql="select dc.id_Cursada as id_cursada, pl.Carrera as carrera, dc.Anio as anio,
    u.User as usuario, dc.fk_Legajo as legajo,
    concat(p.Nombre,' ',p.Apellido) as nombre_completo,  
    m.Descripcion as materia, e.Descripcion_Estado as estado, 
    ifnull(dc.Primer_Parcial,'-') as Primer_Parcial , 
    ifnull(dc.Recuperatio_Parcial_1,'-') as Recuperatorio_Parcial_1, 
    ifnull(dc.Primer_TP,'-') as Primer_TP, 
    ifnull(dc.Recuperatio_TP_1,'-') as Recuperatorio_TP_1, 
    ifnull(dc.Segundo_Parcial,'-') as Segundo_Parcial, 
    ifnull(dc.Recuperatio_Parcial_2,'-') as Recuperatorio_Parcial_2,
    ifnull(dc.Segundo_TP,'-') as Segundo_TP, 
    ifnull(dc.Recuperatio_TP_2,'-') as Recuperatorio_TP_2, 
    ifnull(dc.Promedio,'-') as Promedio,
    ifnull(dc.Final,'-') as Final
    from DetalleCursada dc
    inner join Materia m on m.Id_Materia=dc.fk_Materia
    inner join Estado e on dc.fk_Estado=e.Id_Estado
    inner join Usuario u on dc.fk_Usuario= u.Id_Usuario
    inner join Persona p on p.DNI=u.fk_DNI
    inner join Plan pl on pl.cod_Plan=u.fk_Plan
    ";

    /*
        si alumnos es todos y materia es todos traigo 
        todas las materias por alumno,
        
        si alumno es un id, y materia es todos traigo 
        todas las materias de ese alumno.

        si el alumno es todos y materia un id traigo
        todos los registros con esa materia

        si el alumno es un id, y materia es un id traigo 
        solamente esa materia

        si alumno es un id y no tiene la materia 
        se muestra un mensaje diciendo que no 
        esta inscripto en la materia
    */ 

    if($id_alumno=="todos_alumnos" && $id_materia=="todas_materias"){

        $order="order by dc.Anio asc, u.fk_Plan, dc.fk_Materia";
        $sql=$sql." ".$order;
        $result_materias = $con->query_prepare($sql,NULL);  

        $con->close();

    }
    else if($id_alumno!="todos_alumnos" && $id_materia=="todas_materias"){
        
        $order="order by dc.Anio asc";
        $where="where u.Id_Usuario=".$id_alumno ; 

        $sql=$sql." ".$where." ". $order;
        $result_materias = $con->query_prepare($sql,NULL);  

        $con->close();

    }
    else if($id_alumno=="todos_alumnos" && $id_materia!="todas_materias"){
        
        $where="where dc.fk_Materia=".$id_materia;
        $sql=$sql." ".$where;
        $result_materias = $con->query_prepare($sql,NULL);  

        $con->close();
    }
    else if($id_alumno!="todos_alumnos" && $id_materia!="todas_materias"){
            
        $where=" where u.Id_Usuario=".$id_alumno. " and dc.fk_Materia=".$id_materia;
        $sql=$sql." ".$where;

        $result_materias= $con->query_prepare($sql,NULL);  

        $con->close();

        
    
    }


    

    if($result_materias==""){

        echo "no hay detalles de su cursada";
    }
    else if($result_materias->num_rows ==0 ){
        
        echo "no hay detalles de su cursada";
    }
    else{

        header("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
        header("Content-Disposition: attachment; filename=detalle_cursada.xls ");
?>


        <table border=1>
            <caption>detalle cursada</caption>
            <tr>
                <th>id_cursada</th>
                <th>carrera</th>
                <th>anio</th>
                <th>usuario</th>
                <th>legajo</th>
                <th>nombre_completo</th>
                <th>materia</th>
                <th>estado</th>
                <th>primer_parcial</th>
                <th>recuperatorio_parcial_1</th>
                <th>primer_tp</th>
                <th>recuperatorio_tp_1</th>
                <th>segundo_parcial</th>
                <th>recuperatorio_parcial_2</th>
                <th>segundo_tp</th>
                <th>recuperatorio_tp_2</th>
                <th>promedio</th>
                <th>final</th>
            </tr>

            <?php
                while($row=$result_materias->fetch_assoc()){
            ?>  
                <tr>
                    <td><?php echo $row["id_cursada"]  ?></td>
                    <td><?php echo $row["carrera"]  ?></td>
                    <td><?php echo $row["anio"]  ?></td>
                    <td><?php echo $row["usuario"]  ?></td>
                    <td><?php echo $row["legajo"]  ?></td>
                    <td><?php echo $row["nombre_completo"]  ?></td>
                    <td><?php echo $row["materia"]  ?></td>
                    <td><?php echo $row["estado"]  ?></td>
                    <td><?php echo $row["Primer_Parcial"]  ?></td>
                    <td><?php echo $row["Recuperatorio_Parcial_1"]  ?></td>
                    <td><?php echo $row["Primer_TP"]  ?></td>
                    <td><?php echo $row["Recuperatorio_TP_1"]  ?></td>
                    <td><?php echo $row["Segundo_Parcial"]  ?></td>
                    <td><?php echo $row["Recuperatorio_Parcial_2"]  ?></td>
                    <td><?php echo $row["Segundo_TP"]  ?></td>
                    <td><?php echo $row["Recuperatorio_TP_2"]  ?></td>
                    <td><?php echo $row["Promedio"]  ?></td>
                    <td><?php echo $row["Final"]  ?></td>
                </tr>
            <?php
                }
            ?>

        </table>

<?php



    }
    



?>









