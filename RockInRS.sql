drop database RockInRS;
create database RockInRS;

use RockInRS;

create table Tipo_Ingresso(
	id_tipo_ingresso integer primary key auto_increment,
	descricao_ingresso longtext,
	valor_ingresso float,
	volume_ingresso int
 );       
 
 create table Cliente(
	id_cliente integer primary key auto_increment,
	nome_cliente varchar(50),
        cpf varchar(20),
        email varchar(50),
        telefone bigint(14)
 );
 
 create table Tipo_Ingresso_Cliente(
	 id_tipo_ingresso_cliente integer primary key auto_increment,
	 id_tipo_ingresso integer,
	 id_cliente integer,
	 foreign key(id_tipo_ingresso) references Tipo_Ingresso(id_tipo_ingresso),
	 foreign key(id_cliente) references Cliente(id_cliente)
 );
 
 create table Endereco_Cliente(
	 id_endereco_cliente integer primary key auto_increment,
	 id_cliente integer,
	 cidade varchar(50),
	 nome_cliente varchar(50),
	 foreign key(id_cliente) references Cliente(id_cliente)
 );
