DROP TABLE Contacts;
DROP SEQUENCE contact_id_seq;

CREATE TABLE Contacts (
	contactid NUMBER(4) NOT NULL,
	contactfirstname VARCHAR2(20),
	contactlastname VARCHAR2(30),
	contactemail VARCHAR2(30),
	contactsubject VARCHAR2(20),
	contactmessage VARCHAR2(300),
       	primary key (contactid) 
); 

CREATE TABLE Contacts (
	contactid INTEGER(4) NOT NULL AUTO_INCREMENT,
	contactfirstname VARCHAR(20),
	contactlastname VARCHAR(30),
	contactemail VARCHAR(30),
	contactsubject VARCHAR(20),
	contactmessage VARCHAR(300),
       	primary key (contactid) 
); 


create sequence contact_id_seq 
start with 1 
increment by 1 
nomaxvalue;

INSERT INTO Contacts (contactfirstname, contactlastname, contactemail, contactsubject, contactmessage) VALUES ('Fred', 'Flinstone', 'ff@boulder.com', 'Hey Wilma', 'Yabba Dabba Do! Hey Barn.');

commit;