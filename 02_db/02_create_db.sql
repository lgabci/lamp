-- execute this SQL script:
-- sudo mysql -u root <02_create_db.sql

delimiter $$

use mysql

drop procedure if exists 02_create_db$$

create procedure 02_create_db()
begin
  declare v_count int;

  select count(*)
    into v_count
    from information_schema.SCHEMATA
    where schema_name = 'lamp_db';

  if v_count = 0 then

    create database lamp_db
    default character set utf8mb4
    collate utf8mb4_unicode_ci;

  end if;

  select count(*)
    into v_count
    from user
    where user = 'lamp_user'
      and host = 'localhost';

  if v_count = 0 then

    create user 'lamp_user'@'localhost' identified by 'almA0000';
    grant all privileges on lamp_db.* to 'lamp_user'@'localhost';
    flush privileges;

  end if;

end$$

delimiter ;

call 02_create_db();

drop procedure 02_create_db;
