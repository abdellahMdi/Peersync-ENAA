# PeerSync (ENAA)

PeerSync est un projet **PHP / MySQL** réalisé dans le cadre du bootcamp **ENAA**. L’objectif est de structurer et fiabiliser l’entraide entre apprenants (demandes d’aide) et tuteurs volontaires, au lieu de laisser les demandes se perdre dans un flux Discord.

Le projet met l’accent sur :
- une **modélisation orientée objet** (objets typés, encapsulation)
- une **persistance robuste** en **MySQL**
- une séparation claire entre **Entités** (modèle) et **Repositories** (accès aux données)

---

## Contexte
À l’ENAA, l’entraide est essentielle mais aujourd’hui informelle (Discord). Problèmes :
- les demandes se perdent dans le flux de messages
- l’administration ne peut pas mesurer l’impact
- l’engagement des tuteurs n’est pas valorisé

**Solution attendue :** développer PeerSync, où chaque interaction (demande, session, statut) est un **Objet PHP** persisté en base **MySQL**.

---

## User Stories (résumé)

### Épic 1 — Gestion des utilisateurs & profils
- **US1 : Connexion et rôles (Tuteur / Apprenant)**
  - connexion via identifiants ENAA
  - profil avec tags de compétences (ex: POO, SQL, JavaScript)

### Épic 2 — Gestion des demandes d’aide (le flux)
- **US2 : Création d’une demande d’aide**
  - titre + description + techno/catégorie
  - la demande apparaît sur un tableau de bord
  - objet `Ticket` / `HelpRequest` avec statut initial `Statut::PENDING` (Enum PHP)

- **US3 : Prise en charge par un tuteur**
  - le tuteur voit les demandes en attente et en accepte une
  - statut : “En attente” → “Assignée”
  - méthode métier attendue : `assignTo(User $tutor)`
    - empêche un tuteur de s’assigner lui-même
    - persiste la mise à jour via un Repository

### Épic 3 — Suivi et validation des sessions
- **US4 : Clôture**
  - l’apprenant marque la demande “Résolue”
  - commentaire de remerciement possible
  - statut : `Statut::RESOLVED`

- **US5 : Avis / note**
  - note de 1 à 5 étoiles
  - la persistance en base doit être rejetée si la note est hors intervalle

### Bonus
- Gamification (points, badges, leaderboard)
- Dashboard admin (statistiques, top tuteurs, technos demandées, export)

---

## Structure du projet

### 1) Base de données
- Schéma SQL : `docs/schema.sql`
- Le dépôt contient aussi des **données de démonstration** (seed) pour tester.

### 2) Entités PHP
Les entités représentent les objets métier (exemples attendus) :
- `User` (apprenant/tuteur)
- `HelpRequest` / `Ticket`
- `Session`
- `Review` / `Rating`
- `Statut` (Enum)

Elles contiennent typiquement :
- propriétés privées + **getters/setters**
- règles métier (ex: assignation, résolution)
- validations (ex: note 1..5)

### 3) Repositories
Les repositories isolent les requêtes SQL afin d’éviter du SQL dispersé dans la logique métier.

Ils gèrent typiquement :
- `find(...)`, `findAll(...)`
- `save(...)`, `update(...)`, `delete(...)`
- requêtes spécifiques (ex: liste des tickets `PENDING`, stats, etc.)

---

## Installation / Lancement (indicatif)
> À adapter selon votre environnement (WAMP/MAMP/XAMPP/Docker).

1. Cloner le dépôt
2. Créer une base MySQL
3. Importer le schéma : `docs/schema.sql`
4. Configurer la connexion DB (host, dbname, user, password)
5. Lancer le projet avec votre serveur local

---

## Notes
- Le dépôt est 100% PHP (d’après la composition GitHub).
- L’objectif principal est d’appliquer une architecture simple et propre : **Entities + Repositories + MySQL**.
