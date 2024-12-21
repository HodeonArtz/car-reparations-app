create database if not exists car_workshop;
use car_workshop;
create table if not exists reparations(
	id int(4) primary key not null auto_increment,
    uuid char(36) not null,
    workshop_name varchar(12) not null,
    register_date date not null,
    license_plate char(8) not null,
    vehicle_image mediumblob not null
);
-- select * from reparations; 