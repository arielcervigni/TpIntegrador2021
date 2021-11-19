create database if not exists ofertaslaborales;
use ofertaslaborales;

create table if not exists users (
userId int not null auto_increment,
firstName varchar(50),
lastName varchar(50),
phoneNumber varchar(15),
email varchar(100),
pass varchar(20),
isAdmin varchar(25), 
isActive bit,
companyId int null,
PRIMARY KEY (userId));

create table if not exists companys (
companyId int not null auto_increment,
cuit varchar(50),
descrip varchar(100),
aboutUs varchar(250),
companyLink varchar(100),
isActive bit,
PRIMARY KEY (companyId));

create table if not exists jobOffers (
jobOfferId int not null auto_increment,
companyId int,
province varchar(50),
city varchar(50),
endDate varchar(20),
jobPositionId int,
modality varchar(40),
availability varchar(40),
descrip varchar(500),
careerId int,
isActive bit,
PRIMARY KEY (jobOfferId)
);

create table if not exists appointments (
appointmentId int not null auto_increment,
studentId int,
jobOfferId int,
cv varchar(500),
descrip varchar(1000),
isActive bit, 
PRIMARY KEY (appointmentId)
);

