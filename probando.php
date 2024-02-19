
<?php
  include_once ('config.php');
  include_once( 'conexion.php');

  $con = new db();

  $id_alumno=$_POST["opciones_alumnos"];
  $id_materia=$_POST["opciones_materias"];


  echo $id_alumno;
  echo $id_materia;
?>