
use lujanbue_practica_prof;

--listado materias todos los alumnos


select dc.id_Cursada , pl.Carrera as Carrera, dc.Anio,
u.User as Usuario, dc.fk_Legajo as legajo,
concat(p.Nombre,' ',p.Apellido) as nombre_completo,  
m.Descripcion as materia, e.Descripcion_Estado as estado, 
ifnull(dc.Primer_Parcial,"-") as Primer_Parcial , 
ifnull(dc.Recuperatio_Parcial_1,"-") as Recuperatorio_Parcial_1, 
ifnull(dc.Primer_TP,"-") as Primer_TP, 
ifnull(dc.Recuperatio_TP_1,"-") as Recuperatorio_TP_1, 
ifnull(dc.Segundo_Parcial,"-") as Segundo_Parcial, 
ifnull(dc.Recuperatio_Parcial_2,"-") as Recuperatorio_Parcial_2,
ifnull(dc.Segundo_TP,"-") as Segundo_TP, 
ifnull(dc.Recuperatio_TP_2,"-") as Recuperatorio_TP_2, 
ifnull(dc.Promedio,"-") as Promedio,
ifnull(dc.Final,"-") as Final
from DetalleCursada dc
inner join Materia m on m.Id_Materia=dc.fk_Materia
inner join Estado e on dc.fk_Estado=e.Id_Estado
inner join Usuario u on dc.fk_Usuario= u.Id_Usuario
inner join Persona p on p.DNI=u.fk_DNI
inner join Plan pl on pl.cod_Plan=u.fk_Plan
order by dc.Anio asc, u.fk_Plan, dc.fk_Materia


--lista de alumnos
select concat(u.User ,' - ',u.fk_Plan,' - ',p.DNI,' - ',p.Nombre,' ',p.Apellido) as alumnos, u.Id_Usuario as id_usuario 
from  Usuario u 
inner join Persona p on p.DNI=u.fk_DNI
where u.fk_Rol=1;


--lista materias
select Id_Materia as id_materia, Descripcion as descripcion 
from Materia where Descripcion!="No Aplica";


-- finales disponibles
select f.Id_Fecha_Final as id_final, dc.fk_Materia as id_materia, 
m.Descripcion as materia, f.Fecha as fecha, dc.fk_Legajo as legajo
from Materia m 
inner join DetalleCursada dc on dc.fk_Materia=Id_Materia
inner join FechasFinales f on f.fk_Materia=dc.fk_Materia
where f.fk_Estado_Final=1
and dc.Promedio>=4 
and dc.fk_Usuario=501
and dc.Final<4


select a.fk_id_Fecha_final as id_final, a.fk_Fecha_Final as fecha, 
m.Descripcion as materia, a.Folio as folio, a.Nota as Nota
from ActaVolante a 
inner join Materia m on m.Id_Materia=a.fk_Materia
where a.fk_Usuario=
order by a.fk_Fecha_Final asc


select * from Usuario where fk_Rol=1;

select * from Rol

select * from Materia

select * from Estado

select * from Persona

select * from Plan

select * from DetalleCursada


