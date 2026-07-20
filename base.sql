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



