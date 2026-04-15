# 🔐 RÉCAPITULATIF DES ACCÈS AU SYSTÈME (LTD)

Ce document répertorie les identifiants de connexion configurés pour le système scolaire LTD (Lycée Technologique de Diffa).

## 🏛️ PARTIE ADMINISTRATION & PERSONNELS (Firebase)
L'accès se fait via la page : `login-fb.html`

| Rôle | Email (Identifiant) | Mot de Passe par défaut | Redirection |
| :--- | :--- | :--- | :--- |
| **Directeur / Admin** | `91038061@ltd.edu` | `123456` | `/director/dashboard-fb.html` |
| **Enseignant** | *(À créer via Firebase)* | *(Défini à la création)* | `/teacher/dashboard-fb.html` |
| **Surveillant** | *(À créer via Firebase)* | *(Défini à la création)* | `/supervisor/dashboard-fb.html` |

---

## 🎓 PORTAIL ÉLÈVES (Firebase)
L'accès se fait via le portail élève : `student/login-fb.html`

Les élèves se connectent avec leur **Matricule** et une **Clé Secrète**.

| Nom de l'Élève (Exemple) | Matricule | Clé Secrète (MDP) |
| :--- | :--- | :--- |
| **MOUSSA Ibrahim** | `LTD-2024-0001` | *Identique au matricule* |
| **FATIMA Sani** | `LTD-2024-0002` | *Identique au matricule* |

---

## 📂 ANCIEN SYSTÈME (PHP / Legacy)
Pour référence, les identifiants de l'ancien système local :

| Rôle | Identifiant (Téléphone) | Mot de Passe |
| :--- | :--- | :--- |
| **Admin Local** | `0000` | `admin123` |

---

## 🛠️ INSTRUCTIONS DE GESTION
1. **Ajout de Staff** : Les comptes du personnel (Directeur, Profs, Surveillants) doivent être créés manuellement dans la **Console Firebase** (Authentication) puis ajoutés dans la collection Firestore `users` avec le champ `role` correspondant.
2. **Ajout d'Élèves** : Les élèves sont gérés dans la collection Firestore `eleves`. Chaque document doit contenir les champs `matricule`, `nom`, `prenom`, `classeId` et `password`.
