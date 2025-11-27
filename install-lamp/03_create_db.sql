-- execute this SQL script:
-- mysql -u root <03_create_db.sql

-- set root password
alter user 'root'@'localhost' identified by 'africa89$';
flush privileges;

-- create database and user
create database lamp_db default character set utf8mb4 collate utf8mb4_unicode_ci;
create user 'lamp_user'@'localhost' identified by 'almA0000';
grant all privileges on lamp_db.* to 'lamp_user'@'localhost';
flush privileges;
