create database geptaf;

use geptaf;

create table if not exists licencas(
id int auto_increment,
empresa varchar(60),
codigo varchar(64),
lic_start date,
lic_end date,
periodo varchar(15),
primary key(id),
unique(codigo))engine=innodb charset=utf8;

create table if not exists usuarios(
id bigint auto_increment,
email varchar(50),
snhpwd varchar(64),
ativo boolean default 1,
licenca int,
primary key(id),
unique(email))engine=innodb charset=utf8;

create table if not exists modulos(
id int auto_increment,
nomemodulo varchar(50),
primary key(id))engine=innodb charset=utf8;

create table if not exists permission(
id int auto_increment,
usuario bigint,
licenca int,
modulo int,
primary key(id),
foreign key(usuario) references usuarios(id),
foreign key(licenca) references licencas(id),
foreign key(modulo) references modulos())engine=innodb charset=utf8;

create table if not exists tarefas(
id int auto_increment,
nometarefa varchar(60),
descricao text,
criadopor bigint,
diacriacao date,
datastart date,
dataend date,
licenca int,
primary key(id),
foreign key(criadopor) references usuarios(id),
foreign key(licenca) references licencas(id))engine=innodb charset=utf8;
