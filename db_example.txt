drop database if exists autosdb;
create database autosdb;
use autosdb;

create table auto(
	id int primary key auto_increment,
    marca varchar(30) not null,
    modelo varchar(30) not null,
    color varchar(10) not null,
    puertas tinyint not null,
    cilindrado bool default false,
    automatico bool default false,
    electrico bool default false,
    deleted_at timestamp null default null
);