# Système de Gestion Paroissiale - Saint Michel Archange de la BAE

## Table des matières

1. [Présentation du projet](#présentation-du-projet)
2. [Architecture technique](#architecture-technique)
3. [Base de données](#base-de-données)
4. [Fonctionnalités principales](#fonctionnalités-principales)
5. [Sécurité et permissions](#sécurité-et-permissions)
6. [Interface utilisateur](#interface-utilisateur)
7. [Installation et configuration](#installation-et-configuration)
8. [Guide d'utilisation](#guide-dutilisation)
9. [Développement et maintenance](#développement-et-maintenance)

---

## Présentation du projet

### Vue d'ensemble

Le **Système de Gestion Paroissiale** est une application web complète développée pour la Paroisse Saint Michel Archange de la BAE. Cette solution permet de gérer efficacement tous les aspects de la vie paroissiale : fidèles, sacrements, mouvements, finances, événements et communications.

### Objectifs principaux

- **Centralisation des données** : Un système unique pour gérer toutes les informations paroissiales
- **Automatisation administrative** : Simplification des tâches administratives quotidiennes
- **Traçabilité** : Historique complet des activités et transactions
- **Accessibilité** : Interface web accessible depuis n'importe quel appareil
- **Sécurité** : Gestion des permissions et protection des données sensibles

### Public cible

- **Clergé** : Curé, prêtres, diacres
- **Conseil paroissial** : Membres du conseil de gestion
- **Mouvements paroissiaux** : Responsables de CEB, mouvements de jeunesse, etc.
- **Secrétariat paroissial** : Personnel administratif
- **Fidèles** : Accès public aux informations et annonces

---

## Architecture technique

### Stack technologique

#### Backend
- **Framework** : Laravel 13.x (PHP 8.5+)
- **Base de données** : MySQL/MariaDB
- **Génération PDF** : DomPDF (barryvdh/laravel-dompdf)
- **File Storage** : Laravel Filesystem (support S3, local)

#### Frontend
- **Framework CSS** : Bootstrap 5.3.3
- **Icônes** : Bootstrap Icons 1.11.3
- **Polices** : Google Fonts (Cinzel, Inter, Cormorant Garamond)
- **Build tool** : Vite

#### Structure du projet

```
paroisse-saint-michel-projet-complet/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Contrôleurs MVC
│   │   ├── Middleware/           # Middleware (auth, permissions)
│   │   └── Requests/             # Validation des formulaires
│   ├── Models/                   # Modèles Eloquent
│   └── Providers/                # Service providers
├── config/                       # Configuration de l'application
├── database/
│   ├── migrations/              # Migrations de base de données
│   └── seeders/                 # Données de test
├── public/                      # Fichiers publics
│   ├── css/                     # Feuilles de style
│   └── images/                  # Images statiques
├── resources/
│   ├── views/                   # Templates Blade
│   │   ├── layouts/             # Layouts principaux
│   │   ├── pages/               # Pages publiques
│   │   ├── pdf/                 # Templates PDF
│   │   └── crud/                # Templates CRUD génériques
│   └── css/                     # Assets SCSS/CSS
├── routes/
│   └── web.php                  # Routes web
└── storage/                     # Stockage des fichiers
```

### Architecture MVC

L'application suit le pattern Model-View-Controller de Laravel :

- **Models** : Représentent les entités de la base de données et la logique métier
- **Views** : Templates Blade pour l'affichage des données
- **Controllers** : Gèrent les requêtes HTTP et orchestrent la logique

### Contrôleur CRUD générique

L'application utilise un contrôleur CRUD abstrait (`CrudController`) qui permet de créer rapidement des interfaces d'administration pour n'importe quelle entité :

- **fields()** : Définition des champs du formulaire
- **columns()** : Définition des colonnes du tableau
- **extraRules()** : Règles de validation supplémentaires
- **prepare()** : Préparation des données avant sauvegarde
- **after()** : Actions après sauvegarde

---

## Base de données

### Schéma relationnel

#### Tables principales

1. **users** - Utilisateurs du système
2. **fideles** - Fidèles de la paroisse
3. **cebs** - Communautés Ecclésiales de Base
4. **mouvements** - Mouvements paroissiaux
5. **sacrements** - Sacrements (mariage, confirmation, etc.)
6. **baptemes** - Baptêmes
7. **evenements** - Événements paroissiaux
8. **intentions** - Intentions de messe
9. **annonces** - Annonces paroissiales
10. **recettes** - Recettes financières
11. **depenses** - Dépenses financières
12. **classes_cate** - Classes de catéchèse
13. **catechumenes** - Catéchumènes
14. **clerge** - Membres du clergé
15. **conseil_paroissial** - Membres du conseil paroissial
16. **mouvement_paroissial** - Mouvements paroissiaux
17. **contacts** - Messages de contact

### Relations principales

```
fideles (1) ───< (N) baptemes
fideles (1) ───< (N) sacrements
fideles (1) ───< (N) catechumenes
fideles (1) ───< (N) fidele_mouvement ───> (N) mouvements
fideles (N) ───> (1) cebs
evenements (1) ───< (N) intentions
users (1) ───< (N) recettes
users (1) ───< (N) depenses
users (1) ───< (N) intentions
```

### Description des tables

#### users
Gestion des utilisateurs du système avec permissions granulaires.

| Champ | Type | Description |
|-------|------|-------------|
| id | bigint | Identifiant unique |
| name | string | Nom complet |
| email | string | Email (unique) |
| password | string | Mot de passe hashé |
| role | string | Rôle (admin, clergy, council, etc.) |
| permissions | json | Permissions JSON |

#### fideles
Registre des fidèles de la paroisse.

| Champ | Type | Description |
|-------|------|-------------|
| id | bigint | Identifiant unique |
| nom | string | Nom de famille |
| prenoms | string | Prénoms |
| sexe | enum | M ou F |
| date_naissance | date | Date de naissance |
| lieu_naissance | string | Lieu de naissance |
| telephone | string | Numéro de téléphone |
| email | string | Adresse email |
| profession | string | Profession |
| quartier | string | Quartier de résidence |
| situation_matrimoniale | string | État civil |
| ceb_id | bigint | CEB d'appartenance |
| statut | enum | actif, transfere, decede |
| baptise | boolean | Est baptisé |
| date_bapteme | date | Date de baptême |
| lieu_bapteme | string | Lieu de baptême |
| confirmation | boolean | Est confirmé |
| date_confirmation | date | Date de confirmation |
| eucharistie | boolean | A reçu l'eucharistie |
| mariage | boolean | Est marié |
| date_mariage | date | Date de mariage |
| conjoint | string | Nom du conjoint |

#### cebs
Communautés Ecclésiales de Base.

| Champ | Type | Description |
|-------|------|-------------|
| id | bigint | Identifiant unique |
| nom | string | Nom du CEB |
| responsable | string | Responsable |
| zone_couverture | string | Zone couverte |
| numero_responsable | string | Numéro du responsable |

#### sacrements
Enregistrement des sacrements (mariage, confirmation, etc.).

| Champ | Type | Description |
|-------|------|-------------|
| id | bigint | Identifiant unique |
| type | string | Type de sacrement |
| fidele_id | bigint | Fidèle concerné |
| conjoint_id | bigint | Conjoint (pour mariage) |
| date_celebration | date | Date de célébration |
| lieu | string | Lieu de célébration |
| ministre | string | Ministre célébrant |
| temoin1 | string | Témoin 1 |
| temoin2 | string | Témoin 2 |
| numero_acte | string | Numéro d'acte |
| observations | text | Observations |

#### evenements
Gestion des événements paroissiaux.

| Champ | Type | Description |
|-------|------|-------------|
| id | bigint | Identifiant unique |
| titre | string | Titre de l'événement |
| type | string | Type d'événement |
| date_heure | datetime | Date et heure |
| lieu | string | Lieu |
| celebrant | string | Célébrant |
| description | text | Description |

#### intentions
Intentions de messe et offrandes.

| Champ | Type | Description |
|-------|------|-------------|
| id | bigint | Identifiant unique |
| demandeur | string | Nom du demandeur |
| telephone | string | Téléphone |
| intention | text | Intention de messe |
| offrande | bigint | Montant de l'offrande |
| date_messe | date | Date de la messe |
| evenement_id | bigint | Événement associé |
| statut | string | Statut (recue, celebree) |
| recu_numero | string | Numéro de reçu |
| user_id | bigint | Utilisateur enregistrant |

#### recettes
Gestion des recettes financières.

| Champ | Type | Description |
|-------|------|-------------|
| id | bigint | Identifiant unique |
| date | date | Date de la recette |
| type | string | Type (quête, offrande, don, etc.) |
| montant | bigint | Montant en FCFA |
| fidele_id | bigint | Fidèle donateur |
| ceb_id | bigint | CEB concerné |
| recu_numero | string | Numéro de reçu |
| note | string | Note |
| user_id | bigint | Utilisateur enregistrant |

#### depenses
Gestion des dépenses.

| Champ | Type | Description |
|-------|------|-------------|
| id | bigint | Identifiant unique |
| date | date | Date de la dépense |
| categorie | string | Catégorie |
| libelle | string | Libellé |
| montant | bigint | Montant en FCFA |
| user_id | bigint | Utilisateur enregistrant |

---

## Fonctionnalités principales

### 1. Gestion des fidèles

#### Création et modification
- Enregistrement complet des fidèles (nom, prénoms, coordonnées)
- Suivi des sacrements reçus (baptême, confirmation, eucharistie, mariage)
- Attribution à un CEB
- Gestion du statut (actif, transféré, décédé)

#### Recherche et filtrage
- Recherche par nom, prénoms
- Filtrage par CEB, statut
- Export des données en Excel

#### Sacrements
- Enregistrement des baptêmes avec certificats
- Gestion des autres sacrements (mariage, confirmation, etc.)
- Génération de certificats en PDF

### 2. Gestion des CEB (Communautés Ecclésiales de Base)

- Création et gestion des CEB
- Attribution de responsables
- Définition des zones de couverture
- Suivi des membres par CEB

### 3. Gestion des mouvements

- Création de mouvements paroissiaux
- Gestion des membres de mouvements
- Attribution de fonctions au sein des mouvements
- Historique des participations

### 4. Gestion du clergé

- Enregistrement des membres du clergé
- Distinction curé/diacre/prêtre
- Statut de résidence
- Informations de contact

### 5. Gestion du conseil paroissial

- Membres du conseil paroissial
- Rôles et responsabilités
- Période de mandat

### 6. Gestion des événements

- Création d'événements (messes, célébrations, réunions)
- Planification avec date, heure, lieu
- Association de célébrants
- Publication au calendrier

### 7. Intentions de messe

- Enregistrement des intentions de messe
- Gestion des offrandes
- Association aux événements
- Génération de reçus PDF
- Suivi du statut (reçue, célébrée)

### 8. Annonces paroissiales

- Publication d'annonces
- Support d'images (affiches)
- Gestion des dates de publication et expiration
- Affichage public sur le site

### 9. Gestion financière

#### Recettes
- Enregistrement des recettes (quêtes, offrandes, dons)
- Attribution aux fidèles ou CEB
- Génération automatique de numéros de reçu
- Export de reçus PDF élégants

#### Dépenses
- Catégorisation des dépenses
- Suivi des libellés
- Équilibrage budgétaire

#### Bilans
- Bilans mensuels
- Bilans globaux
- Export PDF des bilans
- Calcul automatique du solde

### 10. Catéchèse

- Gestion des classes de catéchèse
- Inscription des catéchumènes
- Suivi de la progression
- Gestion des catéchistes

### 11. Contact et communication

- Formulaire de contact public
- Réception des messages
- Marquage comme lu/non lu
- Réponses aux demandes

### 12. Site public

- Page d'accueil avec informations
- Page "À propos"
- Annonces paroissiales
- Formulaire de contact
- Navigation mobile élégante

---

## Sécurité et permissions

### Système d'authentification

- **Connexion sécurisée** : Hashage des mots de passe avec Bcrypt
- **Protection contre brute-force** : Throttling (6 tentatives par minute)
- **Sessions sécurisées** : Stockage en base de données
- **Protection CSRF** : Tokens CSRF sur tous les formulaires

### Gestion des rôles

L'application utilise un système de permissions granulaire basé sur des clés JSON :

#### Rôles disponibles
- **admin** : Accès complet à toutes les fonctionnalités
- **clergy** : Accès aux fonctions pastorales
- **council** : Accès aux fonctions de gestion
- **secretary** : Accès limité aux tâches administratives

#### Permissions par module

| Module | Permission clé | Description |
|--------|----------------|-------------|
| Fidèles | `fideles` | Gestion des fidèles |
| Sacrements | `sacrements` | Gestion des sacrements |
| CEB | `cebs` | Gestion des CEB |
| Mouvements | `mouvements` | Gestion des mouvements |
| Clergé | `clerge` | Gestion du clergé |
| Conseil paroissial | `conseil_paroissial` | Gestion du conseil |
| Mouvements paroissiaux | `mouvement_paroissial` | Gestion des mouvements paroissiaux |
| Événements | `evenements` | Gestion des événements |
| Intentions | `intentions` | Gestion des intentions |
| Annonces | `annonces` | Gestion des annonces |
| Classes de catéchèse | `classes_cate` | Gestion de la catéchèse |
| Catéchumènes | `catechumenes` | Gestion des catéchumènes |
| Finances | `finances` | Gestion financière |
| Utilisateurs | `users` | Gestion des utilisateurs |
| Contacts | `contacts` | Gestion des contacts |

### Middleware de protection

- **auth** : Vérifie que l'utilisateur est connecté
- **permission:xxx** : Vérifie que l'utilisateur a la permission spécifique
- **guest** : Redirige les utilisateurs connectés
- **throttle** : Limite les tentatives de connexion

---

## Interface utilisateur

### Design system

#### Palette de couleurs

```css
--nuit:        #0B1B3A;      /* Bleu nuit profond */
--nuit-deep:   #07122B;      /* Bleu nuit très profond */
--archange:    #2748B8;      /* Bleu archange */
--or:          #D4A937;      /* Or principal */
--or-clair:    #F2D98A;      /* Or clair */
--ivoire:      #FAF7F0;      /* Ivoire (fond) */
--carte:       #FFFFFF;      /* Blanc (cartes) */
--encre:       #1B2233;      /* Encre (texte) */
--brume:       #6B7590;      /* Brume (texte secondaire) */
--parchemin:   #E6E1D3;      /* Parchemin (bordures) */
--flamme:      #C8322B;      /* Flamme (rouge) */
--emeraude:    #1F8A70;      /* Émeraude (vert) */
```

#### Typographie

- **Titres** : Cinzel (police serif élégante)
- **Corps** : Inter (police sans-serif moderne)
- **Documents** : Cormorant Garamond (police serif classique)

### Layouts

#### Layout public
- Navigation responsive avec dock mobile élégant
- Footer avec informations de contact
- Design moderne et accueillant

#### Layout administratif
- Sidebar fixe avec navigation
- Tableau de bord avec statistiques
- Interface CRUD cohérente

### Navigation mobile

L'application dispose d'une navigation mobile sophistiquée :
- Dock fixe en bas de l'écran
- Icônes avec étiquettes
- Animation fluide
- Design arrondi et moderne

### Reçus PDF

Les reçus générés en PDF comportent :
- Design élégant avec bordures dorées
- Logo de la paroisse
- Typographie raffinée
- Zones de signature stylisées
- Pied de page avec croix décorative

---

## Installation et configuration

### Prérequis

- PHP 8.5 ou supérieur
- Composer 2.x
- MySQL/MariaDB 5.7 ou supérieur
- Node.js 18+ (pour les assets)
- Git

### Installation locale

```bash
# Cloner le repository
git clone https://github.com/yvesroland-yrn/michel-archange.git
cd michel-archange

# Installer les dépendances PHP
composer install

# Installer les dépendances Node
npm install

# Configuration de l'environnement
cp .env.example .env
php artisan key:generate

# Configuration de la base de données
# Éditer .env et configurer les paramètres DB

# Exécuter les migrations
php artisan migrate

# Lancer le serveur de développement
php artisan serve
```

### Configuration de la base de données

Dans le fichier `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=paroisse_saint_michel
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

### Création du lien de stockage

```bash
php artisan storage:link
```

### Compilation des assets

```bash
npm run build
```

### Configuration du stockage en ligne (optionnel)

Pour utiliser AWS S3 ou un service compatible :

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=votre_clé
AWS_SECRET_ACCESS_KEY=votre_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=nom_du_bucket
AWS_URL=https://nom_du_bucket.s3.amazonaws.com
```

### Création du premier utilisateur

```bash
php artisan tinker
```

```php
$user = new \App\Models\User();
$user->name = 'Administrateur';
$user->email = 'admin@paroisse.com';
$user->password = bcrypt('votre_mot_de_passe');
$user->role = 'admin';
$user->permissions = ['all'];
$user->save();
```

---

## Guide d'utilisation

### Connexion

1. Accéder à l'URL de l'application
2. Cliquer sur "CONNEXION" dans la navigation
3. Entrer l'email et le mot de passe
4. Cliquer sur "Se connecter"

### Tableau de bord

Après connexion, l'utilisateur accède au tableau de bord affichant :
- Statistiques globales (fidèles, CEB, mouvements, etc.)
- Dernières activités
- Raccourcis vers les principales fonctionnalités

### Gestion des fidèles

#### Ajouter un fidèle
1. Aller dans "Fidèles" → "Nouveau fidèle"
2. Remplir le formulaire avec les informations
3. Sélectionner le CEB si applicable
4. Cocher les sacrements reçus
5. Cliquer sur "Enregistrer"

#### Modifier un fidèle
1. Aller dans "Fidèles"
2. Cliquer sur "Modifier" à côté du fidèle
3. Mettre à jour les informations
4. Cliquer sur "Mettre à jour"

#### Enregistrer un baptême
1. Aller dans "Fidèles"
2. Cliquer sur "Baptême" à côté du fidèle
3. Remplir les informations du baptême
4. Cliquer sur "Enregistrer"
5. Cliquer sur "Certificat" pour générer le PDF

### Gestion financière

#### Enregistrer une recette
1. Aller dans "Finances"
2. Dans la section "Nouvelle recette"
3. Sélectionner la date et le type
4. Entrer le montant
5. Sélectionner le fidèle ou le CEB si applicable
6. Cliquer sur "Enregistrer"
7. Le numéro de reçu est généré automatiquement

#### Générer un reçu
1. Aller dans "Finances"
2. Dans la liste des recettes
3. Cliquer sur "Reçu" à côté de la recette
4. Le PDF s'ouvre dans le navigateur

#### Consulter le bilan
1. Aller dans "Finances"
2. Sélectionner la période (mois ou tout)
3. Cliquer sur "Bilan"
4. Le PDF s'ouvre avec le récapitulatif

### Publication d'annonces

1. Aller dans "Annonces"
2. Cliquer sur "Nouvelle annonce"
3. Entrer le titre et le contenu
4. Sélectionner les dates de publication
5. Optionnel : ajouter une image
6. Cocher "Afficher comme affiche" si applicable
7. Cliquer sur "Enregistrer"

---

## Développement et maintenance

### Structure du code

#### Contrôleurs

Les contrôleurs étendent `CrudController` pour bénéficier des fonctionnalités CRUD automatiques :

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
            'champ1' => ['Libellé', 'text', true],
            'champ2' => ['Libellé', 'textarea', false],
        ];
    }
    
    protected function columns(): array
    {
        return [
            'Colonne 1' => 'champ1',
            'Colonne 2' => 'champ2',
        ];
    }
}
```

#### Modèles

Les modèles utilisent les conventions Laravel :

```php
class MonModel extends Model
{
    protected $fillable = ['champ1', 'champ2'];
    
    // Relations
    public function relation()
    {
        return $this->belongsTo(RelatedModel::class);
    }
}
```

### Ajout de nouvelles fonctionnalités

#### 1. Créer une migration

```bash
php artisan make:migration create_ma_table
```

#### 2. Définir le schéma

```php
Schema::create('ma_table', function (Blueprint $t) {
    $t->id();
    $t->string('nom');
    $t->timestamps();
});
```

#### 3. Créer le modèle

```bash
php artisan make:model MonModel
```

#### 4. Créer le contrôleur

```bash
php artisan make:controller MonController
```

#### 5. Ajouter les routes

```php
Route::middleware('permission:ma_permission')->group(function () {
    Route::resource('ma-route', MonController::class)->except('show');
});
```

### Tests

```bash
# Exécuter les tests
php artisan test

# Exécuter les tests avec coverage
php artisan test --coverage
```

### Déploiement

#### En production

1. Configurer l'environnement (`APP_ENV=production`)
2. Désactiver le debug (`APP_DEBUG=false`)
3. Optimiser l'application :
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
4. Compiler les assets :
```bash
npm run build
```
5. Configurer le stockage en ligne (S3 recommandé)
6. Configurer les tâches planifiées (cron)

#### Tâches planifiées

Ajouter au crontab :

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Sauvegarde

#### Base de données

```bash
# Sauvegarde
mysqldump -u user -p database > backup.sql

# Restauration
mysql -u user -p database < backup.sql
```

#### Fichiers

```bash
# Sauvegarder le storage
tar -czf storage-backup.tar.gz storage/
```

### Mise à jour

```bash
# Pull des changements
git pull origin main

# Mise à jour des dépendances
composer update
npm update

# Exécution des migrations
php artisan migrate

# Cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## Support et maintenance

### Documentation technique

- **Laravel Documentation** : https://laravel.com/docs
- **Bootstrap Documentation** : https://getbootstrap.com/docs
- **DomPDF Documentation** : https://github.com/barryvdh/laravel-dompdf

### Contact

Pour toute question ou suggestion concernant le projet :
- Repository GitHub : https://github.com/yvesroland-yrn/michel-archange
- Issues : Signaler via GitHub Issues

### Licence

Ce projet est développé pour la Paroisse Saint Michel Archange de la BAE.

---

## Annexe

### Glossaire

- **CEB** : Communauté Ecclésiale de Base
- **BAE** : Base Aérienne d'Edéa
- **FCFA** : Franc CFA (monnaie)

### Roadmap

Fonctionnalités prévues pour les futures versions :

- [ ] Module de gestion des quêtes par messe
- [ ] Statistiques avancées et graphiques
- [ ] Envoi d'emails automatiques (annonces, rappels)
- [ ] Application mobile native
- [ ] Intégration SMS pour les notifications
- [ ] Gestion des dîmes et contributions
- [ ] Module de gestion des biens immobiliers
- [ ] Système de réservation de salles
- [ ] Gestion des inscriptions aux événements
- [ ] Export de données multi-formats

### Changelog

#### Version 1.0.0 (30 septembre 2026)
- Version initiale du système
- Modules de base : fidèles, sacrements, finances, événements
- Interface publique et administrative
- Génération de documents PDF
- Système de permissions

---

**Document généré le 30 septembre 2026**
**Système de Gestion Paroissiale - Saint Michel Archange de la BAE**
