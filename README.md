# SAE3 – Plateforme d’Échange d’Objets

Projet universitaire réalisé dans le cadre du **BUT Informatique**.

SAE3 est une plateforme web permettant aux étudiants, enseignants et chefs de département de proposer, gérer et échanger des objets au sein d’une université, dans une logique de mutualisation et de réutilisation des ressources.

## 🎯 Présentation du projet

Ce projet a été développé dans le cadre d’une **SAE (Situation d’Apprentissage et d’Évaluation)**.  
Il vise à mettre en pratique les concepts fondamentaux du développement web côté serveur, notamment l’architecture MVC, la gestion des rôles et la sécurité des données.

## 🏗️ Architecture générale

Le projet repose sur une architecture **MVC personnalisée** en PHP.

```
SAE3/
├── app/
│   ├── controllers/        # Logique métier (par rôle)
│   ├── models/             # Accès données (PDO)
│   ├── views/              # Templates HTML
│   ├── core/               # Classe de base (Controller, Model, View, Validator, ErrorHandler)
├── assets/                 # CSS, JS (organisés par rôle)
├── core/                   # Noyau du framework (alias)
├── scripts/                # Scripts CLI (migration, seed, audit)
├── logs/                   # Fichiers de logs (créés à l'exécution)
├── vendor/                 # Dépendances Composer
├── index.php               # Point d'entrée (routeur)
├── .env                    # Variables d'environnement (NON commité)
└── composer.json           # Gestion des dépendances
```

### Flux MVC

```
index.php (routeur)
  ↓
Controller (app/controllers/{Page}Controller.php)
  ↓ (appelle)
Model (app/models/{Entity}.php)
  ↓ (retourne)
View (app/views/{role}/{page}.php) + rendu
```

## 🔐 Fonctionnalités principales

- Authentification sécurisée des utilisateurs
- Gestion des rôles (étudiant, enseignant, chef de département)
- Proposition, recherche et réservation d’objets
- Gestion d’un inventaire partagé
- Validation côté serveur et protection contre les injections SQL

## 👥 Rôles utilisateurs

- **Chef de département** : gestion de l’inventaire et validation des propositions  
- **Étudiant** : proposer et réserver des objets  
- **Enseignant** : consulter les ressources et signaler des besoins  

## 🧠 Objectifs pédagogiques

- Concevoir une application web structurée
- Appliquer une architecture MVC
- Manipuler une base de données avec PDO
- Mettre en œuvre de bonnes pratiques de sécurité
- Travailler en équipe sur un projet long

## 👤 Auteurs

Projet réalisé en groupe :

- [@XwerieS](https://github.com/XwerieS)  
- [@AlixCORBIN](https://github.com/AlixCORBIN)  
- [@NoanHeinry](https://github.com/NoanHeinry)  
- [@TiboTsr](https://github.com/TiboTsr)

