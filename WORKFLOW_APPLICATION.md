# GUIDE DES WORKFLOWS
# Système de Gestion Paroissiale - Saint Michel Archange de la BAE

---

## TABLE DES MATIÈRES

1. [Introduction aux Workflows](#1-introduction-aux-workflows)
2. [Workflow d'Authentification](#2-workflow-dauthentification)
3. [Workflow de Gestion des Fidèles](#3-workflow-de-gestion-des-fidèles)
4. [Workflow des Sacrements](#4-workflow-des-sacrements)
5. [Workflow de Gestion des CEB](#5-workflow-de-gestion-des-ceb)
6. [Workflow des Mouvements](#6-workflow-des-mouvements)
7. [Workflow des Événements](#7-workflow-des-événements)
8. [Workflow des Intentions de Messe](#8-workflow-des-intentions-de-messe)
9. [Workflow de Gestion Financière](#9-workflow-de-gestion-financière)
10. [Workflow de Catéchèse](#10-workflow-de-catéchèse)
11. [Workflow des Annonces](#11-workflow-des-annonces)
12. [Workflow du Tableau de Bord](#12-workflow-du-tableau-de-bord)
13. [Workflow Inter-modules](#13-workflow-inter-modules)

---

## 1. INTRODUCTION AUX WORKFLOWS

### 1.1 Qu'est-ce qu'un Workflow ?

Un workflow (flux de travail) est une séquence d'étapes nécessaires pour accomplir une tâche spécifique dans l'application. Chaque workflow définit :

- **Le point de départ** : Où commence le processus
- **Les étapes intermédiaires** : Actions à effectuer
- **Les décisions** : Points où des choix sont faits
- **Le point d'arrivée** : Quand le processus est terminé
- **Les acteurs** : Qui peut effectuer chaque action

### 1.2 Acteurs du Système

```
┌─────────────────────────────────────────────────────────┐
│                 ACTEURS DU SYSTÈME                      │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ADMINISTRATEUR (admin)                                 │
│  ├── Accès complet à tous les modules                  │
│  ├── Gestion des utilisateurs                          │
│  └── Configuration du système                          │
│                                                         │
│  CURÉ (cure)                                            │
│  ├── Accès pastoral complet                             │
│  ├── Gestion des fidèles et sacrements                  │
│  ├── Gestion des événements et intentions               │
│  └── Pas d'accès à la gestion des utilisateurs         │
│                                                         │
│  SECRÉTAIRE (secretaire)                                │
│  ├── Gestion des fidèles                                │
│  ├── Gestion des sacrements                             │
│  ├── Vie paroissiale (CEB, mouvements)                  │
│  ├── Catéchèse                                          │
│  └── Pas d'accès aux finances                           │
│                                                         │
│  TRÉSORIER (tresorier)                                  │
│  ├── Gestion financière uniquement                     │
│  ├── Recettes et dépenses                               │
│  ├── Bilans                                             │
│  └── Pas d'accès aux autres modules                     │
│                                                         │
│  CATÉCHISTE (catechiste)                                │
│  ├── Gestion de la catéchèse uniquement                │
│  ├── Classes et catéchumènes                            │
│  └── Pas d'accès aux autres modules                     │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

### 1.3 Légende des Diagrammes

```
→  Flux normal
↘  Décision/Condition
┌─┐ Étape
⬥ Point de départ
◯ Point d'arrivée
```

---

## 2. WORKFLOW D'AUTHENTIFICATION

### 2.1 Diagramme du Workflow de Connexion

```
⬥ DÉBUT : Utilisateur accède à l'application
 │
 ↓
┌─────────────────────────────────────┐
│ Page de connexion                    │
│ - Email                              │
│ - Mot de passe                       │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation des données               │
│ - Email valide ?                     │
│ - Mot de passe non vide ?           │
└─────────────────────────────────────┘
 │
 ↓
 ↘ Données valides ?
 │ OUI │ NON
 ↓     ↓
┌─────────────────────┐   ┌─────────────────────┐
│ Vérification en DB  │   │ Message d'erreur    │
│ - Email existe ?     │   │ Afficher erreurs    │
│ - Mot de passe OK ? │   └─────────────────────┘
└─────────────────────┘            │
 │                              ↑
 ↓                              │
 ↘ Identifiants corrects ?        │
 │ OUI │ NON                     │
 ↓     ↓                         │
┌─────────────────┐   ┌─────────────────┐
│ Création session │   │ Incrémenter     │
│ - Token CSRF     │   │ compteur échecs │
│ - Stockage user  │   │ (>6 = blocage)  │
└─────────────────┘   └─────────────────┘
 │                              ↑
 ↓                              │
┌─────────────────────────────────────┐
│ Vérification des permissions        │
│ - Charger les permissions JSON     │
│ - Déterminer l'accès aux modules    │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Redirection vers tableau de bord    │
│ - Afficher les statistiques         │
│ - Afficher les modules autorisés    │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Utilisateur connecté
```

### 2.2 Workflow de Déconnexion

```
⬥ DÉBUT : Utilisateur clique sur "Déconnexion"
 │
 ↓
┌─────────────────────────────────────┐
│ Destruction de la session           │
│ - Supprimer token CSRF              │
│ - Vider données utilisateur         │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Redirection vers page de connexion  │
│ - Message de déconnexion            │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Utilisateur déconnecté
```

### 2.3 Workflow de Création d'Utilisateur

```
⬥ DÉBUT : Admin accède à "Utilisateurs"
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Nouvel utilisateur"       │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire de création              │
│ - Nom                               │
│ - Email                             │
│ - Mot de passe                      │
│ - Rôle (admin/cure/secretaire/etc)  │
│ - Permissions (cases à cocher)      │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation                          │
│ - Email unique ?                    │
│ - Mot de passe > 8 caractères ?     │
│ - Rôle valide ?                     │
└─────────────────────────────────────┘
 │
 ↓
 ↘ Validé ?
 │ OUI │ NON
 ↓     ↓
┌─────────────────┐   ┌─────────────────┐
│ Hashage du mot  │   │ Afficher erreurs│
│ de passe        │   │ dans formulaire │
└─────────────────┘   └─────────────────┘
 │                              ↑
 ↓                              │
┌─────────────────────────────────────┐
│ Création en base de données         │
│ - Enregistrer l'utilisateur         │
│ - Sauvegarder permissions JSON      │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Confirmation                        │
│ - Message "Utilisateur créé"        │
│ - Redirection vers liste            │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Utilisateur créé
```

---

## 3. WORKFLOW DE GESTION DES FIDÈLES

### 3.1 Workflow d'Enregistrement d'un Fidèle

```
⬥ DÉBUT : Secrétaire/Curé accède à "Fidèles"
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Nouveau fidèle"            │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire d'enregistrement         │
│ INFORMATIONS PERSONNELLES           │
│ ├─ Nom (obligatoire)                │
│ ├─ Prénoms (obligatoire)            │
│ ├─ Sexe (M/F, obligatoire)          │
│ ├─ Date de naissance                │
│ └─ Lieu de naissance                │
│                                     │
│ COORDONNÉES                         │
│ ├─ Téléphone                        │
│ ├─ Email                            │
│ ├─ Profession                       │
│ ├─ Quartier                         │
│ └─ Situation matrimoniale           │
│                                     │
│ PAROISSIAL                          │
│ ├─ CEB (sélection)                 │
│ ├─ Statut (actif/transfere/decede)  │
│ └─ Sacrements (checkboxes)          │
│   ├─ Baptisé                        │
│   ├─ Confirmé                       │
│   └─ Marié                          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation côté client              │
│ - Champs obligatoires remplis ?    │
│ - Email format valide ?            │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Soumission du formulaire            │
│ - Token CSRF envoyé                 │
│ - Données POST                      │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation côté serveur             │
│ - Nom et prénoms requis            │
│ - Sexe requis                       │
│ - Statut requis                     │
│ - Email unique (si fourni)          │
│ - CEB existe (si sélectionné)       │
└─────────────────────────────────────┘
 │
 ↓
 ↘ Validé ?
 │ OUI │ NON
 ↓     ↓
┌─────────────────┐   ┌─────────────────┐
│ Conversion des  │   │ Retour formulaire│
│ checkboxes     │   │ avec erreurs    │
│ - baptise → bool│   └─────────────────┘
│ - confirme → bool│           ↑
│ - marie → bool  │           │
└─────────────────┘           │
 │                              │
 ↓                              │
┌─────────────────────────────────────┐
│ Enregistrement en base de données   │
│ INSERT INTO fideles (...)            │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Confirmation                        │
│ - Message "Fidèle enregistré"       │
│ - Redirection vers liste            │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Fidèle enregistré
```

### 3.2 Workflow de Modification d'un Fidèle

```
⬥ DÉBUT : Utilisateur accède à liste des fidèles
 │
 ↓
┌─────────────────────────────────────┐
│ Recherche du fidèle                 │
│ - Par nom/prénoms                   │
│ - Par CEB                           │
│ - Par statut                         │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Modifier"                 │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire pré-rempli               │
│ - Données actuelles chargées        │
│ - Modification possible             │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation et soumission             │
│ - Même processus que création       │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Mise à jour en base de données      │
│ UPDATE fideles SET ...              │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Confirmation                        │
│ - Message "Fidèle mis à jour"      │
│ - Redirection vers liste            │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Fidèle modifié
```

### 3.3 Workflow d'Enregistrement d'un Baptême

```
⬥ DÉBUT : Utilisateur dans liste des fidèles
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Baptême" à côté du fidèle  │
└─────────────────────────────────────┘
 │
 ↓
 ↘ Fidèle a déjà un baptême ?
 │ NON │ OUI
 ↓     ↓
┌─────────────────┐   ┌─────────────────┐
│ Formulaire vide │   │ Message erreur  │
│                 │   │ "Déjà baptisé"  │
└─────────────────┘   └─────────────────┘
 │                              ↑
 ↓                              │
┌─────────────────────────────────────┐
│ Formulaire de baptême               │
│ - Numéro d'acte (obligatoire)       │
│ - Date du baptême (obligatoire)     │
│ - Lieu                               │
│ - Ministre (obligatoire)             │
│ - Parrain                            │
│ - Marraine                           │
│ - Père                               │
│ - Mère                               │
│ - Livre                              │
│ - Folio                              │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation                          │
│ - Numéro d'acte unique ?            │
│ - Date valide ?                      │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement en base de données   │
│ INSERT INTO baptemes (...)           │
│ - Association avec fidele_id        │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Mise à jour du fidèle               │
│ UPDATE fideles SET baptise = true    │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Affichage des options                │
│ - Modifier le baptême               │
│ - Générer certificat PDF            │
└─────────────────────────────────────┘
 │
 ↓
 ↘ Générer certificat ?
 │ OUI │ NON
 ↓     ↓
┌─────────────────┐   ◯ FIN : Baptême enregistré
│ Génération PDF  │
│ - Chargement    │
│   template      │
│ - Injection     │
│   données       │
│ - Stream PDF    │
└─────────────────┘
 │
 ↓
◯ FIN : Certificat généré
```

### 3.4 Workflow d'Export des Fidèles

```
⬥ DÉBUT : Utilisateur dans liste des fidèles
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Exporter CSV"              │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Récupération des données            │
│ SELECT * FROM fideles               │
│ - Jointure avec CEB                  │
│ - Tri par nom                        │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Génération du CSV                   │
│ - En-têtes : Nom, Prénoms, Sexe...  │
│ - BOM UTF-8 pour Excel              │
│ - Séparateur ;                       │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Téléchargement du fichier            │
│ - Nom : fideles-YYYYMMDD.csv        │
│ - Type MIME : text/csv              │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Fichier CSV téléchargé
```

---

## 4. WORKFLOW DES SACREMENTS

### 4.1 Workflow d'Enregistrement d'un Sacrement (hors baptême)

```
⬥ DÉBUT : Utilisateur dans fiche d'un fidèle
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Sacrements"               │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Liste des sacrements existants      │
│ - Type                              │
│ - Date de célébration               │
│ - Lieu                              │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Nouveau sacrement"        │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Sélection du type                    │
│ - Communion                         │
│ - Profession de foi                  │
│ - Confirmation                       │
│ - Mariage                           │
│ - Onction des malades                │
│ - Funérailles                        │
└─────────────────────────────────────┘
 │
 ↓
 ↘ Type = Mariage ?
 │ OUI │ NON
 ↓     ↓
┌─────────────────┐   ┌─────────────────┐
│ Formulaire avec │   │ Formulaire sans │
│ sélection du    │   │ conjoint        │
│ conjoint        │   └─────────────────┘
└─────────────────┘           │
 │                              │
 ↓                              │
┌─────────────────────────────────────┐
│ Formulaire de sacrement             │
│ - Numéro d'acte (auto)              │
│ - Date de célébration               │
│ - Lieu                              │
│ - Ministre                          │
│ - Témoin 1                          │
│ - Témoin 2 (si requis)              │
│ - Observations                      │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation                          │
│ - Numéro d'acte unique ?            │
│ - Date valide ?                      │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement en base de données   │
│ INSERT INTO sacrements (...)        │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Confirmation                        │
│ - Message "Sacrement enregistré"    │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Sacrement enregistré
```

### 4.2 Workflow de Génération de Certificat

```
⬥ DÉBUT : Utilisateur dans liste des sacrements
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Certificat"               │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Récupération des données            │
│ - Sacrement                         │
│ - Fidèle                            │
│ - Conjoint (si mariage)              │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Chargement du template PDF          │
│ - Type de sacrement                  │
│ - Logo paroisse                      │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Génération du PDF                   │
│ - Injection des données             │
│ - Formatage officiel                │
│ - Date de génération                │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Stream du PDF                       │
│ - Affichage dans le navigateur      │
│ - Possibilité de téléchargement     │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Certificat généré
```

---

## 5. WORKFLOW DE GESTION DES CEB

### 5.1 Workflow de Création d'un CEB

```
⬥ DÉBUT : Secrétaire/Curé accède à "CEB"
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Nouveau CEB"               │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire de création               │
│ - Nom (obligatoire, unique)          │
│ - Responsable                       │
│ - Zone de couverture                 │
│ - Numéro du responsable             │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation                          │
│ - Nom unique ?                      │
│ - Nom non vide ?                    │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement en base de données   │
│ INSERT INTO cebs (...)              │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Confirmation                        │
│ - Message "CEB créé"                │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : CEB créé
```

### 5.2 Workflow d'Attribution d'un Fidèle à un CEB

```
⬥ DÉBUT : Lors de l'enregistrement/modification d'un fidèle
 │
 ↓
┌─────────────────────────────────────┐
│ Sélection du CEB dans le formulaire  │
│ - Liste déroulante des CEB          │
│ - Option vide possible              │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation                          │
│ - CEB existe en base ?              │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement/Mise à jour          │
│ UPDATE fideles SET ceb_id = ...     │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Fidèle attribué au CEB
```

---

## 6. WORKFLOW DES MOUVEMENTS

### 6.1 Workflow de Création d'un Mouvement

```
⬥ DÉBUT : Utilisateur accède à "Mouvements"
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Nouveau mouvement"        │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire de création               │
│ - Nom (obligatoire, unique)          │
│ - Responsable                       │
│ - Date de création                  │
│ - Description                       │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation et enregistrement         │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Mouvement créé
```

### 6.2 Workflow d'Ajout d'un Membre à un Mouvement

```
⬥ DÉBUT : Utilisateur dans liste des mouvements
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Membres" à côté du mouvement│
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Liste des membres actuels            │
│ - Nom du fidèle                      │
│ - Fonction                          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire d'ajout                  │
│ - Sélection du fidèle               │
│ - Fonction (défaut: Membre)         │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation                          │
│ - Fidèle existe ?                    │
│ - Pas déjà membre ?                 │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement dans table pivot      │
│ INSERT INTO fidele_mouvement (...)  │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Membre ajouté
```

---

## 7. WORKFLOW DES ÉVÉNEMENTS

### 7.1 Workflow de Création d'un Événement

```
⬥ DÉBUT : Curé/Secrétaire accède à "Événements"
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Nouvel événement"          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire de création               │
│ - Titre (obligatoire)               │
│ - Type (messe, adoration, etc.)      │
│ - Date et heure (obligatoire)        │
│ - Lieu                              │
│ - Célébrant                         │
│ - Description                       │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation                          │
│ - Date/heure valide ?                │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement en base de données   │
│ INSERT INTO evenements (...)        │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Affichage dans le calendrier         │
│ - Liste chronologique               │
│ - Filtres par type                  │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Événement créé
```

### 7.2 Workflow d'Export du Calendrier

```
⬥ DÉBUT : Utilisateur dans tableau de bord ou événements
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Exporter PDF"              │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Récupération des événements         │
│ SELECT * FROM evenements            │
│ - Filtrage par date (futurs)        │
│ - Tri chronologique                 │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Génération du PDF                   │
│ - Template calendrier                │
│ - Logo paroisse                      │
│ - Tableau des événements             │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Calendrier PDF généré
```

---

## 8. WORKFLOW DES INTENTIONS DE MESSE

### 8.1 Workflow Complet des Intentions

```
⬥ DÉBUT : Fidèle/Responsable souhaite enregistrer une intention
 │
 ↓
┌─────────────────────────────────────┐
│ Accès au formulaire d'intention      │
│ - Via secrétariat                    │
│ - Ou formulaire public (future)     │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire d'enregistrement         │
│ INFORMATIONS DEMANDEUR              │
│ ├─ Nom du demandeur                 │
│ ├─ Téléphone                        │
│                                     │
│ INTENTION                           │
│ ├─ Type (action grâce/repos éternel)│
│ ├─ Texte de l'intention             │
│ ├─ Offrande (montant FCFA)          │
│ ├─ Date de messe souhaitée          │
│ ├─ Jour (samedi/dimanche)           │
│ └─ Détail (dimanche 7h, 9h, etc.)   │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation                          │
│ - Demandeurs requis                 │
│ - Intention requise                 │
│ - Offrande >= 0                     │
│ - Date valide                       │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Génération du numéro de reçu        │
│ - Format : INT-XXXXX                │
│ - Incrément automatique             │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement en base de données   │
│ INSERT INTO intentions (...)         │
│ - Statut : en_attente               │
│ - Numéro de semaine généré          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Options disponibles                 │
│ - Générer reçu PDF                  │
│ - Modifier l'intention              │
└─────────────────────────────────────┘
 │
 ↓
↘ Générer reçu ?
 │ OUI │ NON
 ↓     ↓
┌─────────────────┐   ┌─────────────────┐
│ Génération PDF  │   ◯ FIN : Intention│
│ - Design reçu   │   │   enregistrée  │
│ - Données       │   └─────────────────┘
│ - Stream        │
└─────────────────┘
 │
 ↓
◯ FIN : Reçu généré
```

### 8.2 Workflow de Tirage des Intentions

```
⬥ DÉBUT : Curé/Secrétaire accède à "Intentions" → "Tirage"
 │
 ↓
┌─────────────────────────────────────┐
│ Sélection de la semaine             │
│ - Défaut : semaine courante         │
│ - Possibilité de choisir autre      │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Affichage des intentions en attente  │
│ - Par type                          │
│ - Par date souhaitée                │
│ - Total à tirer                     │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Effectuer le tirage"      │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Algorithme de tirage                 │
│                                     │
│ POUR CHAQUE INTENTION :            │
│ 1. SI type = action_grace           │
│      → Jour = samedi                │
│ 2. SI type = repos_eternel          │
│      → Jour = dimanche              │
│ 3. SI type = generale              │
│      → Équilibrer samedi/dimanche   │
│                                     │
│ 4. Assigner jour_messe             │
│ 5. Changer statut = tiree          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Affichage des intentions tirées     │
│ - Samedi : intentions samedi        │
│ - Dimanche : intentions dimanche    │
│ - Statistiques par jour             │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Options d'export                    │
│ - Export PDF (liste officielle)     │
│ - Export Word (document)            │
│ - Export CSV (simple)               │
└─────────────────────────────────────┘
 │
 ↓
 ↘ Exporter ?
 │ OUI │ NON
 ↓     ↓
┌─────────────────┐   ◯ FIN : Tirage effectué
│ Génération      │
│ - Sélection type│
│ - Filtrage      │
│ - Génération    │
│ - Téléchargement│
└─────────────────┘
 │
 ↓
◯ FIN : Liste exportée
```

### 8.3 Workflow de Marquage comme Célébrée

```
⬥ DÉBUT : Après la messe, intention marquée célébrée
 │
 ↓
┌─────────────────────────────────────┐
│ Dans liste des intentions           │
│ - Lien "Marquer célébrée" visible  │
│ - Seulement si statut = tiree       │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Marquer célébrée"          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Mise à jour en base de données      │
│ UPDATE intentions                   │
│ SET statut = 'celebree'             │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Confirmation                        │
│ - Message "Intention célébrée"      │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Intention célébrée
```

---

## 9. WORKFLOW DE GESTION FINANCIÈRE

### 9.1 Workflow d'Enregistrement d'une Recette

```
⬥ DÉBUT : Trésorier/Admin accède à "Finances"
 │
 ↓
┌─────────────────────────────────────┐
│ Section "Nouvelle recette"          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire de recette               │
│ INFORMATIONS DE BASE                │
│ ├─ Date (obligatoire)               │
│ ├─ Type (quête, offrande, don...)   │
│ └─ Montant (obligatoire)            │
│                                     │
│ DONATEUR                            │
│ ├─ Sélection d'un fidèle            │
│ └─ OU nom du donateur (texte)       │
│                                     │
│ COMPLÉMENTS                         │
│ ├─ CEB (optionnel)                  │
│ └─ Note (optionnel)                 │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation spécifique par type     │
│                                     │
│ SI type = offrande_messe :          │
│ - Montant nullable                  │
│ - Note requise si montant vide      │
│                                     │
│ SINON :                             │
│ - Montant requis                    │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Génération du numéro de reçu        │
│ - Format : REC-XXXXX                │
│ - Incrément automatique             │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement en base de données   │
│ INSERT INTO recettes (...)          │
│ - user_id = utilisateur actuel     │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Affichage dans la liste             │
│ - Avec lien vers reçu               │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Recette enregistrée
```

### 9.2 Workflow de Génération de Reçu

```
⬥ DÉBUT : Dans liste des recettes
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur le numéro de reçu          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Récupération des données            │
│ - Recette                           │
│ - Donateur (fidèle ou nom)          │
│ - CEB                               │
│ - Type et catégorie                 │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Préparation du motif                │
│ - Type de recette                   │
│ - Note si existante                 │
│ - Concaténation                     │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Chargement du logo                  │
│ - Chemin : public/images/saint.jpg  │
│ - Encodage base64                   │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Génération du PDF                   │
│ - Template reçu.blade.php           │
│ - Injection des données             │
│ - Design élégant                    │
│ - Zones de signature                │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Stream du PDF                       │
│ - Nom : recu-RECXXXXX.pdf           │
│ - Affichage navigateur              │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Reçu affiché/téléchargé
```

### 9.3 Workflow d'Enregistrement d'une Dépense

```
⬥ DÉBUT : Trésorier/Admin dans "Finances"
 │
 ↓
┌─────────────────────────────────────┐
│ Section "Nouvelle dépense"           │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire de dépense               │
│ - Date (obligatoire)                │
│ - Catégorie (obligatoire)           │
│ - Libellé (obligatoire)             │
│ - Montant (obligatoire)             │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation                          │
│ - Date valide ?                      │
│ - Catégorie valide ?                 │
│ - Montant > 0 ?                     │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement en base de données   │
│ INSERT INTO depenses (...)          │
│ - user_id = utilisateur actuel     │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Dépense enregistrée
```

### 9.4 Workflow de Génération de Bilan

```
⬥ DÉBUT : Trésorier/Admin dans "Finances"
 │
 ↓
┌─────────────────────────────────────┐
│ Section "Bilan"                     │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Sélection des paramètres            │
│ - Période (mois ou tout)            │
│ - Catégorie (tous ou spécifique)    │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Récupération des données            │
│                                     │
│ RECETTES :                          │
│ SELECT * FROM recettes              │
│ - Filtrage par période              │
│ - Filtrage par catégorie (si choisi)│
│ - Somme des montants                │
│                                     │
│ DÉPENSES :                          │
│ SELECT * FROM depenses              │
│ - Filtrage par période              │
│ - Somme des montants                │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Calcul du solde                     │
│ Solde = Total recettes - Total dépenses│
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Génération du PDF                   │
│ - Template bilan.blade.php         │
│ - Tableau des recettes              │
│ - Tableau des dépenses              │
│ - Récapitulatif avec solde          │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Bilan PDF généré
```

### 9.5 Workflow par Catégorie (Dons, Dîmes, etc.)

```
⬥ DÉBUT : Accès à une vue spécialisée (ex: Dons)
 │
 ↓
┌─────────────────────────────────────┐
│ Filtrage automatique                │
│ - Type filtré par catégorie         │
│ - Ex: TYPE IN ('don')               │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Affichage de la liste               │
│ - Recettes de la catégorie          │
│ - Total de la catégorie             │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Actions disponibles                 │
│ - Ajouter recette (pré-rempli type)│
│ - Voir reçu par ligne               │
│ - Exporter la liste                 │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Vue catégorielle affichée
```

---

## 10. WORKFLOW DE CATÉCHÈSE

### 10.1 Workflow de Création d'une Classe

```
⬥ DÉBUT : Catéchiste/Secrétaire accède à "Classes de catéchèse"
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Nouvelle classe"           │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire de création               │
│ - Année scolaire (ex: 2026-2027)    │
│ - Niveau (CP1, CP2, CE1, etc.)      │
│ - Catéchiste responsable            │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation et enregistrement        │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Classe créée
```

### 10.2 Workflow d'Inscription d'un Catéchumène

```
⬥ DÉBUT : Catéchiste dans "Catéchumènes"
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Nouveau catéchumène"       │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire d'inscription            │
│ - Sélection du fidèle               │
│ - Sélection de la classe            │
│ - Statut (inscrit par défaut)       │
│ - Observations                      │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Validation                          │
│ - Fidèle existe ?                    │
│ - Classe existe ?                    │
│ - Pas déjà inscrit dans cette classe?│
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement en base de données   │
│ INSERT INTO catechumenes (...)      │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Catéchumène inscrit
```

### 10.3 Workflow de Suivi de Progression

```
⬥ DÉBUT : Catéchiste dans liste des catéchumènes
 │
 ↓
┌─────────────────────────────────────┐
│ Modification du statut              │
│ - inscrit → en_cours               │
│ - en_cours → termine               │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Mise à jour en base de données      │
│ UPDATE catechumenes SET statut = ...│
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Progression mise à jour
```

---

## 11. WORKFLOW DES ANNONCES

### 11.1 Workflow de Publication d'une Annonce

```
⬥ DÉBUT : Curé/Secrétaire accède à "Annonces"
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Nouvelle annonce"          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire de publication           │
│ CONTENU                            │
│ ├─ Titre (obligatoire)              │
│ ├─ Contenu (obligatoire)            │
│ └─ Image (optionnel)                │
│                                     │
│ PUBLICATION                         │
│ ├─ Date de publication (obligatoire) │
│ ├─ Date d'expiration (optionnel)    │
│ └─ Afficher comme affiche (checkbox)│
└─────────────────────────────────────┘
 │
 ↓
 ↘ Image fournie ?
 │ OUI │ NON
 ↓     ↓
┌─────────────────┐   ┌─────────────────┐
│ Upload de l'image│   ┌─────────────────┐
│ - Validation    │   │ Sans image      │
│ - Type MIME     │   └─────────────────┘
│ - Taille < 2MB  │           │
│ - Stockage      │           │
└─────────────────┘           │
 │                              │
 ↓                              │
┌─────────────────────────────────────┐
│ Enregistrement en base de données   │
│ INSERT INTO annonces (...)          │
│ - Chemin image si uploadée          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Confirmation                        │
│ - Message "Annonce publiée"         │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Annonce publiée
```

### 11.2 Workflow d'Affichage Public

```
⬥ DÉBUT : Visiteur accède au site public
 │
 ↓
┌─────────────────────────────────────┐
│ Page d'accueil                      │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Récupération des annonces           │
│ SELECT * FROM annonces              │
│ WHERE publie_le <= NOW()            │
│ AND (expire_le IS NULL              │
│      OR expire_le >= NOW())         │
│ ORDER BY publie_le DESC             │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Affichage                           │
│ - Annonces comme cartes             │
│ - Affiches comme grandes images     │
│ - Titre et extrait du contenu       │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Annonces affichées au public
```

---

## 12. WORKFLOW DU TABLEAU DE BORD

### 12.1 Workflow de Chargement du Tableau de Bord

```
⬥ DÉBUT : Utilisateur connecté
 │
 ↓
┌─────────────────────────────────────┐
│ Vérification des permissions         │
│ - Quels modules sont accessibles ?  │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Récupération des statistiques       │
│                                     │
│ STATISTIQUES GLOBALES :            │
│ - Fidèles actifs                    │
│ - Baptêmes de l'année               │
│ - Catéchumènes inscrits             │
│ - Intentions à célébrer             │
│                                     │
│ FINANCES (si autorisé) :            │
│ - Recettes de l'année               │
│ - Dépenses de l'année               │
│ - Solde                             │
│ - Par catégorie                     │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Récupération des données récentes  │
│                                     │
│ DERNIERS FIDÈLES (si autorisé) :   │
│ - 10 derniers fidèles inscrits     │
│                                     │
│ PROCHAINS ÉVÉNEMENTS (si autorisé) :│
│ - 5 prochains événements            │
│                                     │
│ MOUVEMENTS (si autorisé) :          │
│ - Mouvements paroissiaux actifs     │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Affichage du tableau de bord         │
│ - Cartes de statistiques            │
│ - Tableaux de données récentes      │
│ - Actions rapides                   │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Tableau de bord affiché
```

### 12.2 Workflow des Actions Rapides

```
⬥ DÉBUT : Utilisateur sur tableau de bord
 │
 ↓
┌─────────────────────────────────────┐
│ Section "Actions rapides"           │
│ - Boutons vers les modules          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur une action rapide          │
│ Ex: "Nouveau fidèle"                │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Redirection vers le formulaire      │
│ route('fideles.create')             │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Formulaire affiché
```

---

## 13. WORKFLOW INTER-MODULES

### 13.1 Workflow Fidèle → Sacrements

```
⬥ DÉBUT : Fidèle enregistré
 │
 ↓
┌─────────────────────────────────────┐
│ Accès à la fiche du fidèle          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Options disponibles                 │
│ - Enregistrer baptême              │
│ - Enregistrer autre sacrement      │
│ - Voir sacrements existants         │
└─────────────────────────────────────┘
 │
 ↓
↘ Enregistrer sacrement ?
 │ OUI
 ↓
┌─────────────────────────────────────┐
│ Création du sacrement               │
│ - Association fidele_id             │
│ - Mise à jour checkbox si applicable│
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Sacrement lié au fidèle
```

### 13.2 Workflow Fidèle → Mouvements

```
⬥ DÉBUT : Fidèle enregistré
 │
 ↓
┌─────────────────────────────────────┐
│ Accès à un mouvement                │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Clic sur "Membres"                  │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire d'ajout                  │
│ - Sélection du fidèle               │
│ - Fonction                          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Création dans table pivot           │
│ INSERT INTO fidele_mouvement        │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Fidèle membre du mouvement
```

### 13.3 Workflow Événement → Intentions

```
⬥ DÉBUT : Événement créé (ex: messe dimanche)
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement d'une intention       │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire d'intention              │
│ - Sélection de l'événement (optionnel)│
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement avec evenement_id    │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Intention liée à l'événement
```

### 13.4 Workflow Recette → Fidèle

```
⬥ DÉBUT : Enregistrement d'une recette
 │
 ↓
┌─────────────────────────────────────┐
│ Formulaire de recette               │
│ - Sélection d'un fidèle             │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ Enregistrement avec fidele_id       │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Recette liée au fidèle
```

### 13.5 Workflow Complet : Fidèle → Tout

```
⬥ DÉBUT : Nouveau fidèle arrive à la paroisse
 │
 ↓
┌─────────────────────────────────────┐
│ ÉTAPE 1 : Enregistrement            │
│ - Formulaire fidèle                 │
│ - Informations de base              │
│ - Attribution CEB                   │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ ÉTAPE 2 : Sacrements               │
│ - Enregistrement baptême            │
│ - Suivi autres sacrements           │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ ÉTAPE 3 : Mouvements               │
│ - Ajout aux mouvements             │
│ - Attribution de fonctions          │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ ÉTAPE 4 : Catéchèse (si enfant)    │
│ - Inscription classe catéchèse     │
│ - Suivi progression                │
└─────────────────────────────────────┘
 │
 ↓
┌─────────────────────────────────────┐
│ ÉTAPE 5 : Finances                │
│ - Enregistrement dîmes             │
│ - Enregistrement offrandes         │
└─────────────────────────────────────┘
 │
 ↓
◯ FIN : Fidèle intégré complètement
```

---

## CONCLUSION

### Résumé des Workflows Principaux

1. **Authentification** : Sécurisée avec permissions granulaires
2. **Fidèles** : Enregistrement complet avec sacrements
3. **Sacrements** : Traçabilité et certificats PDF
4. **CEB** : Organisation communautaire
5. **Mouvements** : Gestion des membres et fonctions
6. **Événements** : Calendrier paroissial
7. **Intentions** : Enregistrement, tirage, célébration
8. **Finances** : Recettes, dépenses, bilans
9. **Catéchèse** : Classes et catéchumènes
10. **Annonces** : Communication avec les fidèles

### Points Clés

- **Chaque workflow est sécurisé** par le système de permissions
- **Validation à chaque étape** pour garantir l'intégrité des données
- **Traçabilité complète** avec utilisateur et date
- **Génération automatique de documents** (reçus, certificats)
- **Interconnexion des modules** pour une gestion globale

### Bonnes Pratiques

1. **Toujours valider** les données avant enregistrement
2. **Générer des documents** pour chaque action importante
3. **Mettre à jour les statuts** pour suivre les progrès
4. **Utiliser les filtres** pour retrouver rapidement les informations
5. **Exporter régulièrement** pour les sauvegardes

---

**Document généré le 2 octobre 2026**
**Version 1.0.0**
**Système de Gestion Paroissiale - Saint Michel Archange de la BAE**
