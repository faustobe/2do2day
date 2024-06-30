# 2do2day
matrice di eisenhower
***
gestione del tempo tramite una classica matrice di eisenhower con funzionalità di aggiornamento e dettaglio delle attività
***
utilizza un db mysql così strutturato:
***
table tasks
+-------------+--------------+------+-----+-------------------+-------------------+
| Field       | Type         | Null | Key | Default           | Extra             |
+-------------+--------------+------+-----+-------------------+-------------------+
| id          | int          | NO   | PRI | NULL              | auto_increment    |
| description | varchar(255) | NO   |     | NULL              |                   |
| quadrant    | int          | NO   |     | NULL              |                   |
| created_at  | timestamp    | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED |
| status      | tinyint(1)   | YES  |     | 0                 |                   |
+-------------+--------------+------+-----+-------------------+-------------------+

table subtasks
+---------------+--------------+------+-----+-------------------+-------------------+
| Field         | Type         | Null | Key | Default           | Extra             |
+---------------+--------------+------+-----+-------------------+-------------------+
| id            | int          | NO   | PRI | NULL              | auto_increment    |
| task_id       | int          | NO   | MUL | NULL              |                   |
| description   | varchar(255) | NO   |     | NULL              |                   |
| expected_time | int          | NO   |     | NULL              |                   |
| spent_time    | int          | NO   |     | 0                 |                   |
| created_at    | timestamp    | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED |
+---------------+--------------+------+-----+-------------------+-------------------+

