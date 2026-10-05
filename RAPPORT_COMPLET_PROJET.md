# RAPPORT COMPLET DU PROJET
# Système de Gestion Paroissiale - Saint Michel Archange de la BAE

---

## TABLE DES MATIÈRES

1. [Introduction](#1-introduction)
2. [Contexte et Problématique](#2-contexte-et-problématique)
3. [Objectifs du Projet](#3-objectifs-du-projet)
4. [Architecture Technique](#4-architecture-technique)
5. [Base de Données](#5-base-de-données)
6. [Fonctionnalités Détaillées](#6-fonctionnalités-détaillées)
7. [Sécurité et Gestion des Accès](#7-sécurité-et-gestion-des-accès)
8. [Interface Utilisateur](#8-interface-utilisateur)
9. [Flux de Travail](#9-flux-de-travail)
10. [Installation et Déploiement](#10-installation-et-déploiement)
11. [Guide d'Utilisation](#11-guide-dutilisation)
12. [Maintenance et Évolution](#12-maintenance-et-évolution)
13. [Conclusion](#13-conclusion)

---

## 1. INTRODUCTION

### 1.1 Présentation Générale

Le **Système de Gestion Paroissiale** est une application web complète développée pour la Paroisse Saint Michel Archange de la BAE (Base Aérienne d'Edéa). Cette solution numérique vise à moderniser et centraliser la gestion administrative, pastorale et financière de la paroisse.

### 1.2 Portée du Projet

Le système couvre l'ensemble des activités paroissiales :
- Gestion des fidèles et registres paroissiaux
- Administration des sacrements
- Organisation de la vie paroissiale (CEB, mouvements, événements)
- Gestion financière complète
- Communication avec les fidèles
- Catéchèse et formation religieuse

### 1.3 Public Cible

**Utilisateurs Principaux :**
- **Clergé** : Curé, prêtres, diacres
- **Conseil Paroissial** : Membres du conseil de gestion
- **Secrétariat** : Personnel administratif
- **Trésorier** : Gestionnaire financier
- **Catéchistes** : Responsables de la formation
- **Responsables de Mouvements** : Chorales, légion de Marie, etc.

**Bénéficiaires :**
- L'ensemble des fidèles de la paroisse
- Les visiteurs et nouveaux fidèles

---

## 2. CONTEXTE ET PROBLÉMATIQUE

### 2.1 Contexte Actuel

Avant l'implémentation de ce système, la paroisse faisait face à plusieurs défis :

**Gestion Manuelle :**
- Registres papier pour les fidèles et sacrements
- Fichiers Excel dispersés pour les finances
- Absence de centralisation des informations
- Risques de perte de données

**Processus Redondants :**
- Saisie multiple des mêmes informations
- Difficulté à retrouver des informations historiques
- Manque de traçabilité des actions

**Communication Limitée :**
- Difficulté à informer les fidèles
- Absence de plateforme publique
- Gestion manuelle des annonces

### 2.2 Problématique

Comment moderniser la gestion paroissiale en proposant une solution numérique qui :
- Centralise toutes les données paroissiales
- Automatise les processus administratifs
- Garantit la sécurité et la traçabilité des informations
- Facilite la communication avec les fidèles
- Simplifie la gestion financière

### 2.3 Solution Proposée

Une application web Laravel avec les caractéristiques suivantes :
- Interface moderne et intuitive
- Gestion des rôles et permissions
- Génération automatique de documents PDF
- Interface publique pour les fidèles
- Architecture évolutive et maintenable

---

## 3. OBJECTIFS DU PROJET

### 3.1 Objectifs Fonctionnels

**Gestion des Fidèles :**
- ✅ Registre numérique complet des fidèles
- ✅ Suivi des sacrements reçus
- ✅ Historique des participations
- ✅ Recherche et filtrage avancés

**Gestion Administrative :**
- ✅ Administration des CEB
- ✅ Gestion des mouvements paroissiaux
- ✅ Organisation du clergé
- ✅ Conseil paroissial

**Gestion Pastorale :**
- ✅ Calendrier des messes et événements
- ✅ Intentions de messe avec offrandes
- ✅ Annonces paroissiales
- ✅ Catéchèse et catéchumènes

**Gestion Financière :**
- ✅ Enregistrement des recettes
- ✅ Suivi des dépenses
- ✅ Bilans mensuels
- ✅ Reçus numérotés

### 3.2 Objectifs Techniques

- ✅ Architecture MVC respectant les standards Laravel
- ✅ Base de données relationnelle optimisée
- ✅ Interface responsive (mobile/desktop)
- ✅ Sécurité renforcée (authentification, permissions)
- ✅ Génération de documents PDF
- ✅ Export de données (CSV, PDF, Word)

### 3.3 Objectifs Non-Fonctionnels

- **Performance** : Temps de réponse < 2 secondes
- **Sécurité** : Protection contre les attaques courantes
- **Scalabilité** : Support de plusieurs centaines d'utilisateurs
- **Maintenabilité** : Code documenté et structuré
- **Accessibilité** : Interface claire et intuitive

---

## 4. ARCHITECTURE TECHNIQUE

### 4.1 Stack Technologique

#### Backend
```
Framework : Laravel 13.x
Langage : PHP 8.5+
Base de données : MySQL/MariaDB
ORM : Eloquent (Laravel)
Génération PDF : DomPDF (barryvdh/laravel-dompdf)
Génération Word : PhpOffice/PhpWord
Authentification : Laravel Sanctum (intégré)
```

#### Frontend
```
Framework CSS : Bootstrap 5.3.3
Icônes : Bootstrap Icons 1.11.3
Polices Google Fonts : Cinzel, Inter, Cormorant Garamond
JavaScript : Vanilla JS + Bootstrap JS
```

#### Outils de Développement
```
Gestion de dépendances : Composer (PHP), npm (JS)
Build tool : Vite
Version control : Git
```

### 4.2 Structure du Projet

```
paroisse-saint-michel-projet-complet/
├── app/
│   ├── Http/
│   │   ├── Controllers/              # Contrôleurs MVC
│   │   │   ├── AuthController.php  # Authentification
│   │   │   ├── DashboardController.php # Tableau de bord
│   │   │   ├── CrudController.php  # Contrôleur CRUD générique
│   │   │   ├── FideleController.php # Gestion des fidèles
│   │   │   ├── FinanceController.php # Gestion financière
│   │   │   ├── IntentionController.php # Intentions de messe
│   │   │   └── ...
│   │   ├── Middleware/
│   │   │   ├── CheckPermission.php # Vérification des permissions
│   │   │   └── ...
│   │   └── Requests/                # Validation des formulaires
│   ├── Models/                      # Modèles Eloquent
│   │   ├── User.php                 # Utilisateurs
│   │   ├── Fidele.php               # Fidèles
│   │   ├── Recette.php              # Recettes
│   │   ├── Depense.php              # Dépenses
│   │   ├── Intention.php            # Intentions
│   │   ├── Evenement.php            # Événements
│   │   └── ...
│   └── Providers/
├── config/                          # Configuration Laravel
│   ├── app.php
│   ├── database.php
│   └── filesystems.php
├── database/
│   ├── migrations/                  # Migrations de base de données
│   │   └── 2026_09_29_000001_create_paroisse_tables.php
│   └── seeders/                     # Données de test
├── public/                          # Fichiers publics
│   ├── css/                         # Feuilles de style compilées
│   ├── images/                      # Images statiques
│   │   ├── saint.jpg                # Logo paroisse
│   │   └── michel.jfif              # Image héro
│   └── storage/                     # Lien vers storage
├── resources/
│   ├── views/                       # Templates Blade
│   │   ├── layouts/                 # Layouts principaux
│   │   │   ├── paroisse.blade.php   # Layout administratif
│   │   │   ├── public.blade.php     # Layout public
│   │   │   └── auth.blade.php       # Layout authentification
│   │   ├── dashboard.blade.php      # Tableau de bord
│   │   ├── pages/                   # Pages publiques
│   │   ├── pdf/                     # Templates PDF
│   │   │   ├── recu.blade.php       # Reçu
│   │   │   ├── bilan.blade.php      # Bilan financier
│   │   │   ├── evenement.blade.php  # Calendrier
│   │   │   └── ...
│   │   ├── crud/                    # Templates CRUD génériques
│   │   │   ├── index.blade.php      # Liste
│   │   │   └── form.blade.php       # Formulaire
│   │   ├── fideles/                 # Vues fidèles
│   │   ├── finance/                 # Vues finances
│   │   ├── intentions/              # Vues intentions
│   │   └── ...
│   └── css/                         # Sources SCSS
├── routes/
│   ├── web.php                      # Routes web
│   └── api.php                      # Routes API (future)
├── storage/                         # Stockage des fichiers
│   ├── app/                         # Données applicatives
│   ├── framework/                   # Framework Laravel
│   └── logs/                        # Logs
├── tests/                           # Tests (PHPUnit)
├── .env                             # Configuration environnement
├── .env.example                     # Exemple de configuration
├── composer.json                    # Dépendances PHP
├── package.json                     # Dépendances Node
└── vite.config.js                   # Configuration Vite
```

### 4.3 Architecture MVC

L'application suit strictement le pattern Model-View-Controller de Laravel :

#### Modèle (Model)
Les modèles représentent les entités de la base de données et contiennent :
- La logique métier
- Les relations entre entités
- Les casts de types
- Les accesseurs et mutateurs

**Exemple - Modèle Fidele :**
```php
class Fidele extends Model
{
    protected $guarded = [];
    protected $casts = [
        'date_naissance' => 'date',
        'baptise' => 'boolean',
        'confirme' => 'boolean',
        'marie' => 'boolean'
    ];
    
    // Relations
    public function ceb() { return $this->belongsTo(Ceb::class); }
    public function bapteme() { return $this->hasOne(Bapteme::class); }
    public function sacrements() { return $this->hasMany(Sacrement::class); }
    public function mouvements() { return $this->belongsToMany(Mouvement::class); }
}
```

#### Vue (View)
Les vues sont des templates Blade qui contiennent :
- La structure HTML
- Les directives Blade pour les boucles et conditions
- Les styles CSS
- Les scripts JavaScript

#### Contrôleur (Controller)
Les contrôleurs gèrent :
- Les requêtes HTTP
- La validation des données
- L'appel aux modèles
- Le retour des vues

### 4.4 Contrôleur CRUD Générique

L'application utilise un contrôleur CRUD abstrait (`CrudController`) qui permet de créer rapidement des interfaces d'administration :

**Fonctionnalités :**
- `fields()` : Définition des champs du formulaire
- `columns()` : Définition des colonnes du tableau
- `extraRules()` : Règles de validation supplémentaires
- `prepare()` : Préparation des données avant sauvegarde
- `after()` : Actions après sauvegarde
- `links()` : Liens supplémentaires par ligne

**Avantages :**
- Réduction du code répétitif
- Cohérence des interfaces
- Maintenance facilitée
- Développement accéléré

---

## 5. BASE DE DONNÉES

### 5.1 Schéma Relationnel

#### Diagramme des Relations

```
┌─────────────┐
│    users    │
├─────────────┤
│ id          │──┐
│ name        │  │
│ email       │  │
│ password    │  │
│ role        │  │
│ permissions │  │
└─────────────┘  │
                  │
                  │ 1:N
                  │
┌─────────────┐  │       ┌─────────────┐
│   fideles    │  │       │   recettes  │
├─────────────┤  │       ├─────────────┤
│ id          │  │       │ id          │
│ nom         │  │       │ date        │
│ prenoms     │  │       │ type        │
│ sexe        │  │       │ montant     │
│ ceb_id      │──┼───────│ fidele_id   │
│ statut      │  │       │ user_id     │──┘
│ baptise     │  │       └─────────────┘
│ confirme    │  │
│ marie       │  │
└─────────────┘  │
                  │
        ┌─────────┴─────────┐
        │                   │
┌─────────────┐     ┌─────────────┐
│   baptemes   │     │  sacrements │
├─────────────┤     ├─────────────┤
│ id          │     │ id          │
│ fidele_id   │     │ fidele_id   │
│ numero_acte │     │ type        │
│ date_bapteme│     │ date_celebration
└─────────────┘     └─────────────┘

┌─────────────┐     ┌─────────────┐
│    cebs     │     │ evenements  │
├─────────────┤     ├─────────────┤
│ id          │     │ id          │
│ nom         │     │ titre       │
│ responsable │     │ type        │
└─────────────┘     │ date_heure  │
                    │ lieu        │
                    └─────────────┘
                          │
                          │ 1:N
                          │
                    ┌─────────────┐
                    │  intentions │
                    ├─────────────┤
                    │ id          │
                    │ demandeur   │
                    │ intention   │
                    │ offrande    │
                    │ evenement_id│
                    └─────────────┘
```

### 5.2 Description des Tables

#### 5.2.1 users - Utilisateurs du système

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique (auto-incrément) | Non |
| name | string | Nom complet de l'utilisateur | Non |
| email | string | Email (unique) | Non |
| password | string | Mot de passe hashé (Bcrypt) | Non |
| role | string | Rôle (admin, cure, secretaire, tresorier, catechiste) | Non |
| permissions | json | Permissions JSON (array) | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `unique(email)` : Unicité de l'email

#### 5.2.2 fideles - Registre des fidèles

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| nom | string | Nom de famille | Non |
| prenoms | string | Prénoms | Non |
| sexe | enum | M ou F | Non |
| date_naissance | date | Date de naissance | Oui |
| lieu_naissance | string | Lieu de naissance | Oui |
| telephone | string | Numéro de téléphone | Oui |
| email | string | Adresse email | Oui |
| profession | string | Profession | Oui |
| quartier | string | Quartier de résidence | Oui |
| situation_matrimoniale | string | État civil | Oui |
| ceb_id | bigint | CEB d'appartenance (foreign key) | Oui |
| statut | enum | actif, transfere, decede | Non |
| baptise | boolean | Est baptisé | Oui |
| confirme | boolean | Est confirmé | Oui |
| marie | boolean | Est marié | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `index(nom, prenoms)` : Recherche par nom/prénoms
- `foreign(ceb_id)` → cebs(id)

#### 5.2.3 cebs - Communautés Ecclésiales de Base

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| nom | string | Nom du CEB (unique) | Non |
| responsable | string | Responsable du CEB | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `unique(nom)` : Unicité du nom

#### 5.2.4 baptemes - Registre des baptêmes

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| fidele_id | bigint | Fidèle baptisé (foreign key, unique) | Non |
| numero_acte | string | Numéro d'acte (unique) | Non |
| date_bapteme | date | Date du baptême | Non |
| lieu | string | Lieu du baptême | Oui |
| ministre | string | Ministre célébrant | Non |
| parrain | string | Parrain | Oui |
| marraine | string | Marraine | Oui |
| pere | string | Père | Oui |
| mere | string | Mère | Oui |
| livre | string | Livre du registre | Oui |
| folio | string | Folio du registre | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `unique(fidele_id)` : Un fidèle n'a qu'un baptême
- `unique(numero_acte)` : Unicité du numéro d'acte
- `foreign(fidele_id)` → fideles(id)

#### 5.2.5 sacrements - Autres sacrements

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| type | string | Type de sacrement | Non |
| fidele_id | bigint | Fidèle concerné (foreign key) | Non |
| conjoint_id | bigint | Conjoint (pour mariage, foreign key) | Oui |
| date_celebration | date | Date de célébration | Non |
| lieu | string | Lieu de célébration | Oui |
| ministre | string | Ministre célébrant | Oui |
| temoin1 | string | Témoin 1 | Oui |
| temoin2 | string | Témoin 2 | Oui |
| numero_acte | string | Numéro d'acte (unique) | Non |
| observations | text | Observations | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `unique(numero_acte)` : Unicité du numéro d'acte
- `index(type, fidele_id)` : Recherche par type et fidèle
- `foreign(fidele_id)` → fideles(id)
- `foreign(conjoint_id)` → fideles(id)

#### 5.2.6 mouvements - Mouvements paroissiaux

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| nom | string | Nom du mouvement (unique) | Non |
| responsable | string | Responsable | Oui |
| date_creation | date | Date de création | Oui |
| description | text | Description | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `unique(nom)` : Unicité du nom

#### 5.2.7 fidele_mouvement - Pivot fidèles-mouvements

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| fidele_id | bigint | Fidèle (foreign key) | Non |
| mouvement_id | bigint | Mouvement (foreign key) | Non |
| fonction | string | Fonction dans le mouvement | Non |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `unique(fidele_id, mouvement_id)` : Un fidèle ne peut être qu'une fois dans un mouvement
- `foreign(fidele_id)` → fideles(id)
- `foreign(mouvement_id)` → mouvements(id)

#### 5.2.8 evenements - Événements paroissiaux

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| titre | string | Titre de l'événement | Non |
| type | string | Type (messe, adoration, retraite, etc.) | Non |
| date_heure | datetime | Date et heure | Non |
| lieu | string | Lieu | Oui |
| celebrant | string | Célébrant | Oui |
| description | text | Description | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `index(date_heure)` : Recherche par date

#### 5.2.9 intentions - Intentions de messe

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| demandeur | string | Nom du demandeur | Non |
| telephone | string | Téléphone | Oui |
| type | string | Type d'intention | Non |
| intention | text | Intention de messe | Non |
| offrande | bigint | Montant de l'offrande | Non |
| date_messe | date | Date de la messe souhaitée | Non |
| jour_messe | string | Jour de la messe (samedi/dimanche) | Oui |
| jour_messe_detaille | string | Détail du jour (dimanche 7h, 9h, etc.) | Oui |
| evenement_id | bigint | Événement associé (foreign key) | Oui |
| statut | string | Statut (en_attente, tiree, celebree) | Non |
| recu_numero | string | Numéro de reçu (unique) | Non |
| numero_semaine | string | Numéro de semaine pour tirage | Oui |
| user_id | bigint | Utilisateur enregistrant (foreign key) | Non |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `unique(recu_numero)` : Unicité du numéro de reçu
- `foreign(evenement_id)` → evenements(id)
- `foreign(user_id)` → users(id)

#### 5.2.10 recettes - Recettes financières

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| date | date | Date de la recette | Non |
| type | string | Type (quête, offrande, don, etc.) | Non |
| montant | bigint | Montant en FCFA | Non |
| fidele_id | bigint | Fidèle donateur (foreign key) | Oui |
| ceb_id | bigint | CEB concerné (foreign key) | Oui |
| donateur_nom | string | Nom du donateur (si pas fidèle) | Oui |
| recu_numero | string | Numéro de reçu (unique) | Non |
| note | string | Note complémentaire | Oui |
| user_id | bigint | Utilisateur enregistrant (foreign key) | Non |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `unique(recu_numero)` : Unicité du numéro de reçu
- `foreign(fidele_id)` → fideles(id)
- `foreign(ceb_id)` → cebs(id)
- `foreign(user_id)` → users(id)

#### 5.2.11 depenses - Dépenses

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| date | date | Date de la dépense | Non |
| categorie | string | Catégorie de dépense | Non |
| libelle | string | Libellé de la dépense | Non |
| montant | bigint | Montant en FCFA | Non |
| user_id | bigint | Utilisateur enregistrant (foreign key) | Non |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `foreign(user_id)` → users(id)

#### 5.2.12 classes_cate - Classes de catéchèse

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| annee | string | Année scolaire | Non |
| niveau | string | Niveau (CP1, CP2, etc.) | Non |
| catechiste | string | Catéchiste responsable | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

#### 5.2.13 catechumenes - Catéchumènes

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| fidele_id | bigint | Fidèle (foreign key) | Non |
| classe_cate_id | bigint | Classe de catéchèse (foreign key) | Non |
| statut | string | Statut (inscrit, en_cours, termine) | Non |
| observation | string | Observations | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

**Index :**
- `unique(fidele_id, classe_cate_id)` : Unicité fidèle/classe
- `foreign(fidele_id)` → fideles(id)
- `foreign(classe_cate_id)` → classes_cate(id)

#### 5.2.14 annonces - Annonces paroissiales

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| titre | string | Titre de l'annonce | Non |
| contenu | text | Contenu de l'annonce | Non |
| image | string | Chemin de l'image | Oui |
| publie_le | date | Date de publication | Non |
| expire_le | date | Date d'expiration | Oui |
| afficher_affiche | boolean | Afficher comme affiche | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

#### 5.2.15 clerge - Membres du clergé

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| nom | string | Nom | Non |
| prenoms | string | Prénoms | Non |
| fonction | string | Fonction (curé, prêtre, diacre) | Non |
| residence | string | Lieu de résidence | Oui |
| telephone | string | Téléphone | Oui |
| email | string | Email | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

#### 5.2.16 conseil_paroissial - Conseil paroissial

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| nom | string | Nom | Non |
| prenoms | string | Prénoms | Non |
| role | string | Rôle dans le conseil | Non |
| mandat_debut | date | Début du mandat | Non |
| mandat_fin | date | Fin du mandat | Non |
| telephone | string | Téléphone | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

#### 5.2.17 mouvement_paroissial - Mouvements paroissiaux (affichage public)

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| nom | string | Nom du mouvement | Non |
| icone | string | Icône Bootstrap | Non |
| responsable | string | Responsable | Oui |
| telephone_responsable | string | Téléphone du responsable | Oui |
| description | string | Description | Oui |
| photo | string | Chemin de la photo | Oui |
| actif | boolean | Mouvement actif | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

#### 5.2.18 contacts - Messages de contact

| Champ | Type | Description | Nullable |
|-------|------|-------------|----------|
| id | bigint | Identifiant unique | Non |
| nom | string | Nom de l'expéditeur | Non |
| email | string | Email | Non |
| sujet | string | Sujet du message | Non |
| message | text | Contenu du message | Non |
| lu | boolean | Message lu | Oui |
| created_at | timestamp | Date de création | Non |
| updated_at | timestamp | Date de mise à jour | Non |

### 5.3 Types de Données et Énumérations

#### Types de sacrements
- `bapteme` : Baptême
- `communion` : Première communion
- `profession_foi` : Profession de foi
- `confirmation` : Confirmation
- `mariage` : Mariage
- `onction_malades` : Onction des malades
- `funerailles` : Funérailles

#### Types d'événements
- `messe` : Messe
- `adoration` : Adoration
- `retraite` : Retraite spirituelle
- `reunion` : Réunion
- `fete` : Fête / Solennité
- `autre` : Autre

#### Types d'intentions
- `action_grace` : Action de grâce
- `repos_eternel` : Repos éternel
- `intention_generale` : Intention générale

#### Types de recettes
- `don` : Dons
- `dime` : Dîmes
- `quete_ordinaire` : Quête ordinaire
- `quete_speciale` : Quête spéciale
- `quete_imperative` : Quête impérative
- `quete_semaine` : Quête de semaine
- `denier_culte` : Denier du culte
- `offrande_messe` : Offrande de messe
- `autre` : Autre

#### Catégories de dépenses
- `salaire` : Salaires
- `entretien` : Entretien
- `electricite` : Électricité
- `eau` : Eau
- `communication` : Communication
- `transport` : Transport
- `materiel` : Matériel
- `autre` : Autre

#### Statuts des fidèles
- `actif` : Fidèle actif
- `transfere` : Fidèle transféré
- `decede` : Fidèle décédé

#### Statuts des intentions
- `en_attente` : En attente de tirage
- `tiree` : Tirée pour une messe
- `celebree` : Célébrée

#### Statuts des catéchumènes
- `inscrit` : Inscrit
- `en_cours` : En cours de formation
- `termine` : Formation terminée

### 5.4 Relations Eloquent

#### Relations BelongsTo (Plusieurs-à-Un)
- Fidele → CEB
- Recette → Fidele
- Recette → CEB
- Recette → User
- Depense → User
- Intention → Evenement
- Intention → User
- Sacrement → Fidele
- Sacrement → Fidele (conjoint)
- Catechumene → Fidele
- Catechumene → ClasseCate

#### Relations HasOne (Un-à-Un)
- Fidele → Bapteme

#### Relations HasMany (Un-à-Plusieurs)
- Fidele → Sacrements
- Fidele → Catechumenes
- User → Recettes
- User → Depenses
- User → Intentions
- Evenement → Intentions
- ClasseCate → Catechumenes

#### Relations BelongsToMany (Plusieurs-à-Plusieurs)
- Fidele ↔ Mouvement (pivot: fidele_mouvement)

---

## 6. FONCTIONNALITÉS DÉTAILLÉES

### 6.1 Module d'Authentification

#### 6.1.1 Connexion
- Formulaire de connexion sécurisé
- Validation de l'email et mot de passe
- Protection contre brute-force (6 tentatives/minute)
- Session sécurisée avec token CSRF
- Rappel de mot de passe (future)

#### 6.1.2 Gestion des Rôles
**Rôles disponibles :**
- `admin` : Accès complet à toutes les fonctionnalités
- `cure` : Accès pastoral complet (sauf gestion utilisateurs)
- `secretaire` : Accès administratif (fidèles, sacrements, vie paroissiale, catéchèse)
- `tresorier` : Accès financier uniquement
- `catechiste` : Accès catéchèse uniquement

#### 6.1.3 Système de Permissions
Les permissions sont stockées en JSON dans le champ `permissions` de la table `users` :

**Permissions disponibles :**
- `fideles` : Gestion des fidèles
- `sacrements` : Gestion des sacrements
- `cebs` : Gestion des CEB
- `mouvements` : Gestion des mouvements
- `clerge` : Gestion du clergé
- `conseil_paroissial` : Gestion du conseil paroissial
- `mouvement_paroissial` : Gestion des mouvements paroissiaux
- `evenements` : Gestion des événements
- `intentions` : Gestion des intentions
- `annonces` : Gestion des annonces
- `classes_cate` : Gestion des classes de catéchèse
- `catechumenes` : Gestion des catéchumènes
- `finances` : Gestion financière
- `users` : Gestion des utilisateurs
- `contacts` : Gestion des contacts

**Mécanisme de vérification :**
```php
// Dans le modèle User
public function hasPermission(string $rubrique): bool
{
    return in_array($rubrique, $this->permissions ?? []);
}

// Middleware
Route::middleware('permission:finances')->group(function () {
    // Routes protégées
});
```

### 6.2 Module des Fidèles

#### 6.2.1 Enregistrement des Fidèles
**Informations collectées :**
- Identité : Nom, prénoms, sexe
- Naissance : Date, lieu
- Contact : Téléphone, email
- Personnel : Profession, quartier
- Situation : État matrimonial
- Paroissial : CEB d'appartenance, statut
- Sacrements : Baptisé, confirmé, marié (checkbox)

**Validation :**
- Nom et prénoms obligatoires
- Sexe obligatoire (M/F)
- Statut obligatoire (actif/transfere/decede)
- Email valide si fourni
- Téléphone valide si fourni

#### 6.2.2 Recherche et Filtrage
- Recherche par nom, prénoms, téléphone
- Filtrage par CEB
- Filtrage par statut
- Pagination (20 par page)

#### 6.2.3 Export des Données
- Export CSV avec BOM UTF-8
- Colonnes : Nom, Prénoms, Sexe, Naissance, Téléphone, Quartier, CEB, Statut, Sacrements
- Compatible Excel

#### 6.2.4 Fiche Détaillée
Affichage complet :
- Informations personnelles
- CEB d'appartenance
- Sacrements reçus
- Mouvements et fonctions
- Historique des modifications

### 6.3 Module des Sacrements

#### 6.3.1 Baptême
**Informations enregistrées :**
- Numéro d'acte (généré automatiquement)
- Date du baptême
- Lieu du baptême
- Ministre célébrant
- Parrain et marraine
- Père et mère
- Livre et folio du registre

**Génération du certificat :**
- PDF stylisé avec logo paroisse
- Informations complètes
- Date de génération
- Signature placeholder

#### 6.3.2 Autres Sacrements
**Types gérés :**
- Communion
- Profession de foi
- Confirmation
- Mariage (avec conjoint)
- Onction des malades
- Funérailles

**Informations par sacrement :**
- Numéro d'acte (généré automatiquement)
- Date de célébration
- Lieu
- Ministre
- Témoins (1 ou 2)
- Observations

**Pour le mariage :**
- Conjoint (relation vers fideles)
- Témoins obligatoires

### 6.4 Module des CEB

#### 6.4.1 Gestion des CEB
**Informations :**
- Nom du CEB
- Responsable
- Zone de couverture

**Fonctionnalités :**
- CRUD complet
- Export PDF
- Association aux fidèles

#### 6.4.2 Membres par CEB
- Vue des membres d'un CEB
- Statistiques par CEB
- Export PDF

### 6.5 Module des Mouvements

#### 6.5.1 Mouvements Paroissiaux
**Informations :**
- Nom du mouvement
- Responsable
- Date de création
- Description

**Icônes disponibles :**
- Chorale : `bi-music-note-beamed`
- Légion de Marie : `bi-flower1`
- Serviteurs de l'Autel : `bi-bell`
- CEB : `bi-people`
- Charité : `bi-heart`
- Catéchèse : `bi-book`
- Jeunesse : `bi-calendar-event`
- Autre : `bi-gear`

#### 6.5.2 Gestion des Membres
**Fonctionnalités :**
- Ajout de membres (fidèles)
- Attribution de fonctions
- Retrait de membres
- Vue des membres par mouvement

### 6.6 Module des Événements

#### 6.6.1 Types d'Événements
- Messe
- Adoration
- Retraite
- Réunion
- Fête / Solennité
- Autre

#### 6.6.2 Création d'Événements
**Informations :**
- Titre
- Type
- Date et heure
- Lieu
- Célébrant
- Description

#### 6.6.3 Calendrier
- Affichage chronologique
- Filtrage par type
- Export PDF du calendrier
- Intégration avec intentions

### 6.7 Module des Intentions de Messe

#### 6.7.1 Enregistrement
**Informations :**
- Demandeur
- Téléphone
- Type d'intention
- Intention (texte)
- Offrande (montant)
- Date de messe souhaitée
- Jour de messe (samedi/dimanche)
- Détail du jour (dimanche 7h, 9h, etc.)

**Numérotation automatique :**
- Numéro de reçu généré automatiquement
- Format : INT-XXXXX

#### 6.7.2 Système de Tirage
**Fonctionnement :**
- Les intentions sont en attente
- Tirage automatique par semaine
- Répartition équilibrée samedi/dimanche
- Génération de liste PDF

**Types de tirage :**
- Action de grâce
- Repos éternel
- Général

#### 6.7.3 Reçu PDF
- Design élégant
- Numéro de reçu
- Date
- Demandeur
- Motif
- Montant
- Zones de signature

#### 6.7.4 Statuts
- `en_attente` : En attente de tirage
- `tiree` : Tirée pour une messe
- `celebree` : Célébrée

#### 6.7.5 Exports
- CSV (liste simple)
- PDF (liste détaillée)
- Word (document officiel)

### 6.8 Module Financier

#### 6.8.1 Recettes
**Types :**
- Dons
- Dîmes
- Quêtes (ordinaire, spéciale, impérative, semaine)
- Denier du culte
- Offrandes de messe
- Autre

**Catégories :**
- `don` : Dons
- `dime` : Dîmes
- `quete` : Toutes les quêtes
- `offrande` : Offrandes

**Enregistrement :**
- Date
- Type
- Montant
- Donateur (fidèle ou nom)
- CEB (optionnel)
- Note complémentaire

**Numérotation :**
- Numéro de reçu automatique
- Format : REC-XXXXX

#### 6.8.2 Dépenses
**Catégories :**
- Salaire
- Entretien
- Électricité
- Eau
- Communication
- Transport
- Matériel
- Autre

**Enregistrement :**
- Date
- Catégorie
- Libellé
- Montant

**Protection :**
- Les recettes et dépenses ne sont pas supprimables (traçabilité)

#### 6.8.3 Bilans
**Périodes :**
- Mensuel (YYYY-MM)
- Tout l'historique

**Filtrage :**
- Par catégorie de recette
- Par période

**Export PDF :**
- Récapitulatif des recettes
- Récapitulatif des dépenses
- Solde
- Tableau détaillé

#### 6.8.4 Vues Spécialisées
- Dons : Vue dédiée aux dons
- Dîmes : Vue dédiée aux dîmes
- Offrandes : Vue dédiée aux offrandes
- Quêtes : Vue dédiée aux quêtes
- Denier du culte : Vue dédiée

**Chaque vue :**
- Liste filtrée
- Total
- Export
- Reçu par ligne

#### 6.8.5 Reçu PDF
- Design élégant avec bordures dorées
- Logo paroisse
- Numéro de reçu
- Date
- Donateur
- Motif détaillé
- Montant
- Catégorie
- Zones de signature
- Pied de page avec croix

### 6.9 Module de Catéchèse

#### 6.9.1 Classes de Catéchèse
**Informations :**
- Année scolaire
- Niveau (CP1, CP2, CE1, CE2, CM1, CM2)
- Catéchiste responsable

#### 6.9.2 Catéchumènes
**Inscription :**
- Fidèle
- Classe de catéchèse
- Statut (inscrit, en_cours, termine)
- Observations

**Suivi :**
- Changement de statut
- Historique par classe

### 6.10 Module des Annonces

#### 6.10.1 Publication
**Informations :**
- Titre
- Contenu
- Image (optionnel)
- Date de publication
- Date d'expiration (optionnel)
- Afficher comme affiche

#### 6.10.2 Affichage Public
- Page d'accueil
- Filtrage par date (annonces actives uniquement)
- Design responsive

### 6.11 Module du Clergé

#### 6.11.1 Enregistrement
**Informations :**
- Nom, prénoms
- Fonction (curé, prêtre, diacre)
- Lieu de résidence
- Téléphone
- Email

#### 6.11.2 Export PDF
- Liste du clergé
- Informations complètes

### 6.12 Module du Conseil Paroissial

#### 6.12.1 Enregistrement
**Informations :**
- Nom, prénoms
- Rôle dans le conseil
- Période de mandat (début, fin)
- Téléphone

#### 6.12.2 Export PDF
- Liste du conseil
- Mandats

### 6.13 Module de Contact

#### 6.13.1 Formulaire Public
- Nom
- Email
- Sujet
- Message

#### 6.13.2 Gestion
- Liste des messages
- Marquage lu/non lu
- Réponse (future)

### 6.14 Tableau de Bord

#### 6.14.1 Statistiques Globales
- Fidèles actifs
- Baptêmes de l'année
- Catéchumènes inscrits
- Intentions à célébrer

#### 6.14.2 Statistiques Financières (si autorisé)
- Recettes de l'année
- Dépenses de l'année
- Solde

#### 6.14.3 Statistiques par Catégorie
- Dons totaux
- Dîmes totales
- Quêtes totales
- Offrandes totales

#### 6.14.4 Derniers Fidèles
- Liste des 10 derniers fidèles inscrits
- Informations de base

#### 6.14.5 Prochains Événements
- Liste des 5 prochains événements
- Date, titre, lieu, célébrant

#### 6.14.6 Messes et Calendrier
- Tableau des événements
- Export PDF

#### 6.14.7 Mouvements Paroissiaux
- Grille des mouvements actifs
- Icônes, noms, responsables
- Export PDF

#### 6.14.7 Actions Rapides
- Nouveau fidèle
- Nouvel événement
- Nouvelle annonce
- Gérer finances
- Tirage intentions

---

## 7. SÉCURITÉ ET GESTION DES ACCÈS

### 7.1 Authentification

#### 7.1.1 Hashage des Mots de Passe
- Algorithme : Bcrypt
- Coût : 10 rounds (par défaut Laravel)
- Exemple : `bcrypt('password')`

#### 7.1.2 Protection contre Brute-Force
- Middleware : `throttle:6,1`
- 6 tentatives par minute
- Blocage temporaire après échec

#### 7.1.3 Protection CSRF
- Token CSRF sur tous les formulaires
- Vérification automatique par Laravel
- `@csrf` directive Blade

#### 7.1.4 Sessions
- Stockage : Base de données
- Durée : 2 heures (configurable)
- Régénération à chaque connexion

### 7.2 Gestion des Permissions

#### 7.2.1 Structure des Permissions
Les permissions sont stockées en JSON dans la table `users` :

```json
{
  "fideles": true,
  "sacrements": true,
  "finances": true,
  "evenements": true
}
```

#### 7.2.2 Middleware de Permission
```php
// Dans routes/web.php
Route::middleware('permission:finances')->group(function () {
    Route::resource('recettes', RecetteController::class);
    Route::resource('depenses', DepenseController::class);
});
```

#### 7.2.3 Vérification dans les Contrôleurs
```php
public function index()
{
    if (!auth()->user()->hasPermission('fideles')) {
        abort(403);
    }
    // ...
}
```

#### 7.2.4 Vérification dans les Vues
```php
@if(auth()->user()->hasPermission('finances'))
    <!-- Contenu protégé -->
@endif
```

### 7.3 Validation des Données

#### 7.3.1 Validation côté Serveur
Toutes les données entrantes sont validées :
- Types de données
- Longueur maximale
- Formats (email, date, etc.)
- Unicité (email, numéros uniques)
- Relations (existencedes clés étrangères)

#### 7.3.2 Validation côté Client
- Attributs HTML5 (required, pattern, etc.)
- Validation JavaScript (Bootstrap)
- Feedback immédiat

### 7.4 Protection des Données Sensibles

#### 7.4.1 Champs Protégés
- Mots de passe : Hashés
- Informations financières : Accès restreint
- Données personnelles : Accès par rôle

#### 7.4.2 Journalisation
- Création : Date et utilisateur
- Modification : Date et utilisateur
- Suppression : Soft delete (future)

### 7.5 Sécurité des Fichiers

#### 7.5.1 Upload d'Images
- Validation du type MIME
- Taille maximale : 2MB
- Stockage dans `storage/app/public`
- Accès via lien symbolique

#### 7.5.2 Noms de Fichiers
- Génération de noms uniques
- Protection contre path traversal
- Séparation du stockage

---

## 8. INTERFACE UTILISATEUR

### 8.1 Design System

#### 8.1.1 Palette de Couleurs

```css
/* Couleurs principales */
--nuit:        #0B1B3A;      /* Bleu nuit profond - fond sidebar */
--nuit-deep:   #07122B;      /* Bleu nuit très profond - fond sombre */
--archange:    #2748B8;      /* Bleu archange - accent */
--or:          #D4A937;      /* Or principal - accent doré */
--or-clair:    #F2D98A;      /* Or clair - highlight */
--ivoire:      #FAF7F0;      /* Ivoire - fond principal */
--carte:       #FFFFFF;      /* Blanc - fond des cartes */
--encre:       #1B2233;      /* Encre - texte principal */
--brume:       #6B7590;      /* Brume - texte secondaire */
--parchemin:   #E6E1D3;      /* Parchemin - bordures */
--flamme:      #C8322B;      /* Flamme - rouge (alertes) */
--emeraude:    #1F8A70;      /* Émeraude - vert (succès) */
```

#### 8.1.2 Typographie

**Polices Google Fonts :**
- **Cinzel** : Titres et en-têtes (serif élégant)
- **Inter** : Corps du texte (sans-serif moderne)
- **Cormorant Garamond** : Documents officiels (serif classique)

**Hiérarchie typographique :**
```css
h1, h2, h3 { font-family: 'Cinzel', serif; }
body { font-family: 'Inter', sans-serif; }
.document { font-family: 'Cormorant Garamond', serif; }
```

#### 8.1.3 Composants UI

**Cartes :**
- Fond blanc
- Ombre subtile
- Coins arrondis (8px)
- Bordure fine

**Boutons :**
- Primary : Bleu archange
- Success : Émeraude
- Warning : Or
- Danger : Flamme
- Outline : Bordure colorée

**Tableaux :**
- Lignes alternées
- Hover sur les lignes
- En-têtes colorés
- Responsive (scroll horizontal)

**Formulaires :**
- Champs avec bordure fine
- Focus avec bordure colorée
- Labels clairs
- Messages d'erreur visibles

### 8.2 Layouts

#### 8.2.1 Layout Public (`layouts/public.blade.php`)
**Caractéristiques :**
- Navigation responsive
- Dock mobile élégant
- Footer avec informations
- Design moderne et accueillant

**Navigation Desktop :**
- Logo à gauche
- Liens de navigation au centre
- Bouton de connexion à droite

**Navigation Mobile :**
- Dock fixe en bas
- Icônes avec étiquettes
- Animation fluide
- Design arrondi

#### 8.2.2 Layout Administratif (`layouts/paroisse.blade.php`)
**Caractéristiques :**
- Sidebar fixe à gauche
- Contenu principal à droite
- Tableau de bord accessible
- Interface CRUD cohérente

**Sidebar :**
- Logo paroisse
- Navigation par module
- Icônes Bootstrap
- Indicateur de page active
- Bouton de déconnexion

**Contenu Principal :**
- En-tête avec titre
- Breadcrumbs (future)
- Zone de contenu
- Footer

#### 8.2.3 Layout Authentification (`layouts/auth.blade.php`)
**Caractéristiques :**
- Centré
- Design minimaliste
- Logo paroisse
- Formulaire compact

### 8.3 Navigation Mobile

**Dock Navigation :**
- Fixe en bas de l'écran
- 5 icônes principales
- Animation au hover
- Actif sur les pages publiques

**Icônes :**
- Accueil : `bi-house`
- À propos : `bi-info-circle`
- Annonces : `bi-megaphone`
- Contact : `bi-envelope`
- Connexion : `bi-person`

### 8.4 Reçus PDF

#### 8.4.1 Design du Reçu
**Style :**
- Bordure dorée
- Logo paroisse
- Typographie raffinée
- Zones de signature stylisées
- Pied de page avec croix décorative

**Contenu :**
- En-tête avec logo et nom paroisse
- Titre "REÇU" + catégorie
- Numéro de reçu
- Date
- Donateur
- Motif détaillé
- Montant en évidence
- Zones de signature (cachet, signature)
- Pied de page avec date d'impression

#### 8.4.2 Certificats
**Style :**
- Design officiel
- Bordure classique
- Logo paroisse
- Typographie élégante

**Contenu :**
- En-tête officiel
- Informations du fidèle
- Détails du sacrement
- Date de célébration
- Ministre
- Signature placeholder

### 8.5 Responsive Design

**Breakpoints :**
- Mobile : < 576px
- Tablette : 576px - 992px
- Desktop : > 992px

**Adaptations :**
- Sidebar : Masquée sur mobile (menu hamburger)
- Tableaux : Scroll horizontal sur mobile
- Cartes : 1 colonne sur mobile, 2-3 sur desktop
- Formulaires : Stack sur mobile, inline sur desktop

---

## 9. FLUX DE TRAVAIL

### 9.1 Flux d'Enregistrement d'un Fidèle

```
1. Connexion au système
   ↓
2. Navigation vers "Fidèles"
   ↓
3. Clic sur "Nouveau fidèle"
   ↓
4. Remplissage du formulaire
   - Informations personnelles
   - Coordonnées
   - CEB d'appartenance
   - Sacrements reçus
   ↓
5. Validation des données
   ↓
6. Enregistrement en base de données
   ↓
7. Redirection vers la liste
   ↓
8. Optionnel : Enregistrement du baptême
   ↓
9. Optionnel : Attribution aux mouvements
```

### 9.2 Flux d'Enregistrement d'une Recette

```
1. Connexion au système (avec permission finances)
   ↓
2. Navigation vers "Finances"
   ↓
3. Remplissage du formulaire "Nouvelle recette"
   - Date
   - Type (quête, offrande, don, etc.)
   - Montant
   - Donateur (fidèle ou nom)
   - Note
   ↓
4. Validation des données
   ↓
5. Génération automatique du numéro de reçu
   ↓
6. Enregistrement en base de données
   ↓
7. Affichage dans la liste
   ↓
8. Optionnel : Génération du reçu PDF
```

### 9.3 Flux d'Intention de Messe

```
1. Connexion au système
   ↓
2. Navigation vers "Intentions"
   ↓
3. Clic sur "Nouvelle intention"
   ↓
4. Remplissage du formulaire
   - Demandeur
   - Téléphone
   - Type d'intention
   - Intention (texte)
   - Offrande
   - Date de messe souhaitée
   ↓
5. Validation des données
   ↓
6. Génération automatique du numéro de reçu
   ↓
7. Enregistrement avec statut "en_attente"
   ↓
8. Optionnel : Génération du reçu PDF
   ↓
9. Optionnel : Tirage pour une messe
   ↓
10. Changement de statut en "tiree"
   ↓
11. Optionnel : Marquer comme célébrée
   ↓
12. Changement de statut en "celebree"
```

### 9.4 Flux de Tirage des Intentions

```
1. Navigation vers "Intentions" → "Tirage"
   ↓
2. Sélection de la semaine (optionnel)
   ↓
3. Visualisation des intentions en attente
   ↓
4. Clic sur "Effectuer le tirage"
   ↓
5. Répartition automatique
   - Action de grâce : samedi
   - Repos éternel : dimanche
   - Équilibrage des nombres
   ↓
6. Attribution des jours de messe
   ↓
7. Changement de statut en "tiree"
   ↓
8. Affichage des intentions tirées
   ↓
9. Optionnel : Export PDF de la liste
```

### 9.5 Flux de Publication d'Annonce

```
1. Connexion au système (avec permission annonces)
   ↓
2. Navigation vers "Annonces"
   ↓
3. Clic sur "Nouvelle annonce"
   ↓
4. Remplissage du formulaire
   - Titre
   - Contenu
   - Image (optionnel)
   - Date de publication
   - Date d'expiration (optionnel)
   - Afficher comme affiche
   ↓
5. Validation des données
   ↓
6. Upload de l'image (si fournie)
   ↓
7. Enregistrement en base de données
   ↓
8. Redirection vers la liste
   ↓
9. Affichage automatique sur le site public
   (si date de publication atteinte)
```

---

## 10. INSTALLATION ET DÉPLOIEMENT

### 10.1 Prérequis

**Logiciels requis :**
- PHP 8.5 ou supérieur
- Composer 2.x
- MySQL/MariaDB 5.7 ou supérieur
- Git

**Extensions PHP requises :**
- `gd` : Traitement d'images
- `mbstring` : Manipulation de chaînes multioctets
- `xml` : Génération PDF
- `pdo_mysql` : Connexion MySQL
- `fileinfo` : Détection de types MIME
- `zip` : Compression (pour certaines dépendances)

**Optionnel :**
- Node.js 18+ (pour les assets, non requis avec Bootstrap CDN)
- Laragon (environnement Windows recommandé)

### 10.2 Installation Locale

#### Étape 1 : Clonage du Repository
```bash
git clone https://github.com/yvesroland-yrn/michel-archange.git
cd michel-archange
```

#### Étape 2 : Installation des Dépendances PHP
```bash
composer install
```

#### Étape 3 : Configuration de l'Environnement
```bash
cp .env.example .env
php artisan key:generate
```

#### Étape 4 : Configuration de la Base de Données
Éditer le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=paroisse_saint_michel
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

Créer la base de données MySQL :
```sql
CREATE DATABASE paroisse_saint_michel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Étape 5 : Exécution des Migrations
```bash
php artisan migrate --seed
```

#### Étape 6 : Création du Lien de Stockage
```bash
php artisan storage:link
```

#### Étape 7 : Lancement du Serveur
```bash
php artisan serve
```

L'application est accessible à : `http://localhost:8000`

#### Étape 8 : Première Connexion
- Email : `admin@paroisse.test`
- Mot de passe : `password`

**IMPORTANT :** Changer immédiatement le mot de passe de l'administrateur !

### 10.3 Configuration en Production

#### Étape 1 : Configuration de l'Environnement
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com
```

#### Étape 2 : Optimisation de l'Application
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

#### Étape 3 : Compilation des Assets
```bash
npm run build
```

#### Étape 4 : Configuration du Stockage
Pour utiliser un stockage en ligne (S3 recommandé) :
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=votre_clé
AWS_SECRET_ACCESS_KEY=votre_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=nom_du_bucket
AWS_URL=https://nom_du_bucket.s3.amazonaws.com
```

#### Étape 5 : Configuration des Tâches Planifiées
Ajouter au crontab :
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

#### Étape 6 : Configuration du Serveur Web
**Apache (example) :**
```apache
<VirtualHost *:80>
    ServerName votre-domaine.com
    DocumentRoot /path-to-project/public

    <Directory /path-to-project/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Nginx (example) :**
```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /path-to-project/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.5-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 10.4 Sauvegarde et Restauration

#### Sauvegarde de la Base de Données
```bash
mysqldump -u utilisateur -p paroisse_saint_michel > backup_$(date +%Y%m%d).sql
```

#### Restauration de la Base de Données
```bash
mysql -u utilisateur -p paroisse_saint_michel < backup_20261002.sql
```

#### Sauvegarde des Fichiers
```bash
tar -czf storage-backup_$(date +%Y%m%d).tar.gz storage/
```

#### Automatisation (Script Bash)
```bash
#!/bin/bash
DATE=$(date +%Y%m%d)
mysqldump -u utilisateur -ppassword paroisse_saint_michel > /backup/db_$DATE.sql
tar -czf /backup/storage_$DATE.tar.gz /path-to-project/storage/
find /backup -name "*.sql" -mtime +30 -delete
find /backup -name "*.tar.gz" -mtime +30 -delete
```

---

## 11. GUIDE D'UTILISATION

### 11.1 Première Connexion

1. Accéder à l'URL de l'application
2. Cliquer sur "CONNEXION" dans la navigation
3. Entrer l'email : `admin@paroisse.test`
4. Entrer le mot de passe : `password`
5. Cliquer sur "Se connecter"
6. **Changer immédiatement le mot de passe** via le menu Utilisateurs

### 11.2 Gestion des Utilisateurs

#### Créer un Utilisateur
1. Aller dans "Utilisateurs"
2. Cliquer sur "Nouvel utilisateur"
3. Remplir :
   - Nom
   - Email
   - Mot de passe
   - Rôle
   - Permissions (cocher les modules)
4. Cliquer sur "Enregistrer"

#### Modifier un Utilisateur
1. Aller dans "Utilisateurs"
2. Cliquer sur "Modifier" à côté de l'utilisateur
3. Mettre à jour les informations
4. Cliquer sur "Mettre à jour"

#### Gérer les Permissions
1. Aller dans "Utilisateurs"
2. Cliquer sur "Modifier"
3. Cocher/décocher les permissions
4. Cliquer sur "Mettre à jour"

### 11.3 Gestion des Fidèles

#### Ajouter un Fidèle
1. Aller dans "Fidèles"
2. Cliquer sur "Nouveau fidèle"
3. Remplir le formulaire :
   - Nom (obligatoire)
   - Prénoms (obligatoire)
   - Sexe (obligatoire)
   - Date de naissance
   - Lieu de naissance
   - Téléphone
   - Email
   - Profession
   - Quartier
   - Situation matrimoniale
   - CEB
   - Statut (actif par défaut)
   - Sacrements (cocher)
4. Cliquer sur "Enregistrer"

#### Modifier un Fidèle
1. Aller dans "Fidèles"
2. Cliquer sur "Modifier" à côté du fidèle
3. Mettre à jour les informations
4. Cliquer sur "Mettre à jour"

#### Enregistrer un Baptême
1. Aller dans "Fidèles"
2. Cliquer sur "Baptême" à côté du fidèle
3. Remplir :
   - Numéro d'acte
   - Date du baptême
   - Lieu
   - Ministre
   - Parrain
   - Marraine
   - Père
   - Mère
   - Livre
   - Folio
4. Cliquer sur "Enregistrer"
5. Cliquer sur "Certificat" pour générer le PDF

#### Rechercher un Fidèle
1. Aller dans "Fidèles"
2. Entrer le nom/prénoms/téléphone dans la barre de recherche
3. Cliquer sur "Rechercher"
4. Les résultats s'affichent

#### Exporter les Fidèles
1. Aller dans "Fidèles"
2. Cliquer sur "Exporter CSV"
3. Le fichier CSV se télécharge

### 11.4 Gestion Financière

#### Enregistrer une Recette
1. Aller dans "Finances"
2. Dans la section "Nouvelle recette"
3. Remplir :
   - Date
   - Type (quête, offrande, don, etc.)
   - Montant
   - Donateur (sélectionner un fidèle ou entrer un nom)
   - Note
4. Cliquer sur "Enregistrer"
5. Le numéro de reçu est généré automatiquement

#### Générer un Reçu
1. Aller dans "Finances"
2. Dans la liste des recettes
3. Cliquer sur le numéro de reçu
4. Le PDF s'ouvre dans le navigateur

#### Consulter le Bilan
1. Aller dans "Finances"
2. Sélectionner la période (mois ou tout)
3. Sélectionner la catégorie (optionnel)
4. Cliquer sur "Bilan"
5. Le PDF s'ouvre avec le récapitulatif

#### Enregistrer une Dépense
1. Aller dans "Finances"
2. Dans la section "Nouvelle dépense"
3. Remplir :
   - Date
   - Catégorie
   - Libellé
   - Montant
4. Cliquer sur "Enregistrer"

### 11.5 Intentions de Messe

#### Enregistrer une Intention
1. Aller dans "Intentions"
2. Cliquer sur "Nouvelle intention"
3. Remplir :
   - Demandeur
   - Téléphone
   - Type d'intention
   - Intention (texte)
   - Offrande
   - Date de messe souhaitée
   - Jour de messe (samedi/dimanche)
4. Cliquer sur "Enregistrer"
5. Le numéro de reçu est généré automatiquement

#### Effectuer le Tirage
1. Aller dans "Intentions" → "Tirage"
2. Sélectionner la semaine (optionnel)
3. Cliquer sur "Effectuer le tirage"
4. Les intentions sont réparties entre samedi et dimanche
5. Le statut passe à "tiree"

#### Marquer comme Célébrée
1. Aller dans "Intentions"
2. Dans la liste, cliquer sur "Marquer célébrée"
3. Le statut passe à "celebree"

#### Exporter la Liste
1. Aller dans "Intentions" → "Tirage"
2. Sélectionner le type et la semaine
3. Cliquer sur "Exporter PDF" ou "Exporter Word"
4. Le fichier se télécharge

### 11.6 Publication d'Annonces

1. Aller dans "Annonces"
2. Cliquer sur "Nouvelle annonce"
3. Remplir :
   - Titre
   - Contenu
   - Image (optionnel)
   - Date de publication
   - Date d'expiration (optionnel)
   - Cocher "Afficher comme affiche" si applicable
4. Cliquer sur "Enregistrer"

---

## 12. MAINTENANCE ET ÉVOLUTION

### 12.1 Structure du Code

#### Ajouter un Nouveau Module

**Étape 1 : Créer la Migration**
```bash
php artisan make:migration create_ma_table
```

**Étape 2 : Définir le Schéma**
```php
Schema::create('ma_table', function (Blueprint $t) {
    $t->id();
    $t->string('nom');
    $t->text('description')->nullable();
    $t->timestamps();
});
```

**Étape 3 : Créer le Modèle**
```bash
php artisan make:model MonModel
```

```php
class MonModel extends Model
{
    protected $fillable = ['nom', 'description'];
}
```

**Étape 4 : Créer le Contrôleur**
```bash
php artisan make:controller MonController
```

```php
class MonController extends CrudController
{
    protected string $model = MonModel::class;
    protected string $route = 'mon-route';
    protected string $titre = 'Mes éléments';
    protected string $singulier = 'Élément';
    
    protected function fields(): array
    {
        return [
            'nom' => ['Nom', 'text', true],
            'description' => ['Description', 'textarea', false],
        ];
    }
    
    protected function columns(): array
    {
        return [
            'Nom' => 'nom',
            'Description' => 'description',
        ];
    }
}
```

**Étape 5 : Ajouter les Routes**
```php
Route::middleware('permission:ma_permission')->group(function () {
    Route::resource('mon-route', MonController::class)->except('show');
});
```

**Étape 6 : Ajouter la Permission**
Dans le modèle `User` :
```php
public const RUBRIQUES = [
    // ...
    'ma_permission' => 'Mon Module',
];
```

**Étape 7 : Exécuter la Migration**
```bash
php artisan migrate
```

### 12.2 Tests

#### Exécuter les Tests
```bash
php artisan test
```

#### Exécuter avec Coverage
```bash
php artisan test --coverage
```

### 12.3 Mise à Jour

#### Processus de Mise à Jour
```bash
# 1. Pull des changements
git pull origin main

# 2. Mise à jour des dépendances
composer update
npm update

# 3. Exécution des migrations
php artisan migrate

# 4. Nettoyage du cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 5. Recompilation des assets
npm run build
```

### 12.4 Dépannage

#### Problème : Erreur de Connexion à la Base de Données
**Solution :**
- Vérifier les credentials dans `.env`
- Vérifier que le serveur MySQL est démarré
- Vérifier que la base de données existe

#### Problème : Erreur de Permissions
**Solution :**
- Vérifier que l'utilisateur a les permissions nécessaires
- Vérifier que le middleware est correctement appliqué
- Vérifier les permissions dans la base de données

#### Problème : Images ne s'affichent pas
**Solution :**
- Vérifier que le lien de stockage existe : `php artisan storage:link`
- Vérifier les permissions du dossier `storage`
- Vérifier la configuration `FILESYSTEM_DISK`

#### Problème : PDF ne se génère pas
**Solution :**
- Vérifier que l'extension `gd` est installée
- Vérifier que l'extension `mbstring` est installée
- Vérifier les permissions du dossier temporaire

### 12.5 Roadmap

#### Fonctionnalités Prévues (V2)
- [ ] Module de gestion des quêtes par messe
- [ ] Statistiques avancées et graphiques
- [ ] Envoi d'emails automatiques (annonces, rappels)
- [ ] Gestion des dîmes et contributions
- [ ] Module de gestion des biens immobiliers
- [ ] Système de réservation de salles
- [ ] Gestion des inscriptions aux événements
- [ ] Export de données multi-formats

#### Fonctionnalités Futures (V3)
- [ ] Application mobile native (iOS/Android)
- [ ] Intégration SMS pour les notifications
- [ ] Paiement en ligne (CinetPay/Mobile Money)
- [ ] Journal d'activité complet
- [ ] Présences de catéchèse
- [ ] Gestion du patrimoine et projets
- [ ] Génération de courriers officiels
- [ ] API REST pour intégrations tierces

---

## 13. CONCLUSION

### 13.1 Résumé du Projet

Le **Système de Gestion Paroissiale - Saint Michel Archange de la BAE** est une solution web complète et moderne qui répond aux besoins de gestion administrative, pastorale et financière d'une paroisse catholique.

**Points Forts :**
- ✅ Architecture Laravel solide et maintenable
- ✅ Interface utilisateur moderne et intuitive
- ✅ Système de permissions granulaire
- ✅ Génération automatique de documents PDF
- ✅ Centralisation de toutes les données paroissiales
- ✅ Traçabilité complète des actions
- ✅ Sécurité renforcée
- ✅ Design responsive

**Modules Implémentés :**
- ✅ Authentification et gestion des utilisateurs
- ✅ Gestion des fidèles
- ✅ Gestion des sacrements
- ✅ Gestion des CEB
- ✅ Gestion des mouvements
- ✅ Gestion du clergé
- ✅ Gestion du conseil paroissial
- ✅ Gestion des événements
- ✅ Gestion des intentions de messe
- ✅ Gestion financière complète
- ✅ Gestion de la catéchèse
- ✅ Gestion des annonces
- ✅ Site public
- ✅ Tableau de bord complet

### 13.2 Impact Attendu

**Pour la Paroisse :**
- Amélioration de l'efficacité administrative
- Réduction des erreurs humaines
- Meilleure traçabilité des activités
- Centralisation des informations
- Communication améliorée avec les fidèles

**Pour les Utilisateurs :**
- Interface intuitive et facile à utiliser
- Accès rapide aux informations
- Automatisation des tâches répétitives
- Génération automatique de documents

**Pour les Fidèles :**
- Meilleure information
- Accès aux annonces
- Simplification des démarches

### 13.3 Perspectives d'Avenir

Le système est conçu pour être évolutif et extensible. Les fonctionnalités futures incluront :

- **Communication** : Notifications SMS, emails automatiques
- **Paiements** : Intégration de solutions de paiement en ligne
- **Mobilité** : Application mobile pour les fidèles
- **Analytique** : Statistiques avancées et graphiques
- **Intégration** : API pour intégrations avec d'autres systèmes

### 13.4 Remerciements

Ce projet a été développé pour la Paroisse Saint Michel Archange de la BAE, dans le but de moderniser et faciliter la gestion paroissiale.

**Technologies utilisées :**
- Laravel Framework
- Bootstrap 5
- MySQL
- DomPDF
- PhpOffice

---

**Document généré le 2 octobre 2026**
**Version 1.0.0**
**Système de Gestion Paroissiale - Saint Michel Archange de la BAE**

---

## ANNEXES

### Annexe A : Glossaire

- **CEB** : Communauté Ecclésiale de Base
- **BAE** : Base Aérienne d'Edéa
- **FCFA** : Franc CFA (monnaie)
- **CRUD** : Create, Read, Update, Delete
- **MVC** : Model-View-Controller
- **ORM** : Object-Relational Mapping
- **PDF** : Portable Document Format
- **CSV** : Comma-Separated Values

### Annexe B : Liens Utiles

- **Laravel Documentation** : https://laravel.com/docs
- **Bootstrap Documentation** : https://getbootstrap.com/docs
- **DomPDF Documentation** : https://github.com/barryvdh/laravel-dompdf
- **MySQL Documentation** : https://dev.mysql.com/doc
- **PHP Documentation** : https://www.php.net/docs

### Annexe C : Support

Pour toute question ou suggestion concernant le projet :
- **Repository GitHub** : https://github.com/yvesroland-yrn/michel-archange
- **Issues** : Signaler via GitHub Issues

### Annexe D : Licence

Ce projet est développé pour la Paroisse Saint Michel Archange de la BAE.

---

**Fin du Rapport**
