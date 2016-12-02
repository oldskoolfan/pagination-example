create database babynamesdb;
use babynamesdb;

create table baby_names(
	id int unsigned not null auto_increment primary key,
    name nvarchar(255)
);
