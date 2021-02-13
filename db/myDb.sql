-- \dt - Lists the tables
-- \d+ public.user - Shows the details of the user table
-- DROP TABLE public.user - Removes the user table completely so we can re-create it
-- \q - Quit the application and go back to the regular command prompt

-- CREATE TABLE customer
-- (
-- 	customer_id SERIAL NOT NULL PRIMARY KEY,
-- 	customer_email VARCHAR(100) NOT NULL UNIQUE,
-- 	customer_password VARCHAR(100) NOT NULL,
-- 	customer_firstname VARCHAR(100) NOT NULL,
-- 	customer_lastname VARCHAR(100) NOT NULL
-- );

CREATE TABLE customer
(
	customer_id SERIAL NOT NULL PRIMARY KEY,
	customer_email VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE category
(
	category_id SERIAL NOT NULL PRIMARY KEY,
	category_name VARCHAR(100) NOT NULL
);

CREATE TABLE product
(
	prod_id SERIAL NOT NULL PRIMARY KEY,
	prod_name VARCHAR(100) NOT NULL,
	prod_price INT NOT NULL,
	prod_description VARCHAR(250) NOT NULL,
	prod_stock INT NOT NULL,
	prod_img VARCHAR(100) NOT NULL,
	prod_category INT NOT NULL REFERENCES public.category(category_id)
);

CREATE TABLE public.order
(
	order_id SERIAL NOT NULL PRIMARY KEY,
	order_date TIMESTAMP NOT NULL,
	customer_id INT NOT NULL REFERENCES public.customer(customer_id),
	recipient_id INT NOT NULL REFERENCES public.recipient(recipient_id),
	is_complete BOOLEAN NOT NULL DEFAULT false
);


CREATE TABLE order_item
(
	order_item_id SERIAL NOT NULL PRIMARY KEY,
	order_id INT NOT NULL REFERENCES public.order(order_id),
	prod_id INT NOT NULL REFERENCES public.product(prod_id)
);


CREATE TABLE recipient (
	recipient_id SERIAL NOT NULL PRIMARY KEY,
	fname VARCHAR(45) NOT NULL,
	lname VARCHAR(45) NOT NULL,
	phone VARCHAR(20) NOT NULL,
	address VARCHAR(200) NOT NULL,
	postal_code INT NOT NULL,
	city VARCHAR(45) NOT NULL,
	country VARCHAR(45) NOT NULL,
	order_id INT NOT NULL REFERENCES public.order(order_id)
);


-- INSERTS ----

INSERT INTO customer (
	email,
	customer_password,
	customer_firstname,
	customer_lastname
)
VALUES (
	'user2@gmail.com',
	'p@ssw0rd',
	'admin',
	'user'
);

INSERT INTO category (
	name
)
VALUES (
	'Glassware'
);


INSERT INTO product (
	name,
	prod_price,
	prod_description,
	prod_stock,
	prod_img,
	prod_category
)
VALUES (
	'Clam Shell Jewelry Holder',
	'999',
	'A gorgeous way to keep your jewelry in order. This can also double as a lamp as it is equipped with a nightlight.',
	12,
	'shell.png',
	2
);

