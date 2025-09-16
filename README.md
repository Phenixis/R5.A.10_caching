# Site PHP + PostgreSQL + Cache REDIS

Maxime Duhamel 3A1

## Introduction

La version initiale de ce projet (La table items de la base de données, le README, le site web qui insère et fetch les données dans la bdd postgres) ont été générées par IA.
J'ai fait l'insertion du cache REDIS par la suite.

## Description
Exemple d'application web en PHP permettant :
1. D'insérer rapidement 3 lignes de test dans une table `items` d'une base PostgreSQL locale.
2. De récupérer et afficher les dernières valeurs insérées.

## Prérequis
- PHP >= 8.0 avec extension `pdo_pgsql`
- Serveur PostgreSQL local
- Base de données existante (par défaut `testdb`)
- Utilisateur PostgreSQL (par défaut `postgres` / `postgres`)

Ajustez les identifiants dans `public/config.php`.

## Installation rapide
```bash
# Cloner ou placer les fichiers dans un dossier accessible
cd /chemin/vers/le/projet

# (Optionnel) Créer la base si elle n'existe pas
createdb testdb

# (Optionnel) Créer la table manuellement
psql -d testdb -f public/init.sql
```

## Lancer le serveur de développement PHP
Depuis la racine du projet :
```bash
php -S localhost:8000 -t public
```
Ouvre ensuite : http://localhost:8000

## Utilisation
- Bouton "Insérer 3 valeurs" : ajoute 3 lignes dans la table `items`.
- Bouton "Afficher les valeurs" : recharge la page avec `?fetch=1` et affiche jusqu'à 50 dernières entrées.

## Personnalisation
Modifie `public/config.php` pour changer :
```php
return [
    'host' => 'localhost',
    'port' => 5432,
    'dbname' => 'testdb',
    'user' => 'postgres',
    'password' => 'postgres',
];
```
