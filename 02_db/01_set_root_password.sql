-- execute this SQL script:
-- sudo mysql -u root <01_set_root_password.sql

delimiter $$

use mysql

drop procedure if exists 01_set_root_password$$

create procedure 01_set_root_password()
begin
  declare v_passwd longtext;
  declare v_authstr longtext;
  declare v_count int;

  select password, authentication_string, count(*)
    into v_passwd, v_authstr, v_count
    from mysql.user
   where user = 'root'
     and host = 'localhost'
  order by host, user;

  if v_count <> 1 then
    signal sqlstate '45000'
       set message_text = 'root user not found';
  end if;

  if v_passwd = 'invalid' or v_passwd = '' or v_passwd is null or
    v_authstr = 'invalid' or v_authstr = '' or v_authstr is null then

    alter user 'root'@'localhost' identified by 'passwORD89$';
    flush privileges;

  end if;
end$$

delimiter ;

call 01_set_root_password();

drop procedure 01_set_root_password;
