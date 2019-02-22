/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Andres Geovanny Angulo Botina <andrescabj981@gmail.com>
 * Created: 9/10/2017
 */

create or replace function actualizarProcesado() returns trigger as
$$
    begin
        if TG_OP='INSERT' then
            update llanta set procesado=true where id=new.idLlanta;
        else
            if TG_OP='DELETE' then
                update llanta set procesado=false where id=old.idLlanta;
            end if;
        end if;
        return null;
    end;
$$

language plpgsql;

drop trigger actualizarProcesado on inspeccion_inicial;
create trigger actualizarProcesado after INSERT or DELETE or UPDATE on inspeccion_inicial for EACH row EXECUTE PROCEDURE actualizarProcesado();