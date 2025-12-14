-- execute this SQL script:
-- mysql -u lamp_user -palmA0000 <02_form_mezok.sql

use lamp_db

drop table form_mezok;  ---

create table form_mezok(id int unsigned not null auto_increment primary key,
                        form_id int unsigned not null,
                        html_object varchar(30) not null,
                        html_for varchar(30),
                        html_type varchar(30),
                        html_name varchar(30),
                        html_value varchar(30),
                        szoveg varchar(30)
                        );

insert into form_mezok (form_id, html_object, html_for, szoveg)
                values (1, "label", "form_id", "Form");
insert into form_mezok (form_id, html_object, html_type, html_name)
                values (1, "input", "text", "form_id");

insert into form_mezok (form_id, html_object, html_for, szoveg)
                values (1, "label", "html_object", "Objektum");
insert into form_mezok (form_id, html_object, html_type, html_name)
                values (1, "input", "text", "html_object");

insert into form_mezok (form_id, html_object, html_for, szoveg)
                values (1, "label", "html_for", "For");
insert into form_mezok (form_id, html_object, html_type, html_name)
                values (1, "input", "text", "html_for");

insert into form_mezok (form_id, html_object, html_for, szoveg)
                values (1, "label", "html_type", "Type");
insert into form_mezok (form_id, html_object, html_type, html_name)
                values (1, "input", "text", "html_type");

insert into form_mezok (form_id, html_object, html_for, szoveg)
                values (1, "label", "html_name", "Name");
insert into form_mezok (form_id, html_object, html_type, html_name)
                values (1, "input", "text", "html_name");

insert into form_mezok (form_id, html_object, html_for, szoveg)
                values (1, "label", "html_value", "Value");
insert into form_mezok (form_id, html_object, html_type, html_name)
                values (1, "input", "text", "html_value");

insert into form_mezok (form_id, html_object, html_for, szoveg)
                values (1, "label", "szoveg", "Szöveg");
insert into form_mezok (form_id, html_object, html_type, html_name)
                values (1, "input", "text", "szoveg");

insert into form_mezok (form_id, html_object, html_type, html_value, html_name, szoveg)
                values (1, "button", "submit", "uj", "muvelet", "Rendben");
