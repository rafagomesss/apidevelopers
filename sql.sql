CREATE DATABASE IF NOT EXISTS apidevelopers CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE apidevelopers;

# DROP TABLE developers;
# TRUNCATE TABLE developers;

CREATE TABLE IF NOT EXISTS developers(
  id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
  nome VARCHAR(200) NOT NULL UNIQUE,
  sexo CHAR(1) CHECK (sexo IN('M', 'F')),
  hobby VARCHAR(200),
  datanascimento DATETIME,
  PRIMARY KEY(id)
) ENGINE = InnoDB DEFAULT CHARSET = Latin1;

# INSERT INTO developers VALUES (0, 'Fulano da Silva', 'M', 'Música', NOW());
# INSERT INTO developers VALUES (0, 'Benedita Costa', 'F', 'Volei', NOW());
# INSERT INTO developers VALUES (0, 'Benedita Fulana', 'M', 'Volei', NOW());
# SELECT * FROM developers;
 
 SELECT * FROM developers WHERE nome like '%Benedita%';

UPDATE developers SET nome = 'Teste Atualizado A', sexo = 'F' WHERE id = 1;