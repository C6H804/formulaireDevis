DROP TABLE IF EXISTS sondage_types;
CREATE TABLE sondage_types (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(99) NOT NULL
);

INSERT INTO sondage_types (name) VALUES ("google");
INSERT INTO sondage_types (name) VALUES ("facebook");
INSERT INTO sondage_types (name) VALUES ("instagram");
INSERT INTO sondage_types (name) VALUES ("pinterest");
INSERT INTO sondage_types (name) VALUES ("radio");
INSERT INTO sondage_types (name) VALUES ("bouche à oreille");
INSERT INTO sondage_types (name) VALUES ("publicité grand mail st paul lès dax");
INSERT INTO sondage_types (name) VALUES ("publicité papier (catalogue, prospectus, flyer)");
INSERT INTO sondage_types (name) VALUES ("publicité extérieure (panneau publicitaire)");
INSERT INTO sondage_types (name) VALUES ("sur la route, en passant devant l'agence à bégaar");
INSERT INTO sondage_types (name) VALUES ("sur la route, en passant devant l'agence à lescar");
INSERT INTO sondage_types (name) VALUES ("autre");
INSERT INTO sondage_types (name) VALUES ("aucune réponse");



DROP TABLE IF EXISTS stats_devis;
CREATE TABLE stats_devis (
    id INT PRIMARY KEY AUTO_INCREMENT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS stats_sondage;
CREATE TABLE stats_sondage (
    id_sondage_Type INT,
    id_devis INT,
    FOREIGN KEY (id_sondage_Type) REFERENCES sondage_types(id),
    FOREIGN KEY (id_devis) REFERENCES stats_devis(id)
); 

INSERT INTO stats_devis () VALUES ();

DROP TABLE IF EXISTS projects_types;
CREATE TABLE projects_types (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(99) NOT NULL
);

INSERT INTO projects_types (name) VALUES ("PORTAIL");
INSERT INTO projects_types (name) VALUES ("PORTILLON");
INSERT INTO projects_types (name) VALUES ("CLÔTURE RIGIDE");
INSERT INTO projects_types (name) VALUES ("CLÔTURE BÉTON");
INSERT INTO projects_types (name) VALUES ("CLÔTURE ALUMINIUM");
INSERT INTO projects_types (name) VALUES ("PORTE DE GARAGE");
INSERT INTO projects_types (name) VALUES ("STORE");
INSERT INTO projects_types (name) VALUES ("PERGOLA");
INSERT INTO projects_types (name) VALUES ("CARPORT");
INSERT INTO projects_types (name) VALUES ("FOURNITURES");
INSERT INTO projects_types (name) VALUES ("MAÇONNERIE");
INSERT INTO projects_types (name) VALUES ("AUTRE");
INSERT INTO projects_types (name) VALUES ("AUCUNE RÉPONSE");



DROP TABLE IF EXISTS stats_projects;
CREATE TABLE stats_projects (
    id_project_Type INT,
    id_devis INT,
    FOREIGN KEY (id_project_Type) REFERENCES projects_types(id),
    FOREIGN KEY (id_devis) REFERENCES stats_devis(id)
);
describe stats_projects;

SELECT projects_types.name, COUNT(stats_projects.id_project_Type) AS nombre_devis
FROM projects_types
LEFT JOIN stats_projects ON projects_types.id = stats_projects.id_project_Type
GROUP BY projects_types.name
HAVING nombre_devis > 0;


SELECT sondage_types.name, COUNT(stats_sondage.id_sondage_Type) AS nombre_devis
FROM sondage_types
LEFT JOIN stats_sondage ON sondage_types.id = stats_sondage.id_sondage_Type
GROUP BY sondage_types.name
HAVING nombre_devis > 0;
