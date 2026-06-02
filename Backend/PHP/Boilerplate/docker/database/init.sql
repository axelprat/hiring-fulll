CREATE DATABASE IF NOT EXISTS parking;
USE parking;

DROP TABLE IF EXISTS user_table;
CREATE TABLE IF NOT EXISTS user_table (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY
);

INSERT INTO user_table VALUES (1), (2);

DROP TABLE IF EXISTS fleet;
CREATE TABLE IF NOT EXISTS fleet (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id int(11) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user_table (id)
);

DROP TABLE IF EXISTS vehicle;
CREATE TABLE IF NOT EXISTS vehicle (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    plate_number varchar(50) NOT NULL,
    `long` varchar(50) NULL,
    lat varchar(50) NULL,
    alt int(11) NULL,
    UNIQUE (plate_number)
);
INSERT INTO vehicle VALUES (1, 'AA-000-AA', null, null, null), (2, 'BB-111-BB', null, null, null);

DROP TABLE IF EXISTS fleet_vehicle;
CREATE TABLE IF NOT EXISTS fleet_vehicle (
    fleet_id int(11) NOT NULL,
    vehicle_id int(11) NOT NULL,
    FOREIGN KEY (fleet_id) REFERENCES fleet (id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicle (id),
    CONSTRAINT UC_Fleet_Vehicle UNIQUE (fleet_id, vehicle_id)
);

