-- Active: 1779352759974@@127.0.0.1@3306
-- ============================================================
--  PeerSync — Demo Data
-- ============================================================
 use peersync ;
-- ------------------------------------------------------------
--  roles
-- ------------------------------------------------------------
INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'apprenant'),
(2, 'admin');
 

 DROP TABLE users ;
 DROP TABLE roles ;

 select * from users;
-- ------------------------------------------------------------
--  users  (password = bcrypt of "AZERTY123")
-- ------------------------------------------------------------
INSERT INTO `users` (`id`, `name`, `email`, `password`, `first_time`, `role_id`) VALUES
(1,  'Khalid Moussaoui',  'khalid.m@enaa.ma',   '$2a$11$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK', '0', 1),
(2,  'Sara Benali',       'sara.b@enaa.ma',      '$2a$11$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK', '0', 1),
(3,  'Younes Alaoui',     'younes.a@enaa.ma',    '$2a$11$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK', '0', 1),
(4,  'Fatima Zahra',      'fatima.z@enaa.ma',    '$2a$11$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK', '0', 1),
(5,  'Amine Lahlou',      'amine.l@enaa.ma',     '$2a$11$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK', '0', 1),
(6,  'Mehdi Rachidi',     'mehdi.r@enaa.ma',     '$2a$11$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK', '0', 1),
(7,  'Karim Drissi',      'karim.d@enaa.ma',     '$2a$11$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK', '0', 1),
(8,  'Nadia Chraibi',     'nadia.c@enaa.ma',     '$2a$11$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK', '0', 1),
(9,  'Omar Senhaji',      'omar.s@enaa.ma',      '$2a$11$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK', '0', 1),
(10, 'Admin ENAA',        'admin@enaa.ma',        '$2a$11$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK', '0', 2);
 
-- ------------------------------------------------------------
--  skills
-- ------------------------------------------------------------
INSERT INTO `skills` (`id`, `name`, `dificulti`) VALUES
(1,  'HTML',             'easy'),
(2,  'CSS',              'easy'),
(3,  'JavaScript',       'medium'),
(4,  'TypeScript',       'medium'),
(5,  'PHP',              'medium'),
(6,  'SQL',              'medium'),
(7,  'POO',              'medium'),
(8,  'Git',              'easy'),
(9,  'MySQL',            'medium'),
(10, 'Node.js',          'hard'),
(11, 'React',            'hard'),
(12, 'Laravel',          'hard'),
(13, 'Design Patterns',  'hard'),
(14, 'REST API',         'medium'),
(15, 'Algorithmique',    'hard');
 
-- ------------------------------------------------------------
--  user_skills
-- ------------------------------------------------------------
INSERT INTO `user_skills` (`maitrise`, `skill_id`, `user_id`) VALUES
-- Khalid
('maîtrisées',   1,  1),   -- HTML
('maîtrisées',   2,  1),   -- CSS
('à travailler', 3,  1),   -- JavaScript
('à travailler', 5,  1),   -- PHP
('à travailler', 6,  1),   -- SQL
 
-- Sara
('maîtrisées',   1,  2),
('maîtrisées',   3,  2),
('à travailler', 11, 2),   -- React
('à travailler', 4,  2),   -- TypeScript
 
-- Younes
('maîtrisées',   5,  3),   -- PHP
('maîtrisées',   6,  3),   -- SQL
('maîtrisées',   7,  3),   -- POO
('maîtrisées',   9,  3),   -- MySQL
('à travailler', 12, 3),   -- Laravel
 
-- Fatima 
('maîtrisées',   3,  4),   -- JavaScript
('maîtrisées',   11, 4),   -- React
('maîtrisées',   4,  4),   -- TypeScript
('à travailler', 10, 4),   -- Node.js
 
-- Amine (apprenant — first_time=1, no skills yet)
 
-- Mehdi
('maîtrisées',   7,  6),   -- POO
('maîtrisées',   13, 6),   -- Design Patterns
('maîtrisées',   14, 6),   -- REST API
('maîtrisées',   5,  6),   -- PHP
('à travailler', 15, 6),   -- Algorithmique
 
-- Karim (apprenant — first_time=1, no skills yet)
 
-- Nadia
('maîtrisées',   1,  8),
('maîtrisées',   2,  8),
('à travailler', 6,  8),
('à travailler', 9,  8),
 
-- Omar
('maîtrisées',   15, 9),   -- Algorithmique
('maîtrisées',   7,  9),   -- POO
('maîtrisées',   6,  9),   -- SQL
('à travailler', 13, 9);   -- Design Patterns
 
-- ------------------------------------------------------------
--  badges
-- ------------------------------------------------------------
INSERT INTO `badges` (`id`, `requirements`, `name`) VALUES
(1,  1,  'Premier pas'),       -- 1 help request resolved
(2,  3,  'Coup de main'),      -- 3 resolved
(3,  5,  'Pair solide'),       -- 5 resolved
(4,  10, 'Mentor confirmé'),   -- 10 resolved
(5,  20, 'Expert ENAA');       -- 20 resolved
 
-- ------------------------------------------------------------
--  user_badges
-- ------------------------------------------------------------
INSERT INTO `user_badges` (`user_id`, `skill_id`, `badge_id`) VALUES
(3, 5,  1),   -- Younes : Premier pas (PHP)
(3, 6,  2),   -- Younes : Coup de main (SQL)
(4, 3,  1),   -- Fatima : Premier pas (JavaScript)
(6, 7,  3),   -- Mehdi  : Pair solide (POO)
(6, 14, 2),   -- Mehdi  : Coup de main (REST API)
(9, 15, 2),   -- Omar   : Coup de main (Algorithmique)
(9, 6,  1);   -- Omar   : Premier pas (SQL)
 
-- ------------------------------------------------------------
--  status
-- ------------------------------------------------------------
INSERT INTO `status` (`id`, `status`) VALUES
(1, 'EN_ATTENTE'),
(2, 'ASSIGNE'),
(3, 'RESOLUE');
 
-- ------------------------------------------------------------
--  help_requests
-- ------------------------------------------------------------
INSERT INTO `help_requests` (`title`, `description`, `date_pub`, `date_session`, `learner_id`, `tutor_id`, `skill_id`, `status_id`) VALUES
 
-- RESOLUE
('Comprendre les jointures SQL',
 'Je ne comprends pas la différence entre INNER JOIN, LEFT JOIN et RIGHT JOIN. Peux-tu m\'expliquer avec des exemples concrets ?',
 '2025-01-10 09:15:00', '2025-01-11 14:00:00', 2, 3, 6, 3),
 
('Héritage et méthodes abstraites en POO',
 'J\'ai du mal à implémenter une classe abstraite en PHP. Mon code lève une erreur quand j\'essaie d\'instancier la classe parente.',
 '2025-01-12 10:30:00', '2025-01-13 16:00:00', 1, 6, 7, 3),
 
('Callback vs Promise en JavaScript',
 'Je n\'arrive pas à chaîner plusieurs opérations asynchrones sans tomber dans le callback hell. Comment passer aux Promises ?',
 '2025-01-14 08:00:00', '2025-01-15 10:00:00', 8, 4, 3, 3),
 
-- ASSIGNE
('Problème avec PDO et les transactions',
 'Quand j\'exécute plusieurs requêtes dans un try/catch, si la deuxième échoue la première est quand même committée. J\'ai essayé beginTransaction() sans succès.',
 '2025-01-18 11:00:00', '2025-01-20 15:00:00', 1, 3, 5, 2),
 
('Implémenter le pattern Repository en PHP',
 'Je dois séparer la logique SQL de mes entités mais je ne sais pas comment structurer mes classes Repository correctement.',
 '2025-01-19 14:20:00', '2025-01-21 09:00:00', 2, 6, 13, 2),
 
-- EN_ATTENTE
('Flexbox vs Grid CSS — quand utiliser lequel ?',
 'Je galère à choisir entre Flexbox et Grid pour mes layouts. Y a-t-il une règle générale ?',
 '2025-01-20 16:45:00', NULL, 8, NULL, 2, 1),
 
('Récursivité — exercice sur les arbres binaires',
 'Je dois parcourir un arbre binaire en profondeur mais ma fonction récursive boucle à l\'infini. Besoin d\'aide pour déboguer.',
 '2025-01-21 08:10:00', NULL, 1, NULL, 15, 1),
 
('Créer une API REST avec PHP natif',
 'Comment structurer les routes et gérer les méthodes HTTP (GET, POST, PUT, DELETE) sans framework ?',
 '2025-01-21 09:30:00', NULL, 2, NULL, 14, 1),
 
('Comprendre les énumérations PHP 8.1',
 'Je découvre les Enums en PHP 8.1 pour mon projet PeerSync. Comment les utiliser avec PDO pour mapper les valeurs en base ?',
 '2025-01-21 13:00:00', NULL, 8, NULL, 5, 1),
 
('Initiation à Git — conflits de merge',
 'En travaillant en équipe, j ai un conflit de merge que je ne sais pas résoudre. Git me demande de modifier manuellement le fichier.',
 '2025-01-22 07:55:00', NULL, 1, NULL, 8, 1);
 
-- ------------------------------------------------------------
--  reviews  (only for RESOLUE requests — ids 1, 2, 3)
-- ------------------------------------------------------------
INSERT INTO `reviews` (`comment`, `rating`, `reviewer_id`, `help_quest_id`) VALUES
("Younes a été super patient, il m a expliqué chaque type de jointure avec des exemples clairs. Merci beaucoup !", 5, 2, 1),
('Mehdi a directement trouvé mon erreur de conception. Très professionnel et pédagogue.', 5, 1, 2),
("Fatima m a montré comment refactoriser mon code avec async/await. Très clair et efficace !", 4, 8, 3);