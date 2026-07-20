# Taches
## v1

### Mihaja
- [x] Config prefixes operateur (033, 037...)
- [x] Types operations (depot/retrait/transfert) + baremes frais par tranche (CRUD)
- [x] Situation gains frais (retrait/transfert)
- [x] Situation comptes clients (vue admin)

### Steeven
- [x] Login auto par numero tel (sans inscription)
- [x] Voir solde
- [x] Depot (auto)
- [x] Retrait (auto)
- [x] Transfert
- [x] Historique operations

### Commun
- [x] base.sql (tables, vues, donnees)
- [x] Setup CI4 + SQLite
- [x] Tag v1 (13h)

## v2

### Mihaja
- [x] Prefixes autres operateurs (032, 031...) - champ categorie interne/externe
- [x] Config % commission transferts vers autres operateurs (CRUD)
- [x] Situation gains : separer operateur / autres operateurs
- [x] Situation montants a envoyer a chaque operateur externe

### Steeven
- [x] Option "inclure frais de retrait" lors de l'envoi
- [x] Envoi multiple vers plusieurs numeros (montant divise)

### Commun
- [x] Maj base.sql (categorie prefixe, table commission_externe, vue gains interne/externe)
- [x] Tag v2 (17h10)