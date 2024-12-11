create database car_workshop;
use car_workshop;
create table reparations(
	id int(4) primary key not null,
    uuid char(36) not null,
    workshop_name varchar(12) not null,
    register_date date not null,
    license_plate char(8),
    vehicle_image blob
);
-- select * from reparations;