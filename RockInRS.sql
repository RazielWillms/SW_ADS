drop database RockInRS;
create database RockInRS;

use RockInRS;

create table Tipo_Ingresso(
	id_tipo_ingresso integer primary key auto_increment,
	descricao_ingresso longtext,
    valor_ingresso float
 );       
 insert into Tipo_Ingresso(descricao_ingresso, valor_ingresso) values ("Pista", 30), ("Pista-VIP", 50), ("Camarote", 100), ("Front stage", 150);
 select * from Tipo_Ingresso;
 
 create table Cliente(
	id_cliente integer primary key auto_increment,
	nome_cliente varchar(50)unique,
	cpf varchar(15),
	email varchar(50),
	telefone varchar(14),
	senha varchar(100)
 );
 select * from Cliente;

 create table Tipo_Ingresso_Cliente(
	 id_tipo_ingresso_cliente integer primary key auto_increment,
	 id_tipo_ingresso integer,
	 id_cliente integer,
     volume_ingresso int,
	 foreign key(id_tipo_ingresso) references Tipo_Ingresso(id_tipo_ingresso),
	 foreign key(id_cliente) references Cliente(id_cliente)
 );
  select * from Tipo_Ingresso_Cliente;
 
 create table Endereco_Cliente(
	 id_endereco_cliente integer primary key auto_increment,
	 id_cliente integer,
	 cidade varchar(50),
	 nome_cliente varchar(50),
	 foreign key(id_cliente) references Cliente(id_cliente)
 );
   select * from Endereco_Cliente;
