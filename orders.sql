DROP TABLE orders;
DROP TABLE orderItems;
DROP SEQUENCE order_id_seq;
DROP SEQUENCE order_item_id_seq;

CREATE TABLE orders (
	orderid NUMBER(4) NOT NULL,
	ordertotal NUMBER,
	ordersubtotal NUMBER,
	ordergst NUMBER,
	ordershipping NUMBER,
       	orderfirstname VARCHAR2(20),
	orderlastname VARCHAR2(30),
	orderaddress VARCHAR2(30),
	ordercompany VARCHAR2(30),
	ordercity VARCHAR2(20),
      	orderstate VARCHAR2(5),
	orderpostcode VARCHAR2(4),
	ordercountry VARCHAR2(10),
	orderphone VARCHAR2(15),
	orderemail VARCHAR2(30),
	ordercardname VARCHAR2(30),
	ordercardnumber VARCHAR2(20),
	ordercardexpirymonth VARCHAR2(15),
	ordercardexpiryyear VARCHAR2(4),
	ordercardcvv VARCHAR2(3),
       	primary key (orderid) 
); 

CREATE TABLE orders (
	orderid INTEGER(4) NOT NULL AUTO_INCREMENT,
	ordertotal DECIMAL,
	ordersubtotal DECIMAL,
	ordergst DECIMAL,
	ordershipping DECIMAL,
       	orderfirstname VARCHAR(20),
	orderlastname VARCHAR(30),
	orderaddress VARCHAR(30),
	ordercompany VARCHAR(30),
	ordercity VARCHAR(20),
      	orderstate VARCHAR(5),
	orderpostcode VARCHAR(4),
	ordercountry VARCHAR(10),
	orderphone VARCHAR(15),
	orderemail VARCHAR(30),
	ordercardname VARCHAR(30),
	ordercardnumber VARCHAR(20),
	ordercardexpirymonth VARCHAR(15),
	ordercardexpiryyear VARCHAR(4),
	ordercardcvv VARCHAR(3),
       	primary key (orderid) 
); 

create sequence order_id_seq start with 1 increment by 1 nomaxvalue;

CREATE TABLE orderitems (
	orderitemid NUMBER(4) NOT NULL,
	productid NUMBER(5) NOT NULL,
	productName VARCHAR2(30),
	quantity NUMBER,
	price NUMBER,
	orderid NUMBER(4) NOT NULL,
	primary key (orderitemid)
);

CREATE TABLE orderitems (
	orderitemid INTEGER NOT NULL AUTO_INCREMENT,
	productid INTEGER NOT NULL,
	productName VARCHAR(30),
	quantity INTEGER,
	price DECIMAL,
	orderid INTEGER(4) NOT NULL,
	primary key (orderitemid)
);


create sequence order_item_id_seq start with 1 increment by 1 nomaxvalue;


commit;

(ordertotal, ordersubtotal, ordergst, ordershipping, orderfirstname,
orderlastname, orderaddress, ordercompany, ordercity, orderstate,
orderpostcode, ordercountry, orderphone, orderemail, ordercardname,
ordercardnumber, ordercardexpirymonth, ordercardexpiryyear, ordercardcvv)