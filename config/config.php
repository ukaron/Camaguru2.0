<?php
require ('database.php');
$connect = new connectBD();
$connect->connect();
$connect->DBH->query("create table activeUsers
(
    login          varchar(255) not null,
    email          varchar(255) not null,
    pass           char(64)     not null,
    fname          varchar(255) null,
    lname          varchar(255) null,
    remember_token varchar(255) null,
    constraint activeUsers_email_uindex
        unique (email),
    constraint activeUsers_login_uindex
        unique (login)
);

create table possibleUsers
(
    login varchar(255) not null,
    email varchar(255) not null,
    pass  char(64)     not null,
    token varchar(255) null,
    constraint possibleUsers_login_uindex
        unique (login)
);
");
$connect->commit();

