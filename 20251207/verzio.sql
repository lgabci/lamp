-- execute this SQL script:
-- mysql -u lamp_user -palmA0000 <verzio.sql

use lamp_db

create table verzio(foverzio int,
                    alverzio int,
                    szoveg varchar(50));

insert into verzio (foverzio, alverzio, szoveg)
            values (0, 1, '20251207');
