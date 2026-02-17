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
HAVING nombre_devis > 0
ORDER BY nombre_devis DESC;


SELECT sondage_types.name, COUNT(stats_sondage.id_sondage_Type) AS nombre_devis
FROM sondage_types
LEFT JOIN stats_sondage ON sondage_types.id = stats_sondage.id_sondage_Type
GROUP BY sondage_types.name
HAVING nombre_devis > 0;


SELECT projects_types.name, COUNT(stats_projects.id_project_Type) AS nombre_devis, CONCAT(ROUND((COUNT(stats_projects.id_project_Type) / (SELECT COUNT(*) FROM stats_projects)) * 100, 2), '%') AS pourcentage_devis
FROM projects_types
LEFT JOIN stats_projects ON projects_types.id = stats_projects.id_project_Type
GROUP BY projects_types.name
HAVING nombre_devis > 0
ORDER BY nombre_devis DESC;

    
-- calculer le nombre de devis par type de sondage et le pourcentage de chaque type de sondage par rapport au total des devis
SELECT sondage_types.name, COUNT(stats_sondage.id_sondage_Type) AS nombre_devis, CONCAT(ROUND((COUNT(stats_sondage.id_sondage_Type) / (SELECT COUNT(*) FROM stats_sondage)) * 100, 2), '%') AS pourcentage_devis
FROM sondage_types
LEFT JOIN stats_sondage ON sondage_types.id = stats_sondage.id_sondage_Type
GROUP BY sondage_types.name
HAVING nombre_devis > 0
ORDER BY nombre_devis DESC;


-- calculer le nombre de projets par réponse de sondage
SELECT st.name AS sondage_type, COUNT(sp.id_project_Type) AS nombre_projets
FROM sondage_types st
LEFT JOIN stats_sondage ss ON st.id = ss.id_sondage_Type
LEFT JOIN stats_projects sp ON ss.id_devis = sp.id_devis
GROUP BY st.name
HAVING nombre_projets > 0
ORDER BY nombre_projets DESC;


-- calcule le nombre de devis et de projets par type de sondage
SELECT st.name AS sondage_type, COUNT(DISTINCT ss.id_devis) AS nombre_devis, COUNT(sp.id_project_Type) AS nombre_projets, CONCAT(ROUND((COUNT(DISTINCT ss.id_devis) / (SELECT COUNT(*) FROM stats_sondage)) * 100, 2), '%') AS pourcentage_devis
FROM sondage_types st
LEFT JOIN stats_sondage ss ON st.id = ss.id_sondage_Type
LEFT JOIN stats_projects sp ON ss.id_devis = sp.id_devis
GROUP BY st.name
HAVING nombre_devis > 0
ORDER BY nombre_devis DESC;


-- pour chaques types de projet, calcule le nombres de récurences de chaques réponses de sondage
SELECT pt.name AS project_type, st.name AS sondage_type, COUNT(*) AS nombre_recurences
FROM projects_types pt
LEFT JOIN stats_projects sp ON pt.id = sp.id_project_Type
LEFT JOIN stats_sondage ss ON sp.id_devis = ss.id_devis
LEFT JOIN sondage_types st ON ss.id_sondage_Type = st.id
GROUP BY pt.name, st.name
HAVING nombre_recurences > 0 and sondage_type IS NOT NULL
ORDER BY pt.name, nombre_recurences DESC;



DELETE from stats_projects;
DELETE from stats_sondage;
DELETE from stats_devis;