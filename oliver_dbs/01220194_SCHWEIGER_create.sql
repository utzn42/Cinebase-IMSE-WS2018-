CREATE TABLE programm (
	programm_id MEDIUMINT,
	PRIMARY KEY(programm_id),
	sprache VARCHAR(20),
	altersfreigabe TINYINT,
	CONSTRAINT alter_check CHECK (altersfreigabe BETWEEN 0 and 18)
);


CREATE TABLE film (
	programm_id MEDIUMINT,
	CONSTRAINT film_pk PRIMARY KEY(programm_id),
	CONSTRAINT film_fk FOREIGN KEY (programm_id) REFERENCES programm(programm_id) ON DELETE CASCADE,
	titel VARCHAR(160),
	regisseur VARCHAR(60),
	land VARCHAR(30)	
);

CREATE TABLE sondervorstellung (
	programm_id MEDIUMINT,
	FOREIGN KEY (programm_id) REFERENCES programm(programm_id) ON DELETE CASCADE,
	PRIMARY KEY(programm_id),
	typ VARCHAR(30),
	name VARCHAR(160)	
);


CREATE TABLE saal (
	saal_id MEDIUMINT,
	PRIMARY KEY(saal_id),
	name VARCHAR(10),
	ausstattung VARCHAR(50)		
);

CREATE TABLE vorfuehrung (
	vorfuehrungs_id MEDIUMINT,
	saal_id MEDIUMINT,
	programm_id MEDIUMINT,
	FOREIGN KEY (saal_id) REFERENCES saal(saal_id) ON DELETE CASCADE,
	FOREIGN KEY (programm_id) REFERENCES programm(programm_id) ON DELETE CASCADE,
	PRIMARY KEY(vorfuehrungs_id)
);

CREATE TABLE sitz (
	sitz_id SMALLINT AUTO_INCREMENT,
	saal_id MEDIUMINT,
	FOREIGN KEY (saal_id) REFERENCES saal(saal_id) ON DELETE CASCADE,
	PRIMARY KEY(sitz_id, saal_id),
	sitznummer TINYINT,
	reihennummer TINYINT,
	CONSTRAINT UC_saal_sitz_reihe UNIQUE (saal_id, sitznummer, reihennummer)
);

CREATE TABLE ticket (
	ticket_id MEDIUMINT,
	vorfuehrungs_id MEDIUMINT,
	FOREIGN KEY (vorfuehrungs_id) REFERENCES vorfuehrung(vorfuehrungs_id) ON DELETE CASCADE,
	PRIMARY KEY(ticket_id),
	preis SMALLINT NOT NULL,
	ermaessigung VARCHAR(15) DEFAULT NULL
);

CREATE TABLE mitarbeiter(
	personal_id MEDIUMINT,
	CONSTRAINT m_pk PRIMARY KEY(personal_id),
	partner_id MEDIUMINT UNIQUE,
	CONSTRAINT m_fk FOREIGN KEY (partner_id) REFERENCES mitarbeiter(personal_id) ON DELETE SET NULL,
	vorname VARCHAR(20),
	nachname VARCHAR(20),
	email VARCHAR(40) UNIQUE
);

CREATE TABLE aufsicht(
	saal_id MEDIUMINT,
	aufseher_id MEDIUMINT,
	FOREIGN KEY (saal_id) REFERENCES saal(saal_id) ON DELETE CASCADE,
	FOREIGN KEY (aufseher_id) REFERENCES mitarbeiter(personal_id) ON DELETE CASCADE,
	PRIMARY KEY(saal_id, aufseher_id)
);

CREATE OR REPLACE VIEW v_vorf
	AS SELECT titel, COUNT(*) cn
	FROM vorfuehrung NATURAL JOIN film
	GROUP BY titel
	HAVING COUNT(*) >1;
