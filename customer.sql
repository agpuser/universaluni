DROP TABLE Customers;
DROP SEQUENCE customer_id_seq;

CREATE TABLE Customers (
	custid NUMBER(4) NOT NULL,
	custusertime VARCHAR2(30),
	custusername VARCHAR2(30),
	custpassword VARCHAR2(40),
	custfirstname VARCHAR2(20),
	custlastname VARCHAR2(30),
	custaddress VARCHAR2(30),
	custcompany VARCHAR2(30),
	custcity VARCHAR2(20),
      	custstate VARCHAR2(5),
	custpostcode VARCHAR2(4),
	custcountry VARCHAR2(10),
	custphone VARCHAR2(15),
	custemail VARCHAR2(30),
       	primary key (custid) 
); 

CREATE TABLE Customers (
	custid INTEGER(4) NOT NULL AUTO_INCREMENT,
	custusertime VARCHAR(30),
	custusername VARCHAR(30),
	custpassword VARCHAR(40),
	custfirstname VARCHAR(20),
	custlastname VARCHAR(30),
	custaddress VARCHAR(30),
	custcompany VARCHAR(30),
	custcity VARCHAR(20),
      	custstate VARCHAR(5),
	custpostcode VARCHAR(4),
	custcountry VARCHAR(10),
	custphone VARCHAR(15),
	custemail VARCHAR(30),
       	primary key (custid) 
); 

create sequence customer_id_seq 
start with 1 
increment by 1 
nomaxvalue;



INSERT INTO Customers VALUES (customer_id_seq.nextval, '0.67497600 1538047694', 'janey', '8bb6d6fa2023b5f8419126c62f74a05b', 'Jane', 'Batman', '123 Crime Alley', '', 'Melbourne', 'VIC', '3456', 'Australia', '(03)56475437', 'batyjane02@yahoo.com');

INSERT INTO Customers VALUES (customer_id_seq.nextval, '0.93793200 1538047811', 'simo','fa6ba435fe4b3eef5e70c19477f53698', 'Simon', 'Dew', '3/4 My Way', '', 'Scoresville', 'VIC', '3789', 'Australia', '0405235431', 'deweys@gmail.com');

commit;