configurazione database sqlite;


CREATE TABLE Sitemaps (id INTEGER PRIMARY KEY, file TEXT, records INTEGER, lastInsertId INTEGER);

INSERT INTO Sitemaps (file, records, lastInsertId) VALUES('sitemap1.xml', 0, 0);