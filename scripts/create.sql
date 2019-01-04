CREATE TABLE film (
	film_id MEDIUMINT,
	PRIMARY KEY(film_id),
	title VARCHAR(160),
	director VARCHAR(60),
	country VARCHAR(30)	,
	film_language VARCHAR(30),
	age_rating TINYINT,
	duration SMALLINT
);

CREATE TABLE hall (
	hall_id MEDIUMINT,
	PRIMARY KEY(hall_id),
	name VARCHAR(10),
	equipment VARCHAR(50)		
);

CREATE TABLE screening (
	screening_id MEDIUMINT AUTO_INCREMENT,
	hall_id MEDIUMINT,
	film_id MEDIUMINT,
	FOREIGN KEY (hall_id) REFERENCES hall(hall_id) ON DELETE CASCADE,
	FOREIGN KEY (film_id) REFERENCES film(film_id) ON DELETE CASCADE,
	PRIMARY KEY(screening_id),
	starting_time DATETIME
);

CREATE TABLE seat (
	seat_id SMALLINT AUTO_INCREMENT,
	hall_id MEDIUMINT,
	FOREIGN KEY (hall_id) REFERENCES hall(hall_id) ON DELETE CASCADE,
	PRIMARY KEY(seat_id, hall_id),
	seat_nr TINYINT,
	row_nr TINYINT,
	CONSTRAINT UC_hall_seat_row UNIQUE (hall_id, seat_nr, row_nr)
);

CREATE TABLE customer(
	customer_id MEDIUMINT AUTO_INCREMENT,
	PRIMARY KEY(customer_id),
	customer_type VARCHAR(30),
	email VARCHAR(40) UNIQUE,
	password VARCHAR(40)
);

CREATE TABLE ticket (
	ticket_id MEDIUMINT AUTO_INCREMENT,
	screening_id MEDIUMINT,
	customer_id MEDIUMINT,
	FOREIGN KEY (screening_id) REFERENCES screening(screening_id) ON DELETE CASCADE,
	FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE,
	PRIMARY KEY(ticket_id),
	price FLOAT NOT NULL,
	discount_type VARCHAR(20) DEFAULT NULL
);

CREATE TABLE employee(
	employee_nr MEDIUMINT,
	CONSTRAINT m_pk PRIMARY KEY(employee_nr),
	manager_id MEDIUMINT,
	FOREIGN KEY (manager_id) REFERENCES employee(employee_nr) ON DELETE CASCADE,
	first_name VARCHAR(30),
	last_name VARCHAR(30),
	email VARCHAR(40) UNIQUE,
	password varchar(20)

);

CREATE TABLE supervision(
	hall_id MEDIUMINT,
	supervisor_id MEDIUMINT,
	FOREIGN KEY (hall_id) REFERENCES hall(hall_id) ON DELETE CASCADE,
	FOREIGN KEY (supervisor_id) REFERENCES employee(employee_nr) ON DELETE CASCADE,
	PRIMARY KEY(hall_id, supervisor_id)
);