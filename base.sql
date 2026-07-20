CREATE TABLE prefixe (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL UNIQUE,
    actif INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE type_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE,
    libelle TEXT NOT NULL
);

CREATE TABLE bareme (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL,
    FOREIGN KEY (type_operation_id) REFERENCES type_operation(id)
);

CREATE TABLE compte_client (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_telephone TEXT NOT NULL UNIQUE,
    solde REAL NOT NULL DEFAULT 0,
    date_creation TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    compte_source_id INTEGER,
    compte_destination_id INTEGER,
    montant REAL NOT NULL,
    frais REAL NOT NULL DEFAULT 0,
    date_operation TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (type_operation_id) REFERENCES type_operation(id),
    FOREIGN KEY (compte_source_id) REFERENCES compte_client(id),
    FOREIGN KEY (compte_destination_id) REFERENCES compte_client(id)
);

CREATE VIEW vue_situation_gains AS
SELECT
    t.code AS type_operation,
    t.libelle AS libelle_type,
    strftime('%Y-%m-%d', o.date_operation) AS jour,
    SUM(o.frais) AS total_frais,
    COUNT(o.id) AS nb_operations
FROM operation o
JOIN type_operation t ON t.id = o.type_operation_id
GROUP BY t.id, jour;

CREATE VIEW vue_historique AS
SELECT
    o.id,
    o.date_operation,
    t.code AS type_operation,
    t.libelle AS libelle_type,
    o.montant,
    o.frais,
    cs.numero_telephone AS numero_source,
    cd.numero_telephone AS numero_destination
FROM operation o
JOIN type_operation t ON t.id = o.type_operation_id
LEFT JOIN compte_client cs ON cs.id = o.compte_source_id
LEFT JOIN compte_client cd ON cd.id = o.compte_destination_id;

INSERT INTO prefixe (prefixe, actif) VALUES
('033', 1),
('037', 1);

INSERT INTO type_operation (code, libelle) VALUES
('DEPOT', 'Dépôt'),
('RETRAIT', 'Retrait'),
('TRANSFERT', 'Transfert');

INSERT INTO bareme (type_operation_id, montant_min, montant_max, frais) VALUES
(2, 100, 1000, 50),
(2, 1001, 5000, 50),
(2, 5001, 10000, 100),
(2, 10001, 25000, 200),
(2, 25001, 50000, 400),
(2, 50001, 100000, 800),
(2, 100001, 250000, 1500),
(2, 250001, 500000, 1500),
(2, 500001, 1000000, 2500),
(2, 1000001, 2000000, 3000),
(3, 100, 1000, 50),
(3, 1001, 5000, 50),
(3, 5001, 10000, 100),
(3, 10001, 25000, 200),
(3, 25001, 50000, 400),
(3, 50001, 100000, 800),
(3, 100001, 250000, 1500),
(3, 250001, 500000, 1500),
(3, 500001, 1000000, 2500),
(3, 1000001, 2000000, 3000);

INSERT INTO compte_client (numero_telephone, solde) VALUES
('0331234567', 50000),
('0372345678', 15000),
('0339876543', 100000);




