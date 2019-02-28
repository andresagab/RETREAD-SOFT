-- select pt.id as idpuestotrabajo, pt.nombre as puestotrabajo, p.nombre as insumo, uipd.usado as usado, uipd.terminado as terminado, ipt.cantidad as cantidad, ipt.id as idinsumo, per.nombres || ' ' || per.apellidos as empleado_usador, perer.nombres || ' ' || perer.apellidos as empleado_envio
-- from uso_insumo_proceso as uip, uso_insumo_proceso_detalle as uipd, insumo_puestotrabajo as ipt, puesto_trabajo as pt, producto as i, puc as p, empleado as e, persona as per, usuario as u, usuario_persona as up, empleado as er, persona as perer 
-- where uipd.idusoinsumoproceso=uip.id 
-- and ipt.id=uipd.idinsumopt 
-- and pt.id=ipt.idpuestotrabajo 
-- and i.id=ipt.idinsumo 
-- and p.codigo=i.codpuc
-- and e.id=uipd.idempleado
-- and per.identificacion=e.identificacion
-- and u.usuario=ipt.usuario 
-- and up.idusuario=u.id 
-- and perer.identificacion=up.identificacion 
-- and er.identificacion=perer.identificacion
-- and uip.idproceso=1 
-- and uip.proceso=2
-- 
-- select o.id, nombre, descripcion, ruta, idmenu, o.fecharegistro from opcion as o, rol_accesos as ra where o.id=idopcion and idrol=0;

-- /*Ordenes de servicios*/
-- 
-- select s.id, s.os, s.numerofactura, pe.nombres || ' ' || pe.apellidos as vendedor, e.id as idVendedor, e.identificacion as identificacionVendedor, c.id as idCliente, pc.nombres || ' ' || pc.apellidos as clientes, c.identificacion as identificacionCliente, s.fecharegistro as fechaRecoleccion
-- from servicio as s, cliente as c, empleado as e, persona as pe, persona as pc
-- where e.id=s.idvendedor
-- and pe.identificacion=e.identificacion
-- and c.id=s.idcliente
-- and pc.identificacion=c.identificacion;

-- Llantas os
-- 
-- select s.id as idOs, s.numerofactura, s.os, ll.id as idLlanta, ll.rp, ll.serie from servicio as s, llanta as ll where ll.idservicio=s.id;
-- 
-- select s.id as idOs, s.numerofactura, s.os, ll.id as idLlanta, ll.rp, ll.serie
-- from servicio as s, llanta as ll
-- where ll.idservicio=s.id;

-- Llanta informe rencauche
-- 
-- select s.id as idOs, s.numerofactura, s.os, s.estado as estadoServicio,
-- pcl.identificacion as identificacionCliente, pcl.nombres || ' ' || pcl.apellidos as nombresCliente, cl.razonsocial, 
-- pv.identificacion as identificacionVendedor, pv.nombres || ' ' || pv.apellidos as nombresVendedor, 
-- ll.id as idLlanta, ll.rp, ll.serie, ll.urgente as llantaUrgente,
-- mll.id as idMarca, mll.nombre as nombreMarca,
-- gll.id as idGravado, gll.nombre as nombreGravado,
-- 'B: ' || dr_ao.base || ' - PR: ' || dr_ao.profundidad || ' - PE: ' || dr_ao.peso || ' - LR: ' || dr_ao.largo as medidasAplicacionOriginal, rtll_dr_ao.referencia as referenciaAplicacionOriginal, tll_ao.nombre as tipoAplicacionOriginal,
-- 'B: ' || dr_as.base || ' - PR: ' || dr_as.profundidad || ' - PE: ' || dr_as.peso || ' - LR: ' || dr_as.largo as medidasAplicacionSolicitada, rtll_dr_as.referencia as referenciaAplicacionSolicitada, tll_as.nombre as tipoAplicacionSolicitada
-- from llanta as ll, servicio as s, cliente as cl, persona as pcl, empleado as v, persona as pv, marca_llanta as mll, gravado_llanta as gll, dimension_referencia as dr_ao, referencia_tipo_llanta as rtll_dr_ao, tipo_llanta as tll_ao, dimension_referencia as dr_as, referencia_tipo_llanta as rtll_dr_as, tipo_llanta as tll_as
-- where s.id=ll.idservicio 
-- and cl.id=s.idcliente 
-- and pcl.identificacion=cl.identificacion 
-- and v.id=s.idvendedor 
-- and pv.identificacion=v.identificacion 
-- and mll.id=ll.idmarca
-- and gll.id=ll.idgravado 
-- and dr_ao.id=ll.idaplicacionoriginal 
-- and rtll_dr_ao.id=dr_ao.idreferenciatipollanta 
-- and tll_ao.id=rtll_dr_ao.idtipollanta 
-- and dr_as.id=ll.idaplicacionsolicitada 
-- and rtll_dr_as.id=dr_as.idreferenciatipollanta 
-- and tll_as.id=rtll_dr_as.idtipollanta 
-- 

-- ID PROCESOS
-- 
-- select * 
-- from inspeccion_inicial as ii, raspado as ras, preparacion as pre, reparacion as rep, cementado as cem, relleno as rel, corte_banda as cb, embandado as emb, vulcanizado as v, inspeccion_final as insf, terminacion as t 
-- where ii.idllanta=2
-- and ras.idinspeccion=ii.id 
-- and pre.idraspado=ras.id 
-- and rep.idpreparacion=pre.id 
-- and cem.idreparacion=rep.id 
-- and rel.idcementado=cem.id 
-- and cb.idrelleno=rel.id 
-- and emb.idcortebanda=cb.id 
-- and v.idembandado=emb.id 
-- and insf.idvulcanizado=v.id 
-- and t.idinspeccion_final=insf.id 

-- CONFIGURACION
-- 
-- create table configuracion(
--     id serial primary key,
--     nombre text not null unique,
--     valor text not null,
--     descripcion text,
--     fechaRegistro timeStamp not null
-- );

-- insert into configuracion (nombre, valor, descripcion, fechaRegistro) values ('camaras', '12', 'Este campo identifica la cantidad maximas de posiciones de camaras a registrar', now());

-- INFORME BODEGA
-- 
-- select s.id as idOs, s.numerofactura, s.os, s.estado as estadoServicio,
-- pcl.identificacion as identificacionCliente, pcl.nombres || ' ' || pcl.apellidos as nombresCliente, cl.razonsocial, 
-- pv.identificacion as identificacionVendedor, pv.nombres || ' ' || pv.apellidos as nombresVendedor, 
-- ll.id as idLlanta, ll.rp, ll.serie, ll.urgente as llantaUrgente,
-- mll.id as idMarca, mll.nombre as nombreMarca,
-- gll.id as idGravado, gll.nombre as nombreGravado,
-- 'B: ' || dr_ao.base || ' - PR: ' || dr_ao.profundidad || ' - PE: ' || dr_ao.peso || ' - LR: ' || dr_ao.largo as medidasAplicacionOriginal, rtll_dr_ao.referencia as referenciaAplicacionOriginal, tll_ao.nombre as tipoAplicacionOriginal,
-- 'B: ' || dr_as.base || ' - PR: ' || dr_as.profundidad || ' - PE: ' || dr_as.peso || ' - LR: ' || dr_as.largo as medidasAplicacionSolicitada, rtll_dr_as.referencia as referenciaAplicacionSolicitada, tll_as.nombre as tipoAplicacionSolicitada
-- from llanta as ll, servicio as s, cliente as cl, persona as pcl, empleado as v, persona as pv, marca_llanta as mll, gravado_llanta as gll, dimension_referencia as dr_ao, referencia_tipo_llanta as rtll_dr_ao, tipo_llanta as tll_ao, dimension_referencia as dr_as, referencia_tipo_llanta as rtll_dr_as, tipo_llanta as tll_as
-- where s.id=ll.idservicio 
-- and cl.id=s.idcliente 
-- and pcl.identificacion=cl.identificacion 
-- and v.id=s.idvendedor 
-- and pv.identificacion=v.identificacion 
-- and mll.id=ll.idmarca
-- and gll.id=ll.idgravado 
-- and dr_ao.id=ll.idaplicacionoriginal 
-- and rtll_dr_ao.id=dr_ao.idreferenciatipollanta 
-- and tll_ao.id=rtll_dr_ao.idtipollanta 
-- and dr_as.id=ll.idaplicacionsolicitada 
-- and rtll_dr_as.id=dr_as.idreferenciatipollanta 
-- and tll_as.id=rtll_dr_as.idtipollanta

-- select id, identificacion, nit, razonSocial, fechaRegistro from cliente  where identificacion like '%10%' or identificacion in (select identificacion from persona where nombres like '%10%')

--select id, identificacion, idCargo, fechaRegistro from empleado  where empleado.identificacion like '%10%' or empleado.identificacion in (select persona.identificacion from persona where nombres like '%10%' or apellidos like '%10%')

--select s.id as idOs, s.numerofactura, s.os, s.estado as estadoServicio,
--pcl.identificacion as identificacionCliente, pcl.nombres || ' ' || pcl.apellidos as nombresCliente, cl.razonsocial,
--pv.identificacion as identificacionVendedor, pv.nombres || ' ' || pv.apellidos as nombresVendedor,
--ll.id as idLlanta, ll.rp, ll.serie, ll.urgente as llantaUrgente, ll.idaplicacionoriginal as idaplicacionoriginal, ll.idaplicacionsolicitada as idaplicacionsolicitada, ll.idaplicacionentregada as idaplicacionentregada, ll.urgente as urgentellanta, ll.procesado as procesadollanta, ll.observaciones as observacionesllanta, ll.fecharegistro as fecharegistrollanta, ll.fechainicioproceso,
--mll.id as idMarca, mll.nombre as nombreMarca,
--gll.id as idGravado, gll.nombre as nombreGravado
--from llanta as ll, servicio as s, cliente as cl, persona as pcl, empleado as v, persona as pv, marca_llanta as mll, gravado_llanta as gll, dimension_llanta as dll, referencia_tipo_llanta as rtll_dr_ao, tipo_llanta as tll_ao, referencia_tipo_llanta as rtll_dr_as, tipo_llanta as tll_as
--where s.id=ll.idservicio
--and cl.id=s.idcliente
--and pcl.identificacion=cl.identificacion
--and v.id=s.idvendedor
--and pv.identificacion=v.identificacion
--and mll.id=ll.idmarca
--and gll.id=ll.idgravado
--and rtll_dr_ao.id=ll.idreferenciaoriginal
--and rtll_dr_as.id=ll.idreferenciasolicitada;

--select distinct ll.rp
--from llanta as ll, servicio as s, cliente as cl, persona as pcl, empleado as v, persona as pv, marca_llanta as mll, gravado_llanta as gll, dimension_llanta as dll, referencia_tipo_llanta as rtll_dr_ao, tipo_llanta as tll_ao, referencia_tipo_llanta as rtll_dr_as, tipo_llanta as tll_as
--where s.id=ll.idservicio
      --and cl.id=s.idcliente
      --and pcl.identificacion=cl.identificacion
      --and v.id=s.idvendedor
      --and pv.identificacion=v.identificacion
      --and mll.id=ll.idmarca
      --and gll.id=ll.idgravado
      --and rtll_dr_ao.id=ll.idreferenciaoriginal
      --and rtll_dr_as.id=ll.idreferenciasolicitada

select
  s.id as idOs, s.numerofactura, s.os, s.estado as estadoServicio, s.fecharecoleccion,
  pc.identificacion as identificacionCliente, pc.nombres || '' || pc.apellidos as nombresCliente, cs.razonsocial
from llanta ll,  servicio s, marca_llanta mll, gravado_llanta grll, referencia_tipo_llanta rll_s, referencia_tipo_llanta rll_o, dimension_llanta dll, cliente cs, empleado es, persona pc, persona pv
where ll.idservicio=s.id
  and cs.id=s.idcliente
  and pc.identificacion=cs.identificacion
  and es.id=s.idvendedor
  and pv.identificacion=es.identificacion
  and mll.id=ll.idmarca
  and grll.id=ll.idgravado
  and rll_o.id=ll.idreferenciaoriginal
  or ll.idreferenciaoriginal is null
  and rll_s.id=ll.idreferenciasolicitada
  or ll.idreferenciasolicitada is null
  and dll.id=ll.iddimension
  or ll.iddimension is null;
--group by ll.id order by ll.id desc;

select
  distinct s.id as idServicio,
  ll.id as idLlanta, ll.rp, ll.serie, ll.urgente as urgentellanta, ll.procesado as procesadoLlanta, ll.observaciones obervacionesLlanta, ll.fecharegistro as fechaRegistroLlanta, ll.fechainicioproceso,
  mll.nombre as nombreMarca,
  grll.nombre as nombreGravado
from llanta ll,  servicio s, marca_llanta mll, gravado_llanta grll, referencia_tipo_llanta rll_s, referencia_tipo_llanta rll_o, dimension_llanta dll
where s.id=ll.idservicio
      and mll.id=ll.idmarca
      and grll.id=ll.idgravado
      and rll_o.id=ll.idreferenciaoriginal
      or ll.idreferenciaoriginal is null
         and rll_s.id=ll.idreferenciasolicitada
      or ll.idreferenciasolicitada is null
         and dll.id=ll.iddimension
      or ll.iddimension is null
;

select s.id as idOs, s.numerofactura, s.os, s.estado as estadoServicio,
       pcl.identificacion as identificacionCliente, pcl.nombres || ' ' || pcl.apellidos as nombresCliente, cl.razonsocial,
       pv.identificacion as identificacionVendedor, pv.nombres || ' ' || pv.apellidos as nombresVendedor,
       ll.id as idLlanta, ll.rp, ll.serie, ll.urgente as llantaUrgente, ll.idaplicacionoriginal as idaplicacionoriginal, ll.idaplicacionsolicitada as idaplicacionsolicitada, ll.idaplicacionentregada as idaplicacionentregada, ll.urgente as urgentellanta, ll.procesado as procesadollanta, ll.observaciones as observacionesllanta, ll.fecharegistro as fecharegistrollanta, ll.fechainicioproceso, ll.idreferenciaoriginal, ll.idreferenciasolicitada, ll.iddimension,
       mll.id as idMarca, mll.nombre as nombreMarca,
       gll.id as idGravado, gll.nombre as nombreGravado
from llanta as ll, servicio as s, cliente as cl, persona as pcl, empleado as v, persona as pv, marca_llanta as mll, gravado_llanta as gll
where s.id=ll.idservicio
and cl.id=s.idcliente
and pcl.identificacion=cl.identificacion
and v.id=s.idvendedor
and pv.identificacion=v.identificacion
and mll.id=ll.idmarca
and gll.id=ll.idgravado;

select pc.id as idPuc, pc.codigo as codPuc, pc.nombre nombreProducto,
  pr.id as idProducto, pr.foto,
  ip.id as idInsumoPT, ip.cantidad as cantidadInsumoPT, ip.estado as estadoInsumoPT, per.nombres || ' ' || per.apellidos as nombresEmpleado, per.identificacion as identificacionEmpleado
from insumo_puestotrabajo ip, producto pr, puc pc, usuario u, usuario_persona up, persona per, empleado e
where pr.id=idinsumo
and pc.codigo=pr.codpuc
and u.usuario=ip.usuario
and up.idusuario=u.id
and per.identificacion=up.identificacion
and e.identificacion=per.identificacion;

select ipt.id, ipt.cantidad, ipt.estado,
       p.nombre
from insumo_puestotrabajo as ipt, producto as pr, puc as p
where ipt.idpuestotrabajo=6
and pr.id=ipt.idinsumo
and p.codigo=pr.codpuc;

--2018-09-21 02:48
select cantidad
from uso_insumo_proceso_detalle as uipd, uso_insumo_proceso as uip, corte_banda as cb, preparacion as pre, raspado as ras, inspeccion_inicial as ii
where ii.idllanta=0
and ras.idinspeccion=ii.id
and pre.idraspado=ras.id
and cb.idpreparacion=pre.id
and uip.proceso=6
and uip.idproceso=cb.id
and uipd.idusoinsumoproceso=uip.id;
--END 2018-09-21 02:48

--2018-09-21 12:37 FILTRO PARA GENERAR INFORME DE BODEGA CON FECHAS DE RENCAUCHE EN SERVICIO_FIN
--and sf.id=ll.id and sf.fecharegistro between(0 and 1)
--END 2018-09-21 12:37

--2018-10-12 21:49

select p.nombre as nombreInsumo, p.descripcion descripcionInsumo,
       pr.id as idproducto, pr.stock as stockbodega
from producto as pr, puc as p
where p.codigo=pr.codpuc;

select pr.codpuc, pr.id, sum(cp.cantidad) from producto as pr, carga_producto as cp where cp.idproducto=pr.id group by pr.codpuc, pr.id;

--END 2018-10-12 21:49

--2018-11-13 20:43
select p.nombre, p.descripcion,
       pr.stock, pr.stockmaximo, pr.stockminimo, pr.foto
from puc as p, producto as pr, puesto_trabajo as pt, insumo_puestotrabajo as ipt
where ipt.idpuestotrabajo=x
and pt.id=ipt.idpuestotrabajo
and pr.id=ipt.idinsumo
and p.codigo=pr.codpuc;
--END 2018-11-13 20:43

--2019-01-08 19:56
select t.id, c.razonsocial, p.nombres || ' ' || p.apellidos as nombresCompletos
from tercero as t, cliente as c, persona as p
where c.id=t.idcliente
and p.identificacion=c.identificacion
order by p.nombres, c.razonsocial asc;
--END 2019-01-08 19:56

--2019-02-05 23:50

select ipt.id as id, ipt.idinsumo as idinsumo, ipt.idpuestotrabajo, ipt.cantidad, ipt.estado,
       pr.id as idproducto, pr.stock, pc.nombre as nombrePuc, pr.foto, um.nombre as nombreUnidadMedida, pp.nombre as nombrePresentacionProducto, percli.nombres || ' ' || percli.apellidos as nombresEmpresa, cl.razonsocial
from insumo_puestotrabajo as ipt, producto as pr, puc as pc, tercero as ter, puc as pcter, cliente as cl, persona as percli, unidad_medida as um, presentacion_producto as pp
where pr.id=ipt.idinsumo
and pc.codigo=pr.codpuc
and ter.id=pr.idprovedor
and pcter.codigo=ter.codpuc
and cl.id=ter.idcliente
and percli.identificacion=cl.identificacion
and um.id=pr.idunidadmedida
and pp.id=pr.idpresentacion;
--END 2019-02-05 23:50

--2019-02-23 20:34
select ref.id, ref.idTipoLlanta, ref.idMarcaLlanta, ref.referencia, ref.observaciones, ref.fecharegistro,
       tip.nombre as tipoLlanta, tip.descripcion as tipoLlantaDescripcion, tip.fecharegistro as tipoLlantafechaRegistro,
       mar.nombre as marcaLlanta, mar.descripcion as marcaLlantaDescripcion, mar.fecharegistro as marcaLlantafechaRegistro
from referencia_tipo_llanta as ref, tipo_llanta as tip, marca_llanta as mar
where tip.id=ref.idtipollanta
and mar.id=ref.idMarcaLlanta;

select ref.id, ref.idTipoLlanta, ref.idMarcaLlanta, ref.referencia, ref.observaciones, ref.fecharegistro,
       tip.nombre as tipoLlanta, tip.descripcion as tipoLlantaDescripcion, tip.fecharegistro as tipoLlantafechaRegistro
from referencia_tipo_llanta as ref, tipo_llanta as tip
where tip.id=ref.idtipollanta;
--END 2019-02-23 20:34

-- 2019-02-27 14:42

select s.id as idOs, s.numerofactura, s.os, s.estado as estadoServicio, s.idCliente, s.idvendedor,
       pcl.identificacion as identificacionCliente, pcl.nombres || ' ' || pcl.apellidos as nombresCliente, cl.razonsocial,
       pv.identificacion as identificacionVendedor, pv.nombres || ' ' || pv.apellidos as nombresVendedor,
       ll.id as idLlanta, ll.rp, ll.serie, ll.consecutivo, ll.urgente as llantaUrgente, ll.procesado as llantaProcesado, ll.observaciones as observacionesllanta, ll.fecharegistro as fecharegistrollanta, ll.fechainicioproceso,
       mll.id as idMarca, mll.nombre as nombreMarca,
       gll.id as idGravado, gll.nombre as nombreGravado,
       dll.id as idDimension, dll.dimension,
       rtllo.id as idReferenciaTipoLlantaOriginal, rtllo.referencia as referenciaOriginal,
       tllo.id as idTipoLlantaOriginal, tllo.nombre as tipoLlantaOriginal,
       rtlls.id as idReferenciaTipoLlantaSolicitada, rtlls.referencia as referenciaSolicitada,
       tlls.id as idTipoLlantaSolicitada, tlls.nombre as tipoLlantaSolicitada
from llanta as ll, servicio as s, cliente as cl, persona as pcl, empleado as v, persona as pv, marca_llanta as mll, gravado_llanta as gll, dimension_llanta as dll, referencia_tipo_llanta as rtllo, referencia_tipo_llanta as rtlls, tipo_llanta as tllo, tipo_llanta as tlls
where s.id=ll.idservicio
  and cl.id=s.idcliente
  and pcl.identificacion=cl.identificacion
  and v.id=s.idvendedor
  and pv.identificacion=v.identificacion
  and mll.id=ll.idmarca
  and gll.id=ll.idgravado
  and dll.id=ll.iddimension
  and rtllo.id=ll.idreferenciaoriginal
  and tllo.id=rtllo.idtipollanta
  and rtlls.id=ll.idreferenciasolicitada
  and tlls.id=rtlls.idtipollanta
-- END 2019-02-27 14:42