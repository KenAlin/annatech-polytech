SET CLIENT_ENCODING TO 'UTF8';
;;fjh;;
DROP TABLE "correspondance";
DROP TABLE "sujets";
DROP TABLE "utilisateurs";
DROP TABLE "tokens";
DROP TABLE "matieres";
DROP TABLE "ue";
DROP TABLE "sections";

/*	Create tokens table
	* Informations provided by CodeIgniter documentation
	* Ref : http://www.codeigniter.com/user_guide/libraries/sessions.html#database-driver
*/
CREATE TABLE "tokens" (
        "id" varchar(40) NOT NULL,
        "ip_address" varchar(45) NOT NULL,
        "timestamp" bigint DEFAULT 0 NOT NULL,
        "data" text DEFAULT '' NOT NULL
);
CREATE INDEX "ci_sessions_timestamp" ON "tokens" ("timestamp");
ALTER TABLE "tokens" ADD PRIMARY KEY (id);

/*	Create and fill sections table
	* More informations on documentation
	* Insert every sections listed on homepage of Polytech Montpellier website
*/
CREATE TABLE "sections"(
   nom_section	VARCHAR(7)	PRIMARY KEY	NOT NULL,
   nom_complet	TEXT						NOT NULL,
   ico		TEXT						NOT NULL,
   color		CHAR(6)					NOT NULL
);
INSERT INTO "sections" VALUES ('IG', 'Informatique et Gestion', 'IG.png', 'E2017A');
INSERT INTO "sections" VALUES ('ENR', 'Energétique - énergies renouvelables', 'ENR.png', '98BF0E');
INSERT INTO "sections" VALUES ('GBA', 'Génie biologique et agroalimentaire', 'STIA.png', '97A01B');
INSERT INTO "sections" VALUES ('MAT', 'Matériaux', 'MAT.png', '32B199');
INSERT INTO "sections" VALUES ('MI', 'Mécanique et interactions', 'MI.png', 'B8491E');
INSERT INTO "sections" VALUES ('MEA', 'Microélectronique et automatique', 'MEA.png', '7C659F');
INSERT INTO "sections" VALUES ('STE', 'Sciences et technologies de l''eau', 'STE.png', '0E72B5');
INSERT INTO "sections" VALUES ('EGC', 'Eau et génie civil', 'EGC.png', 'EE7F01');
INSERT INTO "sections" VALUES ('MSI', 'Mécanique structures industrielles', 'MSI.png', '7693A8');
INSERT INTO "sections" VALUES ('SE', 'Systèmes embarqués', 'SE.png', '398697');

/*	Create table "UE" for "Unités d'Enseignement"
	* Informations from Polytech Montpellier website, and personnal knowledge.
*/
CREATE TABLE "ue"(
    id_ue		SERIAL		PRIMARY KEY							NOT NULL,
    nom_ue	TEXT												NOT NULL,
    section 	VARCHAR(7)	REFERENCES sections						NOT NULL,
    annee		INTEGER		CHECK (annee >= 1 AND annee <= 5)			NOT NULL,
    semestre	INTEGER		CHECK (semestre >= 1 AND semestre <= 10)	NOT NULL
);
INSERT INTO "ue" (nom_ue, section, annee, semestre) VALUES ('Fondamentaux de l''Informatique', 'IG', '3', '5');
INSERT INTO "ue" (nom_ue, section, annee, semestre) VALUES ('Fondamentaux des Mathématiques', 'IG', '3', '5');
INSERT INTO "ue" (nom_ue, section, annee, semestre) VALUES ('Gestion et Communication', 'IG', '3', '5');
INSERT INTO "ue" (nom_ue, section, annee, semestre) VALUES ('Fondamentaux de l''Informatique', 'IG', '3', '6');
INSERT INTO "ue" (nom_ue, section, annee, semestre) VALUES ('Techniques de l''Ingénieur', 'IG', '3', '6');
INSERT INTO "ue" (nom_ue, section, annee, semestre) VALUES ('Management', 'IG', '3', '6');
INSERT INTO "ue" (nom_ue, section, annee, semestre) VALUES ('Langues et Communication', 'IG', '3', '6');

/*	Create table for courses
	* Check MCC for reference.
*/
CREATE TABLE "matieres"(
    id_mat		SERIAL		PRIMARY KEY							NOT NULL,
    nom_mat		TEXT												NOT NULL,
    id_ue 		INTEGER		REFERENCES ue							NOT NULL,
    description	TEXT,
    UNIQUE(nom_mat, id_ue)
);
INSERT INTO "matieres" (nom_mat, id_ue, description) VALUES ('Algorithmique et structures de données', '1', 'Coef très haut, matière à ne surtout pas manquer !');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('Architecture des ordinateurs et langage d''assemblage', '1');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('Systèmes d''Exploitation 1', '1');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('Réseaux', '1');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('UNIX', '1');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('Mathématiques pour l''Informatique', '2');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('Modélisation et statistiques', '2');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('Mathématiques de la Décision 1', '2');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('Introduction aux SI', '3');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('ACSI', '3');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('Culture économique et sociétale', '3');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('Comptabilité des entreprises', '3');
INSERT INTO "matieres" (nom_mat, id_ue) VALUES ('Anglais', '3');
INSERT INTO "matieres" (nom_mat, id_ue, description) VALUES ('Intro architecture web', '4', 'Projet de fin d''année très important');

/*	Create users table
	* Admin account : admin/admin
*/
CREATE TABLE "utilisateurs"(
    id_user	SERIAL	PRIMARY KEY			NOT NULL,
    login		TEXT		UNIQUE				NOT NULL,
    mail 		TEXT		UNIQUE				NOT NULL,
    mdp		TEXT							NOT NULL,
    nbsujets	INTEGER	DEFAULT 0				NOT NULL,
    account_cr	DATE		DEFAULT CURRENT_DATE	NOT NULL,
    token		TEXT								   ,
    active	BOOLEAN	DEFAULT FALSE			NOT NULL,
    admin		BOOLEAN	DEFAULT FALSE			NOT NULL
);
INSERT INTO "utilisateurs" (login, mail, mdp, active, admin) VALUES ('Dummy', 'dummy@wave-it.fr', '$2y$10$WznDCHFhptLAk2k4v1iPuO1aG1dc1x5rSLdWYrcnxxy1SQzOtrtZG', 'TRUE', 'TRUE');

/*	Create subjects table
	* Maybe the most important table ?
*/
CREATE TABLE "sujets"(
    id_suj	SERIAL	PRIMARY KEY				NOT NULL,
    titre		TEXT								NOT NULL,
    matiere 	INTEGER	REFERENCES matieres			NOT NULL,
    annee		INTEGER	CHECK (annee >= 1980)		NOT NULL,
    rattrapage	BOOLEAN	DEFAULT FALSE				NOT NULL,
    correction	BOOLEAN	DEFAULT FALSE				NOT NULL,
    posteur	INTEGER	REFERENCES utilisateurs		NOT NULL,
    url		TEXT								NOT NULL
);

/*	Create subjects table
	* Maybe the most important table ?
*/
CREATE TABLE "correspondance"(
	id_sujet		INTEGER			REFERENCES sujets	NOT NULL,
	id_correction	INTEGER	UNIQUE	REFERENCES sujets	NOT NULL,
	UNIQUE(id_sujet, id_correction)
);

/* TRIGGERS !! */
CREATE OR REPLACE FUNCTION incr_nbsujets() RETURNS TRIGGER AS '
BEGIN
	UPDATE utilisateurs SET nbsujets = nbsujets +1 WHERE id_user = new.posteur;
	return new;
END;' LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION decr_nbsujets() RETURNS TRIGGER AS '
BEGIN
	UPDATE utilisateurs SET nbsujets = nbsujets -1 WHERE id_user = old.posteur;
	return old;
END;' LANGUAGE plpgsql;

CREATE TRIGGER incremente_nb_sujets
AFTER INSERT ON sujets
FOR EACH ROW EXECUTE PROCEDURE incr_nbsujets();

CREATE TRIGGER decremente_nb_sujets
AFTER DELETE ON sujets
FOR EACH ROW EXECUTE PROCEDURE decr_nbsujets();

INSERT INTO "sujets" (titre, matiere, annee, posteur, url) VALUES ('Examen', 1, 2015, 1, 'algo2015.pdf');
INSERT INTO "sujets" (titre, matiere, annee, correction, posteur, url) VALUES ('Corrigé algo 2015 officiel', 1, 2015, TRUE, 1, 'coralgo2015.pdf');
INSERT INTO "correspondance" (id_sujet, id_correction) VALUES (1, 2);