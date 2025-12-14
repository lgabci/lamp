-- execute this SQL script:
-- mysql -u lamp_user -palmA0000 <01_formok.sql

use lamp_db

create table formok(id int unsigned not null auto_increment primary key,
                    fejlec varchar(100) not null,
                    action varchar(100));
insert into formok (fejlec, action) values ('Form karbantatartás', 'formok.php');
