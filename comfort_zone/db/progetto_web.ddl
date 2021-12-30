-- * DB-MAIN version: 11.0.1              
-- * Generator date: Dec  4 2018              
-- * Generation date: Fri Dec  3 21:50:37 2021 
-- * LUN file: C:\Users\UTENTE\Desktop\progetto_web_rapyned.lun 
-- * Schema: web logico/1-1-1 
-- *************** 


-- Database Section
-- ______ 

create database comfort_zone;
use comfort_zone;


-- Tables Section
-- _____ 

create table Aula (
     numero_aula varchar(30) not null,
     piano int not null,
     constraint IDAula primary key (numero_aula));

create table Categoria (
     id_categoria int not null,
     nome varchar(30) not null,
     descrizione varchar(100),
     constraint IDCategoria primary key (id_categoria));

create table Fattorino (
     nome_fattorino varchar(50) not null,
     cognome_fattorino varchar(50) not null,
     username_fattorino varchar(30) not null,
     password_fattorino varchar(128) not null,
     email_fattorino varchar(50) not null,
     tentativi int (20) not null,
     abilitato boolean not null,
     tempo_attuale varchar(60),
     tempo_disabilitato varchar(60),
     sale varchar(50) not null,
     ordini_correnti int DEFAULT 0,
     constraint IDFattorino primary key (username_fattorino));

create table Notifica (
     id_notifica int not null AUTO_INCREMENT,
     testo varchar(500) not null,
     username_sender varchar(100) not null,
     username_receiver varchar(100) not null,
     letta boolean not null,
     constraint IDNotifica primary key (id_notifica));

create table Ordine (
     id_ordine int not null AUTO_INCREMENT,
     data_ordine datetime not null,
     data_consegna datetime,
     consegnato boolean not null,
     numero_aula varchar(30) not null,
     username_fattorino varchar(30) not null,
     username_utente varchar(30) not null,
     constraint IDOrdine_ID primary key (id_ordine));

create table Prodotto (
     id_prodotto int not null AUTO_INCREMENT,
     quantità int not null,
     prezzo_unitario float(1) not null,
     nome varchar(200) not null,
     descrizione varchar(500) not null,
     id_categoria int not null,
     username_venditore char(20) not null,
     constraint IDProdotto primary key (id_prodotto));

create table Prodotto_in_Carrello (
     id_prodotto int not null,
     username_utente varchar(30) not null,
     quantità int not null,
     constraint IDCarrello primary key (username_utente, id_prodotto));

create table Prodotto_in_Ordine (
     id_prodotto int not null,
     id_ordine int not null,
     quantità int not null,
     constraint IDProdotto_in_Ordine primary key (id_prodotto, id_ordine));

create table Tag (
     id_tag int not null AUTO_INCREMENT,
     nome varchar(50) not null,
     constraint IDTag_ID primary key (id_tag));

create table tag_del_prodotto (
     id_prodotto int not null,
     id_tag int not null,
     constraint IDtag_del_prodotto primary key (id_tag, id_prodotto));

create table Utente (
     metodo_pagamento varchar(50) not null,
     nome_utente varchar(50) not null,
     cognome_utente varchar(50) not null,
     username_utente varchar(30) not null,
     password_utente varchar(128) not null,
     email_utente varchar(50) not null,
     tentativi int (20) not null,
     abilitato boolean not null,
     tempo_attuale varchar(60),
     tempo_disabilitato varchar(60),
     sale varchar(50) not null,
     constraint IDUtente primary key (username_utente));


create table Venditore (
     codice_bancario varchar(50) not null,
     nome_marchio varchar(50) not null,
     username_venditore varchar(30) not null,
     password_venditore varchar(128) not null,
     email_venditore varchar(50) not null,
     tentativi int (20) not null,
     abilitato boolean not null,
     tempo_attuale varchar(60),
     tempo_disabilitato varchar(60),
     sale varchar(50) not null,
     constraint IDVenditore primary key (username_venditore));


-- Constraints Section
-- _______ 

-- Not implemented
-- alter table Ordine add constraint IDOrdine_CHK
--     check(exists(select * from Prodotto_in_Ordine
--                  where Prodotto_in_Ordine.id_ordine = id_ordine)); 

alter table Ordine add constraint FKconsegna_in
     foreign key (numero_aula)
     references Aula (numero_aula);

alter table Ordine add constraint FKconsegna
     foreign key (username_fattorino)
     references Fattorino (username_fattorino);

alter table Ordine add constraint FKeffettuazione
     foreign key (username_utente)
     references Utente (username_utente);

alter table Prodotto add constraint FKha
     foreign key (id_categoria)
     references Categoria (id_categoria);

alter table Prodotto add constraint FKvende
     foreign key (username_venditore)
     references Venditore (username_venditore);

alter table Prodotto_in_Carrello add constraint FKmet_Ute
     foreign key (username_utente)
     references Utente (username_utente);

alter table Prodotto_in_Carrello add constraint FKmet_Pro
     foreign key (id_prodotto)
     references Prodotto (id_prodotto);

alter table Prodotto_in_Ordine add constraint FKcom_Ord
     foreign key (id_ordine)
     references Ordine (id_ordine);

alter table Prodotto_in_Ordine add constraint FKcom_Pro
     foreign key (id_prodotto)
     references Prodotto (id_prodotto);

-- Not implemented
-- alter table Tag add constraint IDTag_CHK
--     check(exists(select * from tag_del_prodotto
--                  where tag_del_prodotto.id_tag = id_tag)); 

alter table tag_del_prodotto add constraint FKpro_Tag
     foreign key (id_tag)
     references Tag (id_tag);

alter table tag_del_prodotto add constraint FKpro_Pro
     foreign key (id_prodotto)
     references Prodotto (id_prodotto);


-- Index Section
-- _____