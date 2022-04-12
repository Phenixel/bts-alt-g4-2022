# GSB - Gestion de médicament
2021/2022

# Procédure à suivre

## Installation du projet

```bash
$ git clone git@github.com:ort-france/bts-alt-g4-2022.git
```

## Configuration du .env
- Renomer "env.exemple" en ".env"
- Configurer les différentes informations demandées
    - Lien vers la BDD
    - Lien vers sentry
    - Lien vers Mailtrap

## installer composer
```bash
$ composer install
```

## Création de la BDD

```bash
$ symfony console doctrine:migrations:migrate
```

### Importation du jeu de données
```bash
$ symfony console doctrine:fixtures:load
```
> ⚠️Cette commandes remettras votre base de données à 0

---
Auteurs : Yonathan Cardoso & Maxime Buat