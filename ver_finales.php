

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 

include_once ('config.php');
include_once( 'conexion.php');

$con = new db();

$id_alumno=$_POST["opc_alumnos"];

$sql="select f.Id_Fecha_Final as id_final, dc.fk_Materia as id_materia, 
m.Descripcion as materia, f.Fecha as fecha, dc.fk_Legajo as legajo
from Materia m 
inner join DetalleCursada dc on dc.fk_Materia=Id_Materia
inner join FechasFinales f on f.fk_Materia=dc.fk_Materia
where f.fk_Estado_Final=1
and dc.Promedio>=4 
and dc.fk_Usuario=?
and dc.Final<4";

$result= $con->query_prepare($sql,[$id_alumno]);  

?>

<table border="1">
<caption>Finales disponibles</caption>    
<tr>
    <th>id_final</th>
    <th>fecha_final</th>
    <th>materia</th>
    <th>inscripcion</th>
</tr>

<?php
    
    while($row=$result->fetch_assoc()){

        $datos=[$row["id_final"], 
                $row["fecha"] , 
                $row["id_materia"] ,
                $row["materia"] ,
                $id_alumno ,
                $row["legajo"] 
        ];
        
    
?>  
    <tr>
        <td><?php echo $row["id_final"] ?></td>
        <td><?php echo $row["fecha"] ?></td>
        <td><?php echo $row["materia"] ?></td>
        <td><button onclick="funcion( '<?php echo implode('/',$datos) ?>' )">inscripcion</button></td>
    </tr>
        
<?php
    }
?>

</table>



<h2>lista finales</h2>

<?php 
    
    $sql4="select a.fk_id_Fecha_final as id_final, a.fk_Fecha_Final as fecha, 
          m.Descripcion as materia, ifnull(a.Folio, '-') as folio, 
          a.Nota as nota
          from ActaVolante a 
          inner join Materia m on m.Id_Materia=a.fk_Materia
          where a.fk_Usuario=?
          order by a.fk_Fecha_Final asc";
      
    $result= $con->query_prepare($sql4,[$id_alumno]);  

    $con->close();

    if($result->num_rows==0){

?>  
    <p>no se encuentran los finales</p>

<?php
    }
    else{
?>

        <table border=1>
            <caption>finales</caption>
            <tr>
                <th>id_final</th>
                <th>fecha</th>
                <th>materia</th>
                <th>folio</th>
                <th>nota</th>
            </tr>
        <?php
    
            while($row=$result->fetch_assoc()){ 

        ?>
                <tr>
                    <td><?php echo $row["id_final"] ?></td>
                    <td><?php echo $row["fecha"] ?></td>
                    <td><?php echo $row["materia"] ?></td>
                    <td><?php echo $row["folio"] ?></td>
                    <td><?php echo $row["nota"] ?></td>
                </tr>        
    
        <?php
        
                }    
    
            }
        ?>

        </table>



<script src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script>
function funcion(datosObj) {

    
// Ahora puedes enviar estos datos al servidor usando AJAX
$.ajax({
  type: 'POST',
  url: 'registro.php',
  data:
  "datos="+datosObj//["id_alumno"]
  ,
  success: function(response) {
    
    alert(response);
  
},
  error: function(error) {
    // Manejar errores si es necesario
    alert('Hubo un error al registrar los datos');
  }
});
}
</script>
    
</body>
</html>

