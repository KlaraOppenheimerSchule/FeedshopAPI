CREATE DATABASE feedshopAPIDB;
USE feedshopAPIDB;

CREATE TABLE employee
(
	employeeID int not null auto_increment,
    firstname varchar(50),
    lastname varchar(50),
    lastUpdateDT date,
    createDT date,
    primary key(employeeID)
);

INSERT INTO employee VALUES
    (null, "Christoph", "Zobel",null,null),
	  (null, "Karl", "Steinam", null, null);

