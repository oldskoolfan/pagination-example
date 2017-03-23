create database if not exists babynamesdb;
use babynamesdb;

drop table if exists baby_names;
create table baby_names(
	id int unsigned not null auto_increment primary key,
    name nvarchar(255)
);
