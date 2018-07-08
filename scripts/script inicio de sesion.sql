create or replace function f_validar_sesion(p_email varchar, p_clave varchar)
returns table(estado int, codigo_usuario int, nombre_usuario varchar)
as

$body$
	declare
		v_registro record; --Permite almacenar un solo registro que devuelve una consulta sql;
		v_estado int; -- almacena los estados del protocolo http (200: OK, 500: error)
		v_codigo_usuario int;
		v_nombre_usuario varchar;
		
	begin
		begin
			select 
				u.codigo_usuario, 
				u.nombre_usuario, 
				u.estado
			from 
				usuario u

			into 	
				v_registro
			where
				u.email = p_email
				and u.clave = p_clave;
			v_estado =500;

			if FOUND then -- Pregunta si ha encontrado un registro en la ultima consulta SQL select que se ha ejecutado
				if v_registro.estado= 'I' then
					v_nombre_usuario = 'Usuario Inactivo';
				else
					v_nombre_usuario=v_registro.nombre_usuario;
					v_codigo_usuario=v_registro.codigo_usuario;
					v_estado=200;
				end if;
			else
				v_nombre_usuario = 'Los datos del usuario son incorrectos o el usuario no existe';
			end if;
			
			
		EXCEPTION
			when others then RAISE EXCEPTION '%', SQLERRM;
		end;

		if v_estado = 200 then
			return query select v_estado, v_codigo_usuario, v_nombre_usuario;
		else
			return query select v_estado, 0, v_nombre_usuario;
		end if;
	end;

$body$

language plpgsql;

select * from f_validar_sesion('hmera@usat.edu.pe','202cb962ac59075b964b07152d234b70');
select * from f_validar_sesion('earagon@usat.edu.pe','250cf8b51c773f3f8dc8b4be867a9a02')

select * from f_validar_sesion(:p_email, :p_clave)
