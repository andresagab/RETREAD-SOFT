/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Andres Geovanny Angulo Botina <andrescabj981@gmail.com>
 * Created: 9/10/2017
 */

create or replace function actualizarTerminadoUsoInsumoProcesoDetalle() returns trigger as
$$
    begin
        if TG_OP='INSERT' then
            update uso_insumo_proceso_detalle set terminado=true where idInsumoPT=new.idInsumoPT;
        else
            if TG_OP='DELETE' then
                update uso_insumo_proceso_detalle set terminado=false where idInsumoPT=old.idInsumoPT;
            end if;
        end if;
        return null;
    end;
$$

language plpgsql;

drop trigger actualizarTerminadoUsoInsumoProcesoDetalle on insumo_terminacion;
create trigger actualizarTerminadoUsoInsumoProcesoDetalle after INSERT or DELETE or UPDATE on insumo_terminacion for EACH row EXECUTE PROCEDURE actualizarTerminadoUsoInsumoProcesoDetalle();