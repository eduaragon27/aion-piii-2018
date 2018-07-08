create table categoria
( 
	codigo_categoria int not null,
	nombre_categoria varchar(50),
	constraint pk_categoria PRIMARY KEY(codigo_categoria)	
);
create table articulo
(
	codigo_articulo int,
	nombre_articulo varchar(100) not null,
	precio_venta numeric(7,2) not null,
	codigo_categoria int not null,
	constraint pk_articulo PRIMARY KEY(codigo_articulo),
	constraint fk_codigo_categoria FOREIGN KEY (codigo_categoria) REFERENCES categoria(codigo_categoria)
	
);

create table usuario(
	codigo_usuario int,
	nombre_usuario varchar(100) not null,
	email varchar(50) not null,
	clave char(32) not null,
	estado char(1) not null,
	constraint pk_usuario PRIMARY KEY (codigo_usuario)
);

insert into usuario(codigo_usuario, nombre_usuario, email, clave, estado) values (1,'Huilder Mera Montenegro', 'hmera@usat.edu.pe', md5('123'),'A');
insert into usuario(codigo_usuario, nombre_usuario, email, clave, estado) values (2,'Eduardo Aragon', 'earagon@usat.edu.pe', md5('456'),'I');


select md5('123')
202cb962ac59075b964b07152d234b70
	
"202cb962ac59075b964b07152d234b70"