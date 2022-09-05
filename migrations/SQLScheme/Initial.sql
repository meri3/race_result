CREATE DATABASE IF NOT EXISTS race_results;

USE race_results;

CREATE TABLE IF NOT EXISTS Race (
    id int auto_increment,
    race_name varchar(255) not null,
    race_date datetime not null,
    primary key(id)
);

CREATE TABLE IF NOT EXISTS Result (
    id int auto_increment,
    race_id int not null,
    full_name varchar(255) not null,
    race_time int not null,
    distance varchar(16) not null,
    placement int not null,
    primary key(id),
    foreign key(race_id) references Race(id)
);