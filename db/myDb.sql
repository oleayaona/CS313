-- \dt - Lists the tables
-- \d+ public.user - Shows the details of the user table
-- DROP TABLE public.user - Removes the user table completely so we can re-create it
-- \q - Quit the application and go back to the regular command prompt

CREATE TABLE customer
(
	customer_id SERIAL NOT NULL PRIMARY KEY,
	customer_email VARCHAR(100) NOT NULL UNIQUE,
	customer_password VARCHAR(100) NOT NULL,
	customer_firstname VARCHAR(100) NOT NULL,
	customer_lastname VARCHAR(100) NOT NULL
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
	is_complete BOOLEAN NOT NULL
);


CREATE TABLE order_item
(
	order_item_id SERIAL NOT NULL PRIMARY KEY,
	order_id INT NOT NULL REFERENCES public.order(order_id),
	prod_id INT NOT NULL REFERENCES public.product(prod_id),
	order_quantity INT NOT NULL
);

