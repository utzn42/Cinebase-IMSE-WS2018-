CREATE TABLE programm (
	programm_id NUMBER(6),
	PRIMARY KEY(programm_id),
	sprache VARCHAR2(20),
	altersfreigabe NUMBER(2),
	CONSTRAINT alter_check CHECK (altersfreigabe BETWEEN 0 and 18)
);


CREATE TABLE film (
	programm_id NUMBER(6),
	CONSTRAINT film_pk PRIMARY KEY(programm_id),
	CONSTRAINT film_fk FOREIGN KEY (programm_id) REFERENCES programm(programm_id) ON DELETE CASCADE,
	titel VARCHAR2(160),
	regisseur VARCHAR2(60),
	land VARCHAR2(30)	
);

CREATE TABLE sondervorstellung (
	programm_id NUMBER(6),
	FOREIGN KEY (programm_id) REFERENCES programm(programm_id) ON DELETE CASCADE,
	PRIMARY KEY(programm_id),
	typ VARCHAR2(30),
	name VARCHAR2(160)	
);


CREATE TABLE saal (
	saal_id NUMBER(6),
	PRIMARY KEY(saal_id),
	name VARCHAR2(10),
	ausstattung VARCHAR2(50)		
);

CREATE TABLE vorfuehrung (
	vorfuehrungs_id NUMBER(6),
	saal_id NUMBER(6),
	programm_id NUMBER(6),
	FOREIGN KEY (saal_id) REFERENCES saal(saal_id) ON DELETE CASCADE,
	FOREIGN KEY (programm_id) REFERENCES programm(programm_id) ON DELETE CASCADE,
	PRIMARY KEY(vorfuehrungs_id),
	-- startzeit TIME,
	-- endzeit TIME,
	datum DATE DEFAULT (sysdate) 
);

CREATE TABLE sitz (
	sitz_id NUMBER(3),
	saal_id NUMBER(6),
	FOREIGN KEY (saal_id) REFERENCES saal(saal_id) ON DELETE CASCADE,
	PRIMARY KEY(sitz_id, saal_id),
	sitznummer NUMBER(2),
	reihennummer NUMBER(2),
	CONSTRAINT UC_saal_sitz_reihe UNIQUE (saal_id, sitznummer, reihennummer)
);

CREATE TABLE ticket (
	ticket_id NUMBER(6),
	vorfuehrungs_id NUMBER(6),
	FOREIGN KEY (vorfuehrungs_id) REFERENCES vorfuehrung(vorfuehrungs_id) ON DELETE CASCADE,
	PRIMARY KEY(ticket_id),
	preis NUMBER(4,2) NOT NULL,
	ermaessigung VARCHAR2(15) DEFAULT NULL
);

CREATE TABLE mitarbeiter(
	personal_id NUMBER(6),
	CONSTRAINT m_pk PRIMARY KEY(personal_id),
	partner_id NUMBER(6) UNIQUE,
	CONSTRAINT m_fk FOREIGN KEY (partner_id) REFERENCES mitarbeiter(personal_id) ON DELETE SET NULL,
	vorname VARCHAR2(20),
	nachname VARCHAR2(20),
	email VARCHAR2(40) UNIQUE
);

CREATE TABLE aufsicht(
	saal_id NUMBER(6),
	aufseher_id NUMBER(6),
	FOREIGN KEY (saal_id) REFERENCES saal(saal_id) ON DELETE CASCADE,
	FOREIGN KEY (aufseher_id) REFERENCES mitarbeiter(personal_id) ON DELETE CASCADE,
	PRIMARY KEY(saal_id, aufseher_id)
);

--VIEW DER ALLE FILME AUSGIBT, DIE MEHR ALS 1 VORFUEHRUNG HABEN
CREATE OR REPLACE VIEW v_vorf
AS SELECT titel, COUNT(*) cn
FROM vorfuehrung NATURAL JOIN film
GROUP BY titel
HAVING COUNT(*) >1;

 CREATE SEQUENCE seq_sitz
    START WITH 1
    INCREMENT BY 1;
 
  
CREATE OR REPLACE TRIGGER tr_programm
 BEFORE INSERT ON sitz
 FOR EACH ROW
   BEGIN
     SELECT seq_sitz.nextval
     INTO :new.sitz_id
     FROM dual;
   END;
   /
