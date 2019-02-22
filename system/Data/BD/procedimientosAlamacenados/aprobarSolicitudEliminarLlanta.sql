/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Andres Geovanny Angulo Botina <andrescabj981@gmail.com>
 * Created: 9/10/2017
 */

create or replace function aprobarSolicitud() returns trigger as
$$
    begin
        if TG_OP='UPDATE' then
            if new.estado='t' then
                delete from llanta where id=old.idLlanta;
            end if;
        end if;
        return null;
    end;
$$

language plpgsql;

drop trigger aprobarSolicitud on solicitud_eliminar_llanta;
create trigger aprobarSolicitud after UPDATE on solicitud_eliminar_llanta for EACH row EXECUTE PROCEDURE aprobarSolicitud();