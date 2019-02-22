/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Andres Geovanny Angulo Botina <andrescabj981@gmail.com>
 * Created: 9/10/2017
 */

create or replace function actualizarEstadoInsumoPT() returns trigger as
$$
    begin
        if TG_OP='INSERT' then
            update insumo_puestoTrabajo set estado=false where id=new.idInsumoPT;
        else
            if TG_OP='DELETE' then
                update insumo_puestoTrabajo set estado=true where id=old.idInsumoPT;
            end if;
        end if;
        return null;
    end;
$$

language plpgsql;

drop trigger actualizarEstadoInsumoPT on insumo_terminacion;
create trigger actualizarEstadoInsumoPT after INSERT or DELETE or UPDATE on insumo_terminacion for EACH row EXECUTE PROCEDURE actualizarEstadoInsumoPT();