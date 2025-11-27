-- execute this SQL script:
-- mysql -u lamp_user -palmA0000 <04_create_db.sql

use lamp_db;

create table autok(id int unsigned not null auto_increment primary key,
                   rendszam varchar(10) not null,
                   tipus varchar(50) not null,
                   szin varchar(20),
                   evjarat decimal(4) not null);
insert into autok (rendszam, tipus, szin, evjarat) values ('HEM968', 'Suzuki Swift', 'kék', 2000);
insert into autok (rendszam, tipus, szin, evjarat) values ('HEM969', 'Opel Corsa', 'lila', 2010);
insert into autok (rendszam, tipus, szin, evjarat) values ('AAEI233', 'Suzuki Swift', 'fehér', 2024);
