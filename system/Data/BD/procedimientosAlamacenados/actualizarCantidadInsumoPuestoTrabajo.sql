/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Andres Geovanny Angulo Botina <andrescabj981@gmail.com>
 * Created: 03/01/2019
 */

create or replace function actualizarCantidadInsumoPuestoTrabajo() returns trigger as
$$
    begin
        if TG_OP='DELETE' then
            update insumo_puestotrabajo set cantidad=cantidad+old.cantidad where id=old.idinsumopt;
        end if;
        return null;
    end;
$$

language plpgsql;

drop trigger actualizarCantidadInsumoPuestoTrabajo on insumo_terminacion;
create trigger actualizarCantidadInsumoPuestoTrabajo after INSERT or DELETE or UPDATE on uso_insumo_proceso_detalle for EACH row EXECUTE PROCEDURE actualizarCantidadInsumoPuestoTrabajo();